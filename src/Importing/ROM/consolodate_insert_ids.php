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
    global $files, $paths;
    $files = [];
    $paths = [];
    if (is_null($path)) {
        $tempFiles = $db->query("select * from files where parent is null order by id desc");
    } else {
        $tempFiles = $db->query("select * from files where path like '{$path}%' and parent is null order by id desc");
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

function getParents() {
    /**
    * @var \Workerman\MySQL\Connection
    */
    global $db;
    $data = $db->query("select parent, id from files where parent is not null order by parent, path");
    $parents = [];
    foreach ($data as $row) {
        if (!array_key_exists($row['parent'], $parents)) {
            $parents[$row['parent']] = [];
        }
        $parents[$row['parent']][] = $row['id'];
    }
    return $parents;
}

function getFileIds($parent = null) {
    /**
    * @var \Workerman\MySQL\Connection
    */
    global $db;
    if ($parent === false) {
        $files = $db->column("select id from files order by id");
    } elseif ($parent === null) {
        $files = $db->column("select id from files where parent is null order by path");
    } else {
        $files = $db->column("select id from files where parent='{$parent}' order by path");
    }
    return $files;
}

function hasMoreEmpty() {
    global $curId, $maxId, $totalFiles, $allFileIds, $maxAdjustments;
    for (; $maxAdjustments > 0 && $curId < $maxId && $curId < $totalFiles; $curId++) {
        if (!in_array($curId, $allFileIds)) {
            return true;
        }
    }
    return FALSE;
}

function getNextEmpty() {
    global $curId, $maxId, $totalFiles, $allFileIds;
    for (; $curId < $maxId && $curId < $totalFiles; $curId++) {
        if (!in_array($curId, $allFileIds)) {
            return $curId++;
        }
    }
}

/**
* @var \Workerman\MySQL\Connection
*/
global $db;
global $files, $db, $paths, $skipGlobs, $compressionTypes, $tmpDir, $scanCompressed, $hashAlgos, $compressedHashAlgos, $maxSize, $useMaxSize, $curId, $allFileIds, $totalFiles, $maxAdjustments, $maxId;
$curId = 1;
$deleting = [];
$deleted = 0;
$maxDeleting = 100;
$maxAdjustments = 50000;
echo "Getting Total Files   ";
$totalFiles = $db->single("select count(*) as count from files");
echo $totalFiles.PHP_EOL;
echo "Getting Max Id    ";
$maxId = $db->single("select max(id) from files");
echo $maxId.PHP_EOL;
echo "Getting Min Id    ";
$minId = $db->single("select min(id) from files");
echo $minId.PHP_EOL;
echo "Getting All Ids   ";
$allFileIds = getFileIds(false);
echo count($allFileIds) .' total'.PHP_EOL;
echo "Getting Root Ids  ";
$rootIds = getFileIds(null);
echo count($rootIds) .' total'.PHP_EOL;
echo "Getting Children by Parent    ";
$parents = getParents();
echo count($parents) .' total'.PHP_EOL;
if (hasMoreEmpty()) {
    echo "Iterating Root Ids\n";
    $nextEmptyId = getNextEmpty();
    //echo "N{$nextEmptyId} ";
    foreach ($rootIds as $rootId) {
        //echo "R{$rootId} ";
        if ($rootId > $nextEmptyId) {
            echo '+';
            $query = "update files set id={$nextEmptyId} where id={$rootId}";
            //echo $query.PHP_EOL;
            $db->query($query);
            $maxAdjustments--;
            array_splice($allFileIds, array_search($rootId, $allFileIds), 1);
            if (!hasMoreEmpty())
                break;
            $nextEmptyId = getNextEmpty();
            //echo "N{$nextEmptyId} ";
            if ($maxAdjustments % 100 == 0) {
                echo "N{$nextEmptyId} R{$rootId} M{$maxAdjustments}\n";
            }
        } else {
            echo '-';
        }
        if (array_key_exists($rootId, $parents)) {
            foreach ($parents[$rootId] as $child) {
                //echo "C{$child} ";
                if ($child < $nextEmptyId) {
                    echo 'o';
                    $quert = "update files set id={$nextEmptyId} where id={$child}";
                    //echo $query.PHP_EOL;
                    $db->query($query);
                    array_splice($allFileIds, array_search($child, $allFileIds), 1);
                    $maxAdjustments--;
                    if (!hasMoreEmpty())
                        break;
                    $nextEmptyId = getNextEmpty();
                    //echo "N{$nextEmptyId} ";
                    if ($maxAdjustments % 100 == 0) {
                        echo "N{$nextEmptyId} R{$rootId} C{$child} M{$maxAdjustments}\n";
                    }
                } else {
                    echo '.';
                }
            }
        }
    }
}