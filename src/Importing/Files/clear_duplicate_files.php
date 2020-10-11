<?php
/**
* Scans through an array of path globs finding all files and scanning them performing
* checksumming, and storing of basic information.  This process can take a long time on
* a larger set of files.  It also scans inside compressed files. 
*/

require_once __DIR__.'/../../bootstrap.php';


$pathGlobs = ['/storage/*/roms'];
$pathGlobs = ['/storage/vault0/roms/*'];

function loadFiles($path = null) {
	/**
	* @var \Workerman\MySQL\Connection
	*/
	global $db;
	global $duplicates;
	global $minSize;
	if (is_null($path)) {
		$tempFiles = $db->query("select id, path, size, md5 from files where parent is null and size > {$minSize}");
	} else {
		$tempFiles = $db->query("select id, path, size, md5 from files where path like '{$path}%' and parent is null and size > {$minSize}");
	}
	//echo '[Line '.__LINE__.'] Current Memory Usage: '.memory_get_usage().PHP_EOL;
	foreach ($tempFiles as $idx => $data) {
		$key = $data['size'].'-'.$data['md5'];
		if (!isset($duplicates[$key])) {
			$duplicates[$key] = [];
		}
		$duplicates[$key][] = [$data['id'], $data['path']]; 
	}
	//echo '[Line '.__LINE__.'] Current Memory Usage: '.memory_get_usage().PHP_EOL;
}


/**
* @var \Workerman\MySQL\Connection
*/
global $db;
global $db, $skipGlobs, $compressionTypes, $tmpDir, $scanCompressed, $hashAlgos, $compressedHashAlgos, $maxSize, $useMaxSize, $duplicates, $minSize, $config;
$duplicates = [];
$deleting = [];
$deletedBytes = 0;
$deletedFiles = 0;
$maxDeleting = 100;
$minSize = 1;
foreach ($pathGlobs as $pathGlob) {
	foreach (glob($pathGlob) as $path) {
		//echo "ROM Path - {$path}\n";
		//echo '[Line '.__LINE__.'] Current Memory Usage: '.memory_get_usage().PHP_EOL;
		loadFiles($path);
		foreach ($duplicates as $key => $duplicateArray) {
			if (count($duplicateArray) > 1) {
				$deleteIds = [];
				list($size, $md5) = explode('-', $key);
				$keep = array_shift($duplicateArray);
				list($keepId, $keepPath) = $keep;
				echo $keepPath.PHP_EOL;
				//echo 'Found and Deleting Duplicates of: '.$keepPath.' ('.$size.' bytes)'.PHP_EOL;
				foreach ($duplicateArray as $fileArray) {
					list($fileId, $filePath) = $fileArray;
					//echo '    '.$filePath.PHP_EOL;
					echo $filePath.PHP_EOL;
					//unlink($filePath);
					$deleteIds[] = $fileId;
					$deletedFiles++;
					$deletedBytes = bcadd($deletedBytes, $size, 0);
				}
				echo PHP_EOL;
				//$db->delete('files')->where('id in ('.implode(',',$deleteIds).')')->lowPriority($config['db']['low_priority'])->query();
				//echo "So far Deleted {$deletedFiles} Files Freeing {$deletedBytes} Bytes\n";
			}
		}
	}
}
