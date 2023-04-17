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
    -h, --help              this screen
    -f                      force update even if already latest version
    --no-db                 skip the db updates/inserts
    --cache                 enables use of the file cache
    --no-cache              disables use of the file cache
    --yearmonth=<yyyy_mm>   limit the processing to the specified year+month
    --year=<yyyy>           limit the processing to the specified year

");
}
/**
* @var \Workerman\MySQL\Connection
*/
global $db;
$force = in_array('-f', $_SERVER['argv']);
$skipDb = in_array('--no-db', $_SERVER['argv']);
$useCache = !in_array('--no-cache', $_SERVER['argv']);
//$useCache = in_array('--cache', $_SERVER['argv']);
$validYearMonths = [];
$validYears = [];
foreach ($_SERVER['argv'] as $idx => $arg) {
    if (preg_match('/--yearmonth=(.*)/', $arg, $matches)) {
        $validYearMonths[] = $matches[1];
    } elseif (preg_match('/--year=(.*)/', $arg, $matches)) {
        $validYears[] = $matches[1];
    }
}
$dataDir = __DIR__.'/../../../data/json/emucr';
$sitePrefix = 'https://www.emucr.com/';
$dir = '/mnt/e/dev/ConSolo/mirror/emucr/www.emucr.com';
$types = ['st' => 'type_id', 'c' => 'computer_id'];
$data = [
    'emulators' => [],
    'tags' => [],
];
$source = [
    'emulators' => []
];
$tagCounts = [];
$computerUrls = [];
$postUrls = [];
$platforms = [];
$allEmulators = [];
if ($useCache !== false) {
    if (!file_Exists($dataDir.'/archive')) {
        mkdir($dataDir.'/archive', 0777, true);
    }
    if (!file_Exists($dataDir.'/posts')) {
        mkdir($dataDir.'/posts', 0777, true);
    }
    if (!file_Exists($dataDir.'/platforms')) {
        mkdir($dataDir.'/platforms', 0777, true);
    }
}
$converter = new CssSelectorConverter();
$secondsInDay = 60 * 60 * 24;
$clientNoCache = new HttpBrowser(HttpClient::create(['timeout' => 900, 'verify_peer' => false]));
$client = new HttpBrowser(
    $cachingClient = new CachingHttpClient(
        $fakeClient = new FakeCacheHeaderClient(
            $httpClient = HttpClient::create(['timeout' => 900, 'verify_peer' => false]
        )),
        $cacheStore = new Store(__DIR__.'/../../../data/http_cache/emucr'), ['default_ttl' => $secondsInDay * 31]),
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
$crawler = $clientNoCache->request('GET', $sitePrefix);
$crawler->filter('li.archivedate a')->each(function ($node) use (&$computerUrls) {
    $computerUrls[] = $node->attr('href');
});
echo ' done'.PHP_EOL;
echo 'Found '.count($computerUrls).' Archive Pages'.PHP_EOL;
rsort($computerUrls);
$total = count($computerUrls);
echo 'Found '.$total.' Systems'.PHP_EOL;
echo 'Loading Archive Pages ';
$todaysArchive = $sitePrefix.date('Y_m_d').'_archive.html';
foreach ($computerUrls as $url) {
    //echo "URL:{$url}\n";
    echo '.';
    $page = str_replace($sitePrefix, '', $url);
    $year = substr($page, 0, 4);
    if ($useCache === true && $page != $todaysArchive && file_exists($dataDir.'/archive/'.$year.'/'.$page.'.json')) {
        $pageUrls = json_decode(file_get_contents($dataDir.'/archive/'.$year.'/'.$page.'.json'), true);
    } else {
        if ($page == $todaysArchive) {
            $crawler = $clientNoCache->request('GET', $url);
        } else {
            $crawler = $client->request('GET', $url);
        }
        $pageUrls = [];
        $crawler->filter('.blog-posts > a')->each(function ($node) use (&$pageUrls) {
            $pageUrls[$node->attr('href')] = $node->attr('title');
        });
        if ($useCache !== false) {
            if (!file_exists($dataDir.'/archive/'.$year)) {
                mkdir($dataDir.'/archive/'.$year, 0777, true);
            }
            file_put_contents($dataDir.'/archive/'.$year.'/'.$page.'.json', json_encode($pageUrls, getJsonOpts()));
        }
    }
    foreach ($pageUrls as $url => $title)
        $postUrls[$url] = $title;
}
if ($useCache !== false) {
    file_put_contents($dataDir.'/postUrls.json', json_encode($postUrls, getJsonOpts()));
    echo ' done'.PHP_EOL;
    $postUrls = json_decode(file_get_contents($dataDir.'/postUrls.json'), true);
}
echo 'Found '.count($postUrls).' Post Pages'.PHP_EOL;
$count = 0;
$lastYear = false;
$noMatches = [];
ksort($postUrls);
foreach ($postUrls as $url => $title ) {
    $count++;
    /*preg_match('/(?P<seo>.*)-(?P<year>\d\d\d\d)(?P<month>\d\d)(?P<day>\d\d)\.html/u', basebane($url), $matches);
    $seo = $matches['seo'];
    $year = $matches['year'];
    $month = $matches['month'];
    $day = $matches['day'];*/
    $baseUrl = str_replace([$sitePrefix, '/'], ['', '_'], $url);
    $yearMonth = substr($baseUrl, 0, 7);
    $year = substr($baseUrl, 0, 4);
    if ((count($validYearMonths) > 0 && !in_array($yearMonth, $validYearMonths)) || (count($validYears) > 0 && !in_array($year, $validYears))) {
        echo "Skipping {$baseUrl}\n";
        continue;
    }
    if ($useCache !== false && $lastYear !== false && $lastYear != $year) {
        echo "Writing Posts..";
        file_put_contents($dataDir.'/posts.json', json_encode($posts, getJsonOpts()));
        file_put_contents($dataDir.'/tags.json', json_encode($tagCounts, getJsonOpts()));
        ksort($data['emulators']);
        file_put_contents(__DIR__.'/../../../../emulation-data/emucr.json', json_encode($data, getJsonOpts()));
        echo "  done\n";
    }
    $lastYear = $year;
    try {
        echo "Loading URL {$url}    ";
        $crawler = $client->request('GET', $url);
        //$crawler = $crawler->filter('.postMain');
        if ($useCache !== false) {
            if (!file_exists($dataDir.'/posts/'.$yearMonth)) {
                mkdir($dataDir.'/posts/'.$yearMonth, 0777, true);
            }
            file_put_contents($dataDir.'/posts/'.$yearMonth.'/'.$baseUrl, $crawler->outerHtml());
        }
    } catch (\Exception $e) {
        echo "  Ran into a problem on with {$baseUrl}: ".$e->getMessage()."\n";
    }

    try {
        $nameVersion = $crawler->filter('.postMain .title h1 a')->text();
        $datePosted = $crawler->filter('.postMain .meta .entrydate')->text();
        $post = [
            'name' => $nameVersion,
            'date' => $datePosted,
            'nameVersion' => $nameVersion,
            'url' => $url,
            'seo' => $baseUrl,
        ];
        $post['tags'] = $crawler->filter('.postMain .post-labels a[rel="tag"]')->each(function (Crawler $node, $i) use (&$tagCounts) {
            $tag = $node->text();
            if (!array_key_exists($tag, $tagCounts))
                $tagCounts[$tag] = 0;
            $tagCounts[$tag]++;
            return $tag;
        });
        if (preg_match('/^(arbee|news|david haywood|Demul WIP|DU Update|kale)/i', $nameVersion) || $nameVersion =='EmuCR' || in_array('WebLog', $post['tags'])) {
            echo "  Skipping\n";
            continue;
        }
        $linkCrawler = $crawler->filter('.postMain .post-body a[href]');
        $linkCount = $linkCrawler->count();
        $linkSection = false;
        for ($idx = 0; $idx < $linkCount; $idx++) {
            $link = $linkCrawler->eq($idx);
            if (in_array($link->attr('href'), ['http://www.emucr.com', 'https://www.emucr.com'])) {
                if ($link->attr('style') == 'font-weight:bold;color:black;text-decoration: none;') {
                    $linkSection = trim(str_replace(':', '', strtolower($link->text())));
                    if ($linkSection == 'source')
                        $linkSection = 'repo';
                    elseif ($linkSection == 'web')
                        $linkSection = 'home';
                    elseif ($linkSection == 'download') {
                        $linkSection  = 'links';
                        $post[$linkSection] = [];
                    }
                } else {
                    $linkSection = false;
                }
            } elseif ($linkSection == 'links') {
                $post[$linkSection][$link->attr('href')] = $link->text();
            } elseif ($linkSection !== false) {
                $post[$linkSection] = $link->attr('href');
            }
        }
        $post['description'] = $crawler->filter('.postMain .post-body p')->html();
        $post['description'] = preg_replace('/^<a href="[^"]*" target="_blank"><img[^>]*><\/a>/', '', $post['description']);
        if (preg_match('/^(.*)(<a[^>]*>Download:?<\/a>.*)/imsu', $post['description'], $matches)) {
            $post['description'] = trim($matches[1]);
        } elseif (preg_match('/^(.*)(<strong>Download:?<\/strong>.*)(<strong>Source<\/strong>.*)/imsu', $post['description'], $matches)) {
            $post['description'] = trim($matches[1]);
            $linkCrawler = new Crawler($matches[2]);
            $linkCrawler->filter('a');
            $linkCount = $linkCrawler->count();
            $post['links'] = [];
            for ($idx = 0; $idx < $linkCount; $idx++) {
                $link = $linkCrawler->eq($idx);
                $post['links'][$link->attr('href')] = $link->text();
            }
            $linkCrawler = new Crawler($matches[3]);
            $linkCrawler->filter('a');
            $post['repo'] = $linkCrawler->attr('href');
        } elseif (preg_match('/^(.*)(<strong>Download:?<\/strong>.*)/imsu', $post['description'], $matches)) {
            $post['description'] = trim($matches[1]);
            $linkCrawler = new Crawler($matches[2]);
            $linkCrawler->filter('a');
            $linkCount = $linkCrawler->count();
            $post['links'] = [];
            for ($idx = 0; $idx < $linkCount; $idx++) {
                $link = $linkCrawler->eq($idx);
                $post['links'][$link->attr('href')] = $link->text();
            }
        }
        if (preg_match('/^.* is (released|compiled)\.(.*)$/imus', $post['description'], $matches)) {
            $post['description'] = trim($matches[2]);
        }
        if (preg_match('/^(.*)(<(strong|a href[^>]*)>[^<]*Changelog:?<\/(strong|a)>)(.*)$/imsu', $post['description'], $matches)) {
            $post['description'] = trim($matches[1]);
            $post['changes'] = trim($matches[5]);
        }
        if ($crawler->filter('.postMain .post-body p a:nth-child(1) img')->count() > 0) {
            $post['name'] = trim(preg_replace('/^EmuCR:?\s*/', '', trim($crawler->filter('.postMain .post-body p a:nth-child(1) img')->attr('title'))));
            $post['logo'] = $crawler->filter('.postMain .post-body p a:nth-child(1) img')->attr('src');
            $post['version'] = trim(str_replace($post['name'], '', $nameVersion));
        } else {
            //echo "  No logo for {$url}";
        }
        if (preg_match('/^(.*) (r[\d].*|nightly-\d+|bleeding-edge-\d+|\#\d+|\(wip\).*|alpha[\d\.]+|beta[\d\.]+|v[\d\.].*|x[\d\.].*|ver[\d\.]+.*|SVN r\d.*|git .*|\([\d\/]*\).*|r\d+|r\d+ .*|\d[\d\.]*.*)$/iuU', $nameVersion, $matches)) {
            $post['name'] = $matches[1];
            $post['version'] = $matches[2];
            echo "  Name '{$post['name']}' Version '{$post['version']}'";
        } else {
            $noMatches[] = $nameVersion;
            echo "  No version regex match {$url}";
        }
        $id = str_replace(' ', '_', strtolower($post['name']));
        foreach ($post['tags'] as $tag) {
            if (!isset($data['tags'][$tag]))
                $data['tags'][$tag] = [];
            if (!in_array($id, $data['tags'][$tag])) {
                $data['tags'][$tag][] = $id;
                ksort($data['tags'][$tag]);
            }
        }
        ksort($data['tags']);
        if (!isset($data['emulators'][$id])) {
            $data['emulators'][$id] = [
                'id' => $id,
                'name' => $post['name'],
                'description' => $post['description'],
                'tags' => $post['tags'],
                'versions' => []
            ];
            if (isset($post['logo'])) {
                $data['emulators'][$id]['logo'] = $post['logo'];
            }
            if (isset($post['repo'])) {
                $data['emulators'][$id]['web'] = [$post['repo'] => 'repo'];
            }
            $source['emulators'][$id] = [
                'id' => $post['name'],
                'name' => $post['name']
            ];
        }
        if (isset($post['version'])) {
            $data['emulators'][$id]['versions'][] = $post['version'];
        }

        $posts[] = $post;
        if ($useCache !== false) {
            if (!file_exists($dataDir.'/posts/'.$yearMonth)) {
                mkdir($dataDir.'/posts/'.$yearMonth, 0777, true);
            }
            file_put_contents($dataDir.'/posts/'.$yearMonth.'/'.$baseUrl.'.json', json_encode($post, getJsonOpts()));
            echo "done\n";
        }
    } catch (\Exception $e) {
        echo "  Ran into a problem on with {$baseUrl}: ".$e->getMessage()."\n";
    }
}
echo "Finished Processig Posts\n";
sort($noMatches);
file_put_contents($dataDir.'/no_version_matches.json', json_encode($noMatches, getJsonOpts()));
if ($useCache !== false) {
    echo "Writing Posts..";
    file_put_contents($dataDir.'/posts.json', json_encode($posts, getJsonOpts()));
    echo "done\n";
}
ksort($data['emulators']);
ksort($source['emulators']);
file_put_contents(__DIR__.'/../../../../emulation-data/emucr.json', json_encode($data, getJsonOpts()));
$sources = json_decode(file_get_contents(__DIR__.'/../../../../emurelation/sources.json'), true);
$sources['emucr']['updatedLast'] = time();
file_put_contents(__DIR__.'/../../../../emurelation/sources.json', json_encode($sources, getJsonOpts()));
foreach ($source as $type => $data) {
    file_put_contents(__DIR__.'/../../../../emurelation/'.$type.'/emucr.json', json_encode($data, getJsonOpts()));
}
