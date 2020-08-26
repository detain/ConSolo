<?php
require_once __DIR__.'/../../../bootstrap.php';
$imdbFields = ['alsoknow','cast','colors','comment','composer','country','crazy_credits','director','episodes','genre','genres','get_episode_details','goofs','imdbsite','is_serial','keywords','languages','locations','main_url','movietype','mpaa','mpaa_reason','orig_title','photo_localurl','plot','plotoutline','producer','quotes','rating','runtime','seasons','sound','soundtrack','tagline','taglines','title','trailers','trivia','votes','writing','year'];
/**
* @var \Workerman\MySQL\Connection
*/
global $db;
global $config, $curl_config;
$curl_config = [];
$exportDate = ((int)date('H') >= 4 ? date('m_d_Y') : date('m_d_Y', time() - 86400));
$lists = ['collection','tv_network','keyword','production_company','movie','tv_series','person'];
$updates = 0;
$divide = 1;
$part = 1;
if ($_SERVER['argc'] > 1) {
	$program = array_shift($_SERVER['argv']);
	while (count($_SERVER['argv']) > 0) {
		$arg = array_shift($_SERVER['argv']);
		if ($arg == '-l') {
			$lists = explode(',', array_shift($_SERVER['argv']));
		} elseif ($arg == '-d') {
			$divide = array_shift($_SERVER['argv']);
		} elseif ($arg == '-p') {
			$part = array_shift($_SERVER['argv']);
		} elseif ($arg == '-i') {
			$ip = array_shift($_SERVER['argv']);
			$curl_config[CURLOPT_INTERFACE] = $ip;
		} else {
			echo "
Syntax: {$program} <-l lists> <-d #> <-p #> <-r> <-s>

 -l lists   sets the list to a comma seperated list of types to go through from
			collection
			tv_network
			keyword
			production_company
			movie
			tv_series
			person 
 -d #       Divide IDs into # Parts, defaults to 1
 -p #       Part # of Divided IDs to display, defaults to 1
 -i ip      Optional IP address to bind to
			";
			exit;
		}
	}
}
$existing = $db->column("select id from tmdb_tv_seasons");
echo 'Loading TV Series ';
$lookups = [];
$rows = $db->column("select doc from tmdb_tv_series");
foreach ($rows as $row) {
	$row = json_decode($row, true);
	foreach ($row['seasons'] as $season) {
		if (!in_array($season['id'], $existing)) {
			$lookups[] = [$row['id'], $season['season_number']];
		}
	}
}
echo 'done'.PHP_EOL;
$total = count($lookups);
$partSize = ceil($total / $divide);
echo $total.' Total IDs in '.$divide.' Parts = '.$partSize.' IDs/part'.PHP_EOL;
$start = ($part - 1) * $partSize;
$end = $part * $partSize;
if ($end > $total) {
	$end = $total;
}
if ($divide > 1) {
	$lookups = array_slice($lookups, $start, $partSize);
	$total = count($lookups);
}
echo 'Performing '.$total.' Season Lookups: ';
foreach ($lookups as $row) {
	list($id, $x) = $row;
	echo ' #'.$id.' S'.$x;
	$response = loadTmdbTvSeason($id, $x);
	if (isset($response['_id'])) {
		$db->insert('tmdb_tv_seasons')
			->cols([
				'tv_id' => $id,
				'doc' => json_encode($response, JSON_PRETTY_PRINT)
			])
			->lowPriority($config['db_low_priority'])
			->query();		
	}
}
echo ' done'.PHP_EOL;

$existing = $db->column("select id from tmdb_tv_episodes");
$seasons = $db->query("select tv_id, doc from tmdb_tv_seasons order by tv_id, season_number");
foreach ($seasons as $idx => $seasonData) {
	$season = json_decode($seasonData['doc'], true);
	//echo "{$series['name']} {$season['season_number']} {$season['name']}\n";
	//print_r($season);
	foreach ($season['episodes'] as $epIdx => $episode) {
		if (!in_array($episode['id'], $existing)) {
			echo "#{$seasonData['tv_id']} {$series['name']} S{$season['season_number']} {$season['name']} E{$episode['episode_number']} #{$episode['id']}  {$episode['name']}\n";
			$response = loadTmdbTvEpisode($seasonData['tv_id'], $season['season_number'], $episode['episode_number']);
			if (isset($response['id'])) {
				$db->insert('tmdb_tv_episodes')
					->cols([
						'tv_id' => $seasonData['tv_id'],
						'doc' => json_encode($response, JSON_PRETTY_PRINT)
					])
					->lowPriority($config['db_low_priority'])
					->query();        
			}			
		} 
	}
}
