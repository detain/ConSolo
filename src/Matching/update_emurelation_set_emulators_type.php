<?php

require_once __DIR__.'/../bootstrap.php';
require_once __DIR__.'/emurelation.inc.php';

/**
* @var \Workerman\MySQL\Connection
*/
global $db, $mysqlLinkId;
$sourceMap = [
    'emutopia' => 'type',
];

$localSource = loadSourceId('local', true);
$sources = [];
$count = 0;
$totalCount = count($localSource['emulators']);
foreach ($localSource['emulators'] as $localEmuId => $localEmuData) {
    if (!isset($localEmuData['type']))
        $localSource['emulators'][$localEmuId]['type'] = 'Unknown';
    if (!isset($localEmuData['matches']))
        continue;
    $lastSet = false;
    foreach ($sourceMap as $sourceId => $field) {
        if (!isset($sources[$sourceId]))
            $sources[$sourceId] = json_decode(file_get_contents(__DIR__.'/../../../emulation-data/'.$sourceId.'.json'), true);
        if (isset($localEmuData['matches'][$sourceId])) {
            $matchId = $localEmuData['matches'][$sourceId][0];
            $emuData = $sources[$sourceId]['emulators'][$matchId];
            if (!isset($emuData[$field]) || is_null($emuData[$field]))
                continue;
            $value = $emuData[$field];
            if ($lastSet === false) {
                $count++;
                $lastSet = true;
            }
            $localSource['emulators'][$localEmuId]['type'] = $value;
        }
    }
}
file_put_contents(__DIR__.'/../../../emurelation/emulators/local.json', json_encode($localSource['emulators'], getJsonOpts()));
echo "set the type on {$count}/{$totalCount} emulators\n";