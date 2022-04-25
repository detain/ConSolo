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
$row = $db->query("select * from config where field='oldcomputers'");
if (count($row) == 0) {
	$last = 0;
	$db->query("insert into config values ('oldcomputers','0')");
} else {
	$last = $row[0]['value'];
}
$force = in_array('-f', $_SERVER['argv']);
$useCache = true;
$client = new Client();
$sitePrefix = 'https://www.old-computers.com/museum/';
$types = ['st' => 'type_id', 'c' => 'id'];
$dataDir = '/storage/local/ConSolo/data';
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
$computerUrls = json_decode(file_get_contents($dataDir.'/json/oldcomputers/urls.json'), true);
echo 'Loading Computer URLs'.PHP_EOL;
$db->query("truncate oldcomputers_emulator_platforms");
$db->query("delete from oldcomputers_platforms");
$db->query("delete from oldcomputers_emulators");
$db->query("alter table oldcomputers_emulators auto_increment=1");
$db->query("alter table oldcomputers_platforms auto_increment=1");
$platforms = [];
$total = count($computerUrls);
$allEmulators = [];
echo 'Found '.$total.' Systems'.PHP_EOL;
$db->query('truncate oc_platforms');
foreach ($computerUrls as $idx => $url) {
	$cols = [];
	$urlParts = parse_url($url);
	$query = explode('&', $urlParts['query']);
	foreach ($query as $queryPart) {
		list($key, $value) = explode('=', $queryPart);
		$cols[$types[$key]] = (int)$value;
	}
	echo "[{$idx}/{$total}] Loading URL $url\n";
	if ($useCache === true && file_exists($dataDir.'/json/oldcomputers/platforms/'.$cols['id'].'.json')) {
		$cols = json_decode(file_get_contents($dataDir.'/json/oldcomputers/platforms/'.$cols['id'].'.json'), true);
	} else {
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
			$cols['company_name'] = trim($crawler->filter('.grandvert img')->attr('alt'));
			$cols['company_logo'] = $sitePrefix.$crawler->filter('.grandvert img')->attr('src');
		} else {
			$cols['company_name'] = trim($crawler->filter('.grandvert')->eq(0)->text());
		}
		$cols['description'] = trim(str_replace(["\r\n", "\n\n", '<br>',PHP_EOL.PHP_EOL.PHP_EOL,PHP_EOL.PHP_EOL],["\n", "\n", PHP_EOL,PHP_EOL,PHP_EOL], $crawler->filter('p.petitnoir')->html()));
		$crawler->filter('table tr td table tr td.petitnoir2')->each(function(Crawler $node, $i) use (&$cols, &$key, &$value) {
			if ($i % 2 == 0)
				$key = str_replace([' ','/','-','__'], ['_','','_','_'], strtolower(html_entity_decode(trim(preg_replace('/\s+/msuU', ' ', $node->text())))));
			else
				$cols[$key] = str_replace('&amp;', '&', $node->html());
		});
		foreach ($cols['pages'] as $page => $url) {
			if (in_array($page, ['emulators', 'connectors', 'hardware', 'adverts', 'photos', 'links'])) {
				$cols[$page] = [];
				echo '	Loading and processing page '.$url.PHP_EOL;
				$crawler = $client->request('GET', $sitePrefix.$url);
				if ($page == 'emulators') {
					$crawler->filter('body table.petitnoir2 tr td table tr td a.petitnoir3')->each(function(Crawler $node, $i) use (&$cols) {
						$cols['emulators'][] = [
							'name' => trim($node->text()),
							'url' => $node->attr('href'),
							'platform' => str_replace(' emulator', '', $node->ancestors()->eq(1)->filter('td:nth-child(1) > img')->attr('alt')),
							'description' => $node->ancestors()->eq(1)->filter('td:nth-child(4) > p')->count() ?  str_replace(["\r\n", "\n\n"], ["\n", "\n"], $node->ancestors()->eq(1)->filter('td:nth-child(4) > p')->html()) : '',
						];
					});
				} elseif ($page == 'connectors') {
					$crawler->filter('.petitnoir2 tr:nth-child(1) > td:nth-child(3) > table tr > td:nth-child(3) > p')->each(function(Crawler $node, $i) use (&$cols, $sitePrefix) {
						$cols['connectors'][] = [
							'name' => trim($node->ancestors()->eq(1)->filter('td:nth-child(3) > p')->text()),
							'image' => $sitePrefix.$node->ancestors()->eq(1)->filter('td:nth-child(1) > a')->attr('href'),
							'description' => str_replace(["\r\n", "\n\n", '<blockquote>', '<strong>', '</blockquote>', '</strong>'], ["\n", "\n", '', '', '', ''], preg_replace('/^<br><font color="red"><strong>.*<\/strong><\/font><br>/', '', $node->ancestors()->eq(1)->filter('td:nth-child(1) > a')->attr('title'))),
						];
					});
				} elseif ($page == 'hardware') {
					$crawler->filter('.petitnoir2 tr:nth-child(1) > td:nth-child(3) > table tr > td:nth-child(3) > p')->each(function(Crawler $node, $i) use (&$cols, $sitePrefix) {
						$cols['hardware'][] = [
							'name' => trim($node->ancestors()->eq(1)->filter('td:nth-child(3) > p')->text()),
							'image' => $sitePrefix.$node->ancestors()->eq(1)->filter('td:nth-child(1) > a')->attr('href'),
							'description' => str_replace(["\r\n", "\n\n", '<blockquote>', '<strong>', '</blockquote>', '</strong>'], ["\n", "\n", '', '', '', ''], preg_replace('/^<br><font color="red"><strong>.*<\/strong><\/font><br>/', '', $node->ancestors()->eq(1)->filter('td:nth-child(1) > a')->attr('title'))),
						];
					});
				} elseif ($page == 'adverts') {
					$crawler->filter('.petitnoir2 tr:nth-child(1) > td:nth-child(3) > table:nth-child(6) tr > td > a.highslide')->each(function(Crawler $node, $i) use (&$cols, $sitePrefix) {
						$cols['adverts'][] = [
							'image' => $sitePrefix.$node->attr('href'),
							'name' => $node->filter('img')->attr('alt')
						];
					});
				} elseif ($page == 'photos') {
					$crawler->filter('.petitnoir2 tr:nth-child(1) > td:nth-child(3) > table:nth-child(6) tr td a')->each(function(Crawler $node, $i) use (&$cols, $sitePrefix) {
						$cols['photos'][] = [
							'name' => trim($node->ancestors()->eq(0)->text()),
							'image' => $sitePrefix.$node->attr('href'),
							'description' => str_replace(['<blockquote>', '<strong>', '</blockquote>', '</strong>'], ['', '', '', ''], preg_replace('/^<br><font color="red"><strong>.*<\/strong><\/font><br>/', '', $node->attr('title'))),
						];
					});
				} elseif ($page == 'links') {
					$crawler->filter('.petitnoir2 tr:nth-child(1) > td:nth-child(3) > blockquote > a.petitnoir3')->each(function(Crawler $node, $i) use (&$cols) {
						$cols['links'][$i] = ['url' => $node->attr('href'), 'name' => trim($node->text())];
					});
					$crawler->filter('.petitnoir2 tr:nth-child(1) > td:nth-child(3) > blockquote > span.petitgris')->each(function(Crawler $node, $i) use (&$cols) {
						$cols['links'][$i]['description'] = $node->html();
					});
				}
			}
		}
		file_put_contents($dataDir.'/json/oldcomputers/platforms/'.$cols['id'].'.json', json_encode($cols, JSON_PRETTY_PRINT));
	}
	$platforms[$cols['id']] = $cols;
	$db->insert('oc_platforms')
		->cols(['doc' => json_encode($cols)])
		->query();
}
file_put_contents($dataDir.'/json/oldcomputers/platforms.json', json_encode($platforms, JSON_PRETTY_PRINT));
echo PHP_EOL.'done!'.PHP_EOL;
//exit;
echo 'Inserting Emulators into DB   ';
foreach ($allEmulators as $name => $emulator) {
	$emulator['host'] = implode(', ', $emulator['hosts']);
	$platforms = $emulator['platforms'];
	unset($emulator['platforms']);
	unset($emulator['hosts']);
	$emulatorId = $db->insert('oldcomputers_emulators')
		->cols($emulator)
		->lowPriority($config['db']['low_priority'])
		->query();
	foreach ($platforms as $platformId) {
		$db->insert('oldcomputers_emulator_platforms')
			->cols(['emulator' => $emulatorId, 'platform' => $platformId])
			->lowPriority($config['db']['low_priority'])
			->query();
	}
}
echo 'done!'.PHP_EOL;
file_put_contents($dataDir.'/json/oldcomputers/platforms.json', json_encode($platforms, JSON_PRETTY_PRINT));
file_put_contents($dataDir.'/json/oldcomputers/emulators.json', json_encode($allEmulators, JSON_PRETTY_PRINT));
//echo PHP_EOL;
