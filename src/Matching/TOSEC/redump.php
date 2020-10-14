<?php
/**
* grabs latest TheGamesDB data and updates db
*/

require_once __DIR__.'/../../bootstrap.php';

/**
* @var \Workerman\MySQL\Connection
*/
global $db;
$rows = $db->column("select name from dat_files where type='Redump'");
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
echo json_encode($platforms, JSON_PRETTY_PRINT);