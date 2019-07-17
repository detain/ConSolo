<?php
/**
* grabs latest TheGamesDB data and updates db
*/

require_once __DIR__.'/../../bootstrap.php';


/**
* @var \Workerman\MySQL\Connection
*/
global $db;
$rows = $db->query("select name from launchbox_platforms");
foreach ($rows as $idx => $row) {
    $description = $row['name'];
    echo $description.PHP_EOL;
    $rows[$idx]['name'] = $description;
}