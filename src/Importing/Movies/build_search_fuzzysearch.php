<?php
/**
* @link https://github.com/loilo/Fuse 
*/

use FuzzySearch\FuzzySearch;

require_once __DIR__.'/../../../bootstrap.php';

$limit = 1000;
$offset = 0;
$end = false;
$fuseData = [];
while (!$end) {
	//echo "Loading IMDB starting at $offset";
	$tempFiles = $db->query("select * from imdb limit $offset, $limit");
	foreach ($tempFiles as $idx => $data) {
		$doc = json_decode($data['doc'], true);
		$fuse = [
			'title' => $data['title'],
			'year' => $data['year']
		];
		$fuseData[] = $fuse;
	}
	$offset += $limit;
	$end = count($tempFiles) < $limit;
}
$fuse = new \Fuse\Fuse($fuseData);
$results = $fuse->search('hamil');
print_r($results);

$offset = 0;
$end = false;
$fuseData = [];
while (!$end) {
	//echo "Loading TMDB starting at $offset";
	$tempFiles = $db->query("select * from tmdb_movie limit $offset, $limit");
	foreach ($tempFiles as $idx => $data) {
		$doc = json_decode($data['doc'], true);
		$fuse = [
			'title' => $data['title'],
			'year' => substr($data['release_date'], 0, 4)
		];
		$fuseData[] = $fuse;
	}
	$offset += $limit;
	$end = count($tempFiles) < $limit;
}
$fuse = new \Fuse\Fuse($fuseData);
$results = $fuse->search('hamil');
print_r($results);
