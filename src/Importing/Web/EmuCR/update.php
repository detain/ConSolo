<?php
/**
* parses data from old-computers.com
* 
* @todo import software,videos,docs,comments pages
*/

use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

require_once __DIR__.'/../../../bootstrap.php';
/**
* @var \Workerman\MySQL\Connection
*/
global $db;
$row = $db->query("select * from config where field='emucr'");
if (count($row) == 0) {
	$last = 0;
	$db->query("insert into config values ('emucr','0')");
} else {
	$last = $row[0]['value'];
}
$client = new Client();
$sitePrefix = 'https://www.emucr.com/';
$types = ['st' => 'type_id', 'c' => 'computer_id'];
$dataDir = '/storage/local/ConSolo/data';
echo 'Loading and scanning for archive pages..';
$computerUrls = [];
$crawler = $client->request('GET', $sitePrefix);
$crawler->filter('li.archivedate a')->each(function ($node) use (&$computerUrls) {
	$computerUrls[] = $node->attr('href');
});
echo ' done'.PHP_EOL;
echo 'Found '.count($computerUrls).' Archive Pages'.PHP_EOL;
rsort($computerUrls);
$postUrls = [];
echo 'Loading Archive Pages ';
foreach ($computerUrls as $url) {
	echo '.';
	if (file_exists($dataDir.'/json/emucr/archive/'.str_replace($sitePrefix, '', $url).'.json')) {
		$pageUrls = json_decode(file_get_contents($dataDir.'/json/emucr/archive/'.str_replace($sitePrefix, '', $url).'.json'), true);
	} else {
		$crawler = $client->request('GET', $url);
		$pageUrls = [];
		$crawler->filter('.blog-posts > a')->each(function ($node) use (&$pageUrls) {
			$pageUrls[$node->attr('href')] = $node->attr('title');
		});
		file_put_contents($dataDir.'/json/emucr/archive/'.str_replace($sitePrefix, '', $url).'.json', json_encode($pageUrls, JSON_PRETTY_PRINT));
	}
	foreach ($pageUrls as $url => $title)
		$postUrls[$url] = $title;
}
echo ' done'.PHP_EOL;
echo 'Found '.count($postUrls).' Post Pages'.PHP_EOL;
file_put_contents($dataDir.'/json/emucr/urls.json', json_encode($computerUrls, JSON_PRETTY_PRINT));
exit;
$computerUrls = json_decode(file_get_contents($dataDir.'/json/emucr/urls.json'), true);
echo 'Loading Computer URLs'.PHP_EOL;
/*
$db->query("truncate emucr_emulator_platforms");
$db->query("delete from emucr_platforms");
$db->query("delete from emucr_emulators");
$db->query("alter table emucr_emulators auto_increment=1");
$db->query("alter table emucr_platforms auto_increment=1");
*/
$platforms = [];
$total = count($computerUrls);
$allEmulators = [];
echo 'Found '.$total.' Systems'.PHP_EOL;
foreach ($computerUrls as $idx => $url) {
	$cols = [];
	$urlParts = parse_url($url);
	$query = explode('&', $urlParts['query']);
	foreach ($query as $queryPart) {
		list($key, $value) = explode('=', $queryPart);
		$cols[$types[$key]] = $value;
	}
	echo "[{$idx}/{$total}] Loading URL $url\n";
	if (file_exists($dataDir.'/json/emucr/platforms/'.$cols['computer_id'].'.json')) {
		$cols = json_decode($dataDir.'/json/emucr/platforms/'.$cols['computer_id'].'.json', true);
	} else{ 
		/**
		* @var \Symfony\Component\DomCrawler\Crawler
		*/
		$crawler = $client->request('GET', $sitePrefix.$url);
		$key = false;
		$value = false;
		$emulators = false;
		$cols['pages'] = [];
		$crawler->filter('#navbar2 a.navbutton')->each(function($node, $i) use (&$cols) {
			$link = $node->attr('href');
			$text = $node->text();
			$cols['pages'][strtolower($text)] = $link;
			//echo "Link $link - $text\n";
		});
		if ($crawler->filter('table.petitnoir2 tr:nth-child(1) > td:nth-child(3) > table:nth-child(3) tr:nth-child(1) > td:nth-child(1) > img:nth-child(1)')->count() > 0)
			$cols['image'] = $sitePrefix.$crawler->filter('table.petitnoir2 tr:nth-child(1) > td:nth-child(3) > table:nth-child(3) tr:nth-child(1) > td:nth-child(1) > img:nth-child(1)')->attr('src');
		$crawler = $crawler->filter('table.petitnoir2 tr:nth-child(1) > td:nth-child(3)')->eq(0);
		$cols['company_link'] = $crawler->filter('.grandvert')->eq(0)->attr('href');
		if ($crawler->filter('.grandvert img')->count() > 0) {
			$cols['company_name'] = $crawler->filter('.grandvert img')->attr('alt');
			$cols['company_logo'] = $sitePrefix.$crawler->filter('.grandvert img')->attr('src');
		} else {
			$cols['comany_name'] = $crawler->filter('.grandvert')->eq(0)->text();
		}
		$cols['description'] = trim(str_replace(['<br>',PHP_EOL.PHP_EOL.PHP_EOL,PHP_EOL.PHP_EOL],[PHP_EOL,PHP_EOL,PHP_EOL], $crawler->filter('p.petitnoir')->html()));
		$crawler->filter('table tr td table tr td.petitnoir2')->each(function(Crawler $node, $i) use (&$cols, &$key, &$value) {
			if ($i % 2 == 0)
				$key = str_replace([' ','/','-','__'], ['_','','_','_'], strtolower(html_entity_decode(trim(preg_replace('/\s+/msuU', ' ', $node->text())))));
			else
				$cols[$key] = $node->html();
		});
		file_put_contents($dataDir.'/json/emucr/platforms/'.$cols['computer_id'].'.json', json_encode($cols, JSON_PRETTY_PRINT));
	}
	$platforms[] = $cols;
}
file_put_contents($dataDir.'/json/emucr/platforms.json', json_encode($platforms, JSON_PRETTY_PRINT));
echo PHP_EOL.'done!'.PHP_EOL;
exit;
echo 'Inserting Emulators into DB   ';
foreach ($allEmulators as $name => $emulator) {
	$emulator['host'] = implode(', ', $emulator['hosts']);
	$platforms = $emulator['platforms'];
	unset($emulator['platforms']);
	unset($emulator['hosts']);
	$emulatorId = $db->insert('emucr_emulators')->cols($emulator)->lowPriority($config['db']['low_priority'])->query();
	foreach ($platforms as $platformId) {
		$db->insert('emucr_emulator_platforms')->cols(['emulator' => $emulatorId, 'platform' => $platformId])->lowPriority($config['db']['low_priority'])->query();
	}
}
echo 'done!'.PHP_EOL;
file_put_contents($dataDir.'/json/emucr/platforms.json', json_encode($platforms, JSON_PRETTY_PRINT));
file_put_contents($dataDir.'/json/emucr/emulators.json', json_encode($allEmulators, JSON_PRETTY_PRINT));
//echo PHP_EOL;
