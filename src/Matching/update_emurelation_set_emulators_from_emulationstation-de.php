<?php

require_once __DIR__.'/../bootstrap.php';
require_once __DIR__.'/emurelation.inc.php';

/**
* @var \Workerman\MySQL\Connection
*/
global $db, $mysqlLinkId;
$sourceData = json_decode(file_get_contents(__DIR__.'/../../../emulation-data/emulationstation-de.json'), true);
$localSource = loadSourceId('local', true);
$localPlatFromSource = [];
foreach ($localSource['platforms'] as $localPlatId => $localPlatData) {
    if (isset($localPlatData['matches']) && isset($localPlatData['matches']['emulationstation-de'])) {
        $localPlatFromSource[$localPlatData['matches']['emulationstation-de'][0]] = $localPlatId;
    }
}
$missing = [];
foreach ($localSource['emulators'] as $localEmuId => $localEmuData) {
    if (isset($localEmuData['matches']) && isset($localEmuData['matches']['emulationstation-de'])) {
        foreach ($localEmuData['matches']['emulationstation-de'] as $sourceEmuId) {
            $sourceEmuData = $sourceData['emulators'][$sourceEmuId];
            foreach (['bin', 'dir', 'cmd'] as $field) {
                if (!isset($localSource['emulators'][$localEmuId][$field]) && isset($sourceEmuData[$field])
                && (
                    (is_array($sourceEmuData[$field]) && count($sourceEmuData[$field]) > 0)
                    || (!is_array($sourceEmuData[$field]) && trim($sourceEmuData[$field]) != '')
                )) {
                    $localSource['emulators'][$localEmuId][$field] = $sourceEmuData[$field];
                }
            }
            if (isset($sourceEmuData['platforms']) && count($sourceEmuData['platforms']) > 0) {
                if (!isset($localSource['emulators'][$localEmuId]['platforms'])) {
                    $localSource['emulators'][$localEmuId]['platforms'] = [];
                }
                foreach ($sourceEmuData['platforms'] as $sourcePlatId) {
                    if (isset($localPlatFromSource[$sourcePlatId])) {
                        if (!in_array($localPlatFromSource[$sourcePlatId], $localSource['emulators'][$localEmuId]['platforms'])) {
                            $localSource['emulators'][$localEmuId]['platforms'][] = $localPlatFromSource[$sourcePlatId];
                        }
                    } else {
                        if (!in_array($sourcePlatId, $missing)) {
                            $missing[] = $sourcePlatId;
                        }
                    }
                }
            }
        }
    }
}
echo count($missing)." Missing Platforms: ".implode(', ', $missing)."\n";
file_put_contents(__DIR__.'/../../../emurelation/emulators/local.json', json_encode($localSource['emulators'], getJsonOpts()));
