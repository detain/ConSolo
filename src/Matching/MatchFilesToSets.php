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
$matches = [];
foreach (['software','machines'] as $mameType) {
    $single = substr($mameType, -1) == 's' ? substr($mameType, 0, -1) : $mameType;
    echo 'Loading MAME '.ucwords($single).' Hashes...';
    $query = "select 'MAME' as type, ".($mameType == 'machines' ? "'Arcade'" : "platform_description")." as name, mame_{$mameType}.id as game, files.id from mame_{$mameType} left join mame_{$single}_roms on mame_{$mameType}.id={$single}_id left join files on mame_{$single}_roms.size=files.size and mame_{$single}_roms.sha1=files.sha1";
    $roms = $db->query($query);
    echo 'done!'.PHP_EOL;
    echo 'Organizing MAME '.ucwords($single).' Matches...';
    foreach ($roms as $rom) {
        if (!array_key_exists($rom['type'], $matches))
            $matches[$rom['type']] = [];
        if (!array_key_exists($rom['name'], $matches[$rom['type']]))
            $matches[$rom['type']][$rom['name']] = [];
        if (!array_key_exists($rom['game'], $matches[$rom['type']][$rom['name']]))
            $matches[$rom['type']][$rom['name']][$rom['game']] = [0, 0];
        $matches[$rom['type']][$rom['name']][$rom['game']][is_null($rom['id']) ? 1 : 0]++;
    }
    echo 'done!'.PHP_EOL;
}
echo 'Loading DAT File Hashes...';
$roms = $db->query("select type, dat_files.name, game, files.id from dat_files left join dat_games on dat_files.id=file left join dat_roms on dat_games.id=game left join files on dat_roms.size=files.size and dat_roms.sha1=files.sha1");
echo 'done!'.PHP_EOL;
echo 'Organizing DAT File Matches...';
foreach ($roms as $rom) {
    if (!array_key_exists($rom['type'], $matches))
        $matches[$rom['type']] = [];
    if (!array_key_exists($rom['name'], $matches[$rom['type']]))
        $matches[$rom['type']][$rom['name']] = [];
    if (!array_key_exists($rom['game'], $matches[$rom['type']][$rom['name']]))
        $matches[$rom['type']][$rom['name']][$rom['game']] = [0, 0];
    $matches[$rom['type']][$rom['name']][$rom['game']][is_null($rom['id']) ? 1 : 0]++;
}
echo 'done!'.PHP_EOL;
$stats = [];
$typeStats = [];
foreach ($matches as $type => $typeData) {
    $stats[$type] = [];
    $typeStats[$type] = ['games' => count($platformData), 'good' => 0, 'bad' => 0, 'partial' => 0];
    foreach ($typeData as $platform => $platformData) {
        $stats[$type][$platform] = ['games' => count($platformData), 'good' => 0, 'bad' => 0, 'partial' => 0];
        foreach ($platformData as $gameId => $gameData) {
            if ($gameData[1] == 0)
                $stats[$type][$platform]['good']++;
            elseif ($gameData[0] == 0)
                $stats[$type][$platform]['bad']++;
            else
                $stats[$type][$platform]['partial']++;
        }
        if ($stats[$type][$platform]['bad'] == 0)
            $typeStats[$type]['good']++;
        elseif ($stats[$type][$platform]['good'] == 0)
            $typeStats[$type]['bad']++;
        else
            $typeStats[$type]['partial']++;
        echo '['.$type.']['.$platform.'] '.$stats[$type][$platform]['games'].' Games ('.$stats[$type][$platform]['good'].' Good '.$stats[$type][$platform]['bad'].' Bad '.$stats[$type][$platform]['partial'].' Partial )'.PHP_EOL;
    }    
}
foreach ($typeStats as $type => $typeData) {
    echo '['.$type.'] '.$typeData['games'].' Games ('.$typeData['good'].' Good '.$typeData['bad'].' Bad '.$typeData['partial'].' Partial )'.PHP_EOL; 
}