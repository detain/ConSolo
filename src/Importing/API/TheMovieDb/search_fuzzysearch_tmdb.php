<?php
/**
* @link https://github.com/loilo/Fuse 
*/

use FuzzySearch\FuzzySearch;

require_once __DIR__.'/../../../bootstrap.php';

// Convert an UTF-8 encoded string to a single-byte string suitable for
// functions such as levenshtein.
//
// The function simply uses (and updates) a tailored dynamic encoding
// (in/out map parameter) where non-ascii characters are remapped to
// the range [128-255] in order of appearance.
//
// Thus it supports up to 128 different multibyte code points max over
// the whole set of strings sharing this encoding.
//
function utf8_to_extended_ascii($str, &$map)
{
	// find all multibyte characters (cf. utf-8 encoding specs)
	$matches = array();
	if (!preg_match_all('/[\xC0-\xF7][\x80-\xBF]+/', $str, $matches))
		return $str; // plain ascii string
   
	// update the encoding map with the characters not already met
	foreach ($matches[0] as $mbc)
		if (!isset($map[$mbc]))
			$map[$mbc] = chr(128 + count($map));
   
	// finally remap non-ascii characters
	return strtr($str, $map);
}
/*
%t  title
%y  year
%y  resolution
*/
$patterns = [
	'%t %y',
	'%t'
];
$ext = [
	'good' => ['mp4', 'avi', 'mkv', 'ogm', 'm4v'],
	'bad' => ['ini', 'db', 'txt'],
	'related' => ['srt', 'ass', 'ssa', 'sup', 'idx', 'sub', 'srm', 'Srt2Utf-8', 'nfo', 'smi'],
];
$ext['known'] = array_merge($ext['good'], $ext['bad'], $ext['related']);
$results = $db->query("select * from files where parent is null and (path like 'D:/Movies/%' or path like '/storage/movies%')");
foreach ($results as $result) {
	$extra = !is_null($result['extra']) ? json_decode($result['extra'], true) : [];
	if (!isset($extra['tmdb_id'])) {
		$pathInfo = pathinfo($result['path']);
		if (in_array($pathInfo['extension'], $ext['good'])) {
			$name = $pathInfo['filename'];
			if (strpos($name, ' ') === false) {
				$name = preg_replace('/\.([^\.])/', ' \1', $name);
			}
			//echo "$name\n";
		} elseif (!in_array($pathInfo['extension'], $ext['known'])) {
			echo "Unknown extension '{$pathInfo['extension']}' encountered on '{$path}'\n";
		} else {
			continue;
		}
	}
}
echo "Selecting titles...";
$results = $db->query("select title, substring(release_date, 1, 4) as year from tmdb");
echo "done".PHP_EOL;
echo "cleaning titles...";
$charMap = array();
$maxOrigLength = 0;
$maxLength = 0;
$fuseData = [];
foreach ($results as $idx => $data) {
	if (strlen($data['title']) > 250) {
		$data['title'] = substr($data['title'], 0, 250);
	}
	
	$fuseData[] = $data;
	$data['title'] = $data['title'].' '.$data['year'];
	$fuseData[] = $data;
}
echo "done".PHP_EOL;
//$fuseData = json_decode(file_get_contents(__DIR__.'/../../../../data/json/tmdb_fuse.json'), true);
echo 'Initializing Search...';
$fuzzy = new FuzzySearch($fuseData, 'title');
echo "done".PHP_EOL;
$maxDistance = 25;
echo 'Searching...';
$results = $fuzzy->search('Under Suspicion 1991 1080p BluRay x264-[YTS LT]', $maxDistance);
//$results = $fuzzy->search('10 Things I Hate About You (1999) 720p', $maxDistance);
echo "done".PHP_EOL;
print_r($results);
