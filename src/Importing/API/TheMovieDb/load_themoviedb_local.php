<?php
require_once __DIR__.'/../../../bootstrap.php';
$imdbFields = ['alsoknow','cast','colors','comment','composer','country','crazy_credits','director','episodes','genre','genres','get_episode_details','goofs','imdbsite','is_serial','keywords','languages','locations','main_url','movietype','mpaa','mpaa_reason','orig_title','photo_localurl','plot','plotoutline','producer','quotes','rating','runtime','seasons','sound','soundtrack','tagline','taglines','title','trailers','trivia','votes','writing','year'];
$files = loadJson('files');
$themoviedb = loadJson('themoviedb');
$updates = 0;
$saveEverySec = 120;
$startTime = time();
foreach ($files as $fileName => $file) {
	if (isset($file['tmdb_id']) && $file['tmdb_id'] != false) {
		echo '# '.$file['file']['movieName'].' ('.$file['file']['year'].')'.PHP_EOL;
		if (array_key_exists($file['tmdb_id'], $themoviedb)) {
			//echo '    Already Matched, Skipping!'.PHP_EOL;
			$title = $themoviedb[$file['tmdb_id']];
		} else {
			echo '  Loading TheMovieDb Info '.$file['tmdb_id'].PHP_EOL;
			$title = loadTmdb($file['tmdb_id']);
			$themoviedb[$file['tmdb_id']] = $title;
			$updates++;
		}
		if (isset($title['imdb_id']) && (!isset($file['imdb_id']) || $file['imdb_id'] == false)) {
			$updates++;
			echo '  Found IMDB Info '.preg_replace('/^tt/', '', $title['imdb_id']).PHP_EOL;
			$files[$fileName]['imdb_id'] = preg_replace('/^tt/', '', $title['imdb_id']);
			if (array_key_exists('imdb_searchResults', $file)) {
				unset($files[$fileName]['imdb_searchResults']);
			}
		}
		if (array_key_exists('tmdb_searchResults', $file)) {
			unset($files[$fileName]['tmdb_searchResults']);
		}
	}
	$now = time();
	if ($now - $startTime >= $saveEverySec) {
		putJson('files', $files);
		putJson('imdb', $themoviedb);
		echo 'Wrote '.$updates.' updates'.PHP_EOL;        
		$startTime = $now;
	}
}
putJson('files', $files);
ksort($themoviedb);
putJson('themoviedb', $themoviedb);
echo 'Wrote '.$updates.' updates'.PHP_EOL;        
