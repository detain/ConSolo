<?php
/**
* grabs latest nointro data and updates db
*/

require_once __DIR__.'/../../src/bootstrap.php';

/**
* @var \Workerman\MySQL\Connection
*/
global $db;
$configKey = 'redump';
$row = $db->query("select * from config where config.key='{$configKey}'");
if (count($row) == 0) {
    $last = 0;
    $db->query("insert into config values ('{$configKey}','0')");
} else {
    $last = $row[0]['value'];
}
$storageDir = '/storage/data';
$type = 'Redump';
$dir = $storageDir.'/dat/'.$type;
$glob = $dir.'/*';
$cmd = 'curl -s "http://redump.org/downloads/" |sed -e s#"<tr>"#"\n<tr>"#g|grep /datfile/|sed s#"^.*\"\(/datfile/[^\"]*\)\">.*$"#"\1"#g';
$urls = explode("\n", trim(`$cmd`));
echo "Found ".count($urls)." DATs\n";
foreach ($urls as $url) {
    echo `wget -q "http://www.redump.org{$url}" -O dats.zip`;
    echo `rm -rf {$dir};`;
    echo `7z x -o{$dir} dats.zip;`;
    unlink('dats.zip');
}
(new \Detain\ConSolo\ImportDat())->go($type, $glob, $storageDir);
//$db->query("update config set config.value='{$version}' where config.key='{$configKey}'"); 
