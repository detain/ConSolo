<?php
/**
* grabs latest TheGamesDB data and updates db
*/

require_once __DIR__.'/../../src/bootstrap.php';

function apiGet($url, $index = null, $assocNested = true) {
    if (is_null($index)) {
        $index = strtolower(basename(preg_replace('/\?.*$/', '', $url)));
    }
    $url = 'https://api.thegamesdb.net/'.$url;
    $page = 1;
    echo 'Getting '.$index.' Page '.$page; 
    $cmd = 'curl -s -X GET '.escapeshellarg($url).' -H  "accept: application/json"';
    $json = json_decode(trim(`{$cmd}`), true);
    if ($json['code'] != 200) {
        die($index.' got unknown code '.$json['code'].' status '.$json['status']);
    }
    $out = $json['data'][$index];
    while (isset($json['pages']) && !is_null($json['pages']['next'])) {
        $cmd = 'curl -s -X GET "'.$json['pages']['next'].'" -H  "accept: application/json"';
        $page++;
        echo ' '.$page;        
        $json = json_decode(trim(`{$cmd}`), true);
        if ($json['code'] != 200) {
            die($index.' got unknown code '.$json['code'].' status '.$json['status']);
        }
        foreach ($json['data'][$index] as $idx => $data) {
            if ($assocNested == true) {
                if (!isset($out[$idx])) {
                    $out[$idx] = [];
                }
                foreach ($data as $dataIdx => $dataData) {
                    $out[$idx][] = $dataData;
                }
            } else {
                $out[] = $data;
            }
        }
    }
    echo ' done'.PHP_EOL;
    $json['data'][$index] = $out;
    return $json;
}

/**
* @var \Workerman\MySQL\Connection
*/
global $db;
$usePrivate = true;
$useCache = true;
foreach (['Genres', 'Developers', 'Publishers'] as $type) {
    if ($useCache == true && file_exists('/storage/data/json/tgdb/'.$type.'.json')) {
        $var = strtolower($type);
        $$var = json_decode(file_get_contents('/storage/data/json/tgdb/'.$type.'.json'), true);            
    } else {
        $json = apiGet($type.'?apikey='.($usePrivate == true ? $config['thegamesdb_private_api_key'] : $config['thegamesdb_public_api_key']));
        file_put_contents('/storage/data/json/tgdb/'.$type.'.json', json_encode($json, JSON_PRETTY_PRINT));
        $lower = strtolower($type);
        $db->query('delete from tgdb_'.$lower);
        foreach ($json['data'][$lower] as $idx => $data) {
            $db->insert('tgdb_'.$lower)->cols($data)->query();
        }
    }
}
if ($useCache == true && file_exists('/storage/data/json/tgdb/Platforms.json')) {
    $platforms = json_decode(file_get_contents('/storage/data/json/tgdb/Platforms.json'), true);
} else {
    $fields = ['icon', 'console', 'controller', 'developer', 'manufacturer', 'media', 'cpu', 'memory', 'graphics', 'sound', 'maxcontrollers', 'display', 'overview', 'youtube'];
    $platforms = apiGet('Platforms?apikey='.($usePrivate == true ? $config['thegamesdb_private_api_key'] : $config['thegamesdb_public_api_key']).'&fields='.urlencode(implode(',',$fields)));
    file_put_contents('/storage/data/json/tgdb/Platforms.json', json_encode($platforms, JSON_PRETTY_PRINT));
    $db->query('delete from tgdb_platforms');
    foreach ($platforms['data']['platforms'] as $idx => $data) {
            $db->insert('tgdb_platforms')->cols($data)->query();
    }
}
$platformIds = array_keys($platforms['data']['platforms']);
if ($useCache == true && file_exists('/storage/data/json/tgdb/PlatformImages.json')) {
    $platformImages = json_decode(file_get_contents('/storage/data/json/tgdb/PlatformImages.json'), true);
} else {
    $platformImages = apiGet('Platforms/Images?apikey='.($usePrivate == true ? $config['thegamesdb_private_api_key'] : $config['thegamesdb_public_api_key']).'&platforms_id='.urlencode(implode(',',$platformIds)));
    file_put_contents('/storage/data/json/tgdb/PlatformImages.json', json_encode($platformImages, JSON_PRETTY_PRINT));
}
$fields = ['players', 'publishers', 'genres', 'overview', 'last_updated', 'rating', 'platform', 'coop', 'youtube', 'os', 'processor', 'ram', 'hdd', 'video', 'sound', 'alternates'];
$subfields = ['developers', 'genres', 'publishers'];
$db->query('delete from tgdb_games');
foreach ($platforms['data']['platforms'] as $platformIdx => $platformData) {
    $platformId = $platformData['id'];
    echo 'Platform #'.$platformId.' '.$platformData['name'].' ';
    if ($useCache == true && file_exists('/storage/data/json/tgdb/platform/'.$platformId.'.json')) {
        $games = json_decode(file_get_contents('/storage/data/json/tgdb/platform/'.$platformId.'.json'), true);
    } else {
        $games = apiGet('Games/ByPlatformID?apikey='.($usePrivate == true ? $config['thegamesdb_private_api_key'] : $config['thegamesdb_public_api_key']).'&id='.$platformId.'&fields='.urlencode(implode(',',$fields)), 'games', false);
        file_put_contents('/storage/data/json/tgdb/platform/'.$platformId.'.json', json_encode($games, JSON_PRETTY_PRINT));
    }
    echo 'Inserting DB Data..';
    foreach ($games['data']['games'] as $idx => $game) {
        $cols = $game;
        foreach ($subfields as $field) {
            unset($cols[$field]);
        }
        unset($cols['alternates']);
        if (isset($cols['overview'])) {
            $cols['overview'] = utf8_encode($cols['overview']);
        }
        $gameId = $db->insert('tgdb_games')->cols($cols)->query();
        if (isset($game['alternates'])) {
            foreach ($game['alternates'] as $fieldData) {
                $db->insert('tgdb_game_alternates')->cols([
                    'game' => $gameId,
                    'name' => $fieldData
                ])->query();
            }
        }
        foreach ($subfields as $field) {
            if (isset($game[$field])) {
                foreach ($game[$field] as $fieldData) {
                    $db->insert('tgdb_game_'.$field)->cols([
                        'game' => $gameId,
                        substr($field, 0, -1) => $fieldData
                    ])->query();
                }
            }
        }
    }
    echo ' done'.PHP_EOL;
}
