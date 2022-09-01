<?php

require_once __DIR__.'/../bootstrap.php';
require_once __DIR__.'/emurelation.inc.php';

/**
* @var \Workerman\MySQL\Connection
*/
global $db, $mysqlLinkId;
$sources = loadSources();
list($sourceId, $source) = loadSource(__DIR__.'/../../../emurelation/local.json');
$used = [];
$allNames = [];
foreach ($source['platforms'] as $localPlatId => $localData) {
    $allNames[$localPlatId] = [];
    $allNames[$localPlatId][] = strtolower($localData['name']);
    foreach ($localData['matches'] as $sourceId => $sourceList) {
        foreach ($sourceList as $sourcePlatId) {
            if (!isset($used[$sourceId])) {
                $used[$sourceId] = [];
            }
            $used[$sourceId][] = $sourcePlatId;
            foreach ($sources[$sourceId][$sourcePlatId]['names'] as $name) {
                if (!in_array(strtolower($name), $allNames[$localPlatId])) {
                    $allNames[$localPlatId][] = strtolower($name);
                }
            }
        }
    }
}
$unmatched = [
    'platforms' => [],
    'emulators' => [],
    'companies' => [],
    'games' => []
];
$totals = [];
$table = [];
$table[] = "| Source | Type | Mapped | Unmapped | Total | Mapped % |";
$table[] = "|-|-|-|-|-|-|";
ksort($sources);
$sourceDefinitions = json_decode(file_get_contents(__DIR__.'/../../../emurelation/sources.json'), true);

foreach ($sources as $sourceId => $sourceData) {
    if (!isset($used[$sourceId])) {
        $used[$sourceId] = [];
    }
    foreach ($sourceData as $platId => $platData) {
        if (!in_array($platId, $used[$sourceId])) {
            foreach ($platData['names'] as $name) {
                foreach ($allNames as $localPlatId => $localNames) {
                    if (in_array(strtolower($name), $localNames)) {
                        $used[$sourceId][] = $platId;
                        if (!isset($source['platforms'][$localPlatId]['matches'][$sourceId])) {
                            $source['platforms'][$localPlatId]['matches'][$sourceId] = [];
                        }
                        $source['platforms'][$localPlatId]['matches'][$sourceId][] = $platId;
                        echo "Found by Name local:{$localPlatId} - {$sourceId}:{$platId}\n";
                        break 2;
                    }
                }
            }
        }
        if (!in_array($platId, $used[$sourceId])) {
            if (!array_key_exists($sourceId, $unmatched['platforms'])) {
                $unmatched['platforms'][$sourceId] = [];
            }
            $unmatched['platforms'][$sourceId][$platId] = $platData['name'];
        }
    }
    $usedCount = count($used[$sourceId]);
    $unmatchedCount = isset($unmatched['platforms'][$sourceId]) ? count($unmatched['platforms'][$sourceId]) : 0;
    $totalCount = $usedCount + $unmatchedCount;
    $usedPct = round($usedCount / $totalCount * 100, 1);
    if (!isset($sourceDefinitions[$sourceId])) {
        echo "Cant find {$sourceId} in sources list\n";
    }
    $table[] = "| [{$sourceDefinitions[$sourceId]['name']}](sources/{$sourceId}.json) | {$sourceDefinitions[$sourceId]['type']} | {$usedCount} | {$unmatchedCount} | {$totalCount} | {$usedPct}% |";
}
foreach ($unmatched['platforms'] as $key => $values) {
    ksort($values);
    $unmatched['platforms'][$key] = $values;
}
$readme = file_get_contents(__DIR__.'/../../../emurelation/README.md');
preg_match_all('/^### 🎮 Platforms\n\n(?P<table>(^\|[^\n]+\|\n)+)\n/msuU', $readme, $matches);
$readme = str_replace($matches['table'][0], implode("\n", $table)."\n", $readme);
file_put_contents(__DIR__.'/../../../emurelation/README.md', $readme);
file_put_contents(__DIR__.'/../../../emurelation/unmatched.json', json_encode($unmatched, getJsonOpts()));
file_put_contents(__DIR__.'/../../../emurelation/local.json', json_encode($source, getJsonOpts()));

