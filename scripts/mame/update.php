<?php
/**
* DROP TABLE IF EXISTS mame_machines;
CREATE TABLE `mame_machines` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(500) COLLATE utf8mb4_bin DEFAULT NULL,
  `year` varchar(6) COLLATE utf8mb4_bin DEFAULT NULL,
  `manufacturer` varchar(80) COLLATE utf8mb4_bin DEFAULT NULL,
  `name` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `sourcefile` varchar(70) COLLATE utf8mb4_bin DEFAULT NULL,
  `sampleof` varchar(30) COLLATE utf8mb4_bin DEFAULT NULL,
  `romof` varchar(30) COLLATE utf8mb4_bin DEFAULT NULL,
  `cloneof` varchar(30) COLLATE utf8mb4_bin DEFAULT NULL,
  `ismechanical` varchar(4) COLLATE utf8mb4_bin DEFAULT NULL,
  `isbios` varchar(4) COLLATE utf8mb4_bin DEFAULT NULL,
  `isdevice` varchar(4) COLLATE utf8mb4_bin DEFAULT NULL,
  `runnable` varchar(3) COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;
DROP TABLE IF EXISTS `mame_software`;
CREATE TABLE `mame_software` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `platform` varchar(30) COLLATE utf8mb4_bin DEFAULT NULL,
  `platform_description` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `description` varchar(300) COLLATE utf8mb4_bin DEFAULT NULL,
  `year` varchar(6) COLLATE utf8mb4_bin DEFAULT NULL,
  `publisher` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `name` varchar(30) COLLATE utf8mb4_bin DEFAULT NULL,
  `serial` varchar(150) COLLATE utf8mb4_bin DEFAULT NULL,
  `supported` varchar(10) COLLATE utf8mb4_bin DEFAULT NULL,
  `cloneof` varchar(30) COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
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

$tablePrefix = 'mame_';
$tableSuffix = 's';
$configKey = 'mame';
$db = new Workerman\MySQL\Connection('127.0.0.1', '3306', 'consolo', 'consolo', 'consolo');
$row = $db->query("select * from config where config.key='{$configKey}'");
if (count($row) == 0) {
    $last = 0;
    $db->query("insert into config values ('{$configKey}','0')");
} else {
    $last = $row[0]['value'];
}
$version = trim(`curl -s -L https://github.com/mamedev/mame/releases/latest|grep /mamedev/mame/releases/download/|grep lx.zip|cut -d/ -f6|cut -c5-`);
echo "Last:    {$last}\nCurrent: {$version}\n";
if (intval($version) <= intval($last)) {
    die('Already Up-To-Date'.PHP_EOL);
}

echo `wget -q https://github.com/mamedev/mame/releases/download/mame{$version}/mame{$version}b_64bit.exe -O mame.exe;`;
echo `rm -rf /tmp/update;`;
echo `7z x -o/tmp/update mame.exe;`;
unlink('mame.exe');
echo 'Generating XML'.PHP_EOL;
echo `cd /tmp/update; wine64 mame64.exe -listxml > xml.xml;`;
echo 'Generating Software'.PHP_EOL;
echo `cd /tmp/update; wine64 mame64.exe -listsoftware > software.xml;`;


/*$txt = ['brothers', 'clones', 'crc', 'devices', 'full', 'media', 'roms', 'samples', 'slots', 'source'];
foreach ($txt as $list) {
    echo "Getting and Writing {$list} List   ";
    file_put_contents($list.'.txt', `mame -list{$list}`);
    echo "done\n";

}*/

$xml = ['software', 'xml'];
$removeXml = ['port','chip','display','sound','dipswitch','driver','feature','sample','device_ref','input','biosset','configuration','device','softwarelist','disk','slot','ramoption','adjuster'];
foreach ($xml as $list) {
	echo "Getting {$list} List   ";
    $xmlFile = '/tmp/update/'.$list.'.xml';
    $string = file_get_contents($xmlFile);
	echo "Parsing XML To Array   ";
	$array = xml2array($string, 1, 'attribute');
    unset($string);
    echo "Simplifying Array   ";
    RunArray($array);
    if ($list == 'software') {
        $db->query("truncate mame_software");
        $games = [];
        foreach ($array['softwarelists']['softwarelist'] as $idx => $software) {
            $name = $software['name'];
            $description = $software['description'];
            if (isset($software['software']['name']))
                $software['software'] = [$software['software']];
            foreach ($software['software'] as $gameIdx => $game) {
                if (isset($game['info'])) {
                    if (isset($game['info']['serial'])) {
                        $game['serial'] = $game['info']['serial'];
                    }
                    unset($game['info']);
                }
                if (isset($game['part']))
                    unset($game['part']);
                $game['platform'] = $name;
                $game['platform_description'] = $description;
                $db->insert('mame_software')->cols($game)->query();
            }            
        }
    } elseif ($list == 'xml') {
        $db->query("truncate mame_machines");
        $machines = [];
        foreach ($array['mame']['machine'] as $idx => $machine) {
            foreach ($removeXml as $remove)
                if (array_key_exists($remove, $machine))
                    unset($machine[$remove]);
            if (isset($machine['rom'])) {
                $roms = $machine['rom'];
                unset($machine['rom']);
            }
            $db->insert('mame_machines')->cols($machine)->query();
        }
    }
	//echo "Writing to JSON {$list}.json   ";
	//file_put_contents($list.'.json', json_encode($array, JSON_PRETTY_PRINT));
	echo "done\n";
    @unlink($xmlFile);
}
echo `rm -rf /tmp/update;`;