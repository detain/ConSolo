<?php
/**
* grabs latest TheGamesDB data and updates db
*/

require_once __DIR__.'/../../bootstrap.php';

/**
* @var \Workerman\MySQL\Connection
*/
global $db;
$rows = $db->query("select Manufacturer, Name from launchbox_platforms");
$platforms = [];
foreach ($rows as $row) {
	$platform = trim($row['Name']);
	$manufacturer = is_null($row['Manufacturer']) || trim($row['Manufacturer']) == '' ? 'Generic' : trim($row['Manufacturer']);
	if (!array_key_exists($manufacturer, $platforms))
		$platforms[$manufacturer] = [];
	if (!in_array($platform, $platforms[$manufacturer]))
		$platforms[$manufacturer][] = $platform;
}
echo json_encode($platforms, JSON_PRETTY_PRINT);