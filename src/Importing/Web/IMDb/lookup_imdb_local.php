<?php
require_once __DIR__.'/../../vendor/autoload.php';
require_once __DIR__.'/inc.php';
$imdbFields = ['alsoknow','cast','colors','comment','composer','country','crazy_credits','director','episodes','genre','genres','get_episode_details','goofs','imdbsite','is_serial','keywords','languages','locations','main_url','movietype','mpaa','mpaa_reason','orig_title','photo_localurl','plot','plotoutline','producer','quotes','rating','runtime','seasons','sound','soundtrack','tagline','taglines','title','trailers','trivia','votes','writing','year'];
$files = loadJson('files');
$plex = loadJson('plex');
$updates = 0;
$matched = 0;
$saveEverySec = 60;
$startTime = time();
$search = new \Imdb\TitleSearch(); // Optional $config parameter
foreach ($files as $idx => $file) {
	echo '# '.$file['file']['movieName'].' ('.$file['file']['year'].')'.PHP_EOL;
	if (isset($file['imdb_id']) && $file['imdb_id'] != false) {
		$matched++;
		echo '      Already Matched, Skipping!'.PHP_EOL;
		continue;
	}
	$results = $search->search($file['file']['movieName'], array(\Imdb\TitleSearch::MOVIE)); // Optional second parameter restricts types returned                                                                        
	// $results is an array of Title objects The objects will have title, year and movietype available immediately, but any other data will have to be fetched from IMDb
	$searchResults = [];
	foreach ($results as $result) {
		/** @var $result \Imdb\Title */         
		echo '  '.' '.$result->title() . ' (' . $result->year() . ') #'.$result->imdbid().PHP_EOL;
		$searchResults[] = [
			'name' => $result->title(),
			'year' => $result->year(),
			'imdb_id' => $result->imdbid(),
			'type' => $result->movietype(),
		];
		if (trim(preg_replace('/[^a-zA-Z0-9]*/u', '', mb_strtolower($result->title()))) == trim(preg_replace('/[^a-zA-Z0-9]*/u', '', mb_strtolower($file['file']['movieName']))) && (abs((int)$result->year() - (int)$file['file']['year']) < 3 || $file['file']['year'] === false)) {
			$matched++;
			$imdb_id = $result->imdbid();;
			echo '      Found Match!'.PHP_EOL;
			$files[$idx]['name'] = $result->title();
			$files[$idx]['year'] = $result->year();
			$files[$idx]['imdb_id'] = $imdb_id;
			$updates++;
		}            
	}
	if ($files[$idx]['imdb_id'] == false) {
		// try to find a matching filename entry from plex
		foreach ($plex as $movie) {
			if ($file['file']['name'] == basename($movie['file'])) {
				echo 'Found Plex entry with Matching File '.$file['file']['name'].' searching with its title '.$movie['title'].PHP_EOL;
				$results = $search->search($movie['title'], array(\Imdb\TitleSearch::MOVIE)); // Optional second parameter restricts types returned
				// $results is an array of Title objects The objects will have title, year and movietype available immediately, but any other data will have to be fetched from IMDb
				$searchResults = [];
				foreach ($results as $result) {
					/** @var $result \Imdb\Title */         
					echo '  '.' '.$result->title() . ' (' . $result->year() . ') #'.$result->imdbid().PHP_EOL;
					$searchResults[] = [
						'name' => $result->title(),
						'year' => $result->year(),
						'imdb_id' => $result->imdbid(),
						'type' => $result->movietype(),
					];
					if (trim(preg_replace('/[^a-zA-Z0-9]*/u', '', mb_strtolower($result->title()))) == trim(preg_replace('/[^a-zA-Z0-9]*/u', '', mb_strtolower($movie['title']))) && (abs((int)$result->year() - (int)$movie['year']) < 3 || $movie['year'] === false)) {
						$matched++;
						$imdb_id = $result->imdbid();;
						echo '      Found Match with Plex FileName Match induced search using Plex Title and Year!'.PHP_EOL;
						$files[$idx]['name'] = $result->title();
						$files[$idx]['year'] = $result->year();
						$files[$idx]['imdb_id'] = $imdb_id;
						$updates++;
						break;
					}            
				}                                              
				break;					
			}
		}
	}
	/*    
	if ($files[$idx]['imdb_id'] == false) {
		$cmd = 'googler --json -C -n 50 --np '.escapeshellarg($file['file']['name']);
		$googleResults = json_decode(`$cmd`, true);
		foreach ($googleResults as $googleResult) {
			if (preg_match('/imdb\.com\/title\/tt([^\/]*)/', $googleResult['url'], $matches)) {
				$imdb_id = $matches[1];
				echo '      Found Match with Google Search FileName!'.PHP_EOL;
				$files[$idx]['imdb_id'] = $imdb_id;
				$updates++;
				break;
			}
		}
	}
	*/                                              
	if ($files[$idx]['imdb_id'] == false) {
		$files[$idx]['imdb_searchResults'] = $searchResults;
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
