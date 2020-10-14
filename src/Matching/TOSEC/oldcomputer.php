<?php
/**
* grabs latest TheGamesDB data and updates db
*/

require_once __DIR__.'/../../bootstrap.php';

/**
* @var \Workerman\MySQL\Connection
*/
global $db;
$rows = $db->query("select name, manufacturer from oldcomputers_platforms");
$platforms = [];
foreach ($rows as $row) {
	$platform = $row['name'];
	$manufacturer = $row['manufacturer'];
	if (!array_key_exists($manufacturer, $platforms))
		$platforms[$manufacturer] = [];
	if (!in_array($platform, $platforms[$manufacturer]))
		$platforms[$manufacturer][] = $platform;
}
echo json_encode($platforms, JSON_PRETTY_PRINT);