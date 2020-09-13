<?php
require_once __DIR__.'/../src/bootstrap.php';
/**
* @var \Workerman\MySQL\Connection
*/
global $db;
/**
* @var \Twig\Environment
*/
global $twig;
global $config, $curl_config, $hostId;
$response = [];
if (isset($_REQUEST['id'])) {
	$id = (int)$_REQUEST['id'];
	$json = json_decode($db->single("select doc from tmdb_movie where id={$id} limit 1"), true);
}
$fileId = $db->single("select id from files where tmdb_id={$json['id']} and host={$hostId}");
echo $twig->render('movie.twig', [
	'movie' => $json,
	'fileId' => $fileId,
	'queryString' => $_SERVER['QUERY_STRING']
]);
