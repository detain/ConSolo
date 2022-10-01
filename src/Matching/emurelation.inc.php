<?php

function prepSource($source, $type, $skipNames = false) {
    if (isset($source[$type])) {
        foreach ($source[$type] as $id => $data) {
            $names = [];
            $nameSuffix = [];
            if (isset($data['name'])) {
                $nameSuffix[] = $data['name'];
            }
            if (isset($data['shortName'])) {
                $nameSuffix[] = $data['shortName'];
            }
            if (isset($data['altNames'])) {
                foreach ($data['altNames'] as $altName) {
                    $nameSuffix[] = $altName;
                }
            }
            if ($type == 'platforms') {
                $company = null;
                foreach (['', 'company', 'developer', 'manufacturer'] as $prefixField) {
                    if ($prefixField != '' && isset($data[$prefixField]) && is_null($company)) {
                        $company = $data[$prefixField];
                    }
                    foreach ($nameSuffix as $suffix) {
                        //print_r($nameSuffix);
                        //echo "platId {$platId} prefixField {$prefixField} : ".(isset($data[$prefixField]) ? json_encode($data[$prefixField])." - ".json_encode($suffix) : json_encode($suffix))."\n";
                        $name = strtolower($prefixField != '' && isset($data[$prefixField]) ? $data[$prefixField].' '.$suffix : $suffix);
                        if (!in_array($name, $names)) {
                            $names[] = $name;
                        }
                    }
                }
                //if (!isset($data['company']) && !is_null($company)) {
                    //$source[$type][$id]['company'] = $company;
                //}
            }
            if (!$skipNames) {
                $source[$type][$id]['names'] = $names;
            }
        }
    }
    return $source[$type];
}

function loadSourceId($sourceId, $skipNames = false) {
    $source = [];
    foreach (['platforms', 'companies', 'emulators', 'games'] as $type) {
        $fileName = __DIR__.'/../../../emurelation/'.$type.'/'.$sourceId.'.json';
        if (file_exists($fileName)) {
            $source[$type] = json_decode(file_get_contents($fileName), true);
            $source[$type] = prepSource($source, $type, $skipNames);
        }
    }
    return $source;
}

function loadSource($fileName, $skipNames = false) {
    $sourceId = basename($fileName, '.json');
    $type = basename(dirname($fileName));
    $source = [
        $type => json_decode(file_get_contents($fileName), true)
    ];
    $source[$type] = prepSource($source, $type, $skipNames);
    return [$sourceId, $type, $source[$type]];
}

function loadSources() {
    echo 'Loading sources..';
    $sources = [];
    foreach (['platforms', 'companies', 'emulators', 'games'] as $type) {
        foreach (glob(__DIR__.'/../../../emurelation/'.$type.'/*.json') as $fileName) {
            $sourceId = basename($fileName, '.json');
            if (!isset($sources[$sourceId])) {
                $sources[$sourceId] = [];
            }
            list($sourceId, $type, $sources[$sourceId][$type]) = loadSource($fileName);
        }
    }
    echo 'done'.PHP_EOL;
    return $sources;
}
