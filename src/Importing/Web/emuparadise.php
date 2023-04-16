<?php


use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\BrowserKit\CookieJar;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\CachingHttpClient;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpKernel\HttpCache\Store;
use Symfony\Component\CssSelector\CssSelectorConverter;

require_once __DIR__.'/../../bootstrap.php';
require_once __DIR__.'/FakeCacheHeaderClient.php';

if (in_array('-h', $_SERVER['argv']) || in_array('--help', $_SERVER['argv'])) {
    die("Syntax:
    php ".$_SERVER['argv'][0]." <options>

Options:
    -h, --help  this screen
    -f          force update even if already latest version
    --no-db     skip the db updates/inserts
    --no-cache  disables use of the file cache

");
}
/**
* @var \Workerman\MySQL\Connection
*/
global $db;
$force = in_array('-f', $_SERVER['argv']);
$skipDb = in_array('--no-db', $_SERVER['argv']);
$useCache = !in_array('--no-cache', $_SERVER['argv']);
$dataDir = __DIR__.'/../../../data/json/emucr';
$sitePrefix = 'https://www.emucr.com/';
$dir = '/mnt/e/dev/ConSolo/mirror/emucr/www.emucr.com';
$types = ['st' => 'type_id', 'c' => 'computer_id'];
$computerUrls = [];
$postUrls = [];
$platforms = [];
$allEmulators = [];
if (!file_Exists($dataDir.'/archive')) {
    mkdir($dataDir.'/archive', 0777, true);
}
if (!file_Exists($dataDir.'/posts')) {
    mkdir($dataDir.'/posts', 0777, true);
}
if (!file_Exists($dataDir.'/platforms')) {
    mkdir($dataDir.'/platforms', 0777, true);
}
$converter = new CssSelectorConverter();
$secondsInDay = 60 * 60 * 24;
$clientNoCache = new HttpBrowser(HttpClient::create(['timeout' => 900, 'verify_peer' => false]));
$client = new HttpBrowser(
    $cachingClient = new CachingHttpClient(
        $fakeClient = new FakeCacheHeaderClient(
            $httpClient = HttpClient::create(['timeout' => 900, 'verify_peer' => false]
        )),
        $cacheStore = new Store(__DIR__.'/../../../data/http_cache/emuparadise'), ['default_ttl' => $secondsInDay * 31]),
    null,
    $cookieJar = new CookieJar()
);
//var_dump($converter->toXPath('.post-labels a[rel="tag"]'));
if (!$skipDb) {
    $row = $db->query("select * from config where field='emucr'");
    if (count($row) == 0) {
        $last = 0;
        $db->query("insert into config values ('emucr','0')");
    } else {
        $last = $row[0]['value'];
    }
}

echo 'Loading and scanning for archive pages..';
$crawler = $client->request('GET', $sitePrefix);
$crawler->filter('li.archivedate a')->each(function ($node) use (&$computerUrls) {
    $computerUrls[] = $node->attr('href');
});
echo ' done'.PHP_EOL;
echo 'Found '.count($computerUrls).' Archive Pages'.PHP_EOL;
rsort($computerUrls);
file_put_contents($dataDir.'/urls.json', json_encode($computerUrls, getJsonOpts()));
echo 'Loading Computer URLs'.PHP_EOL;
$computerUrls = json_decode(file_get_contents($dataDir.'/urls.json'), true);
$total = count($computerUrls);
echo 'Found '.$total.' Systems'.PHP_EOL;
echo 'Loading Archive Pages ';
$todaysArchive = $sitePrefix.date('Y_m_d').'_archive.html';
foreach ($computerUrls as $url) {
    //echo "URL:{$url}\n";
    echo '.';
    $page = str_replace($sitePrefix, '', $url);
    if ($useCache === true && $page != $todaysArchive && file_exists($dataDir.'/archive/'.$page.'.json')) {
        $pageUrls = json_decode(file_get_contents($dataDir.'/archive/'.$page.'.json'), true);
    } else {
        $crawler = $client->request('GET', $url);
        $pageUrls = [];
        $crawler->filter('.blog-posts > a')->each(function ($node) use (&$pageUrls) {
            $pageUrls[$node->attr('href')] = $node->attr('title');
        });
        file_put_contents($dataDir.'/archive/'.$page.'.json', json_encode($pageUrls, getJsonOpts()));
    }
    foreach ($pageUrls as $url => $title)
        $postUrls[$url] = $title;
}
file_put_contents($dataDir.'/posts.json', json_encode($postUrls, getJsonOpts()));
echo ' done'.PHP_EOL;
$postUrls = json_decode(file_get_contents($dataDir.'/posts.json'), true);
echo 'Found '.count($postUrls).' Post Pages'.PHP_EOL;
$count = 0;
foreach ($postUrls as $url => $title ) {
    $count++;
    /*preg_match('/(?P<seo>.*)-(?P<year>\d\d\d\d)(?P<month>\d\d)(?P<day>\d\d)\.html/u', basebane($url), $matches);
    $seo = $matches['seo'];
    $year = $matches['year'];
    $month = $matches['month'];
    $day = $matches['day'];*/
    $baseUrl = str_replace([$sitePrefix, '/'], ['', '_'], $url);
    if ($useCache === true && file_exists($dataDir.'/posts/'.$baseUrl.'.json')) {
        echo "Reading file {$baseUrl}\n";
        $cols = json_decode(file_get_contents($dataDir.'/posts/'.$baseUrl.'.json'), true);
    } else{
        try {
            echo "Loading URL {$url} ";
            $crawler = $client->request('GET', $url);
            $title = $crawler->filter('title')->text();
            $title = str_replace(" - EmuCR", '', $title);
            $tags = $crawler->filter('.postMain .post-labels a[rel="tag"]')->each(function (Crawler $node, $i) {
                return $node->text();
            });
            if ($title =='EmuCR' || in_array('WebLog', $tags)) {
                echo "Skipping\n";
                continue;
            }
            $nameVersion = $crawler->filter('.postMain .title h1 a')->text();
            $datePosted = $crawler->filter('.postMain .meta .entrydate')->text();
            $body = $crawler->filter('.postMain .post-body p')->html();
            $links = $crawler->filter('.postMain .post-body a[rel="nofollow"]')->each(function ($node, $i) { return [$node->attr('href'), $node->text()]; });
            $data = [
                'title' => $title,
                'date' => $datePosted,
                'nameVersion' => $nameVersion,
                'url' => $url,
                'seo' => $baseUrl,
                'tags' => $tags,
                'body' => $body,
                'links' => $links,
            ];
            if ($crawler->filter('.postMain .post-body p a:nth-child(1) img')->count() > 0) {
                $data['logo'] = $crawler->filter('.postMain .post-body p a:nth-child(1) img')->attr('src');
            }
            $posts[] = $data;
            file_put_contents($dataDir.'/posts/'.$baseUrl.'.json', json_encode($data, getJsonOpts()));
            echo "done\n";
            if ($count % 50 == 0) {
                echo "Writing Posts..";
                file_put_contents($dataDir.'/posts.json', json_encode($posts, getJsonOpts()));
                echo "done\n";
            }
        } catch (\Exception $e) {
            echo "Ran into a problem on with {$baseUrl}: ".$e->getMessage()."\n";
        }
    }
}
echo "Finished Processig Posts\n";
echo "Writing Posts..";
file_put_contents($dataDir.'/posts.json', json_encode($posts, getJsonOpts()));
echo "done\n";

