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
$dir = '/mnt/e/dev/ConSolo/mirror/emulationking/emulationking.com';
$dataDir = '/mnt/e/dev/ConSolo/data/json/emulationking';
if (!file_Exists($dataDir)) {
	mkdir($dataDir, 0777, true);
}
$html = file_get_contents($dir.'/index.html');
$crawler = new Crawler($html);
$rows = $crawler->filter('.site-main > div.row');
$manufacturers = [];
for ($idx = 0, $idxMax = $rows->count(); $idx < $idxMax; $idx++ ) {
    $manufacturer = [
        'url' => $rows->eq($idx)->filter('h2 a')->attr('href'),
        'name' => $rows->eq($idx)->filter('h2 a')->text(),
        'platforms' => [],
    ];
    $idx++;
    $platformRows = $rows->eq($idx)->filter('div > a.console_icons');
    for ($idxPlat = 0, $maxPlat = $platformRows->count(); $idxPlat < $maxPlat; $idxPlat++) {
        preg_match('/^(?P<platform>.*) \(Rel (?P<year>[0-9][0-9][0-9][0-9])\)/', $rows->eq($idx)->filter('div > a.console_icons')->text(), $matches);
        $platform = [
            'url' => $rows->eq($idx)->filter('div > a.console_icons')->attr('href'),
            'name' => $matches[1],
            'year' => matches[2],
            'runs' => [],
            'sections' => [],
       ];
        $mnanufacturer['platforms'][] = $platform;
        echo "Added Platform {$platform['name']}\n";
    }
    $manufacturers[] = $manufacturer;
    echo "Added Manufacturer {$manufacturer['name']}\n";
}
foreach ($manufacturers as $idxMan => $manufacturer) {
    $html = file_get_contents($dir.$manufacturer['url']);
    $crawler = new Crawler($html);
    $manufacturers[$idxMan]['description'] = $crawler->filter('.entry-content')->html();
}
foreach ($manufacturers as $idxMan => $manufacturer) {
    foreach ($manufacturer['platforms'] as $idxPlat => $platform) {
        $html = file_get_contents($dir.$platform['url']);
        $crawler = new Crawler($html);
        $crawler->filter('.lbb-block-slot')->each(function (Crawler $node, $i) {
            foreach ($crawler as $node) {
                echo "Removing This HTML:".$node->html()."\n";
                $node->parentNode->removeChild($node);
            }
        });
        $rows = $crawler->filter('article > .row');
        $platform['name'] = $rows->eq(0)->filter('article .entry-title')->text();
        $platform['image_cover'] = $rows->eq(1)->filter('div .game-cover .cover-image')->attr('src');
        $specRows = $rows->eq(1)->filter('div .console-meta')->children();
        for ($idxSpec = 1, $maxSpec = $specRows->count(); $idxSpec < $maxSpec; $idxSpec++) {
            $node = $specRows->eq($idxSpec)->filter('strong');
            $field = $node->text();
            $node->parentNode->removeChild($node);
            $value = $specRows->eq($idxSpec)->text();
            $platform[$field] = $value;
        }
        $platform['description'] = $rows->eq(1)->filter('div .entry-content')->html();
        for ($idxRow = 2, $maxRow = $rows->count(); $idxRow < $maxRow; $idxRow++) {
            $seoSection = $rows->eq($idxRow)->filter('h2')->attr('id');
            $section = $rows->eq($idxRow)->filter('h2')->text();
            $platform[$seoSection] = [];
            $platform['sections'][$seoSection] = $section;
            $items = $rows->eq($idxRow)->filter('.border');
            for ($idxItem = 0, $maxItem = $items->count(); $idxItem < $maxItem; $idxItem++) {
                $row = [
                    'url' => $items->eq($idxItem)->filter('.blog-reel-post')->attr('href'),
                    'body_html' => $items->eq($idxItem)->filter('.blog-reel-post .emulator-description')->html(),
                    'body_text' => $items->eq($idxItem)->filter('.blog-reel-post .emulator-description')->text(),
                ];
                if ($items->eq($idxItem)->filter('.blog-reel-post .emulator-image img')->count() > 0)
                    $row['logo'] = $items->eq($idxItem)->filter('.blog-reel-post .emulator-image img')->attr('src');
                $oses = $items->eq($idxItem)->filter('.blog-reel-post emulator-supported-osw-100 i');
                if ($oses->count() > 0) {
                    $row['runs'] = [];
                    foreach ($oses as $node) {
                        $os = $node->attr('class');
                        $row['runs'][] = $os;
                    }
                }
            }
        }
        $manufacturer['platforms'][$idxPlat] = $platform;
        $manufacturers[$idxMan]['platforms'][$idxPlat] = $platform;
    }
}
echo "Writing Parsed Tree..";
file_put_contents($dataDir.'/json/emulationking/emulationking.json', json_encode($manufacturers));
echo "done\n";
