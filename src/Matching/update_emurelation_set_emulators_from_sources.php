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
            $localPlatFromSource[$sourceId] = [];
            foreach ($sourcePlatforms as $sourcePlatId) {
                $localPlatFromSource[$sourceId][$sourcePlatId] = $localPlatId;
            }
        }
    }
}
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
                        if (isset($localPlatFromSource[$sourceId][$sourcePlatId]) && !in_array($localPlatFromSource[$sourceId][$sourcePlatId], $sources['local']['emulators'][$localEmuId]['platforms'])) {
                            $sources['local']['emulators'][$localEmuId]['platforms'][] = $localPlatFromSource[$sourceId][$sourcePlatId];
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
echo count($missing)." Missing Platforms: ".json_encode($missing, getJsonOpts())."\n";
file_put_contents(__DIR__.'/../../../emurelation/emulators/local.json', json_encode($sources['local']['emulators'], getJsonOpts()));
