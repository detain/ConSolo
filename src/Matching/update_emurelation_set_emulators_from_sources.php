<?php

require_once __DIR__.'/../bootstrap.php';
require_once __DIR__.'/emurelation.inc.php';

/**
* @var \Workerman\MySQL\Connection
*/
global $db, $mysqlLinkId;
$sources = loadSources(true);
$localPlatFromSource = [];
foreach ($sources['local']['platforms'] as $localPlatId => $localPlatData) {
    if (isset($localPlatData['matches'])) {
        foreach ($localPlatData['matches'] as $sourceId => $sourcePlatforms) {
            if (!isset($localPlatFromSource[$sourceId])) {
                $localPlatFromSource[$sourceId] = [];
            }
            foreach ($sourcePlatforms as $sourcePlatId) {
                $localPlatFromSource[$sourceId][$sourcePlatId] = $localPlatId;
            }
        }
    }
}
ksort($localPlatFromSource);
foreach ($localPlatFromSource as $sourceId => $sourcePlatforms) {
    ksort($localPlatFromSource[$sourceId]);
}
//print_r($localPlatFromSource['recalbox']);
//exit;
$missing = [];
foreach ($sources['local']['emulators'] as $localEmuId => $localEmuData) {
    if (isset($localEmuData['matches'])) {
        foreach ($localEmuData['matches'] as $sourceId => $sourceEmulators) {
            foreach ($sourceEmulators as $sourceEmuId) {
                $sourceEmuData = $sources[$sourceId]['emulators'][$sourceEmuId];
                if (isset($sourceEmuData['platforms']) && count($sourceEmuData['platforms']) > 0) {
                    if (!array_key_exists('platforms', $sources['local']['emulators'][$localEmuId])) {
                        $sources['local']['emulators'][$localEmuId]['platforms'] = [];
                    }
                    foreach ($sourceEmuData['platforms'] as $sourcePlatId) {
                        if ($sourceId == 'recalbox') {
                            echo "Emu:{$sourceEmuId} ID:{$sourcePlatId} Matching: {$localPlatFromSource[$sourceId][$sourcePlatId]}\n";
                        }

                        if (isset($localPlatFromSource[$sourceId][$sourcePlatId])) {
                            if (!in_array($localPlatFromSource[$sourceId][$sourcePlatId], $sources['local']['emulators'][$localEmuId]['platforms'])) {
                                $sources['local']['emulators'][$localEmuId]['platforms'][] = $localPlatFromSource[$sourceId][$sourcePlatId];
                            }
                        } else {
                            if (!isset($missing[$sourceId]))
                                $missing[$sourceId] =[];
                            if (!in_array($sourcePlatId, $missing[$sourceId])) {

                                $missing[$sourceId][] = $sourcePlatId;
                            }
                        }
                    }
                }
            }
        }
    }
}
ksort($missing);
foreach ($missing as $sourceId => $sourcePlatforms) {
    ksort($missing[$sourceId]);
}
//echo count($missing)." Missing Platforms: ".json_encode($missing, getJsonOpts())."\n";
file_put_contents(__DIR__.'/../../../emurelation/emulators/local.json', json_encode($sources['local']['emulators'], getJsonOpts()));
