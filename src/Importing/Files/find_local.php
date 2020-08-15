<?php
require_once __DIR__.'/inc.php';
$tags = ['webrip', 'brrip', 'bluray', 'dvdrip', '2160p', '1080p', '10800p', '720p', '640p', '480p', 'x264', 'x265', 'yify', 'xvid', '4k', 'ac3', '1080'];
$files = loadJson('files');
$missingFiles = $files;
foreach (glob('/storage/movies*/*') as $fileName) {
	if (array_key_exists($fileName, $missingFiles)) {
		unset($missingFiles[$fileName]);
		continue;
	}
	$pathInfo = pathinfo($fileName);
	$result = [
		'name' => false,
		'year' => false,
		'imdb_id' => false,
		'tmdb_id' => false,
		'yts_id' => false,
		'file' => [
			'name' => $fileName, 
			'movieName' => $fileName, 
			'year' => false,
			'ext' => mb_strtolower($pathInfo['extension']),
			'tags' => [],
			'dir' => $pathInfo['dirname'],
		],
	];
	$nameRaw = $pathInfo['filename'];
	$nameRawParts = explode(' ', implode(' ', explode('.', implode(' ', explode('_', $nameRaw)))));
	$nameParts = [];
	// strip the [, (, ), and ]   
	foreach ($nameRawParts as $idx => $part) {
		if (in_array(mb_substr($part, 0, 1), ['(', '[']) && in_array(mb_substr($part, -1), [')', ']'])) {
			$nameRawParts[$idx] = mb_substr($part, 1, mb_strlen($part) - 2);             
		}
	}
	// find any tags in the name and store them in an array whilst stripping them from the name parts array 
	$firstTagIdx = false;
	foreach ($tags as $tag) {
		foreach ($nameRawParts as $idx => $part) {
			if (in_array($part, ['[',']','(',')'])) {
				unset($nameRawParts[$idx]);
				continue;
			}
			if (mb_strtolower($part) == mb_strtolower($tag)) {
				if ($firstTagIdx === false || $idx < $firstTagIdx) {
					$firstTagIdx = $idx;
				}
				$result['file']['tags'][] = $tag;
				unset($nameRawParts[$idx]);
				break;
			}
		}
	}
	// chop off the parts of the name starting with the first taggged bit
	if ($firstTagIdx !== false) {
		foreach ($nameRawParts as $idx => $part) {
			$nameParts[] = $part;
			if (count($nameParts) >= $firstTagIdx) {
				break;
			}
		}
	} else {
		$nameParts = $nameRawParts;
	}
	
	$lastIdx = count($nameParts) - 1;
	while ($lastIdx > 0) {
		if (is_numeric($nameParts[$lastIdx]) && mb_strlen($nameParts[$lastIdx]) == 4) {
			$result['file']['year'] = $nameParts[$lastIdx];
			foreach ($nameParts as $idx => $part) {
				if ($idx >= $lastIdx) {
					unset($nameParts[$idx]);
				}
			}
			break; 
		}
		$lastIdx--;			
	}
	$result['file']['movieName'] = implode(' ', $nameParts);
	echo '- '.$result['file']['movieName'].' ('.$result['file']['year'].')'.PHP_EOL;
	$files[$fileName] = $result;
}
echo 'Found '.count($missingFiles).' Missing Files'.PHP_EOL;
foreach ($missingFiles as $fileName => $fileData) {
	unset($files[$fileName]);
}
ksort($files);
putJson('files', $files);
