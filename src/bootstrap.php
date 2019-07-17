<?php
include __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/xml2array.php';

global $db;
$db = new Workerman\MySQL\Connection('127.0.0.1', '3306', 'consolo', 'consolo', 'consolo');

  
?>
