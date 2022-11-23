<?php

require_once __DIR__.'/../bootstrap.php';
require_once __DIR__.'/emurelation.inc.php';

/**
* @var \Workerman\MySQL\Connection
*/
global $db, $mysqlLinkId;
$localSource = loadSourceId('local', true);
foreach ($localSource['companies'] as $localComId=> $localComData) {
    if (isset($localSource['companies'][$localComId]['platforms']))
        unset($localSource['companies'][$localComId]['platforms']);
}
foreach ($localSource['platforms'] as $localPlatId=> $localPlatData) {
    if (isset($localSource['platforms'][$localPlatId]['emulators']))
        unset($localSource['platforms'][$localPlatId]['emulators']);
    if (!isset($localPlatData['company']))
        continue;
    if (!isset($localSource['companies'][$localPlatData['company']]))
        continue;
    if (!isset($localSource['companies'][$localPlatData['company']]['platforms']))
        $localSource['companies'][$localPlatData['company']]['platforms'] = [];
    $localSource['companies'][$localPlatData['company']]['platforms'][] = $localPlatId;
}
foreach ($localSource['emulators'] as $localEmuId => $localEmuData) {
    if (!isset($localEmuData['platforms']))
        continue;
    foreach ($localEmuData['platforms'] as $localPlatId) {
        if (!isset($localSource['platforms'][$localPlatId]))
            continue;
        if (!isset($localSource['platforms'][$localPlatId]['emulators']))
            $localSource['platforms'][$localPlatId]['emulators'] = [];
        $localSource['platforms'][$localPlatId]['emulators'][] = $localEmuId;
    }
}
file_put_contents(__DIR__.'/../../../emurelation/companies/local.json', json_encode($localSource['companies'], getJsonOpts()));
file_put_contents(__DIR__.'/../../../emurelation/platforms/local.json', json_encode($localSource['platforms'], getJsonOpts()));
