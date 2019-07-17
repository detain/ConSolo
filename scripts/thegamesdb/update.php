<?php
/**
* grabs latest TheGamesDB data and updates db
*/

require_once __DIR__.'/../../src/bootstrap.php';

/**
* @var \Workerman\MySQL\Connection
*/
global $db;
$usePrivate = false;
$fields = ['icon', 'console', 'controller', 'developer', 'manufacturer', 'media', 'cpu', 'memory', 'graphics', 'sound', 'maxcontrollers', 'display', 'overview', 'youtube'];
$cmd = 'curl -s -X GET "https://api.thegamesdb.net/Platforms?apikey='.($usePrivate == true ? $config['thegamesdb_private_api_key'] : $config['thegamesdb_public_api_key']).'&fields='.urlencode(implode(',',$fields)).'" -H  "accept: application/json"';
$platforms = json_decode(trim(`{$cmd}`), true);
file_put_contents('/storage/data/json/tgdb/Platforms.json', json_encode($platforms, JSON_PRETTY_PRINT));
$platformIds = array_keys($platforms['data']['platforms']);
$cmd = 'curl -s -X GET "https://api.thegamesdb.net/Platforms/Images?apikey='.($usePrivate == true ? $config['thegamesdb_private_api_key'] : $config['thegamesdb_public_api_key']).'&platforms_id='.urlencode(implode(',',$platformIds)).'" -H  "accept: application/json"';
$platformImages = json_decode(trim(`{$cmd}`), true);
$images = $platformImages['data']['images'];
while (isset($platformImages['pages']) && !is_null($platformImages['pages']['next'])) {
    $cmd = 'curl -s -X GET "'.$platformImages['pages']['next'].'" -H  "accept: application/json"';
    $platformImages = json_decode(trim(`{$cmd}`), true);
    foreach ($platformImages['data']['images'] as $platformIdx => $data) {
        if (!isset($images[$platformIdx])) {
            $images[$platformIdx] = [];
        }
        foreach ($data as $dataIdx => $dataData) {
            $images[$platformIdx][] = $dataData;
        }
    }
}
$platformImages['data']['images'] = $images;
file_put_contents('/storage/data/json/tgdb/PlatformImages.json', json_encode($platformImages, JSON_PRETTY_PRINT));
exit;
foreach (['Genres', 'Developers', 'Publishers'] as $type) {
    $cmd = 'curl -s -X GET "https://api.thegamesdb.net/'.$type.'?apikey='.($usePrivate == true ? $config['thegamesdb_private_api_key'] : $config['thegamesdb_public_api_key']).'" -H  "accept: application/json"';
    $json = json_decode(trim(`{$cmd}`), true);
    file_put_contents('/storage/data/json/tgdb/'.$type.'.json', json_encode($json, JSON_PRETTY_PRINT));
    if ($json['code'] != 200) {
        die($type.' got unknown code '.$json['code'].' status '.$json['status']);
    }
    $lower = strtolower($type);
    $db->query('delete from tgdb_'.$lower);
    foreach ($json['data'][$lower] as $idx => $data) {
        $db->insert('tgdb_'.$lower)->cols($data)->query();
    }
}
$fields = ['players', 'publishers', 'genres', 'overview', 'last_updated', 'rating', 'platform', 'coop', 'youtube', 'os', 'processor', 'ram', 'hdd', 'video', 'sound', 'alternates'];
$cmd = 'curl -s -X GET "https://api.thegamesdb.net/Games/ByPlatformID?apikey='.($usePrivate == true ? $config['thegamesdb_private_api_key'] : $config['thegamesdb_public_api_key']).'&id='.$id.'&fields='.urlencode(implode(',',$fields)).'" -H  "accept: application/json"';
$games = json_decode(trim(`{$cmd}`), true);
