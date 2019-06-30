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
$pathGlobs = ['/storage/vault*/roms/Acorn'];
$backupSeconds = 60;

function backupRun() {
    global $files;
    $filesJsonName = '/storage/data/files.json';
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

$files = [];
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
