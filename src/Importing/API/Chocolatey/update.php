<?php
/**
* grabs latest Chocolatey Software list
*/

require_once __DIR__.'/../../../bootstrap.php';

/**
* @var \Workerman\MySQL\Connection
*/
global $db;
$usePrivate = true;
$useCache = true;
$morePages = true;
$skipCounter = 0;
$packages = [];
while ($morePages) {
	echo 'Geting Packages Skip Counter '.$skipCounter.PHP_EOL;
	$xml = file_get_contents('https://chocolatey.org/api/v2/Packages()?$filter=IsLatestVersion&$skip='.$skipCounter);
	$array = xml2array($xml, 0, 'tag');
	foreach ($array['feed']['entry'] as $entry) {
		$package = [
			'id' => $entry['id'],
			'name' => $entry['title'],
			'summary' => $entry['summary'],
			'updated' => $entry['updated'],
			'author' => $entry['author']['name'],
		];
		foreach ($entry['m:properties'] as $key => $value) {
			$key = strtolower(preg_replace('~(?<=\\w)([A-Z])~', '_$1', preg_replace('/^d:/', '', $key)));
			$package[$key] = $value;
		}
		$packages[] = $package;
		//echo '      Added '.$entry['title'].PHP_EOL;
	}
	$entryCount = count($array['feed']['entry']);
	if ($entryCount < 40) {
		echo 'Ending on a response with '.$entryCount.' entries'.PHP_EOL;
		$morePages = false;
	}
	$skipCounter += $entryCount;
}
$dataDir = '/storage/local/ConSolo/data';
file_put_contents($dataDir.'/json/chocolatey.json', json_encode($packages, JSON_PRETTY_PRINT));
echo 'Wrote '.count($packages).' packages'.PHP_EOL;
