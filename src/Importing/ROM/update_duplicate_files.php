<?php
/**
* Scans through an array of path globs finding all files and scanning them performing
* checksumming, and storing of basic information.  This process can take a long time on
* a larger set of files.  It also scans inside compressed files. 
*/

require_once __DIR__.'/../../bootstrap.php';


$pathGlobs = ['/storage/*/roms'];

function loadFiles($path = null) {
    /**
    * @var \Workerman\MySQL\Connection
    */
    global $db;
    global $files, $paths, $duplicates;
    $files = [];
    $paths = [];
    $duplicates = [];
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
        if (isset($paths[$data['path']])) {
            if (!isset($duplicates[$paths[$data['path']]])) {
                $duplicates[$paths[$data['path']]] = [];
            }
            $duplicates[$paths[$data['path']]][] = $id; 
        } else {
            $paths[$data['path']] = $id;
        }
        $files[$id] = $data;
        unset($tempFiles[$idx]);        
    }
    echo '[Line '.__LINE__.'] Current Memory Usage: '.memory_get_usage().PHP_EOL;
}


/**
* @var \Workerman\MySQL\Connection
*/
global $db;
global $files, $db, $paths, $skipGlobs, $compressionTypes, $tmpDir, $scanCompressed, $hashAlgos, $compressedHashAlgos, $maxSize, $useMaxSize, $duplicates;
$deleting = [];
$deleted = 0;
$maxDeleting = 100;
foreach ($pathGlobs as $pathGlob) {
    foreach (glob($pathGlob) as $path) {
        echo "ROM Path - {$path}\n";
        echo '[Line '.__LINE__.'] Current Memory Usage: '.memory_get_usage().PHP_EOL;
        loadFiles($path);
        $duplicateCount = count($duplicates);
        echo "Loaded ".count($files)." Files with ".$duplicateCount." duplicates\n";
        echo '[Line '.__LINE__.'] Current Memory Usage: '.memory_get_usage().PHP_EOL;
        foreach ($duplicates as $firstId => $ids) {
            array_unshift($ids, $firstId);
            $counts = [];
            $bestId = false;
            foreach ($ids as $id) {
                $fileData = $files[$id];
                $goodValues = 0;
                foreach ($fileData as $key => $value) {
                    if (!is_null($value)) {
                        $goodValues++;
                    }
                }
                $counts[$id] = $goodValues;
                if ($bestId === false || $goodValues > $counts[$bestId]) {
                    $bestId = $id;
                }
            }
            $badIds = [];
            foreach ($ids as $id) {
                if ($id != $bestId) {
                    $deleted++;
                    $badIds[] = $id;
                }
            }
            echo 'Deleting Duplicate '.$fileData['path'].' IDs '.implode(', ', $badIds).PHP_EOL;
            $db->delete('files')->where('id in ('.implode(',',$badIds).')')->query();
        }
    }
}
echo "Removed {$deleted} Duplicate File Entries\n";