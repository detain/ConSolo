<?php
/**
* grabs latest TheGamesDB data and updates db
*/

/**
* @var \Workerman\MySQL\Connection
*/
global $db;
$rows = $db->query("select name from dat_files where type='Redump'");
$return = [];
foreach ($rows as $idx => $row) {
    $description = $row['name'];
    $description = str_replace('Arcade - ', '', $description);
    if (preg_match('/^(.*) - (.*)$/', $description, $matches)) {
        $manufacturer = $matches[1];
        $platform = $matches[2];
        $description = $manufacturer.' '.$platform;
        if (!isset($return[$description]))
            $return[$description] = [];
        if (!in_array($description, $return[$description]))
            $return[$description][] = $row['name'];
    } else {
        if (!isset($return[$description]))
            $return[$description] = [];
        if (!in_array($description, $return[$description]))
            $return[$description][] = $row['name'];
    }
    $rows[$idx]['name'] = $description;
}
unset($rows);
return $return;
