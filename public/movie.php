<?php
require_once __DIR__.'/../src/bootstrap.php';
/**
* @var \Workerman\MySQL\Connection
*/
global $db;
global $config, $curl_config;
$response = [];
if (isset($_REQUEST['id'])) {
	$id = (int)$_REQUEST['id'];
	$json = json_decode($db->single("select doc from tmdb_movie where id={$id} limit 1"), true);
	$response['status'] = 'ok';
	$response['movie'] = $json;
} else {
	$response['status'] = 'error';
}
header('Content-type: application/json; charset=UTF-8');
echo json_encode($response, JSON_PRETTY_PRINT);
