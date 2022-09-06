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
$used = [
    'platforms' => [],
    'emulators' => [],
    'companies' => [],
    'games' => []
];
$allNames = [
    'platforms' => [],
    'emulators' => [],
    'companies' => [],
    'games' => []
];
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
foreach ($source['platforms'] as $localPlatId => $localData) {
    $allNames['platforms'][$localPlatId] = [];
    $allNames['platforms'][$localPlatId][] = strtolower($localData['name']);
    foreach ($localData['matches'] as $sourceId => $sourceList) {
        foreach ($sourceList as $sourcePlatId) {
            if (isset($sources[$sourceId]['platforms'][$sourcePlatId])) {
                if (!isset($used['platforms'][$sourceId])) {
                    $used['platforms'][$sourceId] = [];
                }
                $used['platforms'][$sourceId][] = $sourcePlatId;
                foreach ($sources[$sourceId]['platforms'][$sourcePlatId]['names'] as $name) {
                    if (!in_array(strtolower($name), $allNames['platforms'][$localPlatId])) {
                        $allNames['platforms'][$localPlatId][] = strtolower($name);
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
foreach ($tables as $idx => $table) {
    $count = count($source[$idx]);
    if ($count > 0) {
        $tables[$idx][] = "| [local](local.json) | Local | {$count}| 0 | {$count} | 100% |";
    }
}
foreach ($sources as $sourceId => $sourceData) {
    foreach (['platforms', 'emulators', 'companies', 'games'] as $idx) {
        if (!isset($used[$idx][$sourceId])) {
            $used[$idx][$sourceId] = [];
        }
    }
    if (isset($sourceData['companies'])) {
        foreach ($sourceData['companies'] as $compId => $platData) {
            if (!in_array($compId, $used['companies'][$sourceId])) {
                foreach ($platData['names'] as $name) {
                    foreach ($allNames['companies'] as $localPlatId => $localNames) {
                        if (in_array(strtolower($name), $localNames)) {
                            $used['companies'][$sourceId][] = $compId;
                            if (!isset($source['companies'][$localPlatId]['matches'][$sourceId])) {
                                $source['companies'][$localPlatId]['matches'][$sourceId] = [];
                            }
                            $source['companies'][$localPlatId]['matches'][$sourceId][] = $compId;
                            echo "Found company by Name local:{$localPlatId} - {$sourceId}:{$compId}\n";
                            break 2;
                        }
                    }
                }
            }
            if (!in_array($compId, $used['companies'][$sourceId])) {
                if (!array_key_exists($sourceId, $unmatched['companies'])) {
                    $unmatched['companies'][$sourceId] = [];
                }
                $unmatched['companies'][$sourceId][$compId] = $platData['name'];
            }
        }
    }
    if (isset($sourceDaa['platforms'])) {
        foreach ($sourceData['platforms'] as $platId => $platData) {
            if (!in_array($platId, $used['platforms'][$sourceId])) {
                foreach ($platData['names'] as $name) {
                    foreach ($allNames['platforms'] as $localPlatId => $localNames) {
                        if (in_array(strtolower($name), $localNames)) {
                            $used['platforms'][$sourceId][] = $platId;
                            if (!isset($source['platforms'][$localPlatId]['matches'][$sourceId])) {
                                $source['platforms'][$localPlatId]['matches'][$sourceId] = [];
                            }
                            $source['platforms'][$localPlatId]['matches'][$sourceId][] = $platId;
                            echo "Found platform by Name local:{$localPlatId} - {$sourceId}:{$platId}\n";
                            break 2;
                        }
                    }
                }
            }
            if (!in_array($platId, $used['platforms'][$sourceId])) {
                if (!array_key_exists($sourceId, $unmatched['platforms'])) {
                    $unmatched['platforms'][$sourceId] = [];
                }
                $unmatched['platforms'][$sourceId][$platId] = $platData['name'];
            }
        }
    }
    if (isset($sourceDaa['emulators'])) {
        foreach ($sourceData['emulators'] as $platId => $platData) {
            if (!in_array($platId, $used['emulators'][$sourceId])) {
                foreach ($platData['names'] as $name) {
                    foreach ($allNames['emulators'] as $localPlatId => $localNames) {
                        if (in_array(strtolower($name), $localNames)) {
                            $used['emulators'][$sourceId][] = $platId;
                            if (!isset($source['emulators'][$localPlatId]['matches'][$sourceId])) {
                                $source['emulators'][$localPlatId]['matches'][$sourceId] = [];
                            }
                            $source['emulators'][$localPlatId]['matches'][$sourceId][] = $platId;
                            echo "Found platform by Name local:{$localPlatId} - {$sourceId}:{$platId}\n";
                            break 2;
                        }
                    }
                }
            }
            if (!in_array($platId, $used['emulators'][$sourceId])) {
                if (!array_key_exists($sourceId, $unmatched['emulators'])) {
                    $unmatched['emulators'][$sourceId] = [];
                }
                $unmatched['emulators'][$sourceId][$platId] = $platData['name'];
            }
        }
    }
    foreach (['platforms', 'emulators', 'companies', 'games'] as $idx) {
        $usedCount = count($used[$idx][$sourceId]);
        $unmatchedCount = isset($unmatched[$idx][$sourceId]) ? count($unmatched[$idx][$sourceId]) : 0;
        $totalCount = $usedCount + $unmatchedCount;
        $usedPct = $totalCount > 0 ? round($usedCount / $totalCount * 100, 1) : 0;
        if (!isset($sourceDefinitions[$sourceId])) {
            echo "Cant find {$sourceId} in sources list\n";
        }
        $tables[$idx][] = "| [{$sourceDefinitions[$sourceId]['name']}](sources/{$sourceId}.json) | {$sourceDefinitions[$sourceId]['type']} | {$usedCount} | {$unmatchedCount} | {$totalCount} | {$usedPct}% |";
    }
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

