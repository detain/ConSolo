<?php
/**
* grabs latest nointro data and updates db
*/

require_once __DIR__.'/../../src/bootstrap.php';

/**
* @var \Workerman\MySQL\Connection
*/
global $db;
$configKey = 'nointro';
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
$storageDir = '/storage/data';
$type = 'No-Intro';
$dir = $storageDir.'/dat/'.$type.'/Standard';
$glob = $storageDir.'/dat/'.$type.'/*/*';
echo `curl -s "https://datomatic.no-intro.org/?page=download&fun=daily" -H "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:68.0) Gecko/20100101 Firefox/68.0" -H "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8" -H "Accept-Language: en-US,en;q=0.5" --compressed -H "Referer: https://datomatic.no-intro.org/?page=download&fun=daily" -H "Content-Type: application/x-www-form-urlencoded" -H "Connection: keep-alive" -H "Cookie: PHPSESSID=bMGvdze90A"%"2CQPGKo64uTP2" -H "Upgrade-Insecure-Requests: 1" --data "dat_type=standard&download=Download" -o nointro.zip`;
echo `rm -rf {$dir};`;
echo `7z x -o{$dir} nointro.zip;`;
unlink('nointro.zip');
(new ImportDats())->go($type, $glob, $storageDir);
$db->query("update config set config.value='{$version}' where config.key='{$configKey}'"); 
