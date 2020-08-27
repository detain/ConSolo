<?php
require_once __DIR__.'/../src/bootstrap.php';
$imdbFields = ['alsoknow','cast','colors','comment','composer','country','crazy_credits','director','episodes','genre','genres','get_episode_details','goofs','imdbsite','is_serial','keywords','languages','locations','main_url','movietype','mpaa','mpaa_reason','orig_title','photo_localurl','plot','plotoutline','producer','quotes','rating','runtime','seasons','sound','soundtrack','tagline','taglines','title','trailers','trivia','votes','writing','year'];
/**
* @var \Workerman\MySQL\Connection
*/
global $db;
global $config, $curl_config;
$response = [];
if (isset($_REQUEST['id'])) {
	$id = (int)$_REQUEST['id'];
	$json = json_decode($db->single("select doc from tmdb_tv_episodes where id={$id} limit 1"), true);
	$response['status'] = 'ok';
	$response['movie'] = $json;
} else {
	$response['status'] = 'error';
}
header('Content-type: application/json; charset=UTF-8');
echo json_encode($response);
