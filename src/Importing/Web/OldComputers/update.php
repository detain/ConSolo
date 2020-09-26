<?php
/**
* parses data from old-computers.com
* 
* http://www.old-computers.com/museum/computer.asp?st=1&c=91
* 
* @todo detect emulators page and load+parse it
*/

use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

require_once __DIR__.'/../../../bootstrap.php';
/**
* @var \Workerman\MySQL\Connection
*/
global $db;
$row = $db->query("select * from config where field='oldcomputers'");
if (count($row) == 0) {
	$last = 0;
	$db->query("insert into config values ('oldcomputers','0')");
} else {
	$last = $row[0]['value'];
}
$client = new Client();
$sitePrefix = 'https://www.old-computers.com/museum/';
$types = ['st' => 'type_id', 'c' => 'computer_id'];
$dataDir = '/storage/local/ConSolo/data';
if (!file_exists($dataDir.'/json/oldcomputers/urls.json')) {
	echo 'Discovering Computer URLs starting with ';
	$letters = ['0','1','2','3','4','5','6','7','8','9','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
	$computerUrls = [];
	foreach ($letters as $letter) {
		echo $letter;
		$crawler = $client->request('GET', $sitePrefix.'name.asp?l='.$letter);
		$crawler->filter('b>a.petitnoir3')->each(function ($node) use (&$computerUrls) {
			if (!in_array($node->attr('href'), $computerUrls))
				$computerUrls[] = $node->attr('href');
		});
	}
	echo ' done'.PHP_EOL;
	file_put_contents($dataDir.'/json/oldcomputers/urls.json', json_encode($computerUrls, JSON_PRETTY_PRINT));
}
$computerUrls = json_decode(file_get_contents($dataDir.'/json/oldcomputers/urls.json'), true);
echo 'Loading Computer URLs'.PHP_EOL;
/*
$db->query("truncate oldcomputers_emulator_platforms");
$db->query("delete from oldcomputers_platforms");
$db->query("delete from oldcomputers_emulators");
$db->query("alter table oldcomputers_emulators auto_increment=1");
$db->query("alter table oldcomputers_platforms auto_increment=1");
*/
$platforms = [];
$countComputers = count($computerUrls);
$allEmulators = [];
foreach ($computerUrls as $idx => $url) {
	/**
	* @var \Symfony\Component\DomCrawler\Crawler
	*/
	$crawler = $client->request('GET', $sitePrefix.$url);
	$cols = [];
	$urlParts = parse_url($url);
	$query = explode('&', $urlParts['query']);
	foreach ($query as $queryPart) {
		list($key, $value) = explode('=', $queryPart);
		$cols[$types[$key]] = $value;
	}
	$key = false;
	$value = false;
	$emulators = false;
	$crawler->filter('#navbar2 a.navbutton')->each(function($node, $i) use (&$cols, &$key, &$value) {
		$link = $node->attr('href');
		$text = $node->text();
		echo "Link $link - $text\n";
	});
	$cols['image'] = $crawler->filter('table.petitnoir2 tr:nth-child(1) > td:nth-child(3) > table:nth-child(3) tr:nth-child(1) > td:nth-child(1) > img:nth-child(1)')->attr('src');
	$crawler = $crawler->filter('table.petitnoir2 tr:nth-child(1) > td:nth-child(3)')->eq(0);
	$cols['company_link'] = $crawler->filter('.grandvert')->eq(0)->attr('href');
	if ($crawler->filter('.grandvert')->eq(0)->html() != $crawler->filter('.grandvert')->eq(0)->text()) {
		$cols['company_name'] = $crawler->filter('.grandvert img')->attr('alt');
		$cols['company_logo'] = $crawler->filter('.grandvert img')->attr('src');
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
	print_r($cols);
	exit;
	echo '['.$idx.'/'.$countComputers.'] '.$cols['manufacturer'].' '.$cols['name'].' ';
	$platformId = $db->insert('oldcomputers_platforms')->cols($cols)->lowPriority($config['db_low_priority'])->query();
	$platforms[$platformId] = $cols;
	if ($emulators !== false) {
		//$crawler = $client->request('GET', $sitePrefix.$emulators);
		//$html = $crawler->html();
		$html = trim(`curl -s "{$sitePrefix}{$emulators}"`);
		$html = str_replace("\r\n", "\n", $html);
		$html = utf8_encode($html);
		if (preg_match_all('/<table><tr><td width=40><img[^>]*alt="([^"]*) emulator"><\/td><td nowrap><a href="([^"]*)"[^>]*><b>([^<]*)<.*<p[^>]*>([^<]*)<\/td/muU', $html, $matches)) {
			foreach ($matches[1] as $idx => $hostPlatform) {
				if (!array_key_exists($matches[3][$idx], $allEmulators)) {
					$emulator = [
						'name' => $matches[3][$idx],
						'url' => $matches[2][$idx],
						'notes' => $matches[4][$idx],
						'platforms' => [],
						'hosts' => [],
					];
					$allEmulators[$matches[3][$idx]] = $emulator; 
				}
				if (!in_array($hostPlatform, $allEmulators[$matches[3][$idx]]['hosts'])) {
					$allEmulators[$matches[3][$idx]]['hosts'][] = $hostPlatform;
				}
				if (!in_array($platformId, $allEmulators[$matches[3][$idx]]['platforms']))
					$allEmulators[$matches[3][$idx]]['platforms'][] = $platformId;
			}
			//echo 'Emulators '.count($emulators).PHP_EOL;
			echo PHP_EOL;
		} else {
			echo 'No Regex match on Emulators page for Emulators'.PHP_EOL;
		}
	}
}
echo PHP_EOL.'done!'.PHP_EOL;
echo 'Inserting Emulators into DB   ';
foreach ($allEmulators as $name => $emulator) {
	$emulator['host'] = implode(', ', $emulator['hosts']);
	$platforms = $emulator['platforms'];
	unset($emulator['platforms']);
	unset($emulator['hosts']);
	$emulatorId = $db->insert('oldcomputers_emulators')->cols($emulator)->lowPriority($config['db_low_priority'])->query();
	foreach ($platforms as $platformId) {
		$db->insert('oldcomputers_emulator_platforms')->cols(['emulator' => $emulatorId, 'platform' => $platformId])->lowPriority($config['db_low_priority'])->query();
	}
}
echo 'done!'.PHP_EOL;
file_put_contents($dataDir.'/json/oldcomputers/platforms.json', json_encode($platforms, JSON_PRETTY_PRINT));
file_put_contents($dataDir.'/json/oldcomputers/emulators.json', json_encode($allEmulators, JSON_PRETTY_PRINT));
//echo PHP_EOL;
