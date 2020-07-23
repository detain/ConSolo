<?php
require_once __DIR__.'/../../../bootstrap.php';
$imdbFields = ['alsoknow','cast','colors','comment','composer','country','crazy_credits','director','episodes','genre','genres','get_episode_details','goofs','imdbsite','is_serial','keywords','languages','locations','main_url','movietype','mpaa','mpaa_reason','orig_title','photo_localurl','plot','plotoutline','producer','quotes','rating','runtime','seasons','sound','soundtrack','tagline','taglines','title','trailers','trivia','votes','writing','year'];
$files = loadJson('files');
$plex = loadJson('plex');
$updates = 0;
$matched = 0;
$saveEverySec = 60;
$startTime = time();
foreach ($files as $fileName => $file) {
	echo '# '.$file['file']['movieName'].' ('.$file['file']['year'].')'.PHP_EOL;
	if (isset($file['tmdb_id']) && $file['tmdb_id'] != false) {
		$matched++;
		echo '      Already Matched, Skipping!'.PHP_EOL;
		continue;
	}
	if (array_key_exists($fileName, $plex) && isset($plex[$fileName]['tmdb_id'])) {
		$files[$fileName]['tmdb_id'] = $plex[$fileName]['tmdb_id'];
		$matched++;
		$updates++;
		echo '  Setting from plex to '.$plex[$fileName]['tmdb_id'].PHP_EOL;
		continue;
	}
	$results = lookupTmdbMovie($file['file']['movieName']);                                                                        
	$searchResults = [];
	foreach ($results['results'] as $result) {
		/** @var $result \Imdb\Title */         
		echo '  '.' '.$result['title'] . (isset($result['release_date']) ? ' (' . $result['release_date'] . ')' : '').' #'.$result['id'].PHP_EOL;
		$searchResult = [
			'name' => $result['title'],
			'tmdb_id' => $result['id'],
		];
		if (isset($result['release_date'])) {
			$searchResult['year'] = substr($result['release_date'], 0, 4);
		} elseif (isset($result['year'])) {
			$searchResult['year'] = $result['year'];
		}
		$searchResults[] = $searchResult;
		if (trim(preg_replace('/[^a-zA-Z0-9]*/u', '', mb_strtolower($result['title']))) == trim(preg_replace('/[^a-zA-Z0-9]*/u', '', mb_strtolower($file['file']['movieName']))) && (abs((int)substr($result['release_date'], 0, 4) - (int)$file['file']['year']) < 3 || $file['file']['year'] === false)) {
			$matched++;
			$tmdb_id = $result['id'];
			echo '      Found Match!'.PHP_EOL;
			$files[$fileName]['name'] = $searchResult['name'];
			if (isset($searchResult['year'])) {
				$files[$fileName]['year'] = $searchResult['year'];
			}
			$files[$fileName]['tmdb_id'] = $searchResult['tmdb_id'];
			$updates++;
		}            
	}
	if (!isset($files[$fileName]['tmdb_id']) || $files[$fileName]['tmdb_id'] == false) {
		$files[$fileName]['tmdb_searchResults'] = $searchResults;
	}
	$now = time();
	if ($now - $startTime >= $saveEverySec) {
		putJson('files', $files);
		echo 'Wrote JSON with '.$matched.' matches, '.$updates.' updates'.PHP_EOL;
		$startTime = $now;
	}
}
echo 'Matched up '.$updates.' Movies!'.PHP_EOL;
putJson('files', $files);
