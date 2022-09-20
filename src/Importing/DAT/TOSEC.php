<?php
/**
* grabs latest tosec data and updates db
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
$configKey = 'tosec';
$row = $db->query("select * from config where field='{$configKey}'");
if (count($row) == 0) {
	$last = 0;
	$db->query("insert into config values ('{$configKey}','0')");
} else {
	$last = $row[0]['value'];
}
$force = in_array('-f', $_SERVER['argv']);
$skipDb = in_array('--no-db', $_SERVER['argv']);
$cmd = 'curl -s "https://www.tosecdev.org/downloads/category/22-datfiles"|grep pd-ctitle|sed s#"^.*<a href=\"\([^\"]*\)\">\([^>]*\)<.*$"#"\1 \2"#g';
list($url, $version) = explode(' ', trim(`$cmd`));
$version = str_replace('-','', $version);
echo "Last:    {$last}\nCurrent: {$version}\n";
if (intval($version) <= intval($last) && !$force) {
	die('Already Up-To-Date'.PHP_EOL);
}
$dataDir = __DIR__.'/../../../data';
$type = 'TOSEC';
$dir = $dataDir.'/dat/'.$type;
$url = trim(`curl -s "https://www.tosecdev.org{$url}"|grep "<a class=\"btn btn-success"|cut -d\" -f8`);
echo `wget -q "https://www.tosecdev.org{$url}" -O dats.zip`;
echo `rm -rf {$dir};`;
echo `7z x -o{$dir} dats.zip;`;
unlink('dats.zip');
foreach (glob($dir.'/TOSEC*') as $tosecdir) {
    $import = new \Detain\ConSolo\Importing\ImportDat();
    $import
        ->setReplacements([
            ['/ - .*$/', '']])
        ->setSkipDb($skipDb);
	$import->go(basename($tosecdir), $tosecdir.'/*', $dataDir);
}
if ($skipDb === false)
    $db->query("update config set config.value='{$version}' where field='{$configKey}'");
