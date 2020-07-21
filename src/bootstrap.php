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
global $config;
$config = require __DIR__.'/config.php';
include_once __DIR__.'/stdObject.php';

function filenameJson($tag) {
	return 'data/'.$tag.'.json';
}

function loadJson($tag) {
	$result = file_exists(filenameJson($tag)) ? json_decode(file_get_contents(filenameJson($tag)), true) : [];
	echo '['.$tag.'] loaded data file and parsed '.count($result).' details'.PHP_EOL;
	return $result;
}

function putJson($tag, $data) {
	file_put_contents(filenameJson($tag), json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
	echo '['.$tag.'] wrote '.count($data).' records to data file'.PHP_EOL;
}

function loadTmdb($id) {
	global $config;
	$apiKey = $config['thetvdb_api_key'];
	$url = 'https://api.themoviedb.org/3/movie/'.$id.'?api_key='.$apiKey.'&language=en-US';
	$cmd = 'curl -s '.escapeshellarg($url);
	$result = json_decode(`$cmd`, true);
	return $result;
}

function lookupTmdb($search) {
	global $config;
	$apiKey = $config['thetvdb_api_key'];
	$url = 'https://api.themoviedb.org/3/search/movie?api_key='.$apiKey.'&query='.urlencode($search);
	$cmd = 'curl -s '.escapeshellarg($url);
	$result = json_decode(`$cmd`, true);
	return $result;
}

global $db;
$db = new \Workerman\MySQL\Connection($config['db_host'], $config['db_port'], $config['db_name'], $config['db_user'], $config['db_pass']);

global $twig;
$twigloader = new \Twig\Loader\FilesystemLoader(__DIR__.'/Views');
$twig = new \Twig\Environment($twigloader, array('/tmp/twig_cache'));

global $hostId, $hostData;
$uname = posix_uname();
$hostData = $db->query("select * from hosts where name='{$uname['nodename']}'");
$hostData = count($hostData) == 0 ? ['id' => null, 'name' => $uname['nodename']] : $hostData[0];
$hostId = $hostData['id'];
