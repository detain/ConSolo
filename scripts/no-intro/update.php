<?php
/** grabs latest nointro data and updates db
* 
* CREATE TABLE `nointro_roms` (
*   `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
*   `platform` varchar(80) COLLATE utf8mb4_bin DEFAULT NULL,
*   `name` varchar(191) COLLATE utf8mb4_bin DEFAULT NULL,
*   `size` bigint(20) DEFAULT NULL,
*   `crc` varchar(9) COLLATE utf8mb4_bin DEFAULT NULL,
*   `md5` varchar(33) COLLATE utf8mb4_bin DEFAULT NULL,
*   `sha1` varchar(41) COLLATE utf8mb4_bin DEFAULT NULL,
*   `status` varchar(9) COLLATE utf8mb4_bin DEFAULT NULL,
*   `file` varchar(191) COLLATE utf8mb4_bin DEFAULT NULL,
*   `serial` varchar(30) COLLATE utf8mb4_bin DEFAULT NULL,
*   `date` varchar(20) COLLATE utf8mb4_bin DEFAULT NULL,
*   PRIMARY KEY (`id`)
* ) ENGINE=InnoDB
*/

include __DIR__.'/../../vendor/autoload.php';
require_once __DIR__.'/../../src/xml2array.php';

function FlattenAttr(&$parent) {
    if (isset($parent['attr'])) {
        if (count($parent['attr']) == 2 && isset($parent['attr']['name']) && isset($parent['attr']['value'])) {
            $parent[$parent['attr']['name']] = $parent['attr']['value'];
            unset($parent['attr']);
        } else {
            foreach ($parent['attr'] as $attrKey => $attrValue) {
                $parent[$attrKey] = $attrValue;
            }
            unset($parent['attr']); 
        }
    }
}

function FlattenValues(&$parent) {
    foreach ($parent as $key => $value) {
        if (is_array($value) && count($value) == 1 && isset($value['value'])) {
            $parent[$key] = $value['value'];
        }
    }
}

function RunArray(&$data) {
    if (is_array($data)) {
        if (count($data) > 0) {
            if (isset($data[0])) {
                foreach ($data as $dataIdx => $dataValue) {
                    RunArray($dataValue);
                    $data[$dataIdx] = $dataValue;
                }
            } else {
                FlattenAttr($data);
                FlattenValues($data);
                foreach ($data as $dataIdx => $dataValue) {
                    RunArray($dataValue);
                    $data[$dataIdx] = $dataValue;
                }
            }
        }
    }
}

