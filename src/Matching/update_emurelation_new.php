<?php

require_once __DIR__.'/../bootstrap.php';
require_once __DIR__.'/emurelation.inc.php';

/**
* @var \Workerman\MySQL\Connection
*/
global $db, $mysqlLinkId;
$sourceDefinitions = json_decode(file_get_contents(__DIR__.'/../../../emurelation/sources.json'), true);
$sources = loadSources();
list($sourceId, $source) = loadSource(__DIR__.'/../../../emurelation/local.json');
$unmatched = [
    'platforms' => [],
    'emulators' => [],
    'companies' => [],
    'games' => []
];
$used = [];
$allNames = [];
foreach ($source['platforms'] as $localPlatId => $localData) {
    $allNames[$localPlatId] = [];
    $allNames[$localPlatId][] = strtolower($localData['name']);
    foreach ($localData['matches'] as $sourceId => $sourceList) {
        foreach ($sourceList as $sourcePlatId) {
            if (isset($sources[$sourceId]['platforms'][$sourcePlatId])) {
                if (!isset($used[$sourceId])) {
                    $used[$sourceId] = [];
                }
                $used[$sourceId][] = $sourcePlatId;
                foreach ($sources[$sourceId]['platforms'][$sourcePlatId]['names'] as $name) {
                    if (!in_array(strtolower($name), $allNames[$localPlatId])) {
                        $allNames[$localPlatId][] = strtolower($name);
                    }
                }
            } else {
                // remove nonexistant match
                echo "Local {$localPlatId} matched {$sourceId} - {$sourcePlatId} but does not exist\n";
                array_filter($source['platforms'][$localPlatId]['matches'][$sourceId], function($var) use ($sourcePlatId) {
                   return $var != $sourcePlatId;
                });
            }
        }
    }
}
$totals = [];
$table = [];
$table[] = "| Source | Type | Mapped | Unmapped | Total | Mapped % |";
$table[] = "|-|-|-|-|-|-|";
$tables = [
    'platforms' => $table,
    'emulators' => $table,
    'companies' => $table,
    'games' => $table,
];
foreach ($tables as $idx => $table) {
    $count = count($source[$idx]);
    if ($count > 0) {
        $tables[$idx][] = "| [local](local.json) | Local | - | - | {$count} | - |";
    }
}
foreach ($sources as $sourceId => $sourceData) {
    if (!isset($used[$sourceId])) {
        $used[$sourceId] = [];
    }
    foreach (['emulators', 'companies', 'games'] as $idx) {
        if (isset($sources[$sourceId][$idx])) {
            $count = count($sources[$sourceId][$idx]);
            if ($count > 0) {
                $tables[$idx][] = "| [{$sourceDefinitions[$sourceId]['name']}](sources/{$sourceId}.json) | {$sourceDefinitions[$sourceId]['type']} | 0 | {$count} | {$count} | 0% |";
            }
        }
    }
    foreach ($sourceData['platforms'] as $platId => $platData) {
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
    $tables['platforms'][] = "| [{$sourceDefinitions[$sourceId]['name']}](sources/{$sourceId}.json) | {$sourceDefinitions[$sourceId]['type']} | {$usedCount} | {$unmatchedCount} | {$totalCount} | {$usedPct}% |";
}
foreach ($unmatched['platforms'] as $key => $values) {
    ksort($values);
    $unmatched['platforms'][$key] = $values;
}
$readme = file_get_contents(__DIR__.'/../../../emurelation/README.md');
if (preg_match_all('/^### .{1,2} (?P<type>\S+)(\n\s*)+(?P<table>(^\|[^\n]+\|\n)+)\n/muU', $readme, $matches)) {
    foreach ($matches['type'] as $idx => $type) {
        $table = implode("\n", $tables[strtolower($type)]);
        $readme = str_replace("{$type}\n\n{$matches['table'][$idx]}\n", "{$type}\n\n{$table}\n\n", $readme);
    }
    file_put_contents(__DIR__.'/../../../emurelation/README.md', $readme);
}
file_put_contents(__DIR__.'/../../../emurelation/unmatched.json', json_encode($unmatched, getJsonOpts()));
file_put_contents(__DIR__.'/../../../emurelation/local.json', json_encode($source, getJsonOpts()));
file_put_contents(__DIR__.'/../../../emurelation/souces_all.json', json_encode($sources, getJsonOpts()));

