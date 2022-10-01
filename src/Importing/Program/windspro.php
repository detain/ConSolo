<?php

require_once __DIR__.'/../../bootstrap.php';

if (in_array('-h', $_SERVER['argv']) || in_array('--help', $_SERVER['argv'])) {
    die("Syntax:
    php ".$_SERVER['argv'][0]." <options>

Options:
    -h, --help  this screen
    -f          force update even if already latest version
    --no-db     skip the db updates/inserts
    --no-cache  disables use of the file cache

");
}
/**
* @var \Workerman\MySQL\Connection
*/
global $db;
$dataDir = __DIR__.'/../../../data/json';
if (!file_exists($dataDir))
    mkdir($dataDir, 0777, true);
$data = [
    'platforms' => [],
    'emulators' => [],
];
$source = [
    'platforms' => [],
    'emulators' => [],
];
//gitSetup('https://github.com/lainz/windspro');
//echo `cd windspro; git checkout 222d8f04d2b38468ba2d0ca3065d4f754e998fd0`;
//$js = file_get_contents('windspro/windsproapps/electron/resources/app/emulators.js');
$js = file_get_contents('/mnt/f/WinDS Pro/resources/app/emulators.js');
$js = preg_replace('/const fs = require.*$/msu', '', $js);
$js .= "\nvar data = { categories: categories, emulators: emulators };\nconsole.log(JSON.stringify(data));\n";
file_put_contents('emulators.js', $js);
$out = trim(`node emulators.js;`);
unlink('emulators.js');
echo `rm -rf windspro;`;
$json = json_decode($out, true);
foreach ($json['emulators'] as $emulator) {
    $id = $emulator['name'];
    $platforms = explode(',', str_replace('/', ',', $emulator['category']));
    $platIds = [];
    foreach ($platforms as $platId) {
        $platId = trim($platId);
        if (!isset($data['platforms'][$platId])) {
            $data['platforms'][$platId] = [
                'id' => $platId,
                'name' => $platId
            ];
            $source['platforms'][$platId] = [
                'id' => $platId,
                'name' => $platId
            ];
            if (preg_match('/^\s*(?P<name>\S.*\S)\s+\((?P<shortName>[^\)]+)\)/', $platId, $matches)) {
                $data['platforms'][$platId]['name'] = $matches['name'];
                $data['platforms'][$platId]['shortName'] = $matches['shortName'];
            }
            $data['platforms'][$platId]['emulators'] = [];
            $source['platforms'][$platId]['emulators'] = [];
        }
        $platIds[] = $platId;
        $data['platforms'][$platId]['emulators'][] = $id;
        $source['platforms'][$platId]['emulators'][] = $id;
    }
    $data['emulators'][$id] = [
        'id' => $id,
        'name' => $id,
        'platforms' => $platIds,
        'bin' => [$emulator['executable']],
        'dir' => [$emulator['folder']],
        'ext' => trim($emulator['extensions']) != '' ? explode(')(', substr($emulator['extensions'], 1, strlen($emulator['extensions']) - 2)) : [],
    ];
    $source['emulators'][$id] = [
        'id' => $id,
        'name' => $id,
    ];
}
file_put_contents($dataDir.'/windspro.json', json_encode($data, getJsonOpts()));
$sources = json_decode(file_get_contents(__DIR__.'/../../../../emurelation/sources.json'), true);
$sources['windspro']['updatedLast'] = time();
file_put_contents(__DIR__.'/../../../../emurelation/sources.json', json_encode($sources, getJsonOpts()));
foreach ($source as $type => $data) {
    file_put_contents(__DIR__.'/../../../../emurelation/'.$type.'/windspro.json', json_encode($data, getJsonOpts()));
}
