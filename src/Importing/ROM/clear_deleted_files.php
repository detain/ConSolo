<?php
/**
* Scans through an array of path globs finding all files and scanning them performing
* checksumming, and storing of basic information.  This process can take a long time on
* a larger set of files.  It also scans inside compressed files. 
*/

require_once __DIR__.'/../../bootstrap.php';


//$pathGlobs = ['/storage/roms*/roms', '/storage/movies*', '/storage/music'];

function loadFiles($path = null) {
	/**
	* @var \Workerman\MySQL\Connection
	*/
	global $db;
	global $files, $paths, $hostId;
	$files = [];
	$paths = [];
	if (is_null($path)) {
		$tempFiles = $db->query("select id,path from files where host={$hostId} and parent is null");
	} else {
		$tempFiles = $db->query("select id,path from files where host={$hostId} and parent is null and path like '{$path}%'");
	}
	echo '[Line '.__LINE__.'] Current Memory Usage (after load query): '.memory_get_usage().PHP_EOL;
	foreach ($tempFiles as $idx => $data) {
		$paths[$data['path']] = $data['id'];
	}
	unset($tempFiles);
	echo '[Line '.__LINE__.'] Current Memory Usage (after parsing into array of path+ids): '.memory_get_usage().PHP_EOL;
}


/**
* @var \Workerman\MySQL\Connection
*/
global $db;
global $files, $db, $paths, $skipGlobs, $compressionTypes, $tmpDir, $scanCompressed, $hashAlgos, $compressedHashAlgos, $maxSize, $useMaxSize, $config, $hostId;
$deleting = [];
$deleted = 0;
$maxDeleting = 100;
echo 'Clearing Deleted Files from DB for Host '.$hostId.PHP_EOL;
$globbedPaths = [];
if (isset($pathGlobs)) {
	foreach ($pathGlobs as $pathGlob) {
		foreach (glob($pathGlob) as $path) {
			$globbedPaths[] = $path;
		}
	}
} else {
	$globbedPaths = [null];
}
foreach ($globbedPaths as $path) {
	echo 'ROM Path - '.(is_null($path) ? 'All' : $path).PHP_EOL;
	echo '[Line '.__LINE__.'] Current Memory Usage (b4 loading files): '.memory_get_usage().PHP_EOL;
	loadFiles($path);
	echo "Loaded ".count($paths)." Files\n";
	echo '[Line '.__LINE__.'] Current Memory Usage (after loading files): '.memory_get_usage().PHP_EOL;
	foreach ($paths as $path => $fileId) {
		if (!file_exists($path)) {
			echo '-'.PHP_EOL.'Removing '.$path.' ';
			$deleted++;
			$deleting[] = $fileId;
			$deletingCount = count($deleting);
			if ($deletingCount >= $maxDeleting) {
				echo "Running delete query on {$deletingCount} files\n";
				$db->delete('files')->where('parent in ('.implode(',',$deleting).')')->lowPriority($config['db_low_priority'])->query();
				$db->delete('files')->where('id in ('.implode(',',$deleting).')')->lowPriority($config['db_low_priority'])->query();
				$deleting = [];
			}
		} else {
		}
	}
}
$deletingCount = count($deleting);
if ($deletingCount > 0) {
	echo "Running delete query on {$deletingCount} files\n";
	$db->delete('files')->where('parent in ('.implode(',',$deleting).')')->lowPriority($config['db_low_priority'])->query();
	$db->delete('files')->where('id in ('.implode(',',$deleting).')')->lowPriority($config['db_low_priority'])->query();
	$deleting = [];
}
echo "Removed {$deleted} Old/Non-Existant Files\n";
