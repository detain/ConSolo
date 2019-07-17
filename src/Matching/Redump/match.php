<?php
/**
* grabs latest TheGamesDB data and updates db
*/

require_once __DIR__.'/../../bootstrap.php';


/**
* @var \Workerman\MySQL\Connection
*/
global $db;
$rows = $db->query("select name from dat_files where type='Redump'");
foreach ($rows as $idx => $row) {
    $description = $row['name'];
    $description = str_replace('Arcade - ', '', $description);
    if (preg_match('/^(.*) - (.*)$/', $description, $matches)) {
        $manufacturer = $matches[1];
        $platform = $matches[2];
        echo $manufacturer.' '.$platform.PHP_EOL;
    } else {
        echo $description.PHP_EOL;
    }
    $rows[$idx]['name'] = $description;
}