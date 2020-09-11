<?php
require_once __DIR__.'/../src/bootstrap.php';
/**
* @var \Workerman\MySQL\Connection
*/
global $db;
global $config, $curl_config;
$response = [];
$types = ['movie', 'tv_seasons', 'tv_episodes', 'person'];
if (!isset($_REQUEST['type']) || !in_array($_REQUEST['type'], $types) || !isset($_REQUEST['id'])) {
	$response['status'] = 'error';
} else {
	$type = $_REQUEST['type'];
	$id = (int)$_REQUEST['id'];
	$json = json_decode($db->single("select doc from tmdb_{$type} where id={$id} limit 1"), true);
	$response = $json;
}
header('Content-type: application/json; charset=UTF-8');
echo json_encode($response, JSON_PRETTY_PRINT);
