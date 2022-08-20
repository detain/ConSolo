<?php
/**
* grabs latest TheGamesDB data and updates db
*/

/**
* @var \Workerman\MySQL\Connection
*/
global $db;
$mediaTypes = json_decode(file_get_contents(__DIR__.'/../mame_media_types.json'), true);
$rows = $db->query("select platform,platform_description from mame_software group by platform,platform_description");
$return = [];
$return['Arcade'] = ['Arcade'];
foreach ($rows as $idx => $row) {
    $description = $row['platform_description'];
    foreach ($mediaTypes as $type) {
        $description = preg_replace('/\s*'.preg_quote($type, '/').'$/i', '', $description);
    }
    if (!isset($return[$description]))
        $return[$description] = [];
    if (!in_array($description, $return[$description]))
        $return[$description][] = $row['platform_description'];
    $rows[$idx]['platform_description'] = $description;
}
unset($rows);
return $return;
