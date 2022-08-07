<?php

use Matomo\Ini;
use Noodlehaus\Config;

require_once __DIR__.'/../../../bootstrap.php';

/**
* @var \Workerman\MySQL\Connection
*/
global $db;
$dataDir = '/storage/local/ConSolo/data/json/emucontrolcenter';
$reader = new \Matomo\Ini\IniReader();
$data = $reader->readFile('emuDownloadCenter/hooks/xenia/emulator_info.ini');
/*
$parser = new \IniParser('emuDownloadCenter/hooks/xenia/emulator_info.ini');
$data = $parser->parse();
*/
/*
$conf = new Config('emuDownloadCenter/hooks/xenia/emulator_info.ini');
$data = $conf->all();
*/
print_r($data);
