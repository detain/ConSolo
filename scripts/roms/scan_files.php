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

function backupRun() {
    global $files, $filesJsonName;
    file_put_contents($filesJsonName, json_encode($files, JSON_PRETTY_PRINT));
    $stats = stat($filesJsonName);
    echo "Wrote {$stats['size']} bytes to file ".(basename($filesJsonName))." in ".dirname($filesJsonName)."\n";    
}

function backupCheck($fileData) {
    global $backupSeconds, $nextBackup;
    $time = time();
    if ($nextBackup <= $time) {
        // backup here
        backupRun();
        $time = time() - $time;
        echo "Data Backup Wrote files.json in {$time} seconds, next backup in {$backupSeconds}\n";
        $nextBackup = time() + $backupSeconds;
    }
}        

function updateFile($path)  {
    global $files, $paths;
    //$hashAlgos = ['md5', 'sha1', 'crc32']; // use hash_algos() to get all possible hashes
    $hashAlgos = ['md5', 'crc32']; // use hash_algos() to get all possible hashes
    $statFields = ['size', 'mtime']; // fields are dev,ino,mode,nlink,uid,gid,rdev,size,atime,mtime,ctime,blksize,blocks 
    $pathStat = stat($path);
    if (!isset($files[$path])) {
        $fileData = [];
    } else {
        $fileData = $files[$path];
    }
    foreach ($statFields as $statField) {
        $fileData[$statField] = $pathStat[$statField];
    }
    $return = false;
    if (array_key_exists($path, $files) && $files[$path]['mtime'] == $fileData['mtime'] && $files[$path]['size'] == $fileData['size']) {
        $return = true;
    }
    foreach ($hashAlgos as $hashAlgo) {
        if (!isset($fileData[$hashAlgo])) {
            $return = false;
            $fileData[$hashAlgo] = hash_file($hashAlgo, $path);
        }
    }
    if ($return === true) {
        //echo "  Skipping {$path}, Its Already Hashed and Still The Same Size and Modification Time\n";
        //echo " Skipping {$path}\n";
        echo '-';
        return;
    }
    if (!isset($files[$path])) {
        echo "  Added {$fileData['size']} byte file {$path}\n";
    } else {
        echo "  Updated {$fileData['size']} byte file {$path}\n";
    }
    $files[$path] = $fileData;
    backupCheck($fileData);
}

function updateDir($path) {
    global $files;
    //echo "  Added directory {$path}\n";
    foreach (glob($path.'/*') as $subPath) {
        if (is_dir($subPath)) {
            updateDir($subPath);
        } else {
            updateFile($subPath);
        }
    }    
}

$pathGlobs = ['/storage/vault*/roms'];
$backupSeconds = 300;
global $files, $db, $paths;
$db = new Workerman\MySQL\Connection('127.0.0.1', '3306', 'consolo', 'consolo', 'consolo');
$nextBackup = time() + $backupSeconds;
foreach ($pathGlobs as $pathGlob) {
    foreach (glob($pathGlob) as $path) {
        echo "Main ROM - {$path}\n";
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
backupRun();
