<?php


use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\CssSelector\CssSelectorConverter;

require_once __DIR__.'/../../bootstrap.php';

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
$dataDir = __DIR__.'/../../../data/json';
$sitePrefix = 'https://emutopia.com';
$converter = new CssSelectorConverter();
$client = new Client();
$emulators = [];
foreach (['emulators', 'other-files'] as $urlSuffix) {
    echo "Loading and scanning for {$urlSuffix} pages..\n";
    $crawler = $client->request('GET', $sitePrefix.'/index.php/'.$urlSuffix);
    $typeCount = $crawler->filter('.categories-list .list .cat-name a')->count();
    for ($idxType = 0; $idxType < $typeCount; $idxType++) {
        $typeName = $crawler->filter('.categories-list .list .cat-name a')->eq($idxType)->text();
        $typeId = preg_match('/^([0-9]+)-(.*)$/', basename($crawler->filter('.categories-list .list .cat-name a')->eq($idxType)->attr('href')), $matches);
        $typeId = $matches[1];
        $typeShort = $matches[2];
        echo "  Got Type {$typeName} ID {$typeId}\n";
        $platCount = $crawler->filter('#subcat'.$typeId.' ul li a')->count();
        for ($idxPlat = 0; $idxPlat < $platCount; $idxPlat++) {
            $platUrl = $crawler->filter('#subcat'.$typeId.' ul li a')->eq($idxPlat)->attr('href');
            $platName = $crawler->filter('#subcat'.$typeId.' ul li a')->eq($idxPlat)->text();
            preg_match('/^([0-9]+)-(.*)$/', basename($platUrl), $matches);
            $platId = $matches[1];
            $platShort = $matches[2];
            echo "      Got Plat {$platName} ID {$platId} ({$platShort})\n";
            $platCrawler = $client->request('GET', $sitePrefix.$platUrl.'?limit=100');
            $platCrawler = $platCrawler->filter('.newstitle a');
            $listCount = $platCrawler->count();
            if ($listCount > 0) {
                for ($idxList = 0; $idxList < $listCount; $idxList++) {
                    $emuName = $platCrawler->eq($idxList)->text();
                    $emuUrl = $platCrawler->eq($idxList)->attr('href');
                    preg_match('/^([0-9]+)-(.*)$/', basename($emuUrl), $matches);
                    $emuId = $matches[1];
                    $emuShort = $matches[2];
                    echo "          Got Emu {$emuName} ID {$emuId} ({$emuShort})\n";
                    $emuCrawler = $client->request('GET', $sitePrefix.$emuUrl);
                    $emuCrawler = $emuCrawler->filter('#topic-article .forum-list tr td');
                    $emuCount = $emuCrawler->count();
                    $emuName = $emuCrawler->eq(1)->filter('h1')->text();
                    $emulator = [
                        'id' => $emuId,
                        'name' => $emuName,
                        'shortName' => $emuShort,
                        'url' => $sitePrefix.$emuUrl,
                        'type' => $typeName,
                        'platforms' => [$platName]
                    ];
                    $linkCrawler = $emuCrawler->eq(1)->filter('div a.filter-link');
                    $linkCount = $linkCrawler->count();
                    $os = [];
                    for ($idxLink = 0; $idxLink < $linkCount; $idxLink++) {
                        $os[] = $linkCrawler->eq($idxLink)->text();
                    }
                    if (count($os) > 0) {
                        $emulator['os'] = $os;
                    }
                    $emuField = false;
                    for ($idxEmu = 2; $idxEmu < $emuCount; $idxEmu++) {
                        if ($emuCrawler->eq($idxEmu)->filter('h2')->count() == 1) {
                            $emuField = strtolower($emuCrawler->eq($idxEmu)->filter('h2')->text());
                        } elseif ($emuField == false) {
                            echo "              No emuField Set yet for ".$emuCrawler->eq($idxEmu)->html();
                        } else {
                            if ($emuField == 'gallery') {
                                $imageCrawler = $emuCrawler->eq($idxEmu)->filter('.image-wrapper a');
                                $imageCount = $imageCrawler->count();
                                $images = [];
                                for ($idxImage = 0; $idxImage < $imageCount; $idxImage++) {
                                    $images[] = $sitePrefix.$imageCrawler->eq($idxImage)->attr('href');
                                }
                                if (count($images) > 0) {
                                    $emulator['images'] = $images;
                                }
                                $tagCrawler = $emuCrawler->filter('#tag-list-'.$emuId.' .tag_list_item a');
                                $tagCount = $tagCrawler->count();
                                $tags = [];
                                for ($idxTag = 0; $idxTag < $tagCount; $idxTag++) {
                                    $tags[] = $tagCrawler->eq($idxTag)->text();
                                }
                                if (count($tags) > 0) {
                                    $emulator['tags'] = $tags;
                                }
                                break;
                            } elseif ($emuField == 'links') {
                                $linkCrawler = $emuCrawler->eq($idxEmu)->filter('li a');
                                $linkCount = $linkCrawler->count();
                                $links = [];
                                for ($idxImage = 0; $idxImage < $linkCount; $idxImage++) {
                                    $links[$sitePrefix.$linkCrawler->eq($idxImage)->attr('href')] = $sitePrefix.$linkCrawler->eq($idxImage)->text();
                                }
                                if (count($links) > 0) {
                                    $emulator['links'] = $links;
                                }

                            } elseif ($emuField == 'downloads') {
                                $downloadCrawler = $emuCrawler->eq($idxEmu)->filter('li a');
                                $downloadCount = $downloadCrawler->count();
                                $downloads = [];
                                for ($idxImage = 0; $idxImage < $downloadCount; $idxImage++) {
                                    $downloads[$sitePrefix.$downloadCrawler->eq($idxImage)->attr('href')] = $sitePrefix.$downloadCrawler->eq($idxImage)->text();
                                }
                                if (count($downloads) > 0) {
                                    $emulator['downloads'] = $downloads;
                                }
                            } else {
                                $emulator[$emuField] = $emuCrawler->eq($idxEmu)->html();
                            }
                            $emuField = false;
                        }
                    }
                    $emulators[$emuId] = $emulator;
                }
            }
        }
    }
}
file_put_contents($dataDir.'/emutopia.json', json_encode($emulators, getJsonOpts()));