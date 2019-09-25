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

/**
* @var \Workerman\MySQL\Connection
*/
global $db;
global $files, $db, $paths, $skipGlobs, $compressionTypes, $tmpDir, $scanCompressed, $hashAlgos, $compressedHashAlgos, $maxSize, $useMaxSize;
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
echo "Calculating Empty Ids ";
$emptyIds = [];
for ($x = 1, $emptyCount = 0; $x < $maxId && $x < $totalFiles && $emptyCount < $maxAdjustments; $x++) {
    if (!in_array($x, $allFileIds)) {
        $emptyIds[] = $x;
        $emptyCount++;
    }
    if ($x % 10000 == 0)
        echo ' X '.$x.' Count '.count($emptyIds).PHP_EOL;
    elseif ($x % 100 == 0)
        echo '.';
}
echo PHP_EOL;
echo count($emptyIds) .' total'.PHP_EOL;
echo "Getting Root Ids  ";
$rootIds = getFileIds(null);
echo count($rootIds) .' total'.PHP_EOL;
echo "Getting Children by Parent    ";
$parents = getParents();
echo count($parents) .' total'.PHP_EOL;
echo "Iterating Root Ids\n";
foreach ($rootIds as $rootId) {
    if (count($emptyIds) == 0)
        break;
    $nextEmptyId = $emptyIds[0];
    if ($rootId > $nextEmptyId) {
        $query = "update files set id={$nextEmptyId} where id={$rootId}";
        //echo $query.PHP_EOL;
        $db->query($query);
        array_shift($emptyIds);
        if (count($emptyIds) == 0)
            break;
        $nextEmptyId = $emptyIds[0];
    }
    if (array_key_exists($rootId, $parents)) {
        foreach ($parents[$rootId] as $child) {
            if ($child < $nextEmptyId) {
                $quert = "update files set id={$nextEmptyId} where id={$child}";
                //echo $query.PHP_EOL;
                $db->query($query);
                array_shift($emptyIds);
                if (count($emptyIds) == 0)
                    break;
                $nextEmptyId = $emptyIds[0];
            }
        }
    }
}
