<?php
require_once __DIR__.'/../../vendor/autoload.php';
require_once __DIR__.'/inc.php';
$imdbFields = ['alsoknow','cast','colors','comment','composer','country','crazy_credits','director','episodes','genre','genres','get_episode_details','goofs','imdbsite','is_serial','keywords','languages','locations','main_url','movietype','mpaa','mpaa_reason','orig_title','photo_localurl','plot','plotoutline','producer','quotes','rating','runtime','seasons','sound','soundtrack','tagline','taglines','title','trailers','trivia','votes','writing','year'];
$files = loadJson('yts');
$imdb = loadJson('imdb');
$updates = 0;
$saveEverySec = 240;
$startTime = time();
foreach ($files as $ytsId => $file) {
	echo '# '.$file['title'].' ('.$file['year'].')'.PHP_EOL;
	if (isset($file['imdb_code'])) {
		$imdbCode = preg_replace('/^tt/','', $file['imdb_code']);
		if (array_key_exists($imdbCode, $imdb)) {
			echo '    Already Matched, Skipping!'.PHP_EOL;
		} else {
			$title = new \Imdb\Title($imdbCode);
			$imdb[$imdbCode] = [];
			foreach ($imdbFields as $field) {
				if (method_exists($title, $field)) {
					$imdb[$imdbCode][$field] = $title->$field();
				} else {
					$imdb[$imdbCode][$field] = $title->$field;
				}
			}            
			$updates++;                   
		}
	}
	$now = time();
	if ($now - $startTime >= $saveEverySec) {
		putJson('imdb', $imdb);
		echo 'Wrote JSON with '.$updates.' updates'.PHP_EOL;		
		$startTime = $now;
	}
}
putJson('imdb', $imdb);
echo 'Loaded '.$updates.' Movies!'.PHP_EOL;
