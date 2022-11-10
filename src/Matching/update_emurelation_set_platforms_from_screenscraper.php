<?php

require_once __DIR__.'/../bootstrap.php';
require_once __DIR__.'/emurelation.inc.php';

/**
* @var \Workerman\MySQL\Connection
*/
global $db, $mysqlLinkId;
$sourceData = json_decode(file_get_contents(__DIR__.'/../../../emulation-data/screenscraper.json'), true);
$localSource = loadSourceId('local', true);
$missing = [];
foreach ($localSource['platforms'] as $localPlatId => $localPlatData) {
    if (isset($localPlatData['matches']) && isset($localPlatData['matches']['screenscraper'])) {
        $sourcePlatData = $sourceData['platforms'][$localPlatData['matches']['screenscraper'][0]];
        foreach (['date_start','date_end','type','romtype','supporttype','controller','icon','illustration','logo-monochrome','photo','video','wheel','ext'] as $field) {
            if (isset($sourcePlatData[$field])) {
                $localSource['platforms'][$localPlatId][$field] = $sourcePlatData[$field];
            }
        }
    }
}
file_put_contents(__DIR__.'/../../../emurelation/platforms/local.json', json_encode($localSource['platforms'], getJsonOpts()));
