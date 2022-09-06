<?php

function loadSource($fileName) {
    $sourceId = basename($fileName, '.json');
    $source = json_decode(file_get_contents($fileName), true);
    foreach (['platforms', 'companies', 'emulators', 'games'] as $type) {
        if (isset($source[$type])) {
            foreach ($source[$type] as $id => $data) {
                $names = [];
                $nameSuffix = [];
                $nameSuffix[] = $data['name'];
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
                    if (!isset($data['company']) && !is_null($company)) {
                        $source[$type][$id]['company'] = $company;
                    }
                }
                if ($sourceId != 'local') {
                    $source[$type][$id]['names'] = $names;
                }
            }
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
