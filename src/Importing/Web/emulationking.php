<?php
/**
* EmulationKing.com scraper
*
* TODO:
* - extract platform manufactuter image
* - extract seo short names and full names from thigns like emulators, platforms, etc.
* - move platforms and emulators into thier own array with seoshort reference to them from the parent
* - parse emulators pages
* - convert utf8 chars to local equivalents
*/

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
    -k          keep xml files, dont delete them
    --no-db     skip the db updates/inserts
    --cache     enables use of the file cache
    --no-cache  disables use of the file cache

");
}
/**
* @var \Workerman\MySQL\Connection
*/
global $db;
$force = in_array('-f', $_SERVER['argv']);
$keep = in_array('-k', $_SERVER['argv']);
$skipDb = in_array('--no-db', $_SERVER['argv']);
$useCache = !in_array('--no-cache', $_SERVER['argv']);;
$useCache = in_array('--cache', $_SERVER['argv']);;
$url = 'https://emulationking.com/';
$data = [
    'companies' => [],
    'platforms' => [],
    'emulators' => []
];
$source = [
    'companies' => [],
    'platforms' => [],
    'emulators' => []
];
$converter = new CssSelectorConverter();
$secondsInDay = 60 * 60 * 24;
$clientNoCache = new HttpBrowser(HttpClient::create(['timeout' => 900, 'verify_peer' => false]));
$client = new HttpBrowser(
    $cachingClient = new CachingHttpClient(
        $fakeClient = new FakeCacheHeaderClient(
            $httpClient = HttpClient::create(['timeout' => 900, 'verify_peer' => false]
        )),
        $cacheStore = new Store(__DIR__.'/../../../data/http_cache/emulationking'), ['default_ttl' => $secondsInDay * 31]),
    null,
    $cookieJar = new CookieJar()
);
echo "Loading EmulationKing main/index page\n";
$crawler = $client->request('GET', $url);
$missingFiles = [];
//$crawler = new Crawler($html);
$rows = $crawler->filter('.site-main > div.row');
for ($idx = 0, $idxMax = $rows->count(); $idx < $idxMax; $idx++ ) {
    $company = [
        'id' => '',
        'url' => $rows->eq($idx)->filter('h2 a')->attr('href'),
        'name' => $rows->eq($idx)->filter('h2 a')->text(),
        'description' => '',
        'logo' => '',
        'platforms' => [],
    ];
    $company['id'] = basename($company['url']);
    $source['companies'][$company['id']] = [
        'id' => $company['id'],
        'name' => $company['name'],
        'shortName' => $company['id']
    ];
    $idx++;
    $platformRows = $rows->eq($idx)->filter('div > a.console_icons');
    for ($idxPlat = 0, $maxPlat = $platformRows->count(); $idxPlat < $maxPlat; $idxPlat++) {
        preg_match('/^(?P<platform>.*) \(Rel (?P<year>[0-9][0-9][0-9][0-9])\)/', $platformRows->eq($idxPlat)->text(), $matches);
        $platform = [
            'id' => '',
            'url' => $platformRows->eq($idxPlat)->attr('href'),
            'name' => $matches[1],
            'company' => $company['id'],
            'year' => $matches[2],
        ];
        $platform['id'] = basename($platform['url']);
        $data['platforms'][$platform['id']] = $platform;
        $company['platforms'][] = $platform['id'];
        $source['platforms'][$platform['id']] = [
            'id' => $platform['id'],
            'name' => $platform['name'],
            'shortName' => $platform['id'],
            'company' => $company['id']
        ];
        echo "  Added Platform {$platform['name']}\n";
    }
    $data['companies'][$company['id']] = $company;
    echo "  Added Manufacturer {$company['name']}\n";
}
foreach ($data['companies'] as $idxMan => $company) {
    echo "  Loading Company {$company['url']}\n";
    $isCached = file_exists($cacheStore->getPath(hash('sha256', $company['url'])));
    $crawler = $client->request('GET', $company['url']);
    if ($isCached == false)
        sleep(1);
    //$crawler = new Crawler($html);
    $data['companies'][$idxMan]['description'] = trim(html_entity_decode(str_replace(['<br>'], ["\n"], preg_replace('/<\/?p>/', '', preg_replace('/^<p><img[^>]*>/', '', trim($crawler->filter('.entry-content')->html()))))));
    $data['companies'][$idxMan]['logo'] = $crawler->filter('.entry-content img')->eq(0)->attr('src');
}

foreach ($data['companies'] as $idxMan => $company) {
    foreach ($company['platforms'] as $idxPlat) {
        $platform = $data['platforms'][$idxPlat];
        echo "      Loading Platform {$platform['url']}\n";
        $isCached = file_exists($cacheStore->getPath(hash('sha256', $platform['url'])));
        $crawler = $client->request('GET', $platform['url']);
        if ($isCached == false)
            sleep(1);
        //eval(\Psy\sh());
        $crawler->filter('.lbb-block-slot')->each(function (Crawler $crawler, $i) {
            foreach ($crawler as $node) {
                $node->parentNode->removeChild($node);
            }
        });
        $rows = $crawler->filter('article > .row');
        if ($rows->eq(0)->filter('.entry-title')->count() == 0) {
            eval(\Psy\sh());
        }
        $platform['name'] = $rows->eq(0)->filter('.entry-title')->text();
        $platform['image'] = $rows->eq(1)->filter('div .game-cover .cover-image')->attr('src');
        $platform['description'] = trim(html_entity_decode(str_replace(['<br>'], ["\n"], preg_replace('/<\/?(p|a)[^>]*>/', '', trim($rows->eq(1)->filter('div .entry-content')->html())))));
        if ($rows->eq(1)->filter('div .console-meta')->count() > 0) {
            $specRows = $rows->eq(1)->filter('div .console-meta')->children();
            for ($idxSpec = 1, $maxSpec = $specRows->count(); $idxSpec < $maxSpec; $idxSpec++) {
                $node = $specRows->eq($idxSpec)->filter('strong');
                if ($node->count() > 0) {
                    $field = str_replace([':'], [''], $node->text()) ;
                    foreach ($node as $thenode)
                        $thenode->parentNode->removeChild($thenode);
                }
                $value = trim($specRows->eq($idxSpec)->text());
                echo "    Spec {$field} .= {$value}\n";
                $platform[$field] = !array_key_exists($field, $platform) ? $value : $platform[$field].'<br>'.$value;
            }
        }
        if ($rows->count() > 2) {
            for ($idxRow = 2, $maxRow = $rows->count(); $idxRow < $maxRow; $idxRow++) {
                $seoSection = $rows->eq($idxRow)->filter('h2')->attr('id');
                $section = $rows->eq($idxRow)->filter('h2')->text();
                if (is_null($seoSection)) {
                    echo "    Skipping section {$section} (null seo section)\n";
                    continue;
                }
                if ($rows->eq($idxRow)->filter('.border .blog-reel-post')->count() == 0) {
                    echo "    Skipping section {$section} (doesnt match our stuff)\n";
                    continue;
                }
                echo "      Adding Section {$section} ({$seoSection})\n";
                $platform[$seoSection] = [];
                $items = $rows->eq($idxRow)->filter('.border');
                for ($idxItem = 0, $maxItem = $items->count(); $idxItem < $maxItem; $idxItem++) {
                    $row = [
                        'id' => '',
                        'url' => $items->eq($idxItem)->filter('.blog-reel-post')->attr('href'),
                        'name' => $items->eq($idxItem)->filter('.emulator-description p a')->text(),
                        'description' => trim(html_entity_decode(str_replace(['<br>'], ["\n"], preg_replace('/<\/?(p|a)[^>]*>/', '', trim($items->eq($idxItem)->filter('.emulator-description')->html()))))),
                    ];
                    $row['id'] = basename($row['url']);
                    if ($items->eq($idxItem)->filter('.emulator-image img')->count() > 0)
                        $row['logo'] = $items->eq($idxItem)->filter('.emulator-image img')->attr('src');
                    echo "          Adding {$section}: {$row['url']}\n";
                    if ($seoSection == 'emulators') {
                        $row['shortDesc'] = $row['description'];
                        unset($row['description']);
                        $row['description'] = $row['shortDesc'];
                        $row['platforms'] = [];
                        $oses = $items->eq($idxItem)->filter('.emulator-supported-osw-100 i');
                        if ($oses->count() > 0) {
                            $row['runs'] = [];
                            for ($idxOs = 0, $maxOs = $oses->count(); $idxOs < $maxOs; $idxOs++ ) {
                                $os = $oses->eq($idxOs)->attr('class');
                                $row['runs'][] = str_replace('emu-icon-', '', $os);
                            }
                        }
                        if (!array_key_exists($row['id'], $source['emulators'])) {
                            $data['emulators'][$row['id']] = $row;
                            $source['emulators'][$row['id']] = [
                                'id' => $row['id'],
                                'name' => $row['name'],
                                'shortName' => $row['id'],
                                'platforms' => []
                            ];
                        }
                        $source['emulators'][$row['id']]['platforms'][] = $platform['id'];
                        $data['emulators'][$row['id']]['platforms'][] = $platform['id'];
                        $platform[$seoSection][] = $row['id'];

                        echo "          Loading Emulator {$row['url']}\n";
                        $isCached = file_exists($cacheStore->getPath(hash('sha256', $row['url'])));
                        $crawler = $client->request('GET', $row['url']);
                        if ($isCached == false)
                            sleep(1);
                        //eval(\Psy\sh());
                        $crawler->filter('.lbb-block-slot')->each(function (Crawler $crawler, $i) {
                            foreach ($crawler as $node) {
                                $node->parentNode->removeChild($node);
                            }
                        });
                        $emuRows = $crawler->filter('article > .row');
                        $fullName = $emuRows->eq(0)->filter('.entry-title')->text();
                        $data['emulators'][$row['id']]['logo'] = $emuRows->eq(1)->filter('div .game-cover .cover-image')->attr('src');
                        $screenshots = [];
                        $emuRows->eq(1)->filter('div .game-screenshots .imagelightbox')->each(function (Crawler $crawler, $i) use (&$screenshots) {
                            $screenshot = $crawler->attr('href');
                            $screenshots[] = $screenshot;
                            //foreach ($crawler as $node) {
                                //$screenshot = $node->attr('href');
                                //$screenshots[] = $screenshot;
                            //}
                        });
                        if (count($screenshots) > 0) {
                            $data['emulators'][$row['id']]['screenshots'] = $screenshots;
                        }
                        $data['emulators'][$row['id']]['description'] = trim(html_entity_decode(str_replace(['<br>'], ["\n"], preg_replace('/<\/?(p|a)[^>]*>/', '', trim($emuRows->eq(1)->filter('div .entry-content')->html())))));
                        if ($emuRows->eq(1)->filter('div .console-meta')->count() > 0) {
                            $specRows = $emuRows->eq(1)->filter('div .console-meta')->children();
                            for ($idxSpec = 1, $maxSpec = $specRows->count(); $idxSpec < $maxSpec; $idxSpec++) {
                                $node = $specRows->eq($idxSpec)->filter('strong');
                                if ($node->count() > 0) {
                                    $field = str_replace([':'], [''], $node->text()) ;
                                    foreach ($node as $thenode)
                                        $thenode->parentNode->removeChild($thenode);
                                }
                                $value = trim($specRows->eq($idxSpec)->text());
                                echo "          Spec {$field} .= {$value}\n";
                                $data['emulators'][$row['id']][$field] = !array_key_exists($field, $data['emulators'][$row['id']]) ? $value : $data['emulators'][$row['id']][$field].'<br>'.$value;
                            }
                        }

                        echo "          Loading Emulator Archive {$row['url']}archive/\n";
                        $isCached = file_exists($cacheStore->getPath(hash('sha256', $row['url'].'archive/')));
                        $crawler = $client->request('GET', $row['url'].'archive/');
                        if ($isCached == false)
                            sleep(1);
                        //eval(\Psy\sh());
                        $crawler->filter('.lbb-block-slot')->each(function (Crawler $crawler, $i) {
                            foreach ($crawler as $node) {
                                $node->parentNode->removeChild($node);
                            }
                        });
                        if (!isset($data['emulators'][$row['id']]['versions'])) {
                            $data['emulators'][$row['id']]['versions'] = [];
                        }
                        $dlRows = $crawler->filter('article > .row > div.mx-auto > a');
                        for ($idxDl = 0, $dlMax = $dlRows->count(); $idxDl < $dlMax; $idxDl++) {
                            $dlRow = $dlRows->eq($idxDl);
                            $dlOs = ucwords(str_replace('down-icon emu-icon-', '', $dlRow->filter('.down-icon')->attr('class')));
                            if ($dlRow->filter('span.d-block strong')->count() > 0) {
                                $dlBranch = $dlRow->filter('.d-block strong')->text();
                            } else {
                                $dlBranch = null;
                            }
                            $dlPageUrl = $dlRow->attr('href');
                            $dlId = str_replace('/', '_', preg_replace('/https:\/\/emulationking.com\/(.*)\/$/', '$1', $dlPageUrl));
                            foreach (['div', 'span'] as $element) {
                                $dlRow->filter($element)->each(function (Crawler $crawler, $i) {
                                    foreach ($crawler as $node) {
                                        $node->parentNode->removeChild($node);
                                    }
                                });
                            }
                            $dlVer = preg_replace('/'.preg_quote($fullName).' \((.*)\)/', '$1', $dlRow->html());
                            if (preg_match('/((\d\d)\/(\d\d)\/(\d\d\d\d))/', $dlVer, $matches)) {
                                $dlVer = preg_replace('/((\d\d)\/(\d\d)\/(\d\d\d\d))/', '$4-$3-$2', $dlVer);
                                $dlDate = $matches[4].'/'.$matches[3].'/'.$matches[2];
                            } else {
                                $dlDate = null;
                            }

                            echo "          Got DL FullName {$fullName} OS {$dlOs} Branch {$dlBranch} ID {$dlId} Ver {$dlVer} PageURL: {$dlPageUrl}\n";
                            echo "          Loading Emulator Download {$dlPageUrl}\n";
                            $isCached = file_exists($cacheStore->getPath(hash('sha256', $dlPageUrl)));
                            $crawler = $client->request('GET', $dlPageUrl, ['headers' => ['Referer' => $row['url'].'archive/']]);
                            if ($isCached == false)
                                sleep(1);
                            $dlToken = $crawler->filter('a.emu-icon-download')->attr('href');
                            $dlUrl = preg_replace('/\?token=.*$/', '', $dlToken);
                            $dlPathSuffix = str_replace('https://files.emulationking.com/', '', $dlUrl);
                            echo "           Final URL {$dlUrl} Suffix {$dlPathSuffix}\n";
                            $dlPath = __DIR__.'/../../../public/emulationking/'.$dlPathSuffix;
                            $newPath = __DIR__.'/../../../public/emulationking/'.$row['id'].'/'.basename($dlPath);
                            if (in_array($row['id'].'/'.basename($dlPath), $missingFiles)) {
                                echo "                 Skipping 404 File\n";
                                continue;
                            }
                            if (file_exists($newPath)) {
                                echo "           Finished File already exists {$newPath}\n";
                            } else {
                                if (!file_exists(dirname($newPath))) {
                                    mkdir(dirname($newPath), 0777, true);
                                }
                                echo `wget --referer="{$dlPageUrl}" "{$dlToken}" -O "{$newPath}" || rm -fv "{$newPath}"`;
                                if (!file_exists($newPath)) {
                                    $missingFiles[] = $row['id'].'/'.basename($dlPath);
                                    echo "          Skipping Emulator Ver {$dlVer}\n";
                                    continue;
                                }
                            }
                            $dlUrl = 'https://consolo.is.cc/emulationking/'.$row['id'].'/'.basename($dlPath);
                            /* "1.26.2.2": {
                                "url": "https://consolo.is.cc/emu/applewin/1.26.2.2.7z",
                                "bin": "Applewin.exe",
                                "os": "Windows",
                                "os_ver": "XP,Vista,7,8,10",
                                "bits": 32,
                                "date": "2017-04-15",
                                "changes": "https://consolo.is.cc/emu/applewin/1.26.2.2_changelog.txt"
                            }, */
                            $version = [
                                'url' => $dlUrl,
                                'os' => $dlOs,
                                'date' => $dlDate,
                                'branch' => $dlBranch,
                            ];
                            foreach (['date', 'branch'] as $field) {
                                if (is_null($version[$field])) {
                                    unset($version[$field]);
                                }
                            }
                            $data['emulators'][$row['id']]['versions'][$dlVer] = $version;
                        }

                    } else {
                        $platform[$seoSection][] = $row;
                    }

                }
            }
        }
        $data['platforms'][$idxPlat] = $platform;
    }
}
file_put_contents('emualtionking_missing.json', json_encode($missingFiles, getJsonOpts()));
echo "Calculating Version Details and Applying Changes...";
$publicDir = __DIR__.'/../../../public';
$binsTxt = file_get_contents($publicDir.'/bins.txt');
$ibinsTxt = file_get_contents($publicDir.'/ibins.txt');
$timeMin = strtotime("1990/01/01");
$timeMax = time();
preg_match_all('/^(?<file>[^:]+):\s+.*PE32.*$/muU', $ibinsTxt, $matches);
$binDates = [];
foreach ($matches['file'] as $idx => $fileName) {
    $cmd = "readpe -f json -h coff '{$publicDir}/{$fileName}'";
    //echo $cmd."\n";
    $binJson = json_decode(trim(`{$cmd}`), true);
    $timestamp = substr($binJson["COFF/File header"]["Date/time stamp"], 0, strpos($binJson["COFF/File header"]["Date/time stamp"], ' '));
    if ($timestamp >= $timeMin && $timestamp <= $timeMax) {
        $date = date('Y-m-d', $timestamp);
        $binDates[$fileName] = $date;
    }
}
preg_match_all('/^.*emulationking\/(?P<emuId>[^\/]*)\/(?P<zip>[^\/]+)\/(?P<sub>[^\/]+)[\/:].*$/muU', $binsTxt, $subDirMatches);
$subCounts = [];
foreach ($subDirMatches['emuId'] as $idx => $emuId) {
    $zip = $subDirMatches['zip'][$idx];
    $sub = $subDirMatches['sub'][$idx];
    if (!array_key_exists($emuId, $subCounts))
        $subCounts[$emuId] = [];
    if (!array_key_exists($zip, $subCounts[$emuId]))
        $subCounts[$emuId][$zip] = [];
    $subCounts[$emuId][$zip][] = $sub;
}
foreach ($subCounts as $emuId => $subZips) {
    foreach ($subZips as $zip => $subs) {
        if (count($subs) == 1) {
            $dir = $subs[0];

        }
    }
}

