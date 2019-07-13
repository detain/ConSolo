<?php
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

$tablePrefix = 'nointro_';
$tableSuffix = 's';
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
if (intval($version) <= intval($last)) {
    die('Already Up-To-Date'.PHP_EOL);
}
echo `curl -s "https://datomatic.no-intro.org/?page=download&fun=daily" -H "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:68.0) Gecko/20100101 Firefox/68.0" -H "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8" -H "Accept-Language: en-US,en;q=0.5" --compressed -H "Referer: https://datomatic.no-intro.org/?page=download&fun=daily" -H "Content-Type: application/x-www-form-urlencoded" -H "Connection: keep-alive" -H "Cookie: PHPSESSID=bMGvdze90A"%"2CQPGKo64uTP2" -H "Upgrade-Insecure-Requests: 1" --data "dat_type=standard&download=Download" -o nointro.zip`;
echo `rm -rf /tmp/scanfiles;`;
echo `7z x -o/tmp/scanfiles nointro.zip;`;
unlink('nointro.zip');

foreach (glob('/tmp/scanfiles/*') as $xmlFile) {
	$list = str_replace([' ','-'],['_','_'], strtolower(basename($xmlFile, '.dat')));
	echo "Getting {$list} List   ";
        $string = file_get_contents($xmlFile);
	echo "Parsing XML To Array   ";
	$array = xml2array($string, 1, 'attribute');
	unset($string);
	echo "Simplifying Array   ";
	RunArray($array);
	echo "Writing to JSON {$list}.json   ";
	file_put_contents($list.'.json', json_encode($array, JSON_PRETTY_PRINT));
	echo "done\n";
	unlink($xmlFile);
}
echo `rm -rf /tmp/scanfiles;`;
