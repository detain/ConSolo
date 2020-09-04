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
global $config, $curl_config;
$response = [];
if (isset($_REQUEST['id'])) {
	$id = (int)$_REQUEST['id'];
	$json = json_decode($db->single("select doc from tmdb_movie where id={$id} limit 1"), true);
}
echo $twig->render('movie.twig', array(
	'movie' => $json,
//    'client_id' => $_GET['client_id'],
//    'response_type' => $_GET['response_type'],
	'queryString' => $_SERVER['QUERY_STRING']
));
