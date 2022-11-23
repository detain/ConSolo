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
    'screenscraper' => 'type',
    'emutopia' => 'type',
    'emucontrolcenter' => 'category',
];
$sources = loadSources(true);
$localSource = loadSourceId('local', true);
$count = 0;
foreach ($localSource['platforms'] as $localPlatId => $localPlatData) {
    if (!isset($localPlatData['matches']))
        continue;
    $lastSet = false;
    foreach ($sourceMap as $sourceId => $field) {
        if (isset($localPlatData['matches'][$sourceId])) {
            if (isset($sources[$sourceId]['platforms'][$localPlatData['matches'][$sourceId][0]][$field]) && !is_null($sources[$sourceId]['platforms'][$localPlatData['matches'][$sourceId][0]][$field]))
                if ($lastSet === false) {
                    $count++;
                    $lastSet = true;
                }
                $localSource['platforms'][$localPlatId]['type'] = ucwords($sources[$sourceId]['platforms'][$localPlatData['matches'][$sourceId][0]][$field]);
        }
    }
}
file_put_contents(__DIR__.'/../../../emurelation/platforms/local.json', json_encode($localSource['platforms'], getJsonOpts()));
