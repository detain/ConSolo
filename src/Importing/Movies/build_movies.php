<?php

use TeamTNT\TNTSearch\TNTSearch;

require_once __DIR__.'/../../bootstrap.php';

global $config, $mysqlLinkId;
global $db;
$db->query("truncate movies");
$results = $db->query("select * from files where parent is null and tmdb_id is not null");
$counter = 0;
foreach ($results as $result) {
	$counter++;
	$db->insert('movies')
		->cols([
			'file_id' => $result['id'],
			'tmdb_id' => $result['tmdb_id'],
			'imdb_id' => $result['imdb_id'],
		])
		->query();
}
echo $counter.' movies added'.PHP_EOL;
