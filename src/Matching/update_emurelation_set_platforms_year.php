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
$months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
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
            $value = str_replace(['Summer ', 'Fall ', 'Unknown ', '? '], ['May ', 'October ', '', ''], $value);
            if (preg_match('/^(\d|\d)[a-zA-Z]{0,1,2} ('.implode('|',$months).')[\- ](\d{4})/i', $value, $matches)) {
                $value = str_replace($matches[0], $matches[3].'-'.sprintf("%02d", array_search($matches[2], $months)+1).'-'.sprintf("%02d", $matches[1]), $value);
            }
            if (preg_match('/^('.implode('|',$months).')[\- ](\d{4})/i', $value, $matches)) {
                $value = str_replace($matches[0], $matches[2].'-'.sprintf("%02d", array_search($matches[1], $months)+1).'-01', $value);
            }
            $localSource['platforms'][$localPlatId]['date'] = trim($value);
        }
    }
}
file_put_contents(__DIR__.'/../../../emurelation/platforms/local.json', json_encode($localSource['platforms'], getJsonOpts()));
echo "set the date on {$count}/{$totalCount} platforms\n";