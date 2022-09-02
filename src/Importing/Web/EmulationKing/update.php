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

require_once __DIR__.'/../../../bootstrap.php';

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
$skipDb = in_array('--no-db', $_SERVER['argv']);
$useCache = !in_array('--no-cache', $_SERVER['argv']);;
$url = 'https://emulationking.com/';
$companies = [];
$platforms = [];
$emulators = [];
$source = [
    'platforms' => [],
    'companies' => [],
    'emulators' => []
];
if (!file_Exists(__DIR__.'/../../../../data/json/emulationking')) {
	mkdir(__DIR__.'/../../../../data/json/emulationking', 0777, true);
}
$converter = new CssSelectorConverter();
$html = getcurlpage($url);
$crawler = new Crawler($html);
$rows = $crawler->filter('.site-main > div.row');
for ($idx = 0, $idxMax = $rows->count(); $idx < $idxMax; $idx++ ) {
    $manufacturer = [
        'url' => $rows->eq($idx)->filter('h2 a')->attr('href'),
        'name' => $rows->eq($idx)->filter('h2 a')->text(),
        'description' => '',
        'platforms' => [],
    ];
    $idx++;
    $platformRows = $rows->eq($idx)->filter('div > a.console_icons');
    for ($idxPlat = 0, $maxPlat = $platformRows->count(); $idxPlat < $maxPlat; $idxPlat++) {
        preg_match('/^(?P<platform>.*) \(Rel (?P<year>[0-9][0-9][0-9][0-9])\)/', $platformRows->eq($idxPlat)->text(), $matches);
        $platform = [
            'url' => $platformRows->eq($idxPlat)->attr('href'),
            'name' => $matches[1],
            'year' => $matches[2],
            'sections' => [],
       ];
        $manufacturer['platforms'][] = $platform;
        echo "Added Platform {$platform['name']}\n";
    }
    $companies[] = $manufacturer;
    echo "Added Manufacturer {$manufacturer['name']}\n";
}
foreach ($companies as $idxMan => $manufacturer) {
    sleep(1);
    echo "Loading {$manufacturer['url']}\n";
    $html = getcurlpage($manufacturer['url']);
    $crawler = new Crawler($html);
    $companies[$idxMan]['description'] = trim($crawler->filter('.entry-content')->html());
}
foreach ($companies as $idxMan => $manufacturer) {
    foreach ($manufacturer['platforms'] as $idxPlat => $platform) {
        sleep(1);
        echo "Loading {$platform['url']}\n";
        $html = getcurlpage($platform['url']);
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
        $platform['image_cover'] = $rows->eq(1)->filter('div .game-cover .cover-image')->attr('src');
        $platform['description'] = trim($rows->eq(1)->filter('div .entry-content')->html());
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
                $platform['sections'][$seoSection] = $section;
                $items = $rows->eq($idxRow)->filter('.border');
                for ($idxItem = 0, $maxItem = $items->count(); $idxItem < $maxItem; $idxItem++) {
                    $row = [
                        'url' => $items->eq($idxItem)->filter('.blog-reel-post')->attr('href'),
                        'body_html' => $items->eq($idxItem)->filter('.emulator-description')->html(),
                        'body_text' => $items->eq($idxItem)->filter('.emulator-description')->text(),
                    ];
                    if ($items->eq($idxItem)->filter('.emulator-image img')->count() > 0)
                        $row['logo'] = $items->eq($idxItem)->filter('.emulator-image img')->attr('src');
                    $oses = $items->eq($idxItem)->filter('.emulator-supported-osw-100 i');
                    if ($oses->count() > 0) {
                        $row['runs'] = [];
                        for ($idxOs = 0, $maxOs = $oses->count(); $idxOs < $maxOs; $idxOs++ ) {
                            $os = $oses->eq($idxOs)->attr('class');
                            $row['runs'][] = str_replace('emu-icon-', '', $os);
                        }
                    }
                    echo "      Adding {$section}: {$row['url']}\n";
                    $platform[$seoSection][] = $row;
                }
            }
        }
        $manufacturer['platforms'][$idxPlat] = $platform;
        $companies[$idxMan]['platforms'][$idxPlat] = $platform;
    }
}

echo "Writing Parsed Tree..";
$companies = json_decode(file_get_contents(__DIR__.'/../../../../data/json/emulationking/emulationking.json'), true);
file_put_contents(__DIR__.'/../../../../data/json/emulationking/emulationking.json', json_encode($companies, getJsonOpts()));
echo "done\n";
$sources = json_decode(file_get_contents(__DIR__.'/../../../../../emurelation/sources.json'), true);
$sources['emulationking']['updatedLast'] = time();
file_put_contents(__DIR__.'/../../../../../emurelation/sources.json', json_encode($sources, getJsonOpts()));
file_put_contents(__DIR__.'/../../../../../emurelation/sources/emulationking.json', json_encode($source, getJsonOpts()));
