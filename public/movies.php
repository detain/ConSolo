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
$rows = $db->query("select title, poster_path, vote_average, overview, release_date from movies left join tmdb_movie on tmdb_movie.id=movies.tmdb_id left join files on file_id=files.id where host={$hostId} and title is not null order by title");
echo $twig->render('movies.twig', array(
	'results' => $rows,
//    'client_id' => $_GET['client_id'],
//    'response_type' => $_GET['response_type'],
	'queryString' => $_SERVER['QUERY_STRING']
));
