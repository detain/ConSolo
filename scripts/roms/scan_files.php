<?php
/**
* Scans through an array of path globs finding all files and scanning them performing
* checksumming, and storing of basic information.  This process can take a long time on
* a larger set of files so there is an automated timed backup that by default occurs 
* roughly every 60 seconds.
* 
* The backup interval and the array of paths globs can be configured in the lines
* directly below.  
*/
include __DIR__.'/../../vendor/autoload.php';

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

function updateFile($path)  {
    /**
    * @var \Workerman\MySQL\Connection
    */
    global $db;
    global $files, $paths;
    //$hashAlgos = ['md5', 'sha1', 'crc32']; // use hash_algos() to get all possible hashes
    //$hashAlgos = ['md5', 'crc32']; // use hash_algos() to get all possible hashes
    $hashAlgos = ['md5']; // use hash_algos() to get all possible hashes
    $statFields = ['size', 'mtime']; // fields are dev,ino,mode,nlink,uid,gid,rdev,size,atime,mtime,ctime,blksize,blocks 
    $pathStat = stat($path);
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
    $return = false;
    if (array_key_exists($path, $paths) && $files[$paths[$path]]['mtime'] == $fileData['mtime'] && $files[$paths[$path]]['size'] == $fileData['size']) {
        $return = true;
    }
    foreach ($hashAlgos as $hashAlgo) {
        if (!isset($fileData[$hashAlgo])) {
            $return = false;
            $newData[$hashAlgo] = hash_file($hashAlgo, $path);
            $fileData[$hashAlgo] = hash_file($hashAlgo, $path);
        }
    }
    if ($return === true) {
        //echo "  Skipping {$path}, Its Already Hashed and Still The Same Size and Modification Time\n";
        //echo " Skipping {$path}\n";
        //echo '-';
        return;
    }
    if (!isset($paths[$path])) {
        $fileData['path'] = $path;
        $id = $db->insert('files')->cols($fileData)->query();
        $paths[$path] = $id;
        echo "  Added file #{$id} {$path}\n";
    } else {
        $id = $paths[$path];
        $db->update('files')->cols($newData)->where('id='.$id)->query();
        echo "  Updated file #{$paths[$path]} {$path}\n".var_export($newData, true).PHP_EOL;
    }
    $files[$id] = $fileData;
}

function updateDir($path) {
    global $files, $skipGlobs;
    //echo "  Added directory {$path}\n";
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

$pathGlobs = ['/storage/vault*/roms'];
$skipGlobs = ['/storage/vault6/roms/toseciso/'];
global $files, $db, $paths, $skipGlobs;
$db = new Workerman\MySQL\Connection('127.0.0.1', '3306', 'consolo', 'consolo', 'consolo');
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
