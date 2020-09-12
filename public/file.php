<?php
require_once __DIR__.'/../src/bootstrap.php';
/**
* @var \Workerman\MySQL\Connection
*/
global $db;
global $config, $curl_config;
$response = [];
if (!isset($_GET['id'])) {
}
$id = (int)$_REQUEST['id'];
$data = $db->row("select * from files left join files_extra using (id) where id={$id}");
if ($data === false) {
}

header('Content-type: application/json; charset=UTF-8');

