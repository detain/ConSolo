<?php
/**
* @link https://github.com/loilo/Fuse 
*/

use TeamTNT\TNTSearch\TNTSearch;

require_once __DIR__.'/../../../bootstrap.php';

global $config;
$tnt = new TNTSearch;
$tnt->loadConfig([
	'driver'    => 'mysql',
	'host'      => $config['db_host'],
	'database'  => $config['db_name'],
	'username'  => $config['db_user'],
	'password'  => $config['db_pass'],
	'storage'   => __DIR__.'/../../../../data/tntsearch/',
	'stemmer'   => \TeamTNT\TNTSearch\Stemmer\PorterStemmer::class//optional
]);
global $db;
$tnt2 = clone $tnt;
$tnt->selectIndex("imdb.index");
$tnt2->selectIndex("tmdb.index");
$limit = 5;

$ext = [
	'good' => ['mp4', 'avi', 'mkv', 'ogm', 'm4v'],
	'bad' => ['ini', 'db', 'txt'],
	'related' => ['srt', 'ass', 'ssa', 'sup', 'idx', 'sub', 'srm', 'Srt2Utf-8', 'nfo', 'smi'],
];
$tags = ['webrip', 'brrip', 'bluray', 'dvdrip', '2160p', '1080p', '10800p', '1080', '720p', '640p', '480p', '280p', '360p', 'x264', 'x265', 'yify', 'xvid', '4k', 'ac3'];
$ext['known'] = array_merge($ext['good'], $ext['bad'], $ext['related']);
//$results = $db->query("select min(substring(release_date, 1, 4)) as min_year, max(substring(release_date, 1, 4)) as max_year from tmdb where release_date != ''");
$results = $db->query("select min(year) as min_year, max(year) as max_year from imdb where year > 0");
$minYear = (int)$results[0]['min_year'];
$maxYear = (int)$results[0]['max_year'];
$results = $db->query("select * from files where parent is null and (path like 'D:/Movies/%' or path like '/storage/movies%')");
foreach ($results as $result) {
	$extra = !is_null($result['extra']) ? json_decode($result['extra'], true) : [];
	if (!isset($extra['tmdb_id']) || !isset($extra['imdb_id'])) {
		$pathInfo = pathinfo($result['path']);
		if (in_array($pathInfo['extension'], $ext['good'])) {
			$name = $pathInfo['filename'];
			if (strpos($name, ' ') === false) {
				$name = preg_replace('/\.([^\.])/', ' \1', $name);
				$name = str_replace('_', ' ', $name);
			}
			$name = str_replace(['(', ')'], [' ', ' '], $name);
			$name = preg_replace('/\s+/', ' ', $name);
			$parts = explode(' ', $name);
			$lastYear = false;
			$junkStart = false;
			$fileTags = [];
			$nameParts = [];
			foreach ($parts as $partIdx => $part) {
				if ($junkStart == false && strlen($part) == 4 && is_numeric($part) && (int)$part >= $minYear && (int)$part <= $maxYear) {
					$lastYear = (int)$part;
					$nameNoYear = implode(' ', $nameParts);
				}
				if ($junkStart == false && in_array(strtolower($part), $tags)) {
					$junkStart = $partIdx;
				}
				if ($junkStart !== false) {
					$fileTags[] = strtolower($part);
				} else {
					$nameParts[] = $part;
				}
			}
			if ($junkStart !== false) {
				$name = implode(' ', $nameParts);
			}
			//echo "$name\n";
			//echo "File:{$pathInfo['filename']}\nName:{$name}\nLast Year:".($lastYear === false ? 'false' : $lastYear)."\nName No Year:{$nameNoYear}\nTags ".implode(', ', $fileTags)."\n\n";
			
			$sure = false;
			$scores = ['tmdb' => [], 'imdb' => [], 'both' => []];
			$imdbResponse = $tnt->search('('.$name.')', $limit);
			//print_r($imdbResponse);
			$imdbResults = $db->query('select id, title, year from imdb where id in ("'.implode('","', $imdbResponse['ids']).'") order by field(id, "'.implode('","', $imdbResponse['ids']).'")');
			foreach ($imdbResults as $idx => $result) {
				$score = ($limit - $idx) * (100 / $limit);
				$scores['imdb'][$result['id']] = $score;
			}
			$tmdbResponse = $tnt2->search('('.$name.')', $limit);
			//print_r($tmdbResponse);
			$tmdbResults = $db->query('select id, title, substring(release_date, 1, 4) as year, imdb_id from tmdb where id in ("'.implode('","', $tmdbResponse['ids']).'") order by field(id, "'.implode('","', $tmdbResponse['ids']).'")');
			foreach ($tmdbResults as $idx => $result) {
				$score = ($limit - $idx) * (100 / $limit);                          
				$scores['tmdb'][$result['id']] = $score;
				if (isset($scores['imdb'][$result['imdb_id']])) {
					$scores['both'][$result['imdb_id']] = $score + $scores['imdb'][$result['imdb_id']];
					if ($score == 100 || $scores['imdb'][$result['imdb_id']] ==  100) {
						$sure = true;
						echo "Sure of: $name\n";
					}
				}
			}
			if (!$sure) {
				echo "Not sure of: $name\n";
				print_r($scores);
				print_r($imdbResults);
				print_r($tmdbResults);
			}

			
		} elseif (!in_array($pathInfo['extension'], $ext['known'])) {
			echo "Unknown extension '{$pathInfo['extension']}' encountered on '{$path}'\n";
		} else {
			continue;
		}
	}
}

