<?php
/**
* grabs latest TheGamesDB data and updates db
*/

require_once __DIR__.'/../../src/bootstrap.php';

function apiGet($url) {
    $index = strtolower(basename(preg_replace('/\?.*$/', '', $url))); 
    $cmd = 'curl -s -X GET '.escapeshellarg($url).' -H  "accept: application/json"';
    $json = json_decode(trim(`{$cmd}`), true);
    if ($json['code'] != 200) {
        die($index.' got unknown code '.$json['code'].' status '.$json['status']);
    }
    $out = $json['data'][$index];
    $pages = 1;
    while (isset($json['pages']) && !is_null($json['pages']['next'])) {
        $cmd = 'curl -s -X GET "'.$json['pages']['next'].'" -H  "accept: application/json"';
        $json = json_decode(trim(`{$cmd}`), true);
        if ($json['code'] != 200) {
            die($index.' got unknown code '.$json['code'].' status '.$json['status']);
        }
        $pages++;
        foreach ($json['data'][$index] as $idx => $data) {
            if (!isset($out[$idx])) {
                $out[$idx] = [];
            }
            foreach ($data as $dataIdx => $dataData) {
                $out[$idx][] = $dataData;
            }
        }
    }
    $json['data'][$index] = $out;
    return $json;
}

/**
* @var \Workerman\MySQL\Connection
*/
global $db;
$usePrivate = false;
/*
foreach (['Genres', 'Developers', 'Publishers'] as $type) {
    $json = apiGet('https://api.thegamesdb.net/'.$type.'?apikey='.($usePrivate == true ? $config['thegamesdb_private_api_key'] : $config['thegamesdb_public_api_key']));
    file_put_contents('/storage/data/json/tgdb/'.$type.'.json', json_encode($json, JSON_PRETTY_PRINT));
    $lower = strtolower($type);
    $db->query('delete from tgdb_'.$lower);
    foreach ($json['data'][$lower] as $idx => $data) {
        $db->insert('tgdb_'.$lower)->cols($data)->query();
    }
}
$fields = ['icon', 'console', 'controller', 'developer', 'manufacturer', 'media', 'cpu', 'memory', 'graphics', 'sound', 'maxcontrollers', 'display', 'overview', 'youtube'];
$platforms = apiGet('https://api.thegamesdb.net/Platforms?apikey='.($usePrivate == true ? $config['thegamesdb_private_api_key'] : $config['thegamesdb_public_api_key']).'&fields='.urlencode(implode(',',$fields)));
file_put_contents('/storage/data/json/tgdb/Platforms.json', json_encode($platforms, JSON_PRETTY_PRINT));
*/
$platforms = json_decode(file_get_contents('/storage/data/json/tgdb/Platforms.json'), true);
$db->query('delete from tgdb_platforms');
foreach ($platforms['data']['platforms'] as $idx => $data) {
        $db->insert('tgdb_platforms')->cols($data)->query();
}
$platformIds = array_keys($platforms['data']['platforms']);
/*
$platformImages = apiGet('https://api.thegamesdb.net/Platforms/Images?apikey='.($usePrivate == true ? $config['thegamesdb_private_api_key'] : $config['thegamesdb_public_api_key']).'&platforms_id='.urlencode(implode(',',$platformIds)));
file_put_contents('/storage/data/json/tgdb/PlatformImages.json', json_encode($platformImages, JSON_PRETTY_PRINT));
*/
$platformImages = json_decode(file_get_contents('/storage/data/json/tgdb/PlatformImages.json'), true);
exit;
$fields = ['players', 'publishers', 'genres', 'overview', 'last_updated', 'rating', 'platform', 'coop', 'youtube', 'os', 'processor', 'ram', 'hdd', 'video', 'sound', 'alternates'];
foreach ($platformIds as $platformId) {
    $cmd = 'curl -s -X GET "https://api.thegamesdb.net/Games/ByPlatformID?apikey='.($usePrivate == true ? $config['thegamesdb_private_api_key'] : $config['thegamesdb_public_api_key']).'&id='.$platformId.'&fields='.urlencode(implode(',',$fields)).'" -H  "accept: application/json"';
    $games = json_decode(trim(`{$cmd}`), true);
}
