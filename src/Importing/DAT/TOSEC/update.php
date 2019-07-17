<?php
/**
* grabs latest tosec data and updates db
*/

require_once __DIR__.'/../../../bootstrap.php';

/**
* @var \Workerman\MySQL\Connection
*/
global $db;
$configKey = 'tosec';
$row = $db->query("select * from config where config.key='{$configKey}'");
if (count($row) == 0) {
    $last = 0;
    $db->query("insert into config values ('{$configKey}','0')");
} else {
    $last = $row[0]['value'];
}
$cmd = 'curl -s "https://www.tosecdev.org/downloads/category/22-datfiles"|grep pd-ctitle|sed s#"^.*<a href=\"\([^\"]*\)\">\([^>]*\)<.*$"#"\1 \2"#g';
list($url, $version) = explode(' ', trim(`$cmd`));
$version = str_replace('-','', $version);
echo "Last:    {$last}\nCurrent: {$version}\n";
if (intval($version) <= intval($last)) {
    die('Already Up-To-Date'.PHP_EOL);
}
$storageDir = '/storage/data';
$type = 'TOSEC';
$dir = $storageDir.'/dat/'.$type;
$url = trim(`curl -s "https://www.tosecdev.org{$url}"|grep "<a class=\"btn btn-success"|cut -d\" -f8`);
echo `wget -q "https://www.tosecdev.org{$url}" -O dats.zip`;
echo `rm -rf {$dir};`;
echo `7z x -o{$dir} dats.zip;`;
unlink('dats.zip');
foreach (glob($dir.'/TOSEC*') as $tosecdir) {
    (new \Detain\ConSolo\Importing\DAT\ImportDat())->go(basename($tosecdir), $tosecdir.'/*', $storageDir);
}
$db->query("update config set config.value='{$version}' where config.key='{$configKey}'"); 