$configKey = 'nointro';
$db = new Workerman\MySQL\Connection('127.0.0.1', '3306', 'consolo', 'consolo', 'consolo');
$row = $db->query("select * from config where config.key='{$configKey}'");
if (count($row) == 0) {
    $last = 0;
    $db->query("insert into config values ('{$configKey}','0')");
} else {
    $last = $row[0]['value'];
}
$version = trim(`curl -s "https://datomatic.no-intro.org/?page=download&fun=daily"|grep "Version <b>"|cut -d">" -f2-|cut -d" " -f1`);
echo "Last:    {$last}\nCurrent: {$version}\n";
if (intval(str_replace('-','', $version)) <= intval(str_replace('-','', $last))) {
    die('Already Up-To-Date'.PHP_EOL);
}
$dir = '/storage/data/dat/No-Intro/Standard';
$glob = '/storage/data/dat/No-Intro/*/*';
$type = 'No-Intro';
echo `curl -s "https://datomatic.no-intro.org/?page=download&fun=daily" -H "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:68.0) Gecko/20100101 Firefox/68.0" -H "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8" -H "Accept-Language: en-US,en;q=0.5" --compressed -H "Referer: https://datomatic.no-intro.org/?page=download&fun=daily" -H "Content-Type: application/x-www-form-urlencoded" -H "Connection: keep-alive" -H "Cookie: PHPSESSID=bMGvdze90A"%"2CQPGKo64uTP2" -H "Upgrade-Insecure-Requests: 1" --data "dat_type=standard&download=Download" -o nointro.zip`;
echo `rm -rf {$dir};`;
echo `7z x -o{$dir} nointro.zip;`;
unlink('nointro.zip');
$db->query("delete from dat_files where type='{$type}'");
foreach (glob($glob) as $xmlFile) {
    $list = basename($xmlFile, '.dat');
	//$list = str_replace([' ','-'],['_','_'], strtolower($list));
	echo "[{$list}] Reading..";
    $string = file_get_contents($xmlFile);
    //unlink($xmlFile);
	echo "XML To Array..";
	$array = xml2array($string, 1, 'attribute');
	unset($string);
	echo "Simplifying..";
	RunArray($array);
    echo "Writing JSON..";
    file_put_contents('/storage/data/json/dat/No-Intro/'.$list.'.json', json_encode($array, JSON_PRETTY_PRINT));
    echo "DB Entries..";
    if (isset($array['datafile']['game'])) {
        $cols = $array['datafile']['header'];
        $cols['type'] = $type;
        if (isset($cols['clrmamepro'])) {
            foreach (['forcepackaging', 'forcenodump', 'forcemerging'] as $section) {
                if (isset($cols['clrmamepro'][$section])) {
                    $cols['clrmamepro_'.$section] = $cols['clrmamepro'][$section];
                }
            }
            unset($cols['clrmamepro']); 
        }
        foreach (['description','version','author','homepage','url'] as $section) {
            if (isset($cols[$section]) && is_array($cols[$section]) && count($cols[$section]) == 0) {
                unset($cols[$section]);
            }
        }
        //echo 'dat_files:'.json_encode($cols).PHP_EOL;
        $fileId = $db->insert('dat_files')->cols($cols)->query();
        $gameSections = ['rom','disk','release','sample','biosset'];    
        if (isset($array['datafile']['game']['name']))
            $array['datafile']['game'] = [$array['datafile']['game']];
        echo count($array['datafile']['game'])." games..";
        foreach ($array['datafile']['game'] as $gameIdx => $gameData) {
            $cols = $gameData;
            $cols['file'] = $fileId; 
            foreach ($gameSections as $section) {
                unset($cols[$section]);
                if (isset($gameData[$section]) && isset($gameData[$section]['name']))
                    $gameData[$section] = [$gameData[$section]];
            }
            if (isset($cols['manufacturer']) && is_array($cols['manufacturer']) && count($cols['manufacturer']) == 0) {
                unset($cols['manufacturer']);
            }            
            //echo 'dat_games:'.json_encode($cols).PHP_EOL;
            $gameId = $db->insert('dat_games')->cols($cols)->query();
            foreach ($gameSections as $section) {
                if (isset($gameData[$section])) {
                    foreach ($gameData[$section] as $sectionIdx => $sectionData) {
                        $cols = $sectionData;
                        $cols['game'] = $gameId;
                        //echo 'dat_'.$section.'s:'.json_encode($cols).PHP_EOL;
//                        try {
                            $db->insert('dat_'.$section.'s')->cols($cols)->query();
/*                        } catch (\PDOException $e) {
                            echo 'Caught PDO Exception!'.PHP_EOL;
                            echo 'Values:'.var_export($cols, true).PHP_EOL;
                            echo 'Message:'.$e->getMessage().PHP_EOL;
                            echo 'Code:'.$e->getCode().PHP_EOL;
                            echo 'File:'.$e->getFile().PHP_EOL;
                            echo 'Line:'.$e->getLine().PHP_EOL;
                            echo 'Trace:'.print_r($e->getTrace(),true).PHP_EOL;
                          }*/
                    }                    
                }
            }
        }
        echo "done\n";
    } else {
        echo "no games, skipping\n";
    }
}
//echo `rm -rf /tmp/update;`;
$db->query("update config set config.value='{$version}' where config.key='{$configKey}'"); 
