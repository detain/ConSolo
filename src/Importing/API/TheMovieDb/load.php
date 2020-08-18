<?php
require_once __DIR__.'/../../../bootstrap.php';
$imdbFields = ['alsoknow','cast','colors','comment','composer','country','crazy_credits','director','episodes','genre','genres','get_episode_details','goofs','imdbsite','is_serial','keywords','languages','locations','main_url','movietype','mpaa','mpaa_reason','orig_title','photo_localurl','plot','plotoutline','producer','quotes','rating','runtime','seasons','sound','soundtrack','tagline','taglines','title','trailers','trivia','votes','writing','year'];
/**
* @var \Workerman\MySQL\Connection
*/
global $db;
global $config;
foreach (['Movie', 'TV'] as $type) {
	echo 'Loading and populating '.$type.' Genres..';
	$ids = $db->select('id')
		->from('tmdb_'.strtolower($type).'_genre')
		->column();
	if (is_null($ids))
		$ids = [];
	$genres = call_user_func('loadTmdb'.$type.'Genres');
	foreach ($genres['genres'] as $genre) {
		if (!in_array($genre['id'], $ids)) {
			echo 'added '.$genre['name'].' ';
			$db->insert('tmdb_'.strtolower($type).'_genre')
				->cols(['id' => $genre['id'], 'name' => $genre['name']])
				->lowPriority($config['db_low_priority'])
				->query();
		}
	}
	echo 'done'.PHP_EOL;
}
$exportDate = ((int)date('H') >= 4 ? date('m_d_Y') : date('m_d_Y', $now - 86400));
$lists = ['collection','tv_network','keyword','production_company','movie','tv_series','person'];
foreach ($lists as $list) {
	echo 'Working on List '.$list.PHP_EOL;
	$Url = 'http://files.tmdb.org/p/exports/'.$list.'_ids_'.$exportDate.'.json.gz';
	echo 'Loading Existing IDs from tmdb_'.$list.' table...';
	$ids = $db->select('id')
		->from('tmdb_'.$list)
		->column();
	if (is_null($ids))
		$ids = [];
	echo count($ids).' loaded'.PHP_EOL;
	echo 'Loading '.$list.' IDs '.$Url.PHP_EOL;
	$lines = explode("\n", trim(gzdecode(getcurlpage($Url))));
	$json = '['.implode(',', $lines).']';
	$lines = json_decode($json, true);    
	echo 'Parsing '.count($lines).' Results..';
	if (count($lines) == count($ids)) {
		echo 'skipping update due to matching id counts. ';
	} else {
		foreach ($lines as $idx => $line) {
			if ($idx % 50000 == 0) {
				echo '[#'.$idx.']';
			}
			if (!in_array($line['id'], $ids)) {
				//echo 'inserting '.$line;
				$id = $db->insert('tmdb_'.$list)
					->cols(['doc' => json_encode($line)])
					->lowPriority($config['db_low_priority'])
					->query();
				echo '+';
			} else {
				$idx = array_search($line['id'], $ids);
				unset($ids[$idx]);
			}
		}
		if (count($ids) > 0) {
			echo 'Got '.count($ids).' Leftover IDs, deleting...'.PHP_EOL;
			$db->delete('tmdb_'.$list)
				->where('id in ('.implode(',', $ids).')')
				->query();
			echo 'done'.PHP_EOL;
		}        
	}
	unset($lines);    
	echo 'done'.PHP_EOL;	
}
