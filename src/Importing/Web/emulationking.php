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
    -k          keep xml files, dont delete them
    --no-db     skip the db updates/inserts
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
if ($useCache === true) {
    @mkdir('cache');
}
if ($useCache === true && file_exists('cache/index.html')) {
    $html = file_get_contents('cache/index.html');
} else {
    $html = getcurlpage($url);
    if ($useCache === true) {
        file_put_contents('cache/index.html', $html);
    }
}
$crawler = new Crawler($html);
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
        echo "Added Platform {$platform['name']}\n";
    }
    $data['companies'][$company['id']] = $company;
    echo "Added Manufacturer {$company['name']}\n";
}
foreach ($data['companies'] as $idxMan => $company) {
    echo "Loading {$company['url']}\n";
    if ($useCache === true && file_exists('cache/'.$idxMan.'.html')) {
        $html = file_get_contents('cache/'.$idxMan.'.html');
    } else {
        sleep(1);
        $html = getcurlpage($company['url']);
        if ($useCache === true) {
            file_put_contents('cache/'.$idxMan.'.html', $html);
        }
    }
    $crawler = new Crawler($html);
    $data['companies'][$idxMan]['description'] = trim(html_entity_decode(str_replace(['<br>'], ["\n"], preg_replace('/<\/?p>/', '', preg_replace('/^<p><img[^>]*>/', '', trim($crawler->filter('.entry-content')->html()))))));
    $data['companies'][$idxMan]['logo'] = $crawler->filter('.entry-content img')->eq(0)->attr('src');
}
foreach ($data['companies'] as $idxMan => $company) {
    foreach ($company['platforms'] as $idxPlat) {
        $platform = $data['platforms'][$idxPlat];
        echo "Loading {$platform['url']}\n";
        if ($useCache === true && file_exists('cache/'.$idxPlat.'.html')) {
            $html = file_get_contents('cache/'.$idxPlat.'.html');
        } else {
            sleep(1);
            $html = getcurlpage($platform['url']);
            if ($useCache === true) {
                file_put_contents('cache/'.$idxPlat.'.html', $html);
            }
        }
        $crawler = new Crawler($html);
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
                echo "  Spec {$field} .= {$value}\n";
                $platform[$field] = !array_key_exists($field, $platform) ? $value : $platform[$field].'<br>'.$value;
            }
        }
        if ($rows->count() > 2) {
            for ($idxRow = 2, $maxRow = $rows->count(); $idxRow < $maxRow; $idxRow++) {
                $seoSection = $rows->eq($idxRow)->filter('h2')->attr('id');
                $section = $rows->eq($idxRow)->filter('h2')->text();
                if (is_null($seoSection)) {
                    echo "  Skipping section {$section} (null seo section)\n";
                    continue;
                }
                if ($rows->eq($idxRow)->filter('.border .blog-reel-post')->count() == 0) {
                    echo "  Skipping section {$section} (doesnt match our stuff)\n";
                    continue;
                }
                echo "  Adding Section {$section} ({$seoSection})\n";
                $platform[$seoSection] = [];
                $items = $rows->eq($idxRow)->filter('.border');
                for ($idxItem = 0, $maxItem = $items->count(); $idxItem < $maxItem; $idxItem++) {
                    $row = [
                        'id' => '',
                        'url' => $items->eq($idxItem)->filter('.blog-reel-post')->attr('href'),
                        'name' => $items->eq($idxItem)->filter('.emulator-description p a')->text(),
                        'description' => trim(html_entity_decode(str_replace(['<br>'], ["\n"], preg_replace('/<\/?(p|a)[^>]*>/', '', trim($items->eq($idxItem)->filter('.emulator-description')->html())))))
                    ];
                    $row['id'] = basename($row['url']);
                    if ($items->eq($idxItem)->filter('.emulator-image img')->count() > 0)
                        $row['logo'] = $items->eq($idxItem)->filter('.emulator-image img')->attr('src');
                    $row['platforms'] = [];
                    $oses = $items->eq($idxItem)->filter('.emulator-supported-osw-100 i');
                    if ($oses->count() > 0) {
                        $row['runs'] = [];
                        for ($idxOs = 0, $maxOs = $oses->count(); $idxOs < $maxOs; $idxOs++ ) {
                            $os = $oses->eq($idxOs)->attr('class');
                            $row['runs'][] = str_replace('emu-icon-', '', $os);
                        }
                    }
                    echo "      Adding {$section}: {$row['url']}\n";
                    if ($seoSection == 'emulators') {
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
                    } else {
                        $platform[$seoSection][] = $row;
                    }

                }
            }
        }
        $data['platforms'][$idxPlat] = $platform;
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
