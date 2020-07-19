<?php
require_once __DIR__.'/../../vendor/autoload.php';
require_once __DIR__.'/inc.php';
$imdbFields = ['alsoknow','cast','colors','comment','composer','country','crazy_credits','director','episodes','genre','genres','get_episode_details','goofs','imdbsite','is_serial','keywords','languages','locations','main_url','movietype','mpaa','mpaa_reason','orig_title','photo_localurl','plot','plotoutline','producer','quotes','rating','runtime','seasons','sound','soundtrack','tagline','taglines','title','trailers','trivia','votes','writing','year'];
$files = loadJson('files');
$imdb = loadJson('imdb');
$updates = 0;
$saveEverySec = 120;
$startTime = time();
foreach ($files as $idx => $file) {
	if ($file['imdb_id'] != false) {
		echo '# '.$file['file']['movieName'].' ('.$file['file']['year'].')'.PHP_EOL;
		if (array_key_exists($file['imdb_id'], $imdb)) {
			echo '    Already Matched, Skipping!'.PHP_EOL;
		} else {
			$title = new \Imdb\Title($file['imdb_id']);
			$imdb[$file['imdb_id']] = [];
			foreach ($imdbFields as $field) {
				if (method_exists($title, $field)) {
					$imdb[$file['imdb_id']][$field] = $title->$field();
				} else {
					$imdb[$file['imdb_id']][$field] = $title->$field;
				}
			}            
			$updates++;                   
		}
		if (array_key_exists('searchResults', $file)) {
			unset($files[$idx]['searchResults']);
		}
	}
	$now = time();
	if ($now - $startTime >= $saveEverySec) {
		putJson('files', $files);
		putJson('imdb', $imdb);
		echo 'Wrote '.$updates.' updates'.PHP_EOL;		
		$startTime = $now;
	}
}
putJson('files', $files);
ksort($imdb);
putJson('imdb', $imdb);
echo 'Wrote '.$updates.' updates'.PHP_EOL;        
