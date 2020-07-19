<?php
require_once __DIR__.'/../../vendor/autoload.php';
$movies =  json_decode(file_get_contents('data/imdb_small.json'), true);
$max = 1000;
$count = 0;
$return = [];
foreach ($movies as $movieName => $movieData) {
	$count++;
	if ($count >= $max)
		break;
	$return[] = $movieData;
}
header('Content-type: application/javascript; charset=UTF-8');
echo 'var result = '.json_encode($return).';'.PHP_EOL;
