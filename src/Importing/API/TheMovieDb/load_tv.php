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
$existing = [];
$rows = $db->query("select id, tv_id, season_number from tmdb_tv_seasons");
if (!is_array($rows))
	$rows = [];
foreach ($rows as $row) {
	if (!array_key_exists($row['tv_id'], $existing))
		$existing[$row['tv_id']] = [];
	$existing[$row['tv_id']][] = $row['season_number'];
}
echo 'Loading TV Series ';
$rows = $db->query("select id, json_unquote(json_extract(`doc`,_utf8mb4'$.number_of_seasons')) as number_of_seasons from tmdb_tv_series");
$total = count($rows);
$partSize = ceil($total / $divide);
echo $total.' Total IDs in '.$divide.' Parts = '.$partSize.' IDs/part'.PHP_EOL;
$start = ($part - 1) * $partSize;
$end = $part * $partSize;
if ($end > $total) {
	$end = $total;
}
if ($divide > 1) {
	$rows = array_slice($rows, $start, $partSize);
	$total = count($rows);
}
foreach ($rows as $row) {
	echo ' #'.$row['id'];
	for ($x = 1; $x <= $row['number_of_seasons']; $x++) {
		if (!array_key_exists($row['id'], $existing) || !in_array($x, $existing[$row['id']])) {
			echo ' S'.$x;
			$response = loadTmdbTvSeason($row['id'], $x);
			if (isset($response['_id'])) {
				$db->insert('tmdb_tv_seasons')
					->cols([
						'tv_id' => $row['id'],
						'doc' => json_encode($response)
					])
					->lowPriority($config['db_low_priority'])
					->query();
				
			}
		}
	}		
}
