<?php
require_once __DIR__.'/../src/bootstrap.php';
require_once __DIR__.'/../src/Matching/MatchFilesToSets.php';

/**
* @var \Twig\Environment
*/
global $twig;
$matches = \Detain\ConSolo\Matching\MatchFilesToSets();
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
    }    
}

echo $twig->render('match.twig', array(
    'stats' => $stats,
    'typeStats' => $typeStats,
//    'client_id' => $_GET['client_id'],
//    'response_type' => $_GET['response_type'],
    'queryString' => $_SERVER['QUERY_STRING']
));
