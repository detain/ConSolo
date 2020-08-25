<?php
/**
* Scans through an array of path globs finding all files and scanning them performing
* checksumming, and storing of basic information.  This process can take a long time on
* a larger set of files.  It also scans inside compressed files. 
*/

require_once __DIR__.'/../../bootstrap.php';



/**
* @var \Workerman\MySQL\Connection
*/
global $db;
global $files, $db, $paths, $skipGlobs, $compressionTypes, $tmpDir, $scanCompressed, $hashAlgos, $compressedHashAlgos, $maxSize, $useMaxSize, $useMagic;

$result = $db->row("select * from files left join files_extra using (id) where id={$_SERVER['argv'][1]}");
$result['extra'] = json_decode($result['extra'], true);
print_r($result);
