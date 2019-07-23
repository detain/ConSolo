<?php
/**
* Scans through an array of path globs finding all files and scanning them performing
* checksumming, and storing of basic information.  This process can take a long time on
* a larger set of files.  It also scans inside compressed files. 
*/
include __DIR__.'/../../../vendor/autoload.php';

function updateCompressedFile($path, $parentId)  {
    /**
    * @var \Workerman\MySQL\Connection
    */
    global $db;
    global $files, $tmpDir, $compressedHashAlgos;
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
    $fileData['path'] = $virtualPath;
    $fileData['parent'] = $parentId;
    $id = $db->insert('files')->cols($fileData)->query();
    echo "  Added file #{$id} {$virtualPath} from Compressed parent {$parentData['path']}\n";
}

function updateCompressedDir($path, $parentId) {
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
    passthru('7z x -o'.$tmpDir.' '.escapeshellarg($path), $return);
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
    global $files, $paths, $hashAlgos;
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
        compressedFileHandler($path);
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
    compressedFileHandler($path);
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


$pathGlobs = ['/storage/*/roms/*'];
$skipGlobs = ['/storage/vault12/roms/GOG/'];
$tmpDir = '/tmp/scanfiles';
$compressionTypes = ['7z', 'rar', 'zip'];
$hashAlgos = ['md5', 'sha1', 'crc32']; // use hash_algos() to get all possible hashes
$compressedHashAlgos = ['md5', 'sha1', 'crc32']; // use hash_algos() to get all possible hashes
$scanCompressed = true;
global $files, $db, $paths, $skipGlobs, $compressionTypes, $tmpDir, $scanCompressed, $hashAlgos, $compressedHashAlgos;
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
