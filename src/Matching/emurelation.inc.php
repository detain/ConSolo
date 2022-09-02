<?php

function loadSource($fileName) {
    $sourceId = basename($fileName, '.json');
    $source = json_decode(file_get_contents($fileName), true);
    foreach ($source['platforms'] as $platId => $platData) {
        $names = [];
        $nameSuffix = [];
        $nameSuffix[] = $platData['name'];
        if (isset($platData['shortName'])) {
            $nameSuffix[] = $platData['shortName'];
        }
        if (isset($platData['altNames'])) {
            foreach ($platData['altNames'] as $altName) {
                $nameSuffix[] = $altName;
            }
        }
        $company = null;
        foreach (['', 'company', 'developer', 'manufacturer'] as $prefixField) {
            if ($prefixField != '' && isset($platData[$prefixField]) && is_null($company)) {
                $company = $platData[$prefixField];
            }
            foreach ($nameSuffix as $suffix) {
                //print_r($nameSuffix);
                //echo "platId {$platId} prefixField {$prefixField} : ".(isset($platData[$prefixField]) ? json_encode($platData[$prefixField])." - ".json_encode($suffix) : json_encode($suffix))."\n";
                $name = strtolower($prefixField != '' && isset($platData[$prefixField]) ? $platData[$prefixField].' '.$suffix : $suffix);
                if (!in_array($name, $names)) {
                    $names[] = $name;
                }
            }
        }
        if (!isset($platData['company']) && !is_null($company)) {
            $source['platforms'][$platId]['company'] = $company;
        }
        if ($sourceId != 'local') {
            $source['platforms'][$platId]['names'] = $names;
        }
    }
    return [$sourceId, $source];
}

function loadSources() {
    echo 'Loading sources..';
    $sources = [];
    foreach (glob(__DIR__.'/../../../emurelation/sources/*.json') as $fileName) {
        list($sourceId, $source) = loadSource($fileName);
        $sources[$sourceId] = $source;
    }
    echo 'done'.PHP_EOL;
    return $sources;
}
