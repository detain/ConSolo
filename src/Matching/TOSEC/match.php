<?php
/**
* grabs latest TheGamesDB data and updates db
*/

/**
* @var \Workerman\MySQL\Connection
*/
global $db;
$rows = $db->query("select name from dat_files where type in ('TOSEC','TOSEC-ISO','TOSEC-PIX')");
$return = [];
foreach ($rows as $idx => $row) {
    $description = $row['name'];
    if (preg_match('/^(.*) - (.*) - (.*) - (.*) - (.*)$/', $description, $matches) ||
        preg_match('/^(.*) - (.*) - (.*) - (.*)$/', $description, $matches) ||
        preg_match('/^(.*) - (.*) - (.*)$/', $description, $matches) ||
        preg_match('/^(.*) - (.*)$/', $description, $matches)) {
        $platform = $matches[1];
        if (!isset($return[$platform]))
            $return[$platform] = [];
        if (!in_array($description, $return[$platform]))
            $return[$platform][] = $description;
    } else {
        if (!isset($return[$description]))
            $return[$description] = [];
        if (!in_array($description, $return[$description]))
            $return[$description][] = $description;
    }
    $rows[$idx]['name'] = $description;
}
unset($rows);
return $return;