$fileTypes = [
    "executable.*Intel 80386"       => ['os' => 'Windows', 'bits' => 32],
    "executable.*x86-64"            => ['os' => 'Windows', 'bits' => 64],
    "executable.*Aarch64"           => ['os' => 'Windows', 'bits' => 64, 'os_arch' => 'arm'],
    "Mach-O.*x86_64.*executable"    => ['os' => 'MAC', 'bits' => 64],
    "Mach-O i386.*executable"       => ['os' => 'MAC', 'bits' => 32],
    "Mach-O ppc.*executable"        => ['os' => 'MAC', 'bits' => 32, 'os_arch' => 'ppc'],
    "Mach-O universal.*executable"  => ['os' => 'MAC', 'bits' => 64, 'os_arch' => 'x86,arm'],
    "Mach-O.*executable.*arm64"     => ['os' => 'MAC', 'bits' => 64, 'os_arch' => 'arm'],
    "ELF.*executable.*x86-64"       => ['os' => 'Linux', 'bits' => 64],
    "ELF.*executable.*Intel 80386"  => ['os' => 'Linux', 'bits' => 32],
    "ELF.*executable.*ARM"          => ['os' => 'Linux', 'bits' => 64, 'os_arch' => 'arm']
];
// TODO
// - merge the entries
// - detect distro packages, etc
// - add list of bins
$binMatches =[];
foreach ([$ibinsTxt, $binsTxt] as $searchTxt) {
    foreach ($fileTypes as $typeRegex => $typeSets) {
        if (preg_match_all('/^.*emulationking\/(?P<emuId>[^\/]+)\/(?P<ver>[^:]+):\s*.*'.$typeRegex.'.*$/muU', $searchTxt, $matches)) {
            foreach ($matches['emuId'] as $idx => $emuId) {
                $binFile = $matches['ver'][$idx];
                foreach ($data['emulators'][$emuId]['versions'] as $emuVer => $verData) {
                    preg_match_all('/^x?emulationking\/(?P<emuId>[^\/]+)\/(?P<ver>[^\/:]+)[\/:].*$/muU', $binFile, $urlMatches);
                    foreach ($urlMatches['emuId'] as $urlIdx => $urlEmuId) {
                        $urlVer = $urlMatches['ver'][$urlIdx];
                        if ($verData['url'] == 'https://consolo.is.cc/emulationking/'.$emuId.'/'.$urlVer) {
                            if (isset($binDates['emulationking/'.$emuId.'/'.$urlVer])) {
                                $data['emulators'][$emuId]['versions'][$urlVer]['date'] = $binDates['emulationking/'.$emuId.'/'.$urlVer];
                            }
                            if (count($subCounts[$emuId][$urlVer]) == 1) {
                                $data['emulators'][$emuId]['versions'][$emuVer]['dir'] = $subCounts[$emuId][$urlVer][0];
                            }
                            // found matching version
                            foreach ($typeSets as $field => $value) {
                                $data['emulators'][$emuId]['versions'][$emuVer][$field] =  $value;
                            }
                        }
                    }
                }
            }
        }
    }
}
echo "Writing Parsed Tree..";
file_put_contents(__DIR__.'/../../../../emulation-data/emulationking.json', json_encode($data, getJsonOpts()));
$sources = json_decode(file_get_contents(__DIR__.'/../../../../emurelation/sources.json'), true);
$sources['emulationking']['updatedLast'] = time();
file_put_contents(__DIR__.'/../../../../emurelation/sources.json', json_encode($sources, getJsonOpts()));
foreach ($source as $type => $data) {
    file_put_contents(__DIR__.'/../../../../emurelation/'.$type.'/emulationking.json', json_encode($data, getJsonOpts()));
}
echo "done\n";
if ($keep === false) {
    echo "clearing cache\n";
    echo `rm -rf cache`;
}
