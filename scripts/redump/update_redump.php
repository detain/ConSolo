<?php
/** grabs latest nointro data and updates db
* 
 CREATE TABLE `redump_roms` (
   `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
   `platform` varchar(191) COLLATE utf8mb4_bin DEFAULT NULL,
   `name` varchar(230) COLLATE utf8mb4_bin DEFAULT NULL,
   `size` bigint(20) DEFAULT NULL,
   `crc` char(8) COLLATE utf8mb4_bin DEFAULT NULL,
   `md5` char(32) COLLATE utf8mb4_bin DEFAULT NULL,
   `sha1` char(40) COLLATE utf8mb4_bin DEFAULT NULL,
   `file` varchar(230) COLLATE utf8mb4_bin DEFAULT NULL,
   PRIMARY KEY (`id`)
 ) ENGINE=InnoDB;
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

$configKey = 'redump';
$db = new Workerman\MySQL\Connection('127.0.0.1', '3306', 'consolo', 'consolo', 'consolo');
$row = $db->query("select * from config where config.key='{$configKey}'");
if (count($row) == 0) {
    $last = 0;
    $db->query("insert into config values ('{$configKey}','0')");
} else {
    $last = $row[0]['value'];
}
$cmd = 'curl -s "http://redump.org/downloads/" |sed -e s#"<tr>"#"\n<tr>"#g|grep /datfile/|sed s#"^.*\"\(/datfile/[^\"]*\)\">.*$"#"\1"#g';
$urls = explode("\n", trim(`$cmd`));
echo "Found ".count($urls)." DATs\n";
$db->query('truncate redump_roms');
echo `rm -rf /tmp/update;`;
mkdir('/tmp/update');
foreach ($urls as $url) {
    echo `wget -q "http://www.redump.org{$url}" -O redump.zip`;
    echo `7z x -o/tmp/update redump.zip;`;
    unlink('redump.zip');
}
foreach (glob('/tmp/update/*') as $xmlFile) {
    $list = basename($xmlFile, '.dat');
	//$list = str_replace([' ','-'],['_','_'], strtolower($list));
	echo "Getting {$list} List   ";
    $string = file_get_contents($xmlFile);
    unlink($xmlFile);
	echo "Parsing XML..";
	$array = xml2array($string, 1, 'attribute');
	unset($string);
	echo "Simplifying..";
	RunArray($array);
    //echo "Writing {$list}.json..";
    //file_put_contents($list.'.json', json_encode($array, JSON_PRETTY_PRINT));
    $platform = $array['datafile']['header']['name'];
    if (isset($array['datafile']['game'])) {
        if (isset($array['datafile']['game']['name']))
            $array['datafile']['game'] = [$array['datafile']['game']];
        echo count($array['datafile']['game'])." games, inserting..";
        foreach ($array['datafile']['game'] as $gameIdx => $gameData) {
            $name = $gameData['name'];
            if (isset($gameData['rom']['name']))
                $gameData['rom'] = [$gameData['rom']];
            foreach ($gameData['rom'] as $romIdx => $romData) {
                $romData['file'] = $romData['name'];
                unset($romData['name']);
                $romData = array_merge([
                    'platform' => $platform,
                    'name' => $name
                ], $romData);
                try {
                    $db->insert('redump_roms')->cols($romData)->query();
                } catch (\PDOException $e) {
                    echo "Caught PDO Exception!".PHP_EOL;
                    echo "Values: ".var_export($romData, true).PHP_EOL;
                    echo "Message: ".$e->getMessage().PHP_EOL;
                    echo "Code: ".$e->getCode().PHP_EOL;
                    echo "File: ".$e->getFile().PHP_EOL;
                    echo "Line: ".$e->getLine().PHP_EOL;
                    echo "Trace: ".$e->getTraceAsString().PHP_EOL;
                }
            }
        }
        echo "done\n";
    } else {
        echo "no games, skipping\n";
    }
}
echo `rm -rf /tmp/update;`;
//$db->query("update config set config.value='{$version}' where config.key='{$configKey}'"); 
