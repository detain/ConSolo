<?php
/**
* 
*/
namespace Detain\ConSolo\Matching;

require_once __DIR__.'/../bootstrap.php';

use FuzzyWuzzy\Fuzz;
use FuzzyWuzzy\Process;

/**
* @var \Workerman\MySQL\Connection
*/
global $db;

$datFiles = $db->query("select id,type,name from dat_files where type != 'TOSEC-PIX' order by name");
$outputGames = false;
$outputSets = true;
foreach ($datFiles as $datFileIdx => $datFileData) {
    $games = $db->query("select id,name from dat_games where file={$datFileData['id']}");
    $goodSet = true;
    $partialSet = false;
    $goodCount = 0;
    $badCount = 0;
    foreach ($games as $gameIdx => $gameData) {
        $roms = $db->query("select * from dat_roms where game={$gameData['id']}");
        if ($outputGames == true)
            echo $datFileData['type'].'     '.$datFileData['name'].'    '.$gameData['name'];
        $good = true;
        $partial = false;
        foreach ($roms as $romIdx => $romData) {
            $files = $db->query("select path from files where size={$romData['size']} and md5='{$romData['md5']}'");
            if ($outputGames == true)
                echo '  '.$romData['name'].' ';
            if (count($files) == 0) {
                if ($outputGames == true)
                    echo 'MISSING!';
                $good = false;
                $goodSet = false;
                $badCount++;
            } else {
                $goodCount++;
                $partialSet = true;
                $partial = true;
                $paths = [];
                foreach ($files as $file) {
                    $paths[] = $file['path'];
                }
                if ($outputGames == true)
                    echo ' FOUND! '.count($paths).' copies in "'.implode('", "', $paths).'"';
            }
        }
        if ($outputGames == true)
            echo '      Game '.($good == true ? 'GOOD' : ($partial == true ? 'PARTIAL' : 'BAD')).PHP_EOL;
    }
    if ($outputSets == true)
        echo $datFileData['type'].' '.$datFileData['name'].'    ['.$goodCount.'/'.($goodCount+$badCount).'] '.($goodSet == true ? 'GOOD' : ($partialSet == true ? 'PARTIAL' : 'BAD')).' SET'.PHP_EOL;
}
