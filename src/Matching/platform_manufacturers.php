<?php
/**
* generates console/composer manufacturer - platform mappings 
*/

require_once __DIR__.'/../bootstrap.php';

function launchbox() {
	/**
	* @var \Workerman\MySQL\Connection
	*/
	global $db;
	$rows = $db->query("select Manufacturer, Name from launchbox_platforms order by Manufacturer, Name");
	$platforms = [];
	foreach ($rows as $row) {
		$platform = trim($row['Name']);
		$manufacturer = is_null($row['Manufacturer']) || trim($row['Manufacturer']) == '' ? 'Generic' : trim($row['Manufacturer']);
		if (!array_key_exists($manufacturer, $platforms))
			$platforms[$manufacturer] = [];
		if (!in_array($platform, $platforms[$manufacturer]))
			$platforms[$manufacturer][] = $platform;
	}
	asort($platforms);
	return $platforms;
}

function thegamesdb() {
	/**
	* @var \Workerman\MySQL\Connection
	*/
	global $db;
	$rows = $db->query("select manufacturer, name from launchbox_platforms order by manufacturer, name");
	$platforms = [];
	foreach ($rows as $row) {
		$platform = trim($row['name']);
		$manufacturer = is_null($row['manufacturer']) || trim($row['manufacturer']) == '' ? 'Generic' : trim($row['manufacturer']);
		if (!array_key_exists($manufacturer, $platforms))
			$platforms[$manufacturer] = [];
		if (!in_array($platform, $platforms[$manufacturer]))
			$platforms[$manufacturer][] = $platform;
	}
	asort($platforms);
	return $platforms;
}

function oldcomputers() {
	/**
	* @var \Workerman\MySQL\Connection
	*/
	global $db;
	$rows = $db->query("select name, manufacturer from oldcomputers_platforms order by manufacturer, name");
	$platforms = [];
	foreach ($rows as $row) {
		$platform = $row['name'];
		$manufacturer = $row['manufacturer'];
		if (!array_key_exists($manufacturer, $platforms))
			$platforms[$manufacturer] = [];
		if (!in_array($platform, $platforms[$manufacturer]))
			$platforms[$manufacturer][] = $platform;
	}
	asort($platforms);
	return $platforms;
}

function redump() {
	/**
	* @var \Workerman\MySQL\Connection
	*/
	global $db;
	$rows = $db->column("select name from dat_files where type='Redump' order by name");
	$platforms = [];
	foreach ($rows as $name) {
		$name = preg_replace('/^Arcade - /muU', '', $name);
		if (strrpos($name, ' - ') !== false) {
			$manufacturer = substr($name, 0, strrpos($name, ' - '));
			if (!array_key_exists($manufacturer, $platforms))
				$platforms[$manufacturer] = [];
			$platform = substr($name, strrpos($name, ' - ') + strlen(' - '));
			if (!in_array($platform, $platforms[$manufacturer]))
				$platforms[$manufacturer][] = $platform;
		}
	}
	asort($platforms);
	return $platforms;
}

function tosec_prepare() {
	`wget -q "https://www.tosecdev.org/downloads/category/50-2020-07-29?download=99:tosec-dat-pack-complete-3036-tosec-v2020-07-29" -O tosec.zip;unzip -qq -o -d tosec tosec.zip;rm -f tosec.zip;`;
}

function tosec_cleanup() {
	`rm -rf tosec;`;
}

function tosec($type) {
	$invalid = ['Magazines', 'Newsletters', 'Manuals', 'Books', 'Commercials', 'Comics', 'Video', 'Catalogs', 'Artbooks', 'Game Guides', 'TV Series'];
	$platforms = [];
	preg_match_all('/mkdir "(?P<manufacturer>[^\\\\"]+)\\\\(?P<name>[^\\\\"]+)[\\\\"].*$/muU', file_get_contents('tosec/Scripts/create folders/'.$type.'_folders.bat'), $matches);
	foreach ($matches['manufacturer'] as $idx => $manufacturer) {
		$platform = $matches['name'][$idx];
		if (in_array($platform, $invalid))
			continue;
		if (!array_key_exists($manufacturer, $platforms))
			$platforms[$manufacturer] = [];
		if (!in_array($platform, $platforms[$manufacturer]))
			$platforms[$manufacturer][] = $platform;
	}
	asort($platforms);
	return $platforms;
}

$dataDir = '/storage/local/ConSolo/json';
$sources = [];
$sources['LaunchBox'] = launchbox();
$sources['TheGamesDB'] = thegamesdb();
$sources['OldComputers'] = oldcomputers();
$sources['Redump'] = redump();
tosec_prepare();
foreach (['TOSEC', 'TOSEC-ISO', 'TOSEC-PIX'] as $type)
	$sources[$type] = tosec($type);
tosec_cleanup();
$json = json_encode($sources, getJsonOpts());
echo $json.PHP_EOL;
file_put_contents($dataDir.'/platform_manufacturers.json', $json);

