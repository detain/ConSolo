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
$pathGlobs = ['/storage/vault*/roms'];
$backupSeconds = 60;
$filesJsonName = '/storage/data/files.json';

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
    global $files;
    $hashAlgos = ['md5', 'sha1', 'crc32']; // use hash_algos() to get all possible hashes
    $statFields = ['size', 'mtime']; // fields are dev,ino,mode,nlink,uid,gid,rdev,size,atime,mtime,ctime,blksize,blocks 
    $pathStat = stat($path);
    $fileData = [];
    foreach ($statFields as $statField) {
        $fileData[$statField] = $pathStat[$statField];
    }
    if (array_key_exists($path, $files) && $files[$path]['mtime'] == $fileData['mtime'] && $files[$path]['size'] == $fileData['size']) {
        //echo "  Skipping {$path}, Its Already Hashed and Still The Same Size and Modification Time\n";
        return;
    }
    foreach ($hashAlgos as $hashAlgo) {
        $fileData[$hashAlgo] = hash_file($hashAlgo, $path);
    }
    echo "  Added {$fileData['size']} byte file {$path}\n";
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

global $files;
$files = json_decode(file_get_contents($filesJsonName), true);
$nextBackup = time() + $backupSeconds;
foreach ($pathGlobs as $pathGlob) {
    foreach (glob($pathGlob) as $path) {
        echo "Main ROM - {$path}\n";
	    if (is_dir($path)) {
            updateDir($path);
	    } else {
            updateFile($path);
	    }
    }
}
backupRun();
