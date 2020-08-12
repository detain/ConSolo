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
$maxSize = 18000000000; // 20gb
$useMaxSize = true;
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
	$tmpDir = 'C:\\Users\\detain\\AppData\\Local\\Temp\\scanfiles-'.uniqid();
}


function updateCompressedFile($path, $parentId)  {
	/**
	* @var \Workerman\MySQL\Connection
	*/
	global $db;
	global $files, $tmpDir, $compressedHashAlgos, $useMagic, $config, $hostId;
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
	if (!isset($fileData['host']) || $fileData['host'] != $hostId) {
		$newData['host'] = $hostId;
	}
	$fileData['host'] = $hostId;
	foreach ($compressedHashAlgos as $hashAlgo) {
		if (!isset($fileData[$hashAlgo])) {
			$newData[$hashAlgo] = hash_file($hashAlgo, $path);
			$fileData[$hashAlgo] = hash_file($hashAlgo, $path);
		}
	}
	if (DIRECTORY_SEPARATOR == '\\') {
		//$cmd = 'C:/Progra~2/GnuWin32/bin/file -b -p '.escapeshellarg($path);
		$cmd = 'E:/Installs/cygwin64/bin/file.exe -b -p '.escapeshellarg($path);
	} else {
		$cmd = 'exec file -b -p '.escapeshellarg($path);
	}
	$fileData['magic'] = cleanUtf8(trim(`{$cmd}`));
	$fileData['path'] = $virtualPath;
	$fileData['parent'] = $parentId;
	$id = $db->insert('files')->cols($fileData)->lowPriority($config['db_low_priority'])->query();
	echo "  Added file #{$id} {$virtualPath} : ".json_encode($fileData)." from Compressed parent {$parentData['path']}\n";
}

