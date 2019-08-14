<?php
/**
* 
*/
namespace Detain\ConSolo\Matching;

function MatchFilesToSets($verbose = false) {
    /**
    * @var \Workerman\MySQL\Connection
    */
    global $db;
    $matches = [];
    foreach (['software','machines'] as $mameType) {
        $single = substr($mameType, -1) == 's' ? substr($mameType, 0, -1) : $mameType;
        if ($verbose == true)
            echo 'Loading MAME '.ucwords($single).' Hashes...';
        $query = "select 'MAME' as type, ".($mameType == 'machines' ? "'Arcade'" : "platform_description")." as name, mame_{$mameType}.id as game, files.id from mame_{$mameType} left join mame_{$single}_roms on mame_{$mameType}.id={$single}_id left join files on mame_{$single}_roms.size=files.size and mame_{$single}_roms.sha1=files.sha1";
        $roms = $db->query($query);
        if ($verbose == true) {
            echo 'done!'.PHP_EOL;
            echo 'Organizing MAME '.ucwords($single).' Matches...';
        }
        foreach ($roms as $rom) {
            if (!array_key_exists($rom['type'], $matches))
                $matches[$rom['type']] = [];
            if (!array_key_exists($rom['name'], $matches[$rom['type']]))
                $matches[$rom['type']][$rom['name']] = [];
            if (!array_key_exists($rom['game'], $matches[$rom['type']][$rom['name']]))
                $matches[$rom['type']][$rom['name']][$rom['game']] = [0, 0];
            $matches[$rom['type']][$rom['name']][$rom['game']][is_null($rom['id']) ? 1 : 0]++;
        }
        if ($verbose == true)
            echo 'done!'.PHP_EOL;
    }
    if ($verbose == true)
        echo 'Loading DAT File Hashes...';
    $roms = $db->query("select type, dat_files.name, game, files.id from dat_files left join dat_games on dat_files.id=file left join dat_roms on dat_games.id=game left join files on dat_roms.size=files.size and dat_roms.sha1=files.sha1");
    if ($verbose == true) {
        echo 'done!'.PHP_EOL;
        echo 'Organizing DAT File Matches...';
    }
    foreach ($roms as $rom) {
        if (!array_key_exists($rom['type'], $matches))
            $matches[$rom['type']] = [];
        if (!array_key_exists($rom['name'], $matches[$rom['type']]))
            $matches[$rom['type']][$rom['name']] = [];
        if (!array_key_exists($rom['game'], $matches[$rom['type']][$rom['name']]))
            $matches[$rom['type']][$rom['name']][$rom['game']] = [0, 0];
        $matches[$rom['type']][$rom['name']][$rom['game']][is_null($rom['id']) ? 1 : 0]++;
    }
    if ($verbose == true)
        echo 'done!'.PHP_EOL;
    return $matches;
}
