<?php

require_once __DIR__.'/../bootstrap.php';
require_once __DIR__.'/emurelation.inc.php';

/**
* @var \Workerman\MySQL\Connection
*/
global $db, $mysqlLinkId;
$sourceMap = [
    'oldcomputers' => 'year',
    'emulationking' => 'year',
    'emucontrolcenter' => 'year_start',
    'screenscraper' => 'date_start',
];

$localSource = loadSourceId('local', true);
$sources = [];
$count = 0;
$totalCount = count($localSource['platforms']);
foreach ($localSource['platforms'] as $localPlatId => $localPlatData) {
    if (isset($localPlatData['date_start']))
        unset($localPlatData['date_start']);
    if (isset($localPlatData['date_end']))
        unset($localPlatData['date_end']);
    //if (!isset($localPlatData['date']))
        //$localSource['platforms'][$localPlatId]['date'] = 'Unknown';
    if (!isset($localPlatData['matches']))
        continue;
    $lastSet = false;
    foreach ($sourceMap as $sourceId => $field) {
        if (!isset($sources[$sourceId]))
            $sources[$sourceId] = json_decode(file_get_contents(__DIR__.'/../../../emulation-data/'.$sourceId.'.json'), true);
        if (isset($localPlatData['matches'][$sourceId])) {
            $matchId = $localPlatData['matches'][$sourceId][0];
            $platData = $sources[$sourceId]['platforms'][$matchId];
            if (!isset($platData[$field]) || is_null($platData[$field]))
                continue;
            $value = $platData[$field];
            if ($lastSet === false) {
                $count++;
                $lastSet = true;
            }
            $localSource['platforms'][$localPlatId]['date'] = $value;
        }
    }
}
file_put_contents(__DIR__.'/../../../emurelation/platforms/local.json', json_encode($localSource['platforms'], getJsonOpts()));
echo "set the date on {$count}/{$totalCount} platforms\n";