<?php

namespace Detain\ConSolo;

ini_set('display_errors', 'on');
if (ini_get('date.timezone') == '') {
    ini_set('date.timezone', 'America/New_York');
}
if (ini_get('default_socket_timeout') < 1200 && ini_get('default_socket_timeout') > 1) {
    ini_set('default_socket_timeout', 1200);
}
include __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/xml2array.php';
$config = require __DIR__.'/config.php';
include_once __DIR__.'/stdObject.php';

global $db;
$db = new \Workerman\MySQL\Connection($config['db_host'], $config['db_port'], $config['db_name'], $config['db_user'], $config['db_pass']);
