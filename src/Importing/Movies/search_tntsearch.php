<?php

use TeamTNT\TNTSearch\TNTSearch;

function handleMovieTitleResults($movieResult, &$extra, $result) {
	global $db;
	if ($movieResult['source'] == 'imdb') {
		$otherResults = $db->query("select id from tmdb_movie where imdb_id='{$movieResult['source_id']}'");
		if (count($otherResults) > 0) {
			$extra['imdb_id'] = $movieResult['source_id'];
			$extra['tmdb_id'] = $otherResults[0]['id'];
			$db->update('files')
				->cols(['extra' => json_encode($extra, JSON_PRETTY_PRINT)])
				->where('id='.$result['id'])
				->query();
			echo 'Updated file '.$result['id'].' set extra '.json_encode($extra).PHP_EOL;
		}
	} else {
		$otherResults = $db->query("select imdb_id from tmdb_movie where id='{$movieResult['source_id']}'");
		if (count($otherResults) > 0) {
			$extra['tmdb_id'] = $movieResult['source_id'];
			$extra['imdb_id'] = $otherResults[0]['imdb_id'];
			$db->update('files')
				->cols(['extra' => json_encode($extra, JSON_PRETTY_PRINT)])
				->where('id='.$result['id'])
				->query();
			echo 'Updated file '.$result['id'].' set extra '.json_encode($extra).PHP_EOL;
		}                        
	}    
}                    

require_once __DIR__.'/../../../bootstrap.php';

global $config, $mysqlLinkId;
global $db;
$tnt = new TNTSearch;
$tnt->loadConfig([
	'driver'    => 'mysql',
	'host'      => $config['db']['host'],
	'database'  => $config['db']['name'],
	'username'  => $config['db']['user'],
	'password'  => $config['db']['pass'],
	'storage'   => __DIR__.'/../../../../data/tntsearch/',
	'stemmer'   => \TeamTNT\TNTSearch\Stemmer\PorterStemmer::class//optional
]);
$tnt->fuzziness = true;
$ext = [
	'good' => ['mp4', 'avi', 'mkv', 'ogm', 'm4v'],
	'bad' => ['ini', 'db', 'txt'],
	'related' => ['srt', 'ass', 'ssa', 'sup', 'idx', 'sub', 'srm', 'Srt2Utf-8', 'nfo', 'smi'],
];
$ext['known'] = array_merge($ext['good'], $ext['bad'], $ext['related']);
$tags = ['webrip', 'brrip', 'bluray', 'dvdrip', '2160p', '1080p', '10800p', '1080', '720p', '640p', '480p', '280p', '360p', '4k', 'x264', 'x265', 'yify', 'xvid', 'ac3'];
$tnt->selectIndex("movie.index");
$results = $db->query("select min(year) as min_year, max(year) as max_year from movie_titles where year > 0");
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
			echo "File:{$pathInfo['filename']}\nName:{$name}\nLast Year:".($lastYear === false ? 'false' : $lastYear)."\nName No Year:{$nameNoYear}\nTags ".implode(', ', $fileTags)."\n";
			if ($lastYear) {
				$movieResults = $db->query("select id, title,  year, source, source_id from movie_titles where title='".$mysqlLinkId->real_escape_string($nameNoYear)."' order by abs(year-{$lastYear})");
				if (count($movieResults) > 0) {
					echo 'Title + Year Matching'.PHP_EOL;
					handleMovieTitleResults($movieResults[0], $extra, $result);
					//print_r($movieResults);
				}
			} else {
				$movieResults = $db->query("select id, title,  year, source, source_id from movie_titles where title='".$mysqlLinkId->real_escape_string($name)."'");
				if (count($movieResults) > 0) {
					echo 'Title Matching'.PHP_EOL;
					handleMovieTitleResults($movieResults[0], $extra, $result);
					//print_r($movieResults);
				}
			}
			if (!is_array($movieResults) || count($movieResults) == 0) {
				//$response = $tnt->search($name, 5);
				$response = $tnt->searchBoolean('('.$name.')', 1);
				if (count($response) > 0 && count($response['ids']) > 0) {
					$movieResults = $db->query('select id, title, year, source, source_id from movie_titles where id in ("'.implode('","', $response['ids']).'") order by field(id, "'.implode('","', $response['ids']).'")');
					if (count($movieResults) > 0) {
						echo 'Search Matching'.PHP_EOL;
						handleMovieTitleResults($movieResults[0], $extra, $result);                        
						//print_r($movieResults);
					}
				}
			}			
		} elseif (!in_array($pathInfo['extension'], $ext['known'])) {
			echo "Unknown extension '{$pathInfo['extension']}' encountered on '{$path}'\n";
		} else {
			continue;
		}
	}
}
