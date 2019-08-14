<?php
/**
* 
*/
namespace Detain\ConSolo\Matching;

require_once __DIR__.'/../bootstrap.php';
require_once __DIR__.'/MatchFilesToSets.php';

$matches = MatchFilesToSets(true);
$stats = [];
$typeStats = [];
foreach ($matches as $type => $typeData) {
    $stats[$type] = [];
    $typeStats[$type] = ['games' => 0, 'good' => 0, 'bad' => 0, 'partial' => 0];
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
        $typeStats[$type]['games'] += $stats[$type][$platform]['games']; 
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