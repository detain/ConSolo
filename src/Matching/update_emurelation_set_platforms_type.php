<?php

require_once __DIR__.'/../bootstrap.php';
require_once __DIR__.'/emurelation.inc.php';

/**
* @var \Workerman\MySQL\Connection
*/
global $db, $mysqlLinkId;
$sourceMap = [
    'oldcomputers' => 'type',
    'arrm' => 'type',
    'emutopia' => 'type',
    'emucontrolcenter' => 'category',
    'screenscraper' => 'type',
];

$localSource = loadSourceId('local', true);
$sources = [];
$count = 0;
$totalCount = count($localSource['platforms']);
foreach ($localSource['platforms'] as $localPlatId => $localPlatData) {
    if (!isset($localPlatData['type']))
        $localSource['platforms'][$localPlatId]['type'] = 'Unknown';
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
            $localSource['platforms'][$localPlatId]['type'] = str_replace(['Home Computer', 'Professional Computer', 'Computers'], ['Computer', 'Computer', 'Computer'], ucwords($value));
        }
    }
}
file_put_contents(__DIR__.'/../../../emurelation/platforms/local.json', json_encode($localSource['platforms'], getJsonOpts()));
echo "set the type on {$count}/{$totalCount} platforms\n";