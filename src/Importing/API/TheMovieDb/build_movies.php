<?php

use TeamTNT\TNTSearch\TNTSearch;

require_once __DIR__.'/../../../bootstrap.php';

global $config, $mysqlLinkId;
global $db;
$db->query("truncate movies");
$results = $db->query("select * from files where parent is null and (path like 'D:/Movies/%' or path like '/storage/movies%') and extra is not null");
$counter = 0;
foreach ($results as $result) {
	$extra = json_decode($result['extra'], true);
	if (isset($extra['tmdb_id'])) {
		$counter++;
		$db->insert('movies')
			->cols([
				'file_id' => $result['id'],
				'tmdb_id' => $extra['tmdb_id'],
				'imdb_id' => $extra['imdb_id'],
			])
			->query();
	}
}
echo $counter.' movies added'.PHP_EOL;
