<?php
/**
* grabs latest TheGamesDB data and updates db
*/

require_once __DIR__.'/../../src/bootstrap.php';


/**
* @var \Workerman\MySQL\Connection
*/
global $db;
$rows = $db->query("select name from dat_files where type in ('TOSEC','TOSEC-ISO','TOSEC-PIX')");
foreach ($rows as $idx => $row) {
    $description = $row['name'];
    if (preg_match('/^(.*) - (.*) - (.*) - (.*) - (.*)$/', $description, $matches) ||
        preg_match('/^(.*) - (.*) - (.*) - (.*)$/', $description, $matches) ||
        preg_match('/^(.*) - (.*) - (.*)$/', $description, $matches) ||
        preg_match('/^(.*) - (.*)$/', $description, $matches)) {
        $platform = $matches[1];
        echo $platform.PHP_EOL;
    } else {
        echo $description."\n";
    }
    $rows[$idx]['name'] = $description;
}