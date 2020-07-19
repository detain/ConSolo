<?php
require_once __DIR__.'/../../vendor/autoload.php';
require_once __DIR__.'/inc.php';
$files = loadJson('files');
$minVotes = 10000;
$minRating = 6.0;
$maxRating = 7.0;
$minYear = 1980;
$validQualities = ['720p', '1080p'];
$qualityValues = [
    '3D' => 1,
    '720p' => 2,
    '1080p' => 3,
    '2160p' => 4,
];
$badGenres = ['Talk-Show','Film-Noir', 'News', 'Reality-TV', 'Short', 'Horror'];
$countFiles = count($files);
$imdbIds = [];
foreach ($files as $fileName => $movie) {
	if (array_key_exists('imdb_id', $movie)) {
		if (!in_array($movie['imdb_id'], $imdbIds)) {
			$imdbIds[] = $movie['imdb_id'];
		}
	}
}
unset($files);
echo 'Found '.count($imdbIds).' IMDB IDs in the Files list'.PHP_EOL;
$yts = loadJson('yts');
$imdb = loadJson('imdb');
$countYts = count($yts);
$found = 0;
$wget = [];
foreach ($yts as $idx => $ytsData) {
	if (array_key_exists('imdb_code', $ytsData)) {
		$imdb_code = preg_replace('/^tt/', '', $ytsData['imdb_code']);
		if (!in_array($imdb_code, $imdbIds)) {
			$imdbData = $imdb[$imdb_code];
			if ((float)$imdbData['rating'] >= $minRating && (float)$imdbData['rating'] < $maxRating) {
				if ((int)$imdbData['votes'] >= $minVotes) {
					if ((int)$imdbData['year'] >= (int)$minYear) {
						if (!in_array($imdbData['genre'], $badGenres)) {
							if (in_array('English', $imdbData['languages'])) {
								$foundQuality = false;
								if (isset($ytsData['torrents']['items'])) {
									foreach ($ytsData['torrents']['items'] as $torrentIdx => $torrentData) {
										if (in_array($torrentData['quality'], $validQualities)) {
                                            if ($foundQuality == false || $qualityValues[$torrentData['quality']] > $qualityValues[$quality]) {
											    $foundQuality = $torrentData['url'];
                                                $quality = $torrentData['quality'];
                                            } 
										}
									}
								}
								if ($foundQuality !== false) {
									echo "Got Rating ".$imdbData['rating']." Votes ".$imdbData['votes']." Quality ".$quality." URL ".$foundQuality." Movie ".$imdbData['title']."\n";
									$wget[] = 'wget -c '.escapeshellarg($foundQuality).' -O torrents/'.escapeshellarg($ytsData['slug'].'.torrent').';';
									$found++;
								} else {
									//echo "Skipping Poor Quality Movie ".$imdbData['title']."\n";
								}
							} else {
								//echo "Skipping Non-English Movie ".$imdbData['title']."\n";
							}
						} else {
							//echo "Skipping Bad Genre Movie ".$imdbData['title']."\n";
						}
					} else {
						//echo "Skipping Outdated Movie ".$imdbData['title']."\n";
					}				
				} else {
					//echo "Skipping Limited Movie ".$imdbData['title']."\n";
				}				
			} else {
				//echo "Skipping Poorly Rated Movie ".$imdbData['title']."\n";
			}
		} else {
			//echo "Skipping Existing Local Movie ".$movie['title']."\n";
		}
	}
}
unset($yts);
echo "Found ".$found." Matches".PHP_EOL;
$cmd = implode("\n", $wget);
file_put_contents('wget.sh', $cmd);
 
