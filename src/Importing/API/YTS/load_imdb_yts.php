<?php
require_once __DIR__.'/../../../bootstrap.php';
$imdbFields = ['alsoknow','cast','colors','comment','composer','country','crazy_credits','director','episodes','genre','genres','get_episode_details','goofs','imdbsite','is_serial','keywords','languages','locations','main_url','movietype','mpaa','mpaa_reason','orig_title','photo_localurl','plot','plotoutline','producer','quotes','rating','runtime','seasons','sound','soundtrack','tagline','taglines','title','trailers','trivia','votes','writing','year'];
/**
* @var \Workerman\MySQL\Connection
*/
global $db;
global $config;
$imdbIds = [];
$result = $db->query("select imdb_code from yts");
foreach ($result as $data) {
	$imdbIds[] = $data['imdb_code'];
}
$existingIds = [];
$result = $db->query("select id from imdb where id in (select imdb_code from yts)");
foreach ($result as $data) {
	$existingIds[] = $data['id'];
}
$imdbIds = array_diff($imdbIds, $existingIds);
$updates = 0;
$total = count($imdbIds);
foreach ($imdbIds as $imdbId) {
	echo '# '.$imdbId.' '.$updates.'/'.$total.PHP_EOL;
	//if (!in_array($imdbId, $existingIds)) {
		$imdbCode = preg_replace('/^tt/','', $imdbId);
		$title = new \Imdb\Title($imdbCode);
		$imdb = [];
		foreach ($imdbFields as $field) {
			if (method_exists($title, $field)) {
				$imdb[$field] = $title->$field();
			} else {
				$imdb[$field] = $title->$field;
			}
		}
		$db->insert('imdb')
			->cols([
				'id' => $imdbId, 
				'doc' => json_encode($imdb, JSON_PRETTY_PRINT)
			])
			->lowPriority($config['db']['low_priority'])
			->query();            
		$updates++;                   
	//}
}
echo 'Loaded '.$updates.' Movies!'.PHP_EOL;
