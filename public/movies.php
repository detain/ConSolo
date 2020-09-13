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
$limit = 100;
$rows = $db->query("select tmdb_movie.id, title, poster_path, vote_average, overview, release_date from movies left join tmdb_movie on tmdb_movie.id=movies.tmdb_id left join files on file_id=files.id where host={$hostId} and title is not null order by title limit {$limit}");
echo $twig->render('movies.twig', [
	'results' => $rows,
	'queryString' => $_SERVER['QUERY_STRING']
]);
