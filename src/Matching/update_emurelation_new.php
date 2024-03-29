<?php

require_once __DIR__.'/../bootstrap.php';
require_once __DIR__.'/emurelation.inc.php';

/**
* @var \Workerman\MySQL\Connection
*/
global $db, $mysqlLinkId;
$sourceDefinitions = json_decode(file_get_contents(__DIR__.'/../../../emurelation/sources.json'), true);
$sourceIds = array_keys($sourceDefinitions);
$sources = loadSources();
$sourceId = 'local';
$source = $sources[$sourceId];
//list($sourceId, $source) = loadSourceId('local', true);
$table = [
    "| Source | Type | Mapped | Unmapped | Total | Mapped % |",
    "|-|-|-|-|-|-|"
];
$listTypes = ['platforms', 'emulators', 'companies', 'games'];
$unmatched = [];
$used = [];
$allNames = [];
$totals = [];
$tables = [];
foreach ($listTypes as $listType) {
    $tables[$listType] = $table;
    $unmatched[$listType] = [];
    $used[$listType] = [];
    $allNames[$listType] = [];
    foreach ($sourceIds as $sourceId) {
        $unused[$listType][$sourceId] = [];
        $used[$listType][$sourceId] = [];
        //$allNames[$listType][$sourceId] = [];
    }
}
foreach ($listTypes as $listType) {
    foreach ($source[$listType] as $localTypeId => $localData) {
        if (!array_key_exists($localTypeId, $allNames[$listType])) {
            $allNames[$listType][$localTypeId] = [];
        }
        if (isset($localData['shortName']) && !in_array(strtolower($localData['shortName']), $allNames[$listType][$localTypeId])) {
            $allNames[$listType][$localTypeId][] = strtolower($localData['shortName']);
        }
        if (!in_array(strtolower($localData['name']), $allNames[$listType][$localTypeId])) {
            $allNames[$listType][$localTypeId][] = strtolower($localData['name']);
        }
        if (isset($localData['altNames'])) {
            foreach ($localData['altNames'] as $name) {
                if (!in_array(strtolower($name), $allNames[$listType][$localTypeId])) {
                    $allNames[$listType][$localTypeId][] = strtolower($name);
                }
            }
        }
        if (!isset($localData['matches']))
            $localData['matches'] = [];
        foreach ($localData['matches'] as $matchSourceId => $matchTargets) {
            foreach ($matchTargets as $matchTargetId) {
                if (isset($sources[$matchSourceId][$listType][$matchTargetId])) { // it finds the match in the targeted source
                    if (!isset($used[$listType][$matchSourceId])) {
                        $used[$listType][$matchSourceId] = [];
                    }
                    if (!in_array($matchTargetId, $used[$listType][$matchSourceId])) {
                        $used[$listType][$matchSourceId][] = $matchTargetId;
                    }
                    /*
                    if (isset($sources[$matchSourceId][$listType][$matchTargetId]['matches'])) {
                        foreach ($sources[$matchSourceId][$listType][$matchTargetId]['matches'] as $subMatchSourceId => $subMatchTargets) {
                            foreach ($subMatchTargets as $subMatchTargetId) {
                                if (isset($sources[$subMatchSourceId][$listType][$subMatchTargetId])) { // it finds the match in the targeted source
                                    if (!isset($used[$listType][$subMatchSourceId])) {
                                        $used[$listType][$subMatchSourceId] = [];
                                    }
                                    if (!in_array($subMatchTargetId, $used[$listType][$subMatchSourceId])) {
                                        $used[$listType][$subMatchSourceId][] = $subMatchTargetId;
                                    }
                                    if (!isset($source[$listType][$localTypeId]['matches'][$subMatchSourceId])) {
                                        $source[$listType][$localTypeId]['matches'][$subMatchSourceId] = [];
                                    }
                                    if (!in_array($subMatchTargetId, $source[$listType][$localTypeId]['matches'][$subMatchSourceId])) {
                                        echo "Adding match type {$listType} {$localTypeId} source {$subMatchSourceId} {$subMatchTargetId}\n";
                                        $source[$listType][$localTypeId]['matches'][$subMatchSourceId][] = $subMatchTargetId;
                                    }
                                }
                            }
                        }
                    }
                    */
                    foreach ($sources[$matchSourceId][$listType][$matchTargetId]['names'] as $name) {
                        if (!in_array(strtolower($name), $allNames[$listType][$localTypeId])) {
                            //echo "Adding Allnames[{$listType}][{$localTypeId}]  didnt have ".strtolower($name)."\n";
                            $allNames[$listType][$localTypeId][] = strtolower($name);
                        }
                    }
                } else { // remove nonexistant matches
                    array_search($matchTargetId, $source[$listType][$localTypeId]['matches'][$matchSourceId]);
                    unset($source[$listType][$localTypeId]['matches'][$matchSourceId][array_search($matchTargetId, $source[$listType][$localTypeId]['matches'][$matchSourceId])]);
                    $source[$listType][$localTypeId]['matches'][$matchSourceId] = array_values($source[$listType][$localTypeId]['matches'][$matchSourceId]);
                    echo "Local {$localTypeId} matched {$matchSourceId} - {$matchTargetId} but does not exist; removing!\n";
                }
            }
        }
    }
}
foreach ($listTypes as $listType) {
    foreach ($sourceIds as $sourceId) {
        if (!isset($sources[$sourceId])) {
            continue;
        }
        if (!isset($used[$listType][$sourceId])) {
            $used[$listType][$sourceId] = [];
        }
        if (isset($sources[$sourceId][$listType])) {
            foreach ($sources[$sourceId][$listType] as $targetId => $targetData) {
                if (!in_array($targetId, $used[$listType][$sourceId])) {
                    if (!isset($sources[$sourceId][$listType][$targetId]['names'])) {
                        $sources[$sourceId][$listType][$targetId]['names'] = [];
                    }
                    if (isset($sources[$sourceId][$listType][$targetId]['name']) && !in_array(strtolower($sources[$sourceId][$listType][$targetId]['name']), $sources[$sourceId][$listType][$targetId]['names'])) {
                        $sources[$sourceId][$listType][$targetId]['names'][] = strtolower($sources[$sourceId][$listType][$targetId]['name']);
                    }
                    if (isset($sources[$sourceId][$listType][$targetId]['shortName']) && !in_array(strtolower($sources[$sourceId][$listType][$targetId]['shortName']), $sources[$sourceId][$listType][$targetId]['names'])) {
                        $sources[$sourceId][$listType][$targetId]['names'][] = strtolower($sources[$sourceId][$listType][$targetId]['shortName']);
                    }
                    if (isset($sources[$sourceId][$listType][$targetId]['altNames'])) {
                        foreach ($sources[$sourceId][$listType][$targetId]['altNames'] as $name) {
                            if (!in_array(strtolower($name), $sources[$sourceId][$listType][$targetId]['names'])) {
                                $sources[$sourceId][$listType][$targetId]['names'][] = strtolower($name);
                            }
                        }
                    }
                    foreach ($sources[$sourceId][$listType][$targetId]['names'] as $name) {
                        foreach ($allNames[$listType] as $localTypeId => $localNames) {
                            if (in_array(strtolower($name), $localNames)) {
                                $used[$listType][$sourceId][] = $targetId;
                                if ($sourceId != 'local') {
                                    if (!isset($source[$listType][$localTypeId]['matches'][$sourceId])) {
                                        $source[$listType][$localTypeId]['matches'][$sourceId] = [];
                                    }
                                    $source[$listType][$localTypeId]['matches'][$sourceId][] = $targetId;
                                }
                                //echo "Found by Name local:{$localTypeId} - {$sourceId}:{$targetId}\n";
                                break 2;
                            }
                        }
                    }
                }
                if (!in_array($targetId, $used[$listType][$sourceId]) && isset($targetData['name'])) {
                    if (!array_key_exists($sourceId, $unmatched[$listType])) {
                        $unmatched[$listType][$sourceId] = [];
                    }
                    if ($listType == 'platforms') {
                        if (isset($targetData['company'])) {
                            $unmatched[$listType][$sourceId][$targetId] = $targetData['company'].' '.$targetData['name'];
                        } elseif (isset($targetData['company_name'])) {
                            $unmatched[$listType][$sourceId][$targetId] = $targetData['company_name'].' '.$targetData['name'];
                        } else {
                            $unmatched[$listType][$sourceId][$targetId] = $targetData['name'];
                        }
                    } else {
                        $unmatched[$listType][$sourceId][$targetId] = $targetData['name'];
                    }
                }
            }
            $usedCount = count($used[$listType][$sourceId]);
            $unmatchedCount = isset($unmatched[$listType][$sourceId]) ? count($unmatched[$listType][$sourceId]) : 0;
            $totalCount = $usedCount + $unmatchedCount;
            $usedPct = $totalCount > 0 ? round($usedCount / $totalCount * 100, 1) : 0;
            if (!isset($sourceDefinitions[$sourceId])) {
                echo "Cant find {$sourceId} in sources list\n";
            }
            $tables[$listType][] = "| [{$sourceDefinitions[$sourceId]['name']}]({$listType}/{$sourceId}.json) | {$sourceDefinitions[$sourceId]['type']} | {$usedCount} | {$unmatchedCount} | {$totalCount} | {$usedPct}% |";
        }
    }
}
foreach ($listTypes as $listType) {
    foreach ($unmatched[$listType] as $key => $values) {
        ksort($values);
        $unmatched[$listType][$key] = $values;
    }
}
$readme = file_get_contents(__DIR__.'/../../../emurelation/README.md');
if (preg_match_all('/^### .{1,2} (?P<type>\S+)(\n\s*)+(?P<table>(^\|[^\n]+\|\n)+)\n/muU', $readme, $matches)) {
    foreach ($matches['type'] as $idx => $listType) {
        echo "Updating {$listType} section in README.md\n";
        $table = implode("\n", $tables[strtolower($listType)]);
        $readme = str_replace("{$listType}\n\n{$matches['table'][$idx]}\n", "{$listType}\n\n{$table}\n\n", $readme);
    }
    file_put_contents(__DIR__.'/../../../emurelation/README.md', $readme);
}
foreach ($listTypes as $listType) {
    foreach ($source[$listType] as $targetId => $targetData) {
        unset($source[$listType][$targetId]['names']);
    }
}

@mkdir(__DIR__.'/../../../emurelation/unmatched', 0777, true);
foreach ($listTypes as $listType) {
    //file_put_contents(__DIR__.'/../../../emurelation/unmatched/'.$listType.'.json', json_encode($unmatched[$listType], getJsonOpts()));
    @mkdir(__DIR__.'/../../../emurelation/unmatched/'.$listType, 0777, true);
    foreach ($unmatched[$listType] as $sourceId => $sourceData) {
        asort($sourceData);
        file_put_contents(__DIR__.'/../../../emurelation/unmatched/'.$listType.'/'.$sourceId.'.json', json_encode($sourceData, getJsonOpts()));
    }
}
//file_put_contents(__DIR__.'/../../../emurelation/unmatched.json', json_encode($unmatched, getJsonOpts()));
foreach ($source as $type => $data) {
    file_put_contents(__DIR__.'/../../../emurelation/'.$type.'/local.json', json_encode($data, getJsonOpts()));
}
//file_put_contents(__DIR__.'/../../../emurelation/used.json', json_encode($used, getJsonOpts()));
//file_put_contents(__DIR__.'/../../../emurelation/all_names.json', json_encode($allNames, getJsonOpts()));
//file_put_contents(__DIR__.'/../../../emurelation/sources_all.json', json_encode($sources, getJsonOpts()));