function updateCompressedDir($path, $parentId) {
	global $files, $skipGlobs;
	if (DIRECTORY_SEPARATOR == '\\') {
		$cmd = 'e:/Installs/cygwin64/bin/find.exe '.escapeshellarg($path).' -type f';
	} else {
		$cmd = 'exec find '.escapeshellarg($path).' -type f';
	}
	$paths = trim(`{$cmd}`);
	if ($paths == '')
		return;
	$paths = explode("\n", $paths);
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

function cleanUtf8($text) {
	$text = preg_replace('/[\x00-\x08\x10\x0B\x0C\x0E-\x19\x7F]'.
	'|(?<=^|[\x00-\x7F])[\x80-\xBF]+'.
	'|([\xC0\xC1]|[\xF0-\xFF])[\x80-\xBF]*'.
	'|[\xC2-\xDF]((?![\x80-\xBF])|[\x80-\xBF]{2,})'.
	'|[\xE0-\xEF](([\x80-\xBF](?![\x80-\xBF]))|(?![\x80-\xBF]{2})|[\x80-\xBF]{3,})/',
	'ï¿½', $text);
	$text = preg_replace('/\xE0[\x80-\x9F][\x80-\xBF]'.
	'|\xED[\xA0-\xBF][\x80-\xBF]/S','?', $text);    
	return $text;    
}

function cleanTmpDir() {
	global $tmpDir;
	echo 'Cleaning Temp Dir '.$tmpDir.PHP_EOL;
	if (DIRECTORY_SEPARATOR == '\\') {
		passthru('rmdir /s /q '.$tmpDir);
	} else {
		passthru('rm -rf '.$tmpDir);
	}
}

function extractCompressedFile($path, $compressionType) {
	global $tmpDir;
	cleanTmpDir();
	mkdir($tmpDir);
	$escapedFile = escapeshellarg($path);
	if (DIRECTORY_SEPARATOR == '\\') {
		passthru('e:/Installs/7-Zip/7z.exe x -o'.$tmpDir.' '.escapeshellarg($path), $return);
	} else {
		passthru('exec 7z x -o'.$tmpDir.' '.escapeshellarg($path), $return);
	}
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
		$cleanPath = cleanPath($path);
		foreach ($compressionTypes as $idx => $compressionType) {
			if (hasFileExt($path, $compressionType)) {
				// handle compressed file
				$parentId = $paths[$cleanPath];
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
	$cleanPath = cleanPath($path);
	$statFields = ['size', 'mtime']; // fields are dev,ino,mode,nlink,uid,gid,rdev,size,atime,mtime,ctime,blksize,blocks 
	$pathStat = stat($path);
	if ($useMaxSize == true && bccomp($pathStat['size'], $maxSize) == 1) {
		echo 'Skipping file "'.$path.'" as it exceeds max filesize ('.$pathStat['size'].' > '.$maxSize.')'.PHP_EOL;
		return;
	}
	if (!array_key_exists($cleanPath, $paths)) {
		$fileData = [];
	} else {
		$fileData = $files[$paths[$cleanPath]];
	}
	$newData = [];
	foreach ($statFields as $statField) {
		if (!isset($fileData[$statField]) || $pathStat[$statField] != $fileData[$statField]) {
			$newData[$statField] = $pathStat[$statField];            
		}
		$fileData[$statField] = $pathStat[$statField];
	}
	if (array_key_exists($cleanPath, $paths) && $files[$paths[$cleanPath]]['mtime'] == $fileData['mtime'] && $files[$paths[$cleanPath]]['size'] == $fileData['size']) {
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
		if (DIRECTORY_SEPARATOR == '\\') {
			//$cmd = 'C:/Progra~2/GnuWin32/bin/file -b -p '.escapeshellarg($path);
			$cmd = 'E:/Installs/cygwin64/bin/file.exe -b -p '.escapeshellarg($path);
		} else {
			$cmd = 'exec file -b -p '.escapeshellarg($path);
		}
		$newData['magic'] = cleanUtf8(trim(`{$cmd}`));
		$fileData['magic'] = $newData['magic'];
		$return = false;    
	}
	if ($return === false) {
		if (!isset($paths[$cleanPath])) {
			$newData['path'] = $cleanPath;
			$fileData['path'] = $cleanPath;
			$id = $db->insert('files')->cols($newData)->lowPriority($config['db_low_priority'])->query();
			$paths[$cleanPath] = $id;
			echo "  Added file #{$id} {$cleanPath} : ".json_encode($newData).PHP_EOL;
		} else {
			$id = $paths[$cleanPath];
			$db->update('files')->cols($newData)->where('id='.$id)->lowPriority($config['db_low_priority'])->query();
			echo "  Updated file #{$paths[$cleanPath]} {$cleanPath} : ".json_encode($newData).PHP_EOL;
		}
		$files[$id] = $fileData;
	}
	if ($reread === true) {
		$id = $paths[$cleanPath];
		$db->delete('files')->where('parent='.$id)->lowPriority($config['db_low_priority'])->query();
	}
	if (!array_key_exists('num_files', $fileData) || $fileData['num_files'] == 0) {
		compressedFileHandler($path);
	}
}

function updateDir($path) {
	global $files, $skipGlobs;
	$cleanPath = cleanPath($path);
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
		$tempFiles = $db->query("select *, (select count(*) from files f2 where f2.parent=f1.id) as num_files from files f1 where host={$hostId} and parent is null");
	} else {
		$cleanPath = cleanPath($path);
		$cleanPath = str_replace("'", '\\'."'", $cleanPath);
		echo 'Searching Path '.$cleanPath.PHP_EOL;
		$tempFiles = $db->query("select *, (select count(*) from files f2 where f2.parent=f1.id) as num_files from files f1 where host={$hostId} and path like '{$cleanPath}%' and parent is null");
	}
	echo '[Line '.__LINE__.'] Current Memory Usage: '.memory_get_usage().PHP_EOL;
	foreach ($tempFiles as $idx => $data) {
		$id = $data['id'];
		unset($data['id']);
		unset($data['parent']);
		$data['path'] = cleanPath($path);
		echo 'Searching Path '.$data['path'].PHP_EOL;
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
		$files = [];
		$paths = [];
		$mem_usage = memory_get_usage();
		loadFiles($path);
		$mem_usage = memory_get_usage() - $mem_usage;
		echo "Loaded ".count($files)." Files ({$mem_usage} Memory Used by Files)\n";
		if (is_dir($path)) {
			updateDir($path);
		} else {
			updateFile($path);
		}
	}
}
