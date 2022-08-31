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
                foreach ($sources[$linkSourceId] as $sourcePlatId => $sourcePlatData) {
                    $unused[$linkSourceId][] = $sourcePlatId;
                    if (in_array($linkPlatformId, $sourcePlatData['names'])) {
                        echo "Found link '{$platform}' => {$linkSourceId} {$sourcePlatData['id']} ".(isset($sourcePlatData['company']) ? "'{$sourcePlatData['company']}' " : '')."'{$sourcePlatData['name']}'\n";
                        if (!in_array([$linkSourceId, $sourcePlatId], $source['platforms'][$platform]['matches'])) {
                            $source['platforms'][$platform]['matches'][] = [$linkSourceId, $sourcePlatId];
                            if (!isset($used[$linkSourceId])) {
                                $used[$linkSourceId] = [];
                            }
                            $used[$linkSourceId][] = $sourcePlatId;
                        }
                    }
                }
            }

        }
    }
}
$unused = [];
$totals = [];
echo "| Source | Mapped | Unmapped | Total | Mapped % |\n";
echo "|-|-|-|-|-|\n";
ksort($sources);
foreach ($sources as $sourceId => $sourceData) {
    $unused[$sourceId] = [];
    if (!isset($used[$sourceId])) {
        $used[$sourceId] = [];
    }
    foreach ($sourceData as $platId => $platData) {
        if (!in_array($platId, $used[$sourceId])) {
            $unused[$sourceId][] = $platId;
        }
    }
    $usedCount = count($used[$sourceId]);
    $unusedCount = count($unused[$sourceId]);
    $totalCount = $usedCount + $unusedCount;
    $usedPct = round($usedCount / $totalCount * 100, 1);
    echo "| {$sourceId} | {$usedCount} | {$unusedCount} | {$totalCount} | {$usedPct}% |\n";
}
file_put_contents(__DIR__.'/../../../emurelation/sources/local.json', json_encode($source, getJsonOpts()));
