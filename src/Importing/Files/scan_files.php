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
$maxSize = 28000000000; // 20gb
$useMaxSize = true;
$nestedDepth = 0;
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
	global $files, $tmpDir, $compressedHashAlgos, $useMagic, $config, $hostId, $Linux, $nestedDepth, $paths;
	$statFields = ['size', 'mtime']; // fields are dev,ino,mode,nlink,uid,gid,rdev,size,atime,mtime,ctime,blksize,blocks
	$parentData = $files[$parentId];
	$parentPath = $parentData['path'];
	$virtualPath = str_replace($tmpDir.'/'.$nestedDepth.'/', '', $path);
	$linkedPath = str_replace($tmpDir.'/'.$nestedDepth.'/', $parentPath.'#', $path); 
	$pathStat = stat($path);
	$fileData = [];
	$newData = [];
	//$fileData['extra'] = [];
	foreach ($statFields as $statField) {
		$fileData[$statField] = $pathStat[$statField];
	}
	$pathInfo = pathinfo($path);
	if (array_key_exists('extension', $pathInfo)) {
		if (isMediainfo($pathInfo['extension']) && (!isset($fileData['mediainfo']) || is_null($fileData['mediainfo']) || $reread == true)) {
			$cmd = 'exec mediainfo --Output=JSON '.escapeshellarg($path);
			$fileData['mediainfo'] = json_decode(`$cmd`, true);
			$fileData['mediainfo'] = $fileData['mediainfo']['media']['track'];
			$return = false;    
		}
		if (isExifinfo($pathInfo['extension']) && (!isset($fileData['exifinfo']) || is_null($fileData['mediainfo']) || $reread == true)) {
			$cmd = 'exec exiftool -j '.escapeshellarg($path);
			$fileData['exifinfo'] = json_decode(`$cmd`, true);
			$fileData['exifinfo'] = $fileData['exifinfo'][0];
			$return = false;    
		}
	}
	if (!isset($fileData['rom_properties']) || is_null($fileData['rom_properties']) || $reread == true) {
		$cmd = 'exec rpcli -j '.escapeshellarg($path).' 2>/dev/null';
		$data = json_decode(trim(`$cmd`), true);
		if (is_array($data) && array_key_exists(0, $data)) {
			$row = $data[0];
			$data = $row;
		}
		if (!is_array($data) || array_key_exists('error', $data)) {
			$data = [];
		} else {
			$fields = [];
			if (isset($data['fields'])) {
				$fields = $data['fields'];  
			} else {
				$fields = [];
			}
			$fields = isset($data['fields']) ? $data['fields'] : [];
			unset($data['fields']);
			foreach ($fields as $idx => $row) {
				$field = $row['desc']['name'];
				$field = str_replace(['/',' ', '.', '#'], ['', '_', '', 'num'], strtolower($field));
				if ($row['type'] == 'STRING') {
					$data[$field] = $row['data']; 
				} elseif ($row['type'] == 'DATETIME') {
					$data[$field] = ($row['data'] == -1 ? null : $row['data']);
				} elseif ($row['type'] == 'BITFIELD') {
					$names = $row['desc']['names'];
					$values = [];
					$bin = strrev(decbin($names[$row['data']]));
					for ($x = 0, $xMax = strlen($bin); $x < $xMax; $x++) {
						$bit = substr($bin, $x, 1);
						$values[$names[$x]] = $bit == '1'; 
					}
					$data[$field] = $values;
				} elseif ($row['type'] == 'LISTDATA') {
					$data[$field ] = $row;
					echo 'Got LISTDATA: '.json_encode($row).PHP_EOL;
				} else {
					echo 'Dont know how to handle type '.$row['type'].PHP_EOL;
				}
			}
			foreach (['imgext', 'imgint'] as $field) {
				if (array_key_exists($field, $data)) {
					unset($data[$field]);
				}
			}
			print_r($data);
		}
		$fileData['rom_properties'] = $data;
		$return = false; 
	}
	$fileData['host'] = $hostId;
	foreach ($compressedHashAlgos as $hashAlgo) {
		if (!isset($fileData[$hashAlgo])) {
			$fileData[$hashAlgo] = hash_file($hashAlgo, $path);
		}
	}
	//if (DIRECTORY_SEPARATOR == '\\') {
	if (!$Linux) {
		//$cmd = 'C:/Progra~2/GnuWin32/bin/file -b -p '.escapeshellarg($path);
		$cmd = 'E:/Installs/cygwin64/bin/file.exe -b -p '.escapeshellarg($path);
	} else {
		$cmd = 'exec file -b -p '.escapeshellarg($path);
	}
	$fileData['magic'] = cleanUtf8(trim(`{$cmd}`));
	$fileData['path'] = $virtualPath;
	$fileData['parent'] = $parentId;
	$extraData = [];
	foreach (['magic', 'mediainfo', 'exifinfo', 'rom_properties'] as $extraField) {
		if (isset($fileData[$extraField])) {
			if (!is_array($fileData[$extraField]))
				$extraData[$extraField] = $fileData[$extraField];
			elseif (count($fileData[$extraField]) > 0)
				$extraData[$extraField] = json_encode($fileData[$extraField]);
			unset($fileData[$extraField]);
		}
	}
	$id = $db
		->insert('files')
		->cols($fileData)
		->lowPriority($config['db_low_priority'])
		->query();
	$files[$id] = $fileData;
	$paths['#'.$parentId.'/'.$virtualPath] = $id;
	$extraData['id'] = $id;
	$db
		->insert('files_extra')
		->cols($extraData)
		->lowPriority($config['db_low_priority'])
		->query();
	echo "  Added file #{$id} {$virtualPath} : ".json_encode($fileData)." from Compressed parent {$parentData['path']}\n";
	if (!array_key_exists('num_files', $fileData) || $fileData['num_files'] == 0) {
		compressedFileHandler($path, $parentId);
	}
}

