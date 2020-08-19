<?php
require_once __DIR__.'/../src/bootstrap.php';

/**
* @var \Workerman\MySQL\Connection
*/
global $db;
$max = 100;
$response = [
	'page' => 1,
	'total_results' => 1,
	'total_pages' => 1,
	'results' => $db->query("select title, poster_path, vote_average, overview from movies left join tmdb_movie on tmdb_id=tmdb_movie.id order by title limit {$max}")
];
$result = $db->query("select count(*) as count from movies");
$response['total_results'] = $result[0]['count']; 
$response['total_pages'] = ceil($response['total_results'] / $max); 
header('Content-type: application/json; charset=UTF-8');
echo json_encode($response);
