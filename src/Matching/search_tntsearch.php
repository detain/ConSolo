<?php
/**
* @link https://github.com/loilo/Fuse 
*/

use TeamTNT\TNTSearch\TNTSearch;

require_once __DIR__.'/../bootstrap.php';

global $config;
/**
* @var \Workerman\MySQL\Connection
*/
global $db;
$tnt = new TNTSearch;
$tnt->loadConfig([
	'driver'    => 'mysql',
	'host'      => $config['db']['host'],
	'database'  => $config['db']['name'],
	'username'  => $config['db']['user'],
	'password'  => $config['db']['pass'],
	'storage'   => __DIR__.'/../../data/tntsearch/',
	'stemmer'   => \TeamTNT\TNTSearch\Stemmer\PorterStemmer::class//optional
]);
$tnt->fuzziness = true;
$tnt->selectIndex("ocplatforms.index");
$json = json_decode(file_get_contents(__DIR__.'/../../json/platforms.json'), true);
$rows = $db->query("select id, manufacturer, name from oc_platforms");
$rows = $db->query("SELECT type, name FROM dat_files;");
$rows = $db->query("SELECT Manufacturer, Name FROM launchbox_platforms;");
$rows = $db->query("SELECT Name, Alternate FROM launchbox_platformalternatenames;");
$rows = $db->query("SELECT platform, platform_description FROM mame_software group by platform_description;");
$rows = $db->query("SELECT manufacturer, name FROM oc_platforms;");
$rows = $db->query("SELECT manufacturer, name FROM tgdb_platforms;");
$manufacturers = [
	'lb' => $db->column("select Manufacturer as manufacturer from launchbox_platforms where Manufacturer is not null and Manufacturer != '' group by Manufacturer order by Manufacturer"),
	'tgdb' => $db->column("select manufacturer from tgdb_platforms where manufacturer is not null group by manufacturer order by manufacturer"),
	'oc' => $db->column("select manufacturer from oc_platforms group by manufacturer order by manufacturer"),
];
$oc = [];
foreach ($rows as $row) {
	$oc[$row['id']] = $row;	
}
foreach ($json as $platform => $data) {
	//$response = $tnt->searchBoolean('('.$platform.')', 5);
	$response = $tnt->search($platform, 3);
	echo 'Search "'.$platform.'" : '.PHP_EOL;
	foreach ($response['ids'] as $id) {
		$row = $oc[$id];
		echo '	'.$row['manufacturer'].'	'.$row['name'].PHP_EOL;
	}
}

