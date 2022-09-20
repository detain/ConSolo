<?php
/**
* grabs latest nointro data and updates db
*/

require_once __DIR__.'/../../bootstrap.php';

if (in_array('-h', $_SERVER['argv']) || in_array('--help', $_SERVER['argv'])) {
    die("Syntax:
    php ".$_SERVER['argv'][0]." <options>

Options:
    -h, --help  this screen
    -f          force update even if already latest version
    --no-db     skip the db updates/inserts

");
}
/**
* @var \Workerman\MySQL\Connection
*/
global $db;
$configKey = 'redump';
$row = $db->query("select * from config where field='{$configKey}'");
if (count($row) == 0) {
	$last = 0;
	$db->query("insert into config values ('{$configKey}','0')");
} else {
	$last = $row[0]['value'];
}
$force = in_array('-f', $_SERVER['argv']);
$skipDb = in_array('--no-db', $_SERVER['argv']);
$dataDir = __DIR__.'/../../../data';
$type = 'Redump';
$dir = $dataDir.'/dat/'.$type;
$glob = $dir.'/*';
$cmd = 'curl -s "http://redump.org/downloads/" |sed -e s#"<tr>"#"\n<tr>"#g|grep /datfile/|sed s#"^.*\"\(/datfile/[^\"]*\)\">.*$"#"\1"#g';
$urls = explode("\n", trim(`$cmd`));
echo "Found ".count($urls)." DATs\n";
$import = new \Detain\ConSolo\Importing\ImportDat();
$import
    ->setMultiRun(true)
    ->setReplacements([
        ['/^Arcade - /', '']])
    ->setSkipDb($skipDb);
//$import->deleteOld = true;
if ($skipDb === false)
    $db->query("delete from dat_files where type='{$type}'");
foreach ($urls as $url) {
	echo `wget -q "http://www.redump.org{$url}" -O dats.zip`;
	echo `rm -rf {$dir};`;
	echo `7z x -o{$dir} dats.zip;`;
	unlink('dats.zip');
	$import->go($type, $glob, $dataDir);
}
$import->writeSource();
//if ($skipDb === false)
    //$db->query("update config set config.value='{$version}' where field='{$configKey}'");
