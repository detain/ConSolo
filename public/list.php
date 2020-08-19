<?php
require_once __DIR__.'/../src/bootstrap.php';

/**
* @var \Workerman\MySQL\Connection
*/
global $db, $hostId;
$max = 100;
$response = [
	'page' => 1,
	'total_results' => 1,
	'total_pages' => 1,
	'results' => $db->query("select title, poster_path, vote_average, overview from files, movies, tmdb_movie where host={$hostId} and file_id=files.id and tmdb_id=tmdb_movie.id and title is not null order by title limit {$max}")
];
$result = $db->query("select count(*) as count from files, movies, tmdb_movie where host={$hostId} and file_id=files.id and tmdb_id=tmdb_movie.id and title is not null");
$response['total_results'] = $result[0]['count']; 
$response['total_pages'] = ceil($response['total_results'] / $max); 
header('Content-type: application/json; charset=UTF-8');
echo json_encode($response);
