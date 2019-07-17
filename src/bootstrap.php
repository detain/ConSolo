<?php
include __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/xml2array.php';
$config = require __DIR__.'/config.php';

global $db;
$db = new Workerman\MySQL\Connection($config['db_host'], $config['db_port'], $config['db_name'], $config['db_user'], $config['db_pass']);
