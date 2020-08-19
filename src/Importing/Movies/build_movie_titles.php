<?php
/**
* @link https://github.com/loilo/Fuse 
*/

require_once __DIR__.'/../../../bootstrap.php';

global $db, $mysqlLinkId;
echo 'doing the imdb movies ';
$tempFiles = $db->query('select id, title, orig_title, year, doc->"$.alsoknow[*].title" as also_known from imdb');
$counter = 0;
$bigInserts = [];
$bigInserts[] = 'truncate movie_titles;';
foreach ($tempFiles as $idx => $data) {
	$titles = [];
	$titles[] = $data['title'];
	if (!is_null($data['orig_title']) && $data['orig_title'] != '' && !in_array($data['orig_title'], $titles))
		$titles[] = $data['orig_title'];
	if (!is_null($data['also_known'])) {
		$data['also_known'] = json_decode($data['also_known'], true);
		foreach ($data['also_known'] as $title)
			if (!is_null($title) && !in_array($title, $titles))
				$titles[] = $title; 
	}
	foreach ($titles as $title)
		$inserts[] = "('".$mysqlLinkId->real_escape_string($title)."','".$mysqlLinkId->real_escape_string($data['year'])."','".$mysqlLinkId->real_escape_string('imdb')."','".$mysqlLinkId->real_escape_string($data['id'])."')"; 
	$counter++;
	if ($counter % 1000 == 0) {
		echo $counter.' ';
		$bigInserts[] = 'insert into movie_titles (`title`, `year`, `source`, `source_id`) values '.implode(', ', $inserts).';';
		$inserts = [];
	}
}
echo PHP_EOL.'finished the imdb movies, now doing the tmdb movies ';
$tempFiles = $db->query('select id, title, original_title, year from tmdb_movie');
foreach ($tempFiles as $idx => $data) {
	$titles = [];
	$titles[] = $data['title'];
	if (!is_null($data['original_title']) && $data['original_title'] != '' && !in_array($data['original_title'], $titles))
		$titles[] = $data['original_title'];
	foreach ($titles as $title)
		$inserts[] = "('".$mysqlLinkId->real_escape_string($title)."','".$mysqlLinkId->real_escape_string($data['year'])."','".$mysqlLinkId->real_escape_string('tmdb')."','".$mysqlLinkId->real_escape_string($data['id'])."')"; 
	$counter++;
	if ($counter % 1000 == 0) {
		echo $counter.' ';
		$bigInserts[] = 'insert into movie_titles (`title`, `year`, `source`, `source_id`) values '.implode(', ', $inserts).';';
		$inserts = [];
	}
}
echo PHP_EOL.'finished the imdb movies'.PHP_EOL;
if (count($inserts) > 0) {
	$bigInserts[] = 'insert into movie_titles (`title`, `year`, `source`, `source_id`) values '.implode(', ', $inserts).';';
}
file_put_contents('inserts.sql', implode("\n", $bigInserts));