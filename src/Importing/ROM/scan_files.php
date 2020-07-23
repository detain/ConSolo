<?php
/**
* Scans through an array of path globs finding all files and scanning them performing
* checksumming, and storing of basic information.  This process can take a long time on
* a larger set of files.  It also scans inside compressed files. 
*/

require_once __DIR__.'/../../bootstrap.php';

$skipGlobs = [];
$compressionTypes = ['7z', 'rar', 'zip'];
$hashAlgos = ['md5', 'sha1', 'crc32']; // use hash_algos() to get all possible hashes
$compressedHashAlgos = ['md5', 'sha1', 'crc32']; // use hash_algos() to get all possible hashes
$scanCompressed = true;
$useMagic = true;
$maxSize = 500000000;
$useMaxSize = false;
if (isset($_SERVER['argc']) && $_SERVER['argc'] > 1) {
	$paths = [];
	for ($x = 1; $x < $_SERVER['argc']; $x++) {
		$arg = $_SERVER['argv'][$x];
		if (in_array($arg, ['-m', '--md5'])) {
			$hashAlgos = ['md5'];
			$compressedHashAlgos = ['md5'];
		} elseif (in_array($arg, ['-n', '--no-hash'])) {
			$hashAlgos = [];
			$compressedHashAlgos = [];
		} elseif (in_array($arg, ['-h', '--help'])) {
			echo "{$_SERVER['argv'][0]} <options>
Options:
-n --no-hash            No Hashing
-m --md5                Only do MD5 Hashing
-s --skip-compressed    Disable Scanning Compressed Files
--skip-magic            Disable Setting magic Info
-h --help               This Page
";
			exit;
		} elseif (in_array($arg, ['-s', '--skip-compressed'])) {
			$scanCompressed = false;
		} elseif (in_array($arg, ['--skip-magic'])) {
			$useMagic = false;
		} else {
			if (substr($arg, -1) == '/')
				$arg = substr($arg, 0, -1);
			$paths[] = $arg;
		}
	}
	$pathGlobs = $paths;
} else {
	$pathGlobs = ['/storage/*/roms'];
}
if (function_exists('posix_getpid')) {
	$tmpDir = '/tmp/scanfiles-'.posix_getpid();
} else {
	$tmpDir = 'C:\\Users\\detain\\AppData\\Local]\\Temp\\scanfiles-'.uniqid();
}


function updateCompressedFile($path, $parentId)  {
	/**
	* @var \Workerman\MySQL\Connection
	*/
	global $db;
	global $files, $tmpDir, $compressedHashAlgos, $useMagic, $config;
	$statFields = ['size', 'mtime']; // fields are dev,ino,mode,nlink,uid,gid,rdev,size,atime,mtime,ctime,blksize,blocks
	$parentData = $files[$parentId];
	$parentPath = $parentData['path'];
	$virtualPath = str_replace($tmpDir.'/', '', $path);
	$linkedPath = str_replace($tmpDir.'/', $parentPath.'#', $path); 
	$realPath = $path;
	$pathStat = stat($realPath);
	$fileData = [];
	$newData = [];
	foreach ($statFields as $statField) {
		if (!isset($fileData[$statField]) || $pathStat[$statField] != $fileData[$statField]) {
			$newData[$statField] = $pathStat[$statField];            
		}
		$fileData[$statField] = $pathStat[$statField];
	}
	foreach ($compressedHashAlgos as $hashAlgo) {
		if (!isset($fileData[$hashAlgo])) {
			$newData[$hashAlgo] = hash_file($hashAlgo, $path);
			$fileData[$hashAlgo] = hash_file($hashAlgo, $path);
		}
	}
	$cmd = 'exec file -b -p '.escapeshellarg($path);
	$fileData['magic'] = trim(`{$cmd}`);
	$fileData['path'] = $virtualPath;
	$fileData['parent'] = $parentId;
	$id = $db->insert('files')->cols($fileData)->lowPriority($config['db_low_priority'])->query();
	echo "  Added file #{$id} {$virtualPath} : ".json_encode($fileData)." from Compressed parent {$parentData['path']}\n";
}

function updateCompressedDir($path, $parentId) {
	global $files, $skipGlobs;
	$cmd = 'exec find '.escapeshellarg($path).' -type f';
	$paths = explode("\n", trim(`{$cmd}`));
	foreach ($paths as $subPath) {
		$bad = false;
		foreach ($skipGlobs as $skipGlob) {
			if (substr($subPath, 0, strlen($skipGlob)) == $skipGlob) {
				echo 'Skipping Path '.$subPath.' matching glob '.$skipGlob.PHP_EOL;
				$bad = true;
			}
		}
		if ($bad === false) {
			if (is_dir($subPath)) {
				updateCompressedDir($subPath, $parentId);
			} else {
				updateCompressedFile($subPath, $parentId);
			}
		}
	}    
}

function cleanTmpDir() {
	global $tmpDir;
	echo 'Cleaning Temp Dir '.$tmpDir.PHP_EOL;
	passthru('rm -rf '.$tmpDir);
}

function extractCompressedFile($path, $compressionType) {
	global $tmpDir;
	cleanTmpDir();
	mkdir($tmpDir);
	$escapedFile = escapeshellarg($path);
	passthru('exec 7z x -o'.$tmpDir.' '.escapeshellarg($path), $return);
	return ($return == 0);
}

function hasFileExt($file, $ext) {
	$origExt = $ext;
	$ext = substr($ext, 0, 1) == '.' ? $ext : '.'.$ext;
	if (substr($file, 0 - strlen($ext)) == $ext) {
		return true;
	} else {
		return false;
	}
}

