<?php
require_once __DIR__.'/../../vendor/autoload.php';
$movies =  json_decode(file_get_contents('data/imdb.json'), true);
$max = 100;
$count = 0;
$return = [];
foreach ($movies as $movieName => $movieData) {
	$count++;
	if ($count >= $max)
		break;
	$movieData['id'] = $movieName;
	$return[] = $movieData;
}
file_put_contents('data/imdb_small.json', json_encode($return));
header('Content-type: application/json; charset=UTF-8');
echo json_encode($return);
