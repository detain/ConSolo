<?php
/**
* grabs latest nointro data and updates db
*/

require_once __DIR__.'/../../../bootstrap.php';

use Goutte\Client;

if (in_array('-h', $_SERVER['argv'])) {
    die("Syntax:
    php ".$_SERVER['argv'][0]." <options>

Options:
    -h          this screen
    -f          force update even if already latest version
    --no-db     skip the db updates/inserts

");
}
/**
* @var \Workerman\MySQL\Connection
*/
global $db;
$configKey = 'nointro';
$row = $db->query("select * from config where field='{$configKey}'");
if (count($row) == 0) {
	$last = 0;
	$db->query("insert into config values ('{$configKey}','0')");
} else {
	$last = $row[0]['value'];
}
$force = in_array('-f', $_SERVER['argv']);
$skipDb = in_array('--no-db', $_SERVER['argv']);
// using wget to auto follow location headers
$version = trim(`wget -q -O - "https://datomatic.no-intro.org/?page=download&op=daily" |grep "Version <b>"|cut -d">" -f2-|cut -d" " -f1`);
echo "Last:    {$last}\nCurrent: {$version}\n";
if (intval(str_replace('-','', $version)) <= intval(str_replace('-','', $last)) && !$force) {
	die('Already Up-To-Date'.PHP_EOL);
}
$dataDir = __DIR__.'/../../../../data';
$type = 'No-Intro';
$dir = $dataDir.'/dat/'.$type;
$glob = $dir.'/*.dat';
$client = new Client();
$crawler = $client->request('GET', 'https://datomatic.no-intro.org/index.php?page=download&op=daily');
$form = $crawler->selectButton('Prepare')->form();
$crawler = $client->submit($form, ['dat_type' => 'standard']);
$form = $crawler->selectButton('Download')->form();
$crawler = $client->submit($form);
file_put_contents('dats.zip', $client->getResponse()->getContent());
echo `rm -rf {$dir};`;
@mkdir($dir, 0775, true);
echo `7z x -o{$dir} dats.zip;`;
unlink('dats.zip');
$import = new \Detain\ConSolo\Importing\DAT\ImportDat();
$import
    ->setReplacements([
        ['/ \(.*$/', ''],
        ['/^(Non-Redump|Source Code|Unofficial) - /', '']])
    ->setSkipDb($skipDb)
    ->go($type, $glob, $dataDir);
if ($skipDb === false)
    $db->query("update config set config.value='{$version}' where field='{$configKey}'");
