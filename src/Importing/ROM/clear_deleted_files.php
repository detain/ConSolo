<?php
/**
* Scans through an array of path globs finding all files and scanning them performing
* checksumming, and storing of basic information.  This process can take a long time on
* a larger set of files.  It also scans inside compressed files. 
*/

require_once __DIR__.'/../../bootstrap.php';


$pathGlobs = ['/storage/*/roms'];

function loadFiles($path = null) {
	/**
	* @var \Workerman\MySQL\Connection
	*/
	global $db;
	global $files, $paths;
	$files = [];
	$paths = [];
	if (is_null($path)) {
		$tempFiles = $db->query("select * from files where parent is null");
	} else {
		$tempFiles = $db->query("select * from files where path like '{$path}%' and parent is null");
	}
	echo '[Line '.__LINE__.'] Current Memory Usage: '.memory_get_usage().PHP_EOL;
	foreach ($tempFiles as $idx => $data) {
		$id = $data['id'];
		unset($data['id']);
		unset($data['parent']);
		$files[$id] = $data;
		$paths[$data['path']] = $id;
		unset($tempFiles[$idx]);        
	}
	echo '[Line '.__LINE__.'] Current Memory Usage: '.memory_get_usage().PHP_EOL;
}


/**
* @var \Workerman\MySQL\Connection
*/
global $db;
global $files, $db, $paths, $skipGlobs, $compressionTypes, $tmpDir, $scanCompressed, $hashAlgos, $compressedHashAlgos, $maxSize, $useMaxSize;
$deleting = [];
$deleted = 0;
$maxDeleting = 100;
foreach ($pathGlobs as $pathGlob) {
	foreach (glob($pathGlob) as $path) {
		echo "ROM Path - {$path}\n";
		echo '[Line '.__LINE__.'] Current Memory Usage: '.memory_get_usage().PHP_EOL;
		loadFiles($path);
		echo "Loaded ".count($files)." Files\n";
		echo '[Line '.__LINE__.'] Current Memory Usage: '.memory_get_usage().PHP_EOL;
		foreach ($paths as $path => $fileId) {
			if (!file_exists($path)) {
				echo '-'.PHP_EOL.'Removing '.$path.' ';
				$deleted++;
				$deleting[] = $fileId;
				$deletingCount = count($deleting);
				if ($deletingCount >= $maxDeleting) {
					echo "Running delete query on {$deletingCount} files\n";
					$db->delete('files')->where('id in ('.implode(',',$deleting).')')->lowPriority()->query();
					$deleting = [];
				}
			} else {
			}
		}
	}
}
$deletingCount = count($deleting);
if ($deletingCount > 0) {
	echo "Running delete query on {$deletingCount} files\n";
	$db->delete('files')->where('id in ('.implode(',',$deleting).')')->lowPriority()->query();
	$deleting = [];
}
echo "Removed {$deleted} Old/Non-Existant Files\n";