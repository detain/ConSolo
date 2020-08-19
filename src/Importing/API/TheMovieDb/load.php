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
foreach ($lists as $list) {
	echo 'Working on List '.$list.PHP_EOL;
	$Url = 'http://files.tmdb.org/p/exports/'.$list.'_ids_'.$exportDate.'.json.gz';
	echo 'Loading Existing IDs from tmdb_'.$list.' table...';
	$ids = $db->select('id')
		->from('tmdb_'.$list)
		->column();
	if (!is_array($ids) && is_null($ids))
		$ids = [];
	echo count($ids).' loaded'.PHP_EOL;
	echo 'Loading '.$list.' IDs '.$Url.PHP_EOL;
	$lines = explode("\n", trim(gzdecode(getcurlpage($Url))));
	$json = '['.implode(',', $lines).']';
	$lines = json_decode($json, true);    
	echo 'Parsing '.count($lines).' Results..';
	if (count($lines) == count($ids) || count($lines) == 0) {
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
	unset($ids);    
	echo 'done'.PHP_EOL;	
}
foreach ($lists as $list) {
	echo 'Working on List '.$list.PHP_EOL;
	if (in_array($list, ['movie']))
		$field = 'credits';
	elseif (in_array($list, ['tv_series']))
		$field = 'name';
	elseif (in_array($list, ['collection']))
		$field = 'overview';    
	elseif (in_array($list, ['person']))
		$field = 'gender';    
	elseif (in_array($list, ['tv_network', 'production_company']))
		$field = 'origin_country';
	else
		continue;
	$ids = $db->select('id')
		->from('tmdb_'.$list)
		->where($field.' is null')
		->column();
	if (is_null($ids))
		$ids = [];
	$total = count($ids);
	$partSize = ceil($total / $divide);
	echo $total.' Total IDs in '.$divide.' Parts = '.$partSize.' IDs/part'.PHP_EOL;
	$start = ($part - 1) * $partSize;
	$end = $part * $partSize;
	if ($end > $total) {
		$end = $total;
	}
	if ($divide > 1) {
		$ids = array_slice($ids, $start, $partSize);
		$total = count($ids);
	}
	$counter = 0;
	echo '['.$part.'/'.$divide.'] #'.$counter.' '.(isset($ip) ? 'IP '.$ip.' ' : '').'Divided them into a section of '.$total.' ids'.PHP_EOL;
	foreach ($ids as $idx => $id) {
		echo '['.$list.'] # '.$id.' ['.$idx.'/'.$total.']';
		$func = 'loadTmdb'.str_replace(' ', '', ucwords(str_replace('_', ' ', $list)));
		$response = call_user_func($func, $id);
		if (isset($response['id']))
			$db->update('tmdb_'.$list)
				->cols(['doc' => json_encode($response)])
				->where('id='.$id)
				->lowPriority($config['db_low_priority'])
				->query();
		echo PHP_EOL;
	}
}	
