<?php
require_once __DIR__.'/../../../bootstrap.php';
$files = loadJson('files');
$plex = loadJson('plex');
$tmdb = loadJson('themoviedb');
$updates = 0;

foreach ($plex as $idx => $plexData) {
	if (preg_match('/^com\.plexapp\.agents\.themoviedb:\/\/(\d+)\?lang=en$/', $plexData['guid'], $matches)) {
		$tmdb_id = $matches[1];
		if (!array_key_exists($tmdb_id, $tmdb)) {
			$movie = loadTmdbMovie($tmdb_id);
			$tmdb[$tmdb_id] = $movie;
			$updates++;
			echo '+';
		}
		foreach ($files as $fileIdx => $fileData) {
			if ($fileData['file']['name'] == basename($plexData['file']) && $files[$fileIdx]['tmdb_id'] != $tmdb_id) {
				$files[$fileIdx]['tmdb_id'] = $tmdb_id;
				$updates++;
				echo 'Matched TheMovieDB ID with fileName Plex <-> Local Matching'.PHP_EOL;
				if (isset($tmdb[$tmdb_id]['imdb_id'])) {
					$imdb_id = preg_replace('/^tt/', '', $tmdb[$tmdb_id]['imdb_id']);
					if ($imdb_id != $fileData['imdb_id']) {
						$files[$fileIdx]['imdb_id'] = $imdb_id;
						echo 'Matched IMDB with fileName Plex <-> Local Matching via TheMovieDB Entry'.PHP_EOL;
					}
				}
				
				break;
			}
		}
		if ($updates % 100 == 0) {
			putJson('files', $files);
			putJson('themoviedb', $tmdb);    
		}
	}
}
putJson('files', $files);
putJson('themoviedb', $tmdb);    
