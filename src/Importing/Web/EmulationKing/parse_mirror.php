<?php


use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\CssSelector\CssSelectorConverter;

require_once __DIR__.'/../../../bootstrap.php';
/**
* @var \Workerman\MySQL\Connection
*/
global $db;

$converter = new CssSelectorConverter();
//var_dump($converter->toXPath('.post-labels a[rel="tag"]'));
$dir = 'https://emulationking.com';
$dataDir = '/mnt/e/dev/ConSolo/data/json/emulationking';
if (!file_Exists($dataDir)) {
	mkdir($dataDir, 0777, true);
}
$html = getcurlpage($dir.'/');
$crawler = new Crawler($html);
$rows = $crawler->filter('.site-main > div.row');
$manufacturers = [];
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
            'runs' => [],
            'sections' => [],
       ];
        $manufacturer['platforms'][] = $platform;
        echo "Added Platform {$platform['name']}\n";
    }
    $manufacturers[] = $manufacturer;
    echo "Added Manufacturer {$manufacturer['name']}\n";
}
foreach ($manufacturers as $idxMan => $manufacturer) {
    $html = getcurlpage($manufacturer['url']);
    $crawler = new Crawler($html);
    $manufacturers[$idxMan]['description'] = $crawler->filter('.entry-content')->html();
}
foreach ($manufacturers as $idxMan => $manufacturer) {
    foreach ($manufacturer['platforms'] as $idxPlat => $platform) {
        $html = getcurlpage($platform['url']);
        $crawler = new Crawler($html);
        //eval(\Psy\sh());
        $crawler->filter('.lbb-block-slot')->each(function (Crawler $crawler, $i) {
            foreach ($crawler as $node) {
                echo "Removing This HTML:".$crawler->html()."\n";
                $node->parentNode->removeChild($node);
            }
        });

        $rows = $crawler->filter('article > .row');
        $platform['name'] = $rows->eq(0)->filter('.entry-title')->text();
        $platform['image_cover'] = $rows->eq(1)->filter('div .game-cover .cover-image')->attr('src');
        $specRows = $rows->eq(1)->filter('div .console-meta')->children();
        for ($idxSpec = 1, $maxSpec = $specRows->count(); $idxSpec < $maxSpec; $idxSpec++) {
            $node = $specRows->eq($idxSpec)->filter('strong');
            $field = str_replace([':'], [''], $node->text()) ;
            foreach ($node as $thenode)
                $thenode->parentNode->removeChild($thenode);
            $value = trim($specRows->eq($idxSpec)->text());
            $platform[$field] = $value;
        }
        $platform['description'] = trim($rows->eq(1)->filter('div .entry-content')->html());
        for ($idxRow = 2, $maxRow = $rows->count(); $idxRow < $maxRow; $idxRow++) {
            $seoSection = $rows->eq($idxRow)->filter('h2')->attr('id');
            if (is_null($seoSection))
                continue;
            $section = $rows->eq($idxRow)->filter('h2')->text();
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
                        $row['runs'][] = $os;
                    }
                }
                $platform[$seoSection][] = $row;
            }
        }
        $manufacturer['platforms'][$idxPlat] = $platform;
        $manufacturers[$idxMan]['platforms'][$idxPlat] = $platform;
        eval(\Psy\sh());
    }
}
print_r($manufacturers);exit;
echo "Writing Parsed Tree..";
file_put_contents($dataDir.'/json/emulationking/emulationking.json', json_encode($manufacturers));
echo "done\n";
