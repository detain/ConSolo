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
$outputGames = false;
$outputSets = true;
foreach (['software','machines'] as $type) {
    $lastPlatform = false;
    $currentPlatform = false;
    $single = substr($type, -1) == 's' ? substr($type, 0, -1) : $type;
    $title = 'MAME '.ucwords($type);
    //echo "Working on {$title}\n";
    if ($type == 'machines')
        $platforms = [['platform_description' => 'Arcade']];
    else
        $platforms = $db->query("select platform_description from mame_software group by platform_description");
    foreach ($platforms as $platformIdx => $mameData) {
        $goodCount = 0;
        $badCount = 0;
        $goodSet = true;
        $partialSet = false;
        $platformData = [
            'type' => $title,
            'name' => $mameData['platform_description'],
        ];
        $escapedPlatform = str_replace('\'','\\\'', $mameData['platform_description']);
        if ($type == 'machines')
            $games = $db->query("select id, description as name, manufacturer from mame_{$type} order by description");
        else
            $games = $db->query("select id, description as name from mame_{$type} where platform_description='{$escapedPlatform}' order by description");
        foreach ($games as $gameIdx => $gameData) {
            $roms = $db->query("select * from mame_{$single}_roms where {$single}_id={$gameData['id']}");
            if ($outputGames == true)
                echo $platformData['type'].'     '.$platformData['name'].'    '.$gameData['name'].'    '.count($roms).' roms for id '.$gameData['id'];
            $goodGame = true;
            $partialGame = false;
            foreach ($roms as $romIdx => $romData) {
                //echo "Looking for Size {$romData['size']} CRC {$romData['crc']}\n";           
                $files = $db->query("select path from files where size={$romData['size']} and (crc32='{$romData['crc']}' or sha1='{$romData['sha1']}')");
                if ($outputGames == true)
                    echo '  '.$romData['name'].' ';
                if (count($files) == 0) {
                    if ($outputGames == true)
                        echo 'MISSING!';
                    $goodGame = false;
                    $goodSet = false;
                    //echo 'Incrementing Bad Counter (was '.$badCount.')'.PHP_EOL;
                    $badCount = $badCount + 1;
                } else {
                    //echo 'Incrementing Good Counter (was '.$goodCount.')'.PHP_EOL;
                    $goodCount = $goodCount + 1;
                    $partialSet = true;
                    $partialGame = true;
                    $paths = [];
                    foreach ($files as $file) {
                        $paths[] = $file['path'];
                    }
                    if ($outputGames == true)
                        echo ' FOUND! '.count($paths).' copies in "'.implode('", "', $paths).'"';
                }
            }
            if ($outputGames == true)
                echo '      Game '.($goodGame == true ? 'GOOD' : ($partialGame == true ? 'PARTIAL' : 'BAD')).PHP_EOL;
        }
        if ($outputSets == true)
            echo $platformData['type'].' '.$platformData['name'].'    ['.$goodCount.'/'.($goodCount+$badCount).'] '.($goodSet == true ? 'GOOD' : ($partialSet == true ? 'PARTIAL' : 'BAD')).' SET'.PHP_EOL;
    }
}

$platforms = $db->query("select id,type,name from dat_files where type != 'TOSEC-PIX' order by name");
foreach ($platforms as $idx => $platformData) {
    $games = $db->query("select id,name from dat_games where file={$platformData['id']}");
    $goodSet = true;
    $partialSet = false;
    $goodCount = 0;
    $badCount = 0;
    foreach ($games as $gameIdx => $gameData) {
        $roms = $db->query("select * from dat_roms where game={$gameData['id']}");
        if ($outputGames == true)
            echo $platformData['type'].'     '.$platformData['name'].'    '.$gameData['name'];
        $goodGame = true;
        $partialGame = false;
        foreach ($roms as $romIdx => $romData) {
            $files = $db->query("select path from files where size={$romData['size']} and md5='{$romData['md5']}'");
            if ($outputGames == true)
                echo '  '.$romData['name'].' ';
            if (count($files) == 0) {
                if ($outputGames == true)
                    echo 'MISSING!';
                $goodGame = false;
                $goodSet = false;
                $badCount++;
            } else {
                $goodCount++;
                $partialSet = true;
                $partialGame = true;
                $paths = [];
                foreach ($files as $file) {
                    $paths[] = $file['path'];
                }
                if ($outputGames == true)
                    echo ' FOUND! '.count($paths).' copies in "'.implode('", "', $paths).'"';
            }
        }
        if ($outputGames == true)
            echo '      Game '.($goodGame == true ? 'GOOD' : ($partialGame == true ? 'PARTIAL' : 'BAD')).PHP_EOL;
    }
    if ($outputSets == true)
        echo $platformData['type'].' '.$platformData['name'].'    ['.$goodCount.'/'.($goodCount+$badCount).'] '.($goodSet == true ? 'GOOD' : ($partialSet == true ? 'PARTIAL' : 'BAD')).' SET'.PHP_EOL;
}

