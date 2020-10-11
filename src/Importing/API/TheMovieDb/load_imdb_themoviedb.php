<?php
require_once __DIR__.'/../../../bootstrap.php';
$imdbFields = ['alsoknow','cast','colors','comment','composer','country','crazy_credits','director','episodes','genre','genres','get_episode_details','goofs','imdbsite','is_serial','keywords','languages','locations','main_url','movietype','mpaa','mpaa_reason','orig_title','photo_localurl','plot','plotoutline','producer','quotes','rating','runtime','seasons','sound','soundtrack','tagline','taglines','title','trailers','trivia','votes','writing','year'];
/**
* @var \Workerman\MySQL\Connection
*/
global $db;
global $config;
$imdbIds = [];
$result = $db->query("select imdb_id from tmdb_movie where imdb_id != 'null'  and imdb_id != ''");
foreach ($result as $data) {
	$imdbIds[] = $data['imdb_id'];
}
echo 'Loaded '.count($imdbIds).' TMDB->IMDB IDs'.PHP_EOL;
$existingIds = [];
$result = $db->query("select id from imdb where id in (select imdb_id from tmdb_movie where imdb_id != 'null'  and imdb_id != '')");
foreach ($result as $data) {
	$existingIds[] = $data['id'];
}
echo 'Loaded '.count($existingIds).' Existing IMDB IDs'.PHP_EOL;
$imdbIds = array_diff($imdbIds, $existingIds);
echo 'Found '.count($imdbIds).' New IMDB IDs'.PHP_EOL;
$updates = 0;
$divide = 1;
$part = 1;
$imdbConfig = new \Imdb\Config();
if ($_SERVER['argc'] > 1) {
	$program = array_shift($_SERVER['argv']);
	while (count($_SERVER['argv']) > 0) {
		$arg = array_shift($_SERVER['argv']);
		if ($arg == '-d') {
			$divide = array_shift($_SERVER['argv']);
		} elseif ($arg == '-p') {
			$part = array_shift($_SERVER['argv']);
		} elseif ($arg == '-i') {
			$ip = array_shift($_SERVER['argv']);
			$imdbConfig->bind_ip_address = $ip;
		} elseif ($arg == '-r') {
			rsort($imdbIds);
		} elseif ($arg == '-s') {
			sort($imdbIds);
		} else {
			echo "
Syntax: {$program} <-d #> <-p #> <-r> <-s>

 -d #       Divide IDs into # Parts, defaults to 1
 -p #       Part # of Divided IDs to display, defaults to 1
 -i ip      Optional IP address to bind to
 -r         reverse sort
 -s         sort
			";
		}
	}
}
$total = count($imdbIds);
$partSize = ceil($total / $divide);
echo $total.' Total IDs in '.$divide.' Parts = '.$partSize.' IDs/part'.PHP_EOL;
$start = ($part - 1) * $partSize;
$end = $part * $partSize;
if ($end > $total) {
	$end = $total;
}
if ($divide > 1) {
	$imdbIds = array_slice($imdbIds, $start, $partSize);
	$total = count($imdbIds);
}
$counter = 0;
echo '['.$part.'/'.$divide.'] #'.$counter.' '.(isset($ip) ? 'IP '.$ip.' ' : '').'Divided them into a section of '.$total.' ids'.PHP_EOL;
foreach ($imdbIds as $imdbId) {
	if (trim($imdbId) == '')
		continue;
	if (file_exists(__DIR__.'/stop'))
		break;
	$counter++;
	echo '['.$part.'/'.$divide.'] #'.$counter.' '.(isset($ip) ? 'IP '.$ip.' ' : '').'# '.$imdbId.' '.$updates.'/'.$total.PHP_EOL;
	//if (!in_array($imdbId, $existingIds)) {
		$imdbCode = preg_replace('/^tt/','', $imdbId);
		$title = new \Imdb\Title($imdbCode, $imdbConfig);
		$imdb = [];
		$imdb['id'] = $imdbId;
		foreach ($imdbFields as $field) {
			if (method_exists($title, $field)) {
				try {
					$imdb[$field] = $title->$field();
				} catch (\Imdb\Exception\Http $e) {
					echo '['.$part.'/'.$divide.'] '.(isset($ip) ? 'IP '.$ip.' ' : '')."exception error ".$e->getMessage().PHP_EOL;
					if (isset($imdb[$field])) {
						unset($imdb[$field]);
					}
				}
			} else {
				$imdb[$field] = $title->$field;
			}
		}
		try {
			$db->insert('imdb')
				->cols([
					'id' => $imdbId, 
					'doc' => json_encode($imdb, JSON_PRETTY_PRINT)
				])
				->lowPriority($config['db']['low_priority'])
				->query();            
			$updates++;                   
		} catch  (\PDOException $E) {
			echo '['.$part.'/'.$divide.'] '.(isset($ip) ? 'IP '.$ip.' ' : '')."Exception error ".$e->getMessage().PHP_EOL;
		}
	//}
}
echo '['.$part.'/'.$divide.'] '.(isset($ip) ? 'IP '.$ip.' ' : '').'Loaded '.$updates.' Movies!'.PHP_EOL;
