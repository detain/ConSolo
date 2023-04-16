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
$dataDir = __DIR__.'/../../../data/json/gametdb';
if (!file_exists($dataDir))
    mkdir($dataDir, 0777, true);
$force = in_array('-f', $_SERVER['argv']);
$skipDb = in_array('--no-db', $_SERVER['argv']);
$useCache = !in_array('--no-cache', $_SERVER['argv']);;
$data = [
    'platforms' => [],
    'games' => [],
];
$source = [
    'platforms' => [
        'GameCube' => [
            'id' => 'GameCube',
            'name' => 'Nintendo GameCube',
            'shortName' => 'GameCube',
        ],
        'DS' => [
            'id' => 'DS',
            'name' => 'Nintendo DS',
            'shortName' => 'DS',
        ],
        '3DS' => [
            'id' => '3DS',
            'name' => 'Nintendo 3DS',
            'shortName' => '3DS',
        ],
        'Wii' => [
            'id' => 'Wii',
            'name' => 'Nintendo Wii',
            'shortName' => 'Wii',
        ],
        'WiiU' => [
            'id' => 'WiiU',
            'name' => 'Nintendo Wii-U',
            'shortName' => 'WiiU',
        ],
        'Switch' => [
            'id' => 'Switch',
            'name' => 'Nintendo Switch',
            'shortName' => 'Switch',
        ],
        'PS3' => [
            'id' => 'PS3',
            'name' => 'Sony Playstation 3',
            'shortName' => 'PS3',
        ],
    ],
    'games' => []
];
$urls = [
    'https://www.gametdb.com/wiitdb.zip?LANG=EN&WIIWARE=1&GAMECUBE=1',
    'https://www.gametdb.com/3dstdb.zip?LANG=EN',
    'https://www.gametdb.com/switchtdb.zip?LANG=EN',
    'https://www.gametdb.com/wiiutdb.zip?LANG=EN',
    'https://www.gametdb.com/ps3tdb.zip?LANG=EN',
    'https://www.gametdb.com/dstdb.zip?LANG=EN'
];

foreach ($urls as $url) {
    $urlParts = parse_url($url);
    $zipFile = basename($urlParts['path']);
    $baseFile = basename($urlParts['path'], '.zip');
    $xmlFile = $baseFile.'.xml';
    echo "Getting {$url}\n";
    echo `wget "{$url}" -O "{$zipFile}";`;
    if (!file_exists($zipFile)) {
        die("Error Loading {$url}\n");
    }
    echo `7z x "{$zipFile}";`;
    @unlink($zipFile);
    if (!file_exists($xmlFile)) {
        die("Error Loading {$url}\n");
    }
    echo "Converting {$xmlFile} to array\n";
    $xml = xml2array(file_get_contents($xmlFile), true);
    unlink($xmlFile);
    echo "Writing {$baseFile}.json\n";
    file_put_contents($dataDir.'/'.$baseFile.'.json', json_encode($xml, getJsonOpts()));
}

//file_put_contents($dataDir.'/gametdb.json', json_encode($data, getJsonOpts()));
$sources = json_decode(file_get_contents(__DIR__.'/../../../../emurelation/sources.json'), true);
$sources['gametdb']['updatedLast'] = time();
file_put_contents(__DIR__.'/../../../../emurelation/sources.json', json_encode($sources, getJsonOpts()));
foreach ($source as $type => $data) {
    file_put_contents(__DIR__.'/../../../../emurelation/'.$type.'/gametdb.json', json_encode($data, getJsonOpts()));
}
