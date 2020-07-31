<?php
require_once __DIR__.'/../../../bootstrap.php';
$imdbFields = ['alsoknow','cast','colors','comment','composer','country','crazy_credits','director','episodes','genre','genres','get_episode_details','goofs','imdbsite','is_serial','keywords','languages','locations','main_url','movietype','mpaa','mpaa_reason','orig_title','photo_localurl','plot','plotoutline','producer','quotes','rating','runtime','seasons','sound','soundtrack','tagline','taglines','title','trailers','trivia','votes','writing','year'];
/**
* @var \Workerman\MySQL\Connection
*/
global $db;
global $config;
$imdbIds = [];
$result = $db->query("select imdb_id from tmdb where imdb_id != 'null'  and imdb_id != ''");
foreach ($result as $data) {
	$imdbIds[] = $data['imdb_id'];
}
echo 'Loaded '.count($imdbIds).' TMDB->IMDB IDs'.PHP_EOL;
$existingIds = [];
$result = $db->query("select id from imdb where id in (select imdb_id from tmdb where imdb_id != 'null'  and imdb_id != '')");
foreach ($result as $data) {
	$existingIds[] = $data['id'];
}
echo 'Loaded '.count($existingIds).' Existing IMDB IDs'.PHP_EOL;
$imdbIds = array_diff($imdbIds, $existingIds);
echo 'Found '.count($imdbIds).' New IMDB IDs'.PHP_EOL;
$updates = 0;
if ($_SERVER['argc'] > 1 && $_SERVER['argv'][1] == '-r')
	rsort($imdbIds);
else
	sort($imdbIds);
$total = count($imdbIds);
foreach ($imdbIds as $imdbId) {
	echo '# '.$imdbId.' '.$updates.'/'.$total.PHP_EOL;
	//if (!in_array($imdbId, $existingIds)) {
		$imdbCode = preg_replace('/^tt/','', $imdbId);
		$title = new \Imdb\Title($imdbCode);
		$imdb = [];
		foreach ($imdbFields as $field) {
			if (method_exists($title, $field)) {
				try {
					$imdb[$field] = $title->$field();
				} catch (Imdb\Exception\Http $e) {
					echo "exception error ".$e->getMessage().PHP_EOL;
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
					'doc' => json_encode($imdb)
				])
				->lowPriority($config['db_low_priority'])
				->query();            
			$updates++;                   
		} catch  (PDOException $E) {
			echo "Exception error ".$e->getMessage().PHP_EOL;
		}
	//}
}
echo 'Loaded '.$updates.' Movies!'.PHP_EOL;
