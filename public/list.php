<?php
require_once __DIR__.'/../src/bootstrap.php';

/**
* @var \Workerman\MySQL\Connection
*/
global $db;
$max = 100;
$response = $db->query("select * from imdb limit {$max}");
header('Content-type: application/json; charset=UTF-8');
echo json_encode($response);
