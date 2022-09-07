<?php

require_once __DIR__.'/../bootstrap.php';
require_once __DIR__.'/emurelation.inc.php';

/**
* @var \Workerman\MySQL\Connection
*/
global $db, $mysqlLinkId;
$sourceDefinitions = json_decode(file_get_contents(__DIR__.'/../../../emurelation/sources.json'), true);
$sources = loadSources();
//$sourceId = 'local';
//$source = $sources[$sourceId];
list($sourceId, $source) = loadSource(__DIR__.'/../../../emurelation/sources/local.json', true);
$table = [
    "| Source | Type | Mapped | Unmapped | Total | Mapped % |",
    "|-|-|-|-|-|-|"
];
$types = ['platforms', 'emulators', 'companies', 'games'];
$unmatched = [];
$used = [];
$allNames = [];
$totals = [];
$tables = [];
foreach ($types as $type) {
    $tables[$type] = $table;
    $unmatched[$type] = [];
    $used[$type] = [];
    $allNames[$type] = [];
    foreach ($sources as $sourceId => $sourceData) {
        $unused[$type][$sourceId] = [];
        $used[$type][$sourceId] = [];
        $allNames[$type][$sourceId] = [];
    }
}
foreach ($types as $type) {
    foreach ($source[$type] as $localTypeId => $localData) {
        if (!array_key_exists($localTypeId, $allNames[$type])) {
            $allNames[$type][$localTypeId] = [];
        }
        if (!in_array(strtolower($localData['name']), $allNames[$type][$localTypeId])) {
            $allNames[$type][$localTypeId][] = strtolower($localData['name']);
        }
        foreach ($localData['matches'] as $matchSourceId => $matchTargets) {
            foreach ($matchTargets as $matchTargetId) {
                if (isset($sources[$matchSourceId][$type][$matchTargetId])) { // it finds the match in the targeted source
                    if (!isset($used[$type][$matchSourceId])) {
                        $used[$type][$matchSourceId] = [];
                    }
                    $used[$type][$matchSourceId][] = $matchTargetId;
                    foreach ($sources[$matchSourceId][$type][$matchTargetId]['names'] as $name) {
                        if (!in_array(strtolower($name), $allNames[$type][$localTypeId])) {
                            $allNames[$type][$localTypeId][] = strtolower($name);
                        }
                    }
                } else { // remove nonexistant matches
                    echo "Local {$localTypeId} matched {$matchSourceId} - {$matchTargetId} but does not exist; removing!\n";
                    array_filter($source[$type][$localTypeId]['matches'][$matchSourceId], function($var) use ($matchTargetId) {
                       return $var != $matchTargetId;
                    });
                }
            }
        }
    }
    $count = count($source[$type]);
    if ($count > 0) {
        $tables[$type][] = "| [local](sources/local.json) | Local | {$count} | 0 | {$count} | 100% |";
    }
}
foreach ($types as $type) {
    foreach ($sources as $sourceId => $sourceData) {
        if ($sourceId == 'local') {
            //continue;
        }
        if (!isset($used[$type][$sourceId])) {
            $used[$type][$sourceId] = [];
        }
        if (isset($sourceData[$type])) {
            foreach ($sourceData[$type] as $targetId => $targetData) {
                if (!in_array($targetId, $used[$type][$sourceId])) {
                    if (isset($targetData['names'])) {
                        foreach ($targetData['names'] as $name) {
                            foreach ($allNames[$type] as $localTypeId => $localNames) {
                                if (in_array(strtolower($name), $localNames)) {
                                    $used[$type][$sourceId][] = $targetId;
                                    if ($sourceId != 'local') {
                                        if (!isset($source[$type][$localTypeId]['matches'][$sourceId])) {
                                            $source[$type][$localTypeId]['matches'][$sourceId] = [];
                                        }
                                        $source[$type][$localTypeId]['matches'][$sourceId][] = $targetId;
                                    }
                                    echo "Found by Name local:{$localTypeId} - {$sourceId}:{$targetId}\n";
                                    break 2;
                                }
                            }
                        }
                    }
                }
                if (!in_array($targetId, $used[$type][$sourceId])) {
                    if (!array_key_exists($sourceId, $unmatched[$type])) {
                        $unmatched[$type][$sourceId] = [];
                    }
                    $unmatched[$type][$sourceId][$targetId] = $targetData['name'];
                }
            }
            $usedCount = count($used[$type][$sourceId]);
            $unmatchedCount = isset($unmatched[$type][$sourceId]) ? count($unmatched[$type][$sourceId]) : 0;
            $totalCount = $usedCount + $unmatchedCount;
            $usedPct = $totalCount > 0 ? round($usedCount / $totalCount * 100, 1) : 0;
            if (!isset($sourceDefinitions[$sourceId])) {
                echo "Cant find {$sourceId} in sources list\n";
            }
            $tables[$type][] = "| [{$sourceDefinitions[$sourceId]['name']}](sources/{$sourceId}.json) | {$sourceDefinitions[$sourceId]['type']} | {$usedCount} | {$unmatchedCount} | {$totalCount} | {$usedPct}% |";
        }
    }
}
foreach ($types as $type) {
    foreach ($unmatched[$type] as $key => $values) {
        ksort($values);
        $unmatched[$type][$key] = $values;
    }
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
file_put_contents(__DIR__.'/../../../emurelation/sources/local.json', json_encode($source, getJsonOpts()));
file_put_contents(__DIR__.'/../../../emurelation/sources_all.json', json_encode($sources, getJsonOpts()));

