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
$rows = $db->query("select tmdb_movie.id,doc->'\$.genres[*]' as genres from movies,tmdb_movie where tmdb_id=tmdb_movie.id");
$genres = [];
foreach ($rows as $row) {
	$rowGenres = json_decode($row['genres'], true);
	if (!is_null($rowGenres))
		foreach ($rowGenres as $genre) {
			if (!array_key_exists($genre['name'], $genres))
				$genres[$genre['name']] = [
					'id' => $genre['id'],
					'name' => $genre['name'],
					'count' => 0,
				];
			$genres[$genre['name']]['count']++;
		}    
}
echo $twig->render('genres.twig', [
	'genres' => $genres,
	'queryString' => $_SERVER['QUERY_STRING']
]);
