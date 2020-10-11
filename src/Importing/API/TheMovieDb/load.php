<?php
require_once __DIR__.'/../../../bootstrap.php';
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
echo 'Loading and populating Genres..'.PHP_EOL;
	foreach (['Movie', 'TV'] as $type) {
	echo '  '.$type.'...';
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
				->lowPriority($config['db']['low_priority'])
				->query();
		}
	}
	echo 'done'.PHP_EOL;
}
foreach ($lists as $list) {
	echo 'Working on List '.$list.PHP_EOL;
	$Url = 'http://files.tmdb.org/p/exports/'.$list.'_ids_'.$exportDate.'.json.gz';
	echo '  Loading Existing IDs from tmdb_'.$list.' table...';
	$ids = $db->select('id')
		->from('tmdb_'.$list)
		->column();
	if (!is_array($ids) && is_null($ids))
		$ids = [];
	echo count($ids).' loaded'.PHP_EOL;
	echo '  Loading '.$list.' IDs '.$Url.PHP_EOL;
	$lines = explode("\n", trim(gzdecode(getcurlpage($Url))));
	$json = '['.implode(',', $lines).']';
	$lines = json_decode($json, true);    
	echo '  Parsing '.count($lines).' Results..';
	if (count($lines) == count($ids) || count($lines) == 0) {
		echo 'skipping update due to matching id counts. '.PHP_EOL;
	} else {
		foreach ($lines as $idx => $line) {
			if ($idx % 50000 == 0) {
				echo '[#'.$idx.']';
			}
			$idx = array_search($line['id'], $ids);
			if ($idx === false) {
				//echo 'inserting '.$line;
				$id = $db->insert('tmdb_'.$list)
					->cols(['doc' => json_encode($line, JSON_PRETTY_PRINT)])
					->lowPriority($config['db']['low_priority'])
					->query();
				echo '+';
			} else {				
				unset($ids[$idx]);
			}
		}
		echo 'done'.PHP_EOL;
		if (count($ids) > 0) {
			echo '  Got '.count($ids).' Leftover IDs, deleting...'.PHP_EOL;
			foreach ($ids as $id) {
				try {
					$db->delete('tmdb_'.$list)
						->where('id='.$id)
						->query();
				} catch (\PDOException $e) {
					echo '  Got Exception #'.$e->getCode().': '.$e->getMessage().' Deleting ID '.$id.PHP_EOL;
					$db->update('files')
						->cols(['imdb_id' => null, 'tmdb_id' => null])
						->where('tmdb_id='.$id)
						->query();
					$db->delete('tmdb_'.$list)
						->where('id='.$id)
						->query();
				}
			}
			echo '  done'.PHP_EOL;
		}        
	}
	unset($lines);
	unset($json);    
	unset($ids);    
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
	echo '  '.$total.' Total IDs in '.$divide.' Parts = '.$partSize.' IDs/part'.PHP_EOL;
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
	echo '  ['.$part.'/'.$divide.'] #'.$counter.' '.(isset($ip) ? 'IP '.$ip.' ' : '').'Divided them into a section of '.$total.' ids'.PHP_EOL;
	$dataDir = __DIR__.'/../../../../data/json/tmdb/tmdb_'.$list;
	if (!file_exists($dataDir))
		mkdir($dataDir, 0777, true);
	foreach ($ids as $idx => $id) {
		echo '  ['.$list.'] # '.$id.' ['.$idx.'/'.$total.']';
		$func = 'loadTmdb'.str_replace(' ', '', ucwords(str_replace('_', ' ', $list)));
		$response = call_user_func($func, $id);
		if (isset($response['id'])) {
			$fileName = $dataDir.'/'.$response['id'].'.json';
			if (!file_exists($fileName)) {
				$json = json_encode($response, JSON_PRETTY_PRINT);
				file_put_contents($fileName, $json);
			}
			$db->update('tmdb_'.$list)
				->cols(['doc' => json_encode($response, JSON_PRETTY_PRINT)])
				->where('id='.$id)
				->lowPriority($config['db']['low_priority'])
				->query();
		}
		echo PHP_EOL;
	}
}	