function updateCompressedDir($path, $parentId) {
	global $files, $skipGlobs, $Linux;
	//if (DIRECTORY_SEPARATOR == '\\') {
	if (!$Linux) {
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

function cleanTmpDir() {
	global $tmpDir, $Linux, $nestedDepth;
	echo 'Cleaning Temp Dir '.$tmpDir.'/'.$nestedDepth.PHP_EOL;
	//if (DIRECTORY_SEPARATOR == '\\') {
	if (!$Linux) {
		passthru('rmdir /s /q '.$tmpDir.'/'.$nestedDepth);
	} else {
		passthru('rm -rf '.$tmpDir.'/'.$nestedDepth);
	}
}

function extractCompressedFile($path, $compressionType) {
	global $tmpDir, $Linux, $nestedDepth;
	cleanTmpDir();
	mkdir($tmpDir.'/'.$nestedDepth, 0777, true);
	$escapedFile = escapeshellarg($path);
	//if (DIRECTORY_SEPARATOR == '\\') {
	if (!$Linux) {
		passthru('e:/Installs/7-Zip/7z.exe x -o'.$tmpDir.'/'.$nestedDepth.' '.escapeshellarg($path), $return);
	} else {
		passthru('exec 7z x -o'.$tmpDir.'/'.$nestedDepth.' '.escapeshellarg($path), $return);
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

function compressedFileHandler($path, $parentParentId = '') {
	/**
	* @var \Workerman\MySQL\Connection
	*/
	global $db;
	global $files, $paths, $compressionTypes, $tmpDir, $scanCompressed, $nestedDepth;
	if ($scanCompressed == true) {
		$cleanPath = cleanPath($path);
		$parentId = $parentParentId != '' ? $paths[str_replace($tmpDir.'/'.$nestedDepth.'/', '#'.$parentParentId.'/', $cleanPath)] : $paths[$cleanPath];
		$fileData = $files[$parentId];
		$nestedDepth++;
		foreach ($compressionTypes as $idx => $compressionType) {
			if (hasFileExt($path, $compressionType)) {
				// handle compressed file
				$rows = $db->query("select files.*, extra from files left join files_extra using (id) where parent={$parentId}");
				echo 'Found Compressed file #'.$parentId.' '.$path.' of type '.$compressionType.' with '.count($rows).' entries'.PHP_EOL;
				if (count($rows) == 0) {
//					if (!is_null($fileData['md5']) && false !== $copyId = $db->single("select id from files where size={$fileData['size']} and md5='{$fileData['md5']}' and id != {$parentId} limit 1")) {
						
//					} else {
						if (extractCompressedFile($path, $compressionType)) {
							updateCompressedDir($tmpDir.'/'.$nestedDepth, $parentId);
						}                
						cleanTmpDir();                        
//					}
				}
			}
		}
		$nestedDepth--;
	}
}

function updateFile($path)  {
	/**
	* @var \Workerman\MySQL\Connection
	*/
	global $db;
	global $files, $paths, $hashAlgos, $maxSize, $useMaxSize, $useMagic, $hostId, $config, $Linux;
	$cleanPath = cleanPath($path);
	//echo "Path:       {$path}\nClean Path: {$cleanPath}\n";exit;
	$statFields = ['size', 'mtime']; // fields are dev,ino,mode,nlink,uid,gid,rdev,size,atime,mtime,ctime,blksize,blocks 
	$pathStat = stat($path);
	if ($useMaxSize == true && bccomp($pathStat['size'], $maxSize) == 1) {
		echo 'Skipping file "'.$path.'" as it exceeds max filesize ('.$pathStat['size'].' > '.$maxSize.')'.PHP_EOL;
		return;
	}
	$fileData = array_key_exists($cleanPath, $paths) ? $files[$paths[$cleanPath]] : [];
	//$fileData['extra'] = !isset($fileData['extra']) || is_null($fileData['extra']) || $fileData['extra'] == '' ? [] : json_decode($fileData['extra'], true);
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
	$pathInfo = pathinfo($path);
	if (array_key_exists('extension', $pathInfo)) {
		if (isMediainfo($pathInfo['extension']) && (!isset($fileData['mediainfo']) || is_null($fileData['mediainfo']) || $reread == true)) {
			$cmd = 'exec mediainfo --Output=JSON '.escapeshellarg($path);
			$fileData['mediainfo'] = json_decode(`$cmd`, true);
			$fileData['mediainfo'] = $fileData['mediainfo']['media']['track'];
			$newData['mediainfo'] = $fileData['mediainfo'];
			$return = false;    
		}
		if (isExifinfo($pathInfo['extension']) && (!isset($fileData['exifinfo']) || is_null($fileData['exifinfo']) || $reread == true)) {
			$cmd = 'exec exiftool -j '.escapeshellarg($path);
			$fileData['exifinfo'] = json_decode(`$cmd`, true);
			$fileData['exifinfo'] = $fileData['exifinfo'][0];
			$newData['exifinfo'] = $fileData['exifinfo'];
			$return = false;    
		}
	}
	if (!isset($fileData['rom_properties']) || is_null($fileData['rom_properties']) || $reread == true) {
		$cmd = 'exec rpcli -j '.escapeshellarg($path).' 2>/dev/null';
		$data = json_decode(trim(`$cmd`), true);
		if (is_array($data) && array_key_exists(0, $data)) {
			$row = $data[0];
			$data = $row;
		}
		if (!is_array($data) || array_key_exists('error', $data)) {
			$data = [];
		} else {
			$fields = [];
			if (isset($data['fields'])) {
				$fields = $data['fields'];  
			} else {
				$fields = [];
			}
			$fields = isset($data['fields']) ? $data['fields'] : [];
			unset($data['fields']);
			foreach ($fields as $idx => $row) {
				$field = $row['desc']['name'];
				$field = str_replace(['/',' ', '.', '#'], ['', '_', '', 'num'], strtolower($field));
				if (in_array($field, ['dt_flags', 'dat_flags_1']))
					continue;
				if ($row['type'] == 'STRING') {
					$data[$field] = $row['data']; 
				} elseif ($row['type'] == 'DATETIME') {
					$data[$field] = ($row['data'] == -1 ? null : $row['data']);
				} elseif ($row['type'] == 'BITFIELD') {
					$names = $row['desc']['names'];
					$values = [];
					$bin = strrev(decbin($names[$row['data']]));
					for ($x = 0, $xMax = strlen($bin); $x < $xMax; $x++) {
						$bit = substr($bin, $x, 1);
						$values[$names[$x]] = $bit == '1'; 
					}
					$data[$field] = $values;
				} elseif ($row['type'] == 'LISTDATA') {
				} else {
					echo 'Dont know how to handle type '.$row['type'].PHP_EOL;
				}
			}
			foreach (['imgext', 'imgint'] as $field) {
				if (array_key_exists($field, $data)) {
					unset($data[$field]);
				}
			}
			print_r($data);
		}
		$fileData['rom_properties'] = $data;
		$newData['rom_properties'] = $data;
		$return = false; 
	}
	if (!isset($fileData['host']) || $fileData['host'] != $hostId) {
		$newData['host'] = $hostId;
	}
	$fileData['host'] = $hostId;
	foreach ($hashAlgos as $hashAlgo) {
		if (!isset($fileData[$hashAlgo]) || $reread == true) {
			$return = false;
			$newData[$hashAlgo] = hash_file($hashAlgo, $path);
			$fileData[$hashAlgo] = $newData[$hashAlgo];
		}
	}
	if ($useMagic == true && (!isset($fileData['magic']) || is_null($fileData['magic']) || $reread == true)) {
		//if (DIRECTORY_SEPARATOR == '\\') {
		if (!$Linux) {
			//$cmd = 'C:/Progra~2/GnuWin32/bin/file -b -p '.escapeshellarg($path);
			$cmd = 'E:/Installs/cygwin64/bin/file.exe -b -p '.escapeshellarg($path);
		} else {
			$cmd = 'exec file -b -p '.escapeshellarg($path);
		}
		$fileData['magic'] = cleanUtf8(trim(`{$cmd}`));
		$newData['magic'] = $fileData['magic'];
		$return = false;    
	}
	$extraData = [];
	foreach (['magic', 'mediainfo', 'exifinfo', 'rom_properties'] as $extraField) {
		if (isset($newData[$extraField])) {
			if (!is_array($newData[$extraField]))
				$extraData[$extraField] = $newData[$extraField];
			elseif (count($newData[$extraField]) > 0)
				$extraData[$extraField] = json_encode($newData[$extraField]);
			unset($newData[$extraField]);
		}
	}
	if ($return === false) {
		if (!isset($paths[$cleanPath])) {
			$newData['path'] = $cleanPath;
			$fileData['path'] = $cleanPath;
			$id = $db
				->insert('files')
				->cols($newData)
				->lowPriority($config['db_low_priority'])
				->query();
			$paths[$cleanPath] = $id;
			echo "  Added file #{$id} {$cleanPath} : ".json_encode($newData).PHP_EOL;
			$extraData['id'] = $id;
			$db
				->insert('files_extra')
				->cols($extraData)
				->lowPriority($config['db_low_priority'])
				->query();
			echo "  Added file extra #{$id} {$cleanPath} : ".json_encode($extraData).PHP_EOL;
		} else {
			$id = $paths[$cleanPath];
			if (count($newData) > 0) {
				$db
					->update('files')
					->cols($newData)
					->where('id='.$id)
					->lowPriority($config['db_low_priority'])
					->query();
				echo "  Updated file #{$paths[$cleanPath]} {$cleanPath} : ".json_encode($newData).PHP_EOL;
			}
			if (isset($extraData) && count($extraData) > 0) {
				echo "  Updated file extra #{$paths[$cleanPath]} {$cleanPath} : ".json_encode($extraData).PHP_EOL;
				$db
					->update('files_extra')
					->cols($extraData)
					->where('id='.$id)
					->lowPriority($config['db_low_priority'])
					->query();
			}
		}
		$files[$id] = $fileData;
	}
	if ($reread === true) {
		$id = $paths[$cleanPath];
		$db
			->delete('files')
			->where('parent='.$id)
			->lowPriority($config['db_low_priority'])
			->query();
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
		$tempFiles = $db->query("select *, (select count(*) from files f2 where f2.parent=f1.id) as num_files from files f1 left join files_extra using (id) where host={$hostId} and parent is null");
	} else {
		$cleanPath = cleanPath($path);
		$cleanPath = str_replace("'", '\\'."'", $cleanPath);
		echo 'Searching Path '.$cleanPath.PHP_EOL;
		$tempFiles = $db->query("select *, (select count(*) from files f2 where f2.parent=f1.id) as num_files from files f1 left join files_extra using (id) where host={$hostId} and path like '{$cleanPath}%' and parent is null");
	}
	echo '[Line '.__LINE__.'] Current Memory Usage: '.memory_get_usage().PHP_EOL;
	foreach ($tempFiles as $idx => $data) {
		$id = $data['id'];
		unset($data['id']);
		unset($data['parent']);
		//$data['path'] = str_replace('!', '\\!', cleanPath($data['path']));
		//echo 'Searching Path '.$data['path'].PHP_EOL;
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