function compressedFileHandler($path) {
	/**
	* @var \Workerman\MySQL\Connection
	*/
	global $db;
	global $files, $paths, $compressionTypes, $tmpDir, $scanCompressed;
	if ($scanCompressed == true) {
		foreach ($compressionTypes as $idx => $compressionType) {
			if (hasFileExt($path, $compressionType)) {
				// handle compressed file
				$parentId = $paths[$path];
				$rows = $db->query("select * from files where parent={$parentId}");
				echo 'Found Compressed file #'.$parentId.' '.$path.' of type '.$compressionType.' with '.count($rows).' entries'.PHP_EOL;
				if (count($rows) == 0) {
					if (extractCompressedFile($path, $compressionType)) {
						updateCompressedDir($tmpDir, $parentId);
					}                
					cleanTmpDir();
				}
			}
		}
	}
}

function updateFile($path)  {
	/**
	* @var \Workerman\MySQL\Connection
	*/
	global $db;
	global $files, $paths, $hashAlgos, $maxSize, $useMaxSize, $useMagic, $hostId, $config;
	$statFields = ['size', 'mtime']; // fields are dev,ino,mode,nlink,uid,gid,rdev,size,atime,mtime,ctime,blksize,blocks 
	$pathStat = stat($path);
	if ($useMaxSize == true && $pathStat['size'] >= $maxSize) {
		return;
	}
	if (!array_key_exists($path, $paths)) {
		$fileData = [];
	} else {
		$fileData = $files[$paths[$path]];
	}
	$newData = [];
	foreach ($statFields as $statField) {
		if (!isset($fileData[$statField]) || $pathStat[$statField] != $fileData[$statField]) {
			$newData[$statField] = $pathStat[$statField];            
		}
		$fileData[$statField] = $pathStat[$statField];
	}
	if (array_key_exists($path, $paths) && $files[$paths[$path]]['mtime'] == $fileData['mtime'] && $files[$paths[$path]]['size'] == $fileData['size']) {
		$return = true;
		$reread = false;
	} else {
		$return = false;
		$reread = true;        
	}
	if (!isset($fileData['host']) || $fileData['host'] != $hostId) {
		$newData['host'] = $hostId;
	}
	$fileData['host'] = $hostId;
	foreach ($hashAlgos as $hashAlgo) {
		if (!isset($fileData[$hashAlgo]) || $reread == true) {
			$return = false;
			$newData[$hashAlgo] = hash_file($hashAlgo, $path);
			$fileData[$hashAlgo] = hash_file($hashAlgo, $path);
		}
	}
	if ($useMagic == true && (!isset($fileData['magic']) || is_null($fileData['magic']) || $reread == true)) {
		$cmd = 'exec file -b -p '.escapeshellarg($path);
		$newData['magic'] = trim(`{$cmd}`);
		$fileData['magic'] = $newData['magic'];
		$return = false;    
	}
	if ($return === false) {
		if (!isset($paths[$path])) {
			$newData['path'] = $path;
			$fileData['path'] = $path;
			$id = $db->insert('files')->cols($newData)->lowPriority($config['db_low_priority'])->query();
			$paths[$path] = $id;
			echo "  Added file #{$id} {$path} : ".json_encode($newData).PHP_EOL;
		} else {
			$id = $paths[$path];
			$db->update('files')->cols($newData)->where('id='.$id)->lowPriority($config['db_low_priority'])->query();
			echo "  Updated file #{$paths[$path]} {$path} : ".json_encode($newData).PHP_EOL;
		}
		$files[$id] = $fileData;
	}
	if ($reread === true) {
		$id = $paths[$path];
		$db->delete('files')->where('parent='.$id)->lowPriority($config['db_low_priority'])->query();
	}
	compressedFileHandler($path);
}

function updateDir($path) {
	global $files, $skipGlobs;
	foreach (glob($path.'/*') as $subPath) {
		$bad = false;
		foreach ($skipGlobs as $skipGlob) {
			if (substr($subPath, 0, strlen($skipGlob)) == $skipGlob) {
				echo 'Skipping Path '.$subPath.' matching glob '.$skipGlob.PHP_EOL;
				$bad = true;
			}
		}
		if ($bad === false) {
			if (is_dir($subPath)) {
				updateDir($subPath);
			} else {
				updateFile($subPath);
			}
		}
	}    
}

function loadFiles($path = null) {
	/**
	* @var \Workerman\MySQL\Connection
	*/
	global $db;
	global $files, $paths, $hostId;
	$files = [];
	$paths = [];
	if (is_null($path)) {
		$tempFiles = $db->query("select * from files where host={$hostId} and parent is null");
	} else {
		$path = str_replace("'", '\\'."'", $path);
		$tempFiles = $db->query("select * from files where host={$hostId} and path like '{$path}%' and parent is null");
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
global $files, $db, $paths, $skipGlobs, $compressionTypes, $tmpDir, $scanCompressed, $hashAlgos, $compressedHashAlgos, $maxSize, $useMaxSize, $useMagic;

foreach ($pathGlobs as $pathGlob) {
	foreach (glob($pathGlob) as $path) {
		echo "ROM Path - {$path}\n";
		echo '[Line '.__LINE__.'] Current Memory Usage: '.memory_get_usage().PHP_EOL;
		loadFiles($path);
		echo "Loaded ".count($files)." Files\n";
		echo '[Line '.__LINE__.'] Current Memory Usage: '.memory_get_usage().PHP_EOL;
		if (is_dir($path)) {
			updateDir($path);
		} else {
			updateFile($path);
		}
	}
}
