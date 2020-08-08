<?php
require_once __DIR__.'/../../../bootstrap.php';
$imdbFields = ['alsoknow','cast','colors','comment','composer','country','crazy_credits','director','episodes','genre','genres','get_episode_details','goofs','imdbsite','is_serial','keywords','languages','locations','main_url','movietype','mpaa','mpaa_reason','orig_title','photo_localurl','plot','plotoutline','producer','quotes','rating','runtime','seasons','sound','soundtrack','tagline','taglines','title','trailers','trivia','votes','writing','year'];
/**
* @var \Workerman\MySQL\Connection
*/
global $db;
global $config;
$result = $db->query("select * from config where field='tmdb_movies'");
$tmdbIds = [];
$now = time();
$updateExisting = false;
if (!$result) {
	$exportDate = ((int)date('H') >= 4 ? date('m_d_Y') : date('m_d_Y', $now - 86400));
	$movieUrl = 'http://files.tmdb.org/p/exports/movie_ids_'.$exportDate.'.json.gz';
	$tvUrl = 'http://files.tmdb.org/p/exports/tv_series_ids_'.$exportDate.'.json.gz';
	echo 'Loading Movie IDs '.$movieUrl.PHP_EOL;
	$lines = explode("\n", trim(gzdecode(getcurlpage($movieUrl))));
	echo 'Parsing Results..';
	foreach ($lines as $line) {
		$line = json_decode(trim($line), true);
		$tmdbIds[] = $line['id'];
	}
	unset($lines);    
	echo 'done'.PHP_EOL;
} else {
	$updateExisting = true;
	$caughtUp = false;
	$start = $result[0]['value'];
	$interval = 86400 * 14;
	echo 'Loading Movie Updates...';
	while ($caughtUp == false) {
		$startDate = date('Y-m-d', $start - 86400);
		$end = $start + $interval;
		if ($end > $now) {
			$end = $now;
			$caughtUp = true;
		} else {
			$start = $end;
		}
		$endDate = date('Y-m-d', $end);
		echo $startDate.' - '.$endDate.'... ';
		$tmdbIds = changedTmdbMovies($startDate, $endDate, $tmdbIds);
	}
	echo 'done'.PHP_EOL;    
}
echo count($tmdbIds).' Pending TMDB IDs Loaded';
echo 'Loading Existing TMDB Entries...';
$existingIds = [];
$result = $db->query("select id from tmdb");
foreach ($result as $data) {
	$existingIds[] = $data['id'];
}
unset($result);
echo 'done'.PHP_EOL;
if ($updateExisting == false) {
	echo 'Removing Existing Entries from List to Process...';
	$tmdbIds = array_diff($tmdbIds, $existingIds);
	echo 'done'.PHP_EOL;
}
$updates = 0;
$total = count($tmdbIds);
foreach ($tmdbIds as $idx => $tmdbId) {
	$title = loadTmdbMovie($tmdbId);
	if (!isset($title['id']) || is_null($title['id'])) {
		print_r($title);
		echo 'Missing "id" field in TMDB Movie '.$tmdbId.PHP_EOL;            
	} else {
		if ($updateExisting == true && in_array($tmdbId, $existingIds)) {
			$db->update('tmdb')
				->cols([
					'doc' => json_encode($title)
				])
				->where('id='.$tmdbId)
				->lowPriority($config['db_low_priority'])
				->query();            
			$updates++;
			echo '# '.$tmdbId.' ['.$idx.'/'.$total.'] Update '.$updates.PHP_EOL;
		} else {
			$db->insert('tmdb')
				->cols([
					'doc' => json_encode($title)
				])
				->lowPriority($config['db_low_priority'])
				->query();            
			$updates++;
			echo '# '.$tmdbId.' ['.$idx.'/'.$total.'] Update '.$updates.PHP_EOL;
		}
	}
	
}
if ($updateExisting == true) {
	$db->update('config')
		->cols(['value' => $now])
		->where('field="tmdb_movies"')
		->lowPriority($config['db_low_priority'])
		->query();
} else {
	$db->insert('config')
		->cols([
			'field' => 'tmdb_movies',
			'value' => $now 
		])
		->lowPriority($config['db_low_priority'])
		->query();
}
echo 'Wrote '.$updates.' updates'.PHP_EOL;        
