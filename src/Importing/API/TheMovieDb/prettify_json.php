<?php
/**
* Calculates the fields used and various usage information about them for each of the main fields in the JSON
* documents of the doc field in some of the tables.  calculates how much each field is used, what variable
* types are used by the field, and the max length of each field.   It will then offer alter table suggestions
* based on the data it fineds
*/
require_once __DIR__.'/../../../bootstrap.php';
/**
* @var \Workerman\MySQL\Connection
*/
global $db;
global $config, $curl_config;
$suffixes = ['imdb', 'tmdb_collection', 'tmdb_production_company', 'tmdb_tv_episodes', 'tmdb_tv_network', 'tmdb_tv_seasons', 'tmdb_tv_series', 'tmdb_movie', 'tmdb_person'];
$fields = [];
$limit = 50000;
$emptyKey = [
	'maxLength' => 0,
	'count' => 0,
	'types' => [],
	'negative' => false,
	'null' => true,
];
$storedFields = ['id', 'season_number', 'imdb_id', 'title'];
foreach($suffixes as $suffix) {
	$fields[$suffix] = [];
	$offset = 0;
	$table = $suffix;
	$dataDir = __DIR__.'/../../../../data/json/'.substr($table, 0, 4).'/'.$table;
	if (!file_exists($dataDir))
		mkdir($dataDir, 0777, true);
	echo 'Working on '.$table;
	while ($docs = $db->query('select id, doc from '.$table.' limit '.$offset.', '.$limit)) {
		echo ' #'.$offset.'-'.($offset+$limit);
		//echo 'Loaded '.$table.' Offset '.$offset.PHP_EOL;
		foreach ($docs as $docData) {
			$fileName = $dataDir.'/'.$docData['id'].'.json';
			if (!file_exists($fileName)) {
				$doc = json_decode($docData['doc'], true);
				$doc['id'] = $docData['id'];
				$json = json_encode($doc, JSON_PRETTY_PRINT);
				file_put_contents($fileName, $json);
				$db->update($table)
					->cols(['doc' => $json])
					->where("id='{$docData['id']}'")
					->lowPriority($config['db']['low_priority'])
					->query();
				echo '+';
			}
		}
		$offset += $limit;
	}
	echo ' done'.PHP_EOL;
}
echo 'all done'.PHP_EOL;