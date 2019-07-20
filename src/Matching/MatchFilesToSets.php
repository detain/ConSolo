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

$datFiles = $db->query("select id,type,name from dat_files order by name");
foreach ($datFiles as $datFileIdx => $datFileData) {
    $games = $db->query("select id,name from dat_games where file={$datFileData['id']}");
    foreach ($games as $gameIdx => $gameData) {
        $roms = $db->query("select * from dat_roms where game={$gameData['id']}");
        echo $datFileData['type'].'     '.$datFileData['name'].'    '.$gameData['name'];
        $good = true;
        foreach ($roms as $romIdx => $romData) {
            $files = $db->query("select path from files where size={$romData['size']} and md5='{$romData['md5']}'");
            echo '  '.$romData['name'].' ';
            if (count($files) == 0) {
                echo 'MISSING!';
                $good = false;
            } else {
                $paths = [];
                foreach ($files as $file) {
                    $paths[] = $file['path'];
                }
                echo ' FOUND! '.count($paths).' copies in "'.implode('", "', $paths).'"';
            }
        }
        echo '      Game '.($good == true ? 'GOOD' : 'BAD').PHP_EOL;
    }
}
