<?php
/**
* grabs latest TheGamesDB data and updates db
*/

/**
* @var \Workerman\MySQL\Connection
*/
global $db;
$rows = $db->query("select name from launchbox_platforms");
$return = [];
foreach ($rows as $idx => $row) {
    $description = $row['name'];
    if (!isset($return[$description]))
        $return[$description] = [];
    if (!in_array($description, $return[$description]))
        $return[$description][] = $description;
    $rows[$idx]['name'] = $description;
}
unset($rows);
return $return;
