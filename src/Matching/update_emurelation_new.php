<?php
require_once __DIR__.'/../bootstrap.php';

/**
* @var \Workerman\MySQL\Connection
*/
global $db, $mysqlLinkId;
$sourceDir = __DIR__.'/../../../emurelation/sources';
echo 'Loading sources..';
$sources = [];
foreach (glob($sourceDir.'/*.json') as $fileName) {
    $sourceId = basename($fileName, '.json');
    if ($sourceId == 'local') {
        continue;
    }
    $json = json_decode(file_get_contents($fileName), true);
    $sources[$sourceId] = $json['platforms'];
    foreach ($json['platforms'] as $platId => $platData) {
        $names = [];
        $nameSuffix = [];
        $nameSuffix[] = $platData['name'];
        if (isset($platData['shortName'])) {
            $nameSuffix[] = $platData['shortName'];
        }
        if (isset($platData['altNames'])) {
            foreach ($platData['altNames'] as $altName) {
                $nameSuffix[] = $altName;
            }
        }
        $company = null;
        foreach (['', 'company', 'developer', 'manufacturer'] as $prefixField) {
            if ($prefixField != '' && isset($platData[$prefixField]) && is_null($company)) {
                $company = $platData[$prefixField];
            }
            foreach ($nameSuffix as $suffix) {
                //print_r($nameSuffix);
                //echo "platId {$platId} prefixField {$prefixField} : ".(isset($platData[$prefixField]) ? json_encode($platData[$prefixField])." - ".json_encode($suffix) : json_encode($suffix))."\n";
                $name = $prefixField != '' && isset($platData[$prefixField]) ? $platData[$prefixField].' '.$suffix : $suffix;
                if (!in_array($name, $names)) {
                    $names[] = $name;
                }
            }
        }
        if (!isset($platData['company']) && !is_null($company)) {
            $sources[$sourceId][$platId]['company'] = $company;
        }
        $sources[$sourceId][$platId]['names'] = $names;
    }
}
echo 'done'.PHP_EOL;
$source = [
    'platforms' => []
];
$locals = [
    $sourceDir.'/../matches/local.json',
    $sourceDir.'/../platforms.json'
];
$used = [];
$allNames = [];
foreach ($locals as $fileName) {
    $local = json_decode(file_get_contents($fileName), true);
    foreach ($local as $platform => $platData) {
        if (isset($platData['tosec'])) {
            $platData['tosecpix'] = $platData['tosec'];
            $platData['toseciso'] = $platData['tosec'];
        }
        if (!isset($source['platforms'][$platform])) {
            $source['platforms'][$platform] = [
                'id' => $platform,
                'name' => $platform,
                'matches' => []
            ];
        }
        foreach ($platData as $linkSourceId => $linkPlatforms) {
            foreach ($linkPlatforms as $linkPlatformId) {
                if (isset($sources[$linkSourceId])) {
                    foreach ($sources[$linkSourceId] as $sourcePlatId => $sourcePlatData) {
                        if (in_array($linkPlatformId, $sourcePlatData['names'])) {
                            //echo "Found link '{$platform}' => {$linkSourceId} {$sourcePlatData['id']} ".(isset($sourcePlatData['company']) ? "'{$sourcePlatData['company']}' " : '')."'{$sourcePlatData['name']}'\n";
                            if (!in_array([$linkSourceId, $sourcePlatId], $source['platforms'][$platform]['matches'])) {
                                $source['platforms'][$platform]['matches'][] = [$linkSourceId, $sourcePlatId];
                                if (!isset($used[$linkSourceId])) {
                                    $used[$linkSourceId] = [];
                                }
                                if (!in_array($sourcePlatId, $used[$linkSourceId]))
                                    $used[$linkSourceId][] = $sourcePlatId;
                            }
                        }
                        if (isset($sourcePlatData['matches'])) {
                            foreach ($sourcePlatData['matches'] as $match) {
                                list($matchSource, $matchPlatform) = $match;
                                if (in_array($match, $source['platforms'][$platform]['matches'])) {
                                    if (!in_array($sourcePlatId, $used[$linkSourceId])) {
                                        $used[$linkSourceId][] = $sourcePlatId;
                                        $source['platforms'][$platform]['matches'][] = [$linkSourceId, $sourcePlatId];
                                        echo "Found {$match[0]}:{$match[1]} - {$linkSourceId}:{$sourcePlatId}\n";
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
foreach ($source['platforms'] as $localPlatId => $localData) {
    $allNames[$localPlatId] = [];
    $allNames[$localPlatId][] = $localData['name'];
    foreach ($localData['matches'] as $matchData) {
        list($matchSourceId, $matchPlatId) = $matchData;
        foreach ($sources[$matchSourceId][$matchPlatId]['names'] as $name) {
            if (!in_array($name, $allNames[$localPlatId])) {
                $allNames[$localPlatId][] = $name;
            }
        }
    }
}
$unused = [];
$totals = [];
$table = [];
$table[] = "| Source | Mapped | Unmapped | Total | Mapped % |";
$table[] = "|-|-|-|-|-|";
ksort($sources);
foreach ($sources as $sourceId => $sourceData) {
    $unused[$sourceId] = [];
    if (!isset($used[$sourceId])) {
        $used[$sourceId] = [];
    }
    foreach ($sourceData as $platId => $platData) {
        if (!in_array($platId, $used[$sourceId])) {
            foreach ($platData['names'] as $name) {
                foreach ($allNames as $localPlatId => $localNames) {
                    if (in_array($name, $localNames)) {
                        $used[$sourceId][] = $platId;
                        $source['platforms'][$localPlatId]['matches'][] = [$sourceId, $platId];
                        echo "Found by Name local:{$localPlatId} - {$sourceId}:{$platId}\n";
                        break 2;
                    }
                }
            }
        }
        if (!in_array($platId, $used[$sourceId])) {
            $unused[$sourceId][$platId] = $platData['name'];
        }
    }
    $usedCount = count($used[$sourceId]);
    $unusedCount = count($unused[$sourceId]);
    $totalCount = $usedCount + $unusedCount;
    $usedPct = round($usedCount / $totalCount * 100, 1);
    $table[] = "| {$sourceId} | {$usedCount} | {$unusedCount} | {$totalCount} | {$usedPct}% |";
}
$readme = file_get_contents(__DIR__.'/../../../emurelation/README.md');
preg_match_all('/^### Platforms\n\n(?P<table>(^\|[^\n]+\|\n)+)\n/msuU', $readme, $matches);
$readme = str_replace($matches['table'][0], implode("\n", $table)."\n", $readme);
file_put_contents(__DIR__.'/../../../emurelation/README.md', $readme);
file_put_contents(__DIR__.'/../../../emurelation/unused.json', json_encode($unused, getJsonOpts()));
file_put_contents(__DIR__.'/../../../emurelation/sources/local.json', json_encode($source, getJsonOpts()));
