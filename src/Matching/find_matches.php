<?php
require_once __DIR__.'/../../vendor/autoload.php';
require_once __DIR__.'/inc.php';
$imdbIds = [
	'files' => [],
	'yts' => [],
	'matches' => [],
];
$files = loadJson('files');
$countFiles = count($files);
echo $countFiles.' parsed file details loaded'.PHP_EOL;
foreach ($files as $fileName => $movie) {
	if (array_key_exists('imdb_id', $movie)) {
		if (!in_array($movie['imdb_id'], $imdbIds['files'])) {
			$imdbIds['files'][] = $movie['imdb_id'];
		}
	}
}
unset($files);
echo 'Found '.count($imdbIds['files']).' IMDB IDs in the Files list'.PHP_EOL;
$files = loadJson('yts');
$countYts = count($files);
echo $countYts.' parsed yts details loaded'.PHP_EOL;
foreach ($files as $idx => $movie) {
	if (array_key_exists('imdb_code', $movie)) {
		$imdb_code = preg_replace('/^tt/', '', $movie['imdb_code']);
		if (!in_array($imdb_code, $imdbIds['yts'])) {
			$imdbIds['yts'][] = $imdb_code;
		}
	}
}
unset($yts);
echo 'Found '.count($imdbIds['yts']).' IMDB IDs in the YTS list'.PHP_EOL;
foreach ($imdbIds['files'] as $imdb_code) {
	if (in_array($imdb_code, $imdbIds['yts'])) {
		$imdbIds['matches'][] = $imdb_code;
	}
}
$countImdbFiles = count($imdbIds['files']);
$countImdbYts = count($imdbIds['yts']);

$countMatches = count($imdbIds['matches']);
$pctFileMatches = number_format($countMatches / $countFiles * 100, 1);
$pctYtsMatches = number_format($countMatches / $countYts * 100, 1); 
$pctFileImdbMatches = number_format($countMatches / $countImdbFiles * 100, 1);
$pctYtsImdbMatches = number_format($countMatches / $countImdbYts * 100, 1);
 
echo 'Found '.count($imdbIds['matches']).' Matches between the Local Files and YTS'.PHP_EOL;
echo $pctFileMatches.'% File Matches'.PHP_EOL;
echo $pctYtsMatches.'% Yts Matches'.PHP_EOL;
echo $pctFileImdbMatches.'% File Imdb Matches'.PHP_EOL;
echo $pctYtsImdbMatches.'% Yts Imdb Matches'.PHP_EOL;
