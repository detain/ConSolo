<?php

require_once __DIR__.'/../../bootstrap.php';

if (in_array('-h', $_SERVER['argv']) || in_array('--help', $_SERVER['argv'])) {
    die("Syntax:
    php ".$_SERVER['argv'][0]." <options>

Options:
    -h, --help  this screen
    -k          keep repo
    -f          force update even if already latest version
    --no-db     skip the db updates/inserts
    --no-cache  disables use of the file cache

");
}
/**
* @var \Workerman\MySQL\Connection
*/
global $db;
$keepRepo = in_array('-k', $_SERVER['argv']);
if (!file_exists(__DIR__.'/../../../data/json/recalbox'))
    mkdir(__DIR__.'/../../../data/json/recalbox', 0777, true);
$data = [
    'emulators' => [],
    'platforms' => [],
    'companies' => [],
];
$source = [
    'platforms' => [],
    'emulators' => [],
    'companies' => [],
];
gitSetup('https://gitlab.com/recalbox/recalbox', false);
$wikiLinks = [];
foreach (glob('recalbox/package/recalbox-romfs2/systems/*/system.ini') as $fileName) {
    echo "Loading ini {$fileName}\n";
    $ini = loadIni($fileName);
    $id = $ini['system']['name'];
    if (isset($ini['system']['doc.link.en']))
        $wikiLinks[] = $ini['system']['doc.link.en'];
    echo "  Adding Platform {$id}\n";
    $source['platforms'][$id] = [
        'id' => $id,
        'shortName' => $id,
        'name' => $ini['system']['fullname'],
        'matches' => [],
    ];
    if (isset($ini['system']['screenscraper.id'])) {
        $source['platforms'][$id]['matches'] = [
            'screenscraper' => [
                $ini['system']['screenscraper.id']
            ]
        ];
    }
    if (isset($ini['properties']['manufacturer'])) {
        $source['platforms'][$id]['manufacturer'] = $ini['properties']['manufacturer'];
        if (!array_key_exists($ini['properties']['manufacturer'], $source['companies'])) {
            echo "      Adding Company {$id}\n";
            $source['companies'][$ini['properties']['manufacturer']] = [
                'id' => $ini['properties']['manufacturer'],
                'name' => $ini['properties']['manufacturer'],
            ];
        }
    }
    for ($x = 0; isset($ini['core.'.$x]); $x++) {
        $emuData = $ini['core.'.$x];
        $emuId = $emuData['emulator'];
        $emuName = $emuData['emulator'];
        if (isset($emuData['core']) && $emuData['core'] != $emuData['emulator']) {
            $emuId .= '_'.$emuData['core'];
            $emuName .= ' '.$emuData['core'];
        }
        $emuName = ucwords($emuName);
        if (!array_key_exists($emuId, $source['emulators'])) {
            echo "      Adding Emulator {$emuId}\n";
            $source['emulators'][$emuId] = [
                'id' => $emuId,
                'name' => $emuName,
                'platforms' => [],
            ];
        }
        echo "          Adding Platform {$id} to Emulator {$emuId}\n";
        $source['emulators'][$emuId]['platforms'][] = $id;
    }
}
if (!$keepRepo) {
    echo "Removing recalbox\n";
    echo `rm -rf recalbox`;
    echo "done\n";
}
echo "Writing sources/recalbox.json\n";
file_put_contents(__DIR__.'/../../../../emurelation/sources/recalbox.json', json_encode($source, getJsonOpts()));
echo "Reading sources.json\n";
$sources = json_decode(file_get_contents(__DIR__.'/../../../../emurelation/sources.json'), true);
$sources['recalbox']['updatedLast'] = time();
echo "Writing sources.json\n";
file_put_contents(__DIR__.'/../../../../emurelation/sources.json', json_encode($sources, getJsonOpts()));
echo "Writing recalbox.json\n";
$data = $source;
file_put_contents(__DIR__.'/../../../data/json/recalbox/recalbox.json', json_encode($data, getJsonOpts()));
echo "done\n";