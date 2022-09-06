<?php

require_once __DIR__.'/../../../bootstrap.php';

/**
* @var \Workerman\MySQL\Connection
*/
global $db;
$dataDir = __DIR__.'/../../../../data/json/retrobat';
if (!file_exists($dataDir))
    mkdir($dataDir, 0777, true);
$data = [
    'emulators' => [],
    'platforms' => [],
];
$source = [
    'platforms' => [],
    'emulators' => []
];
gitSetup('emuDownloadCenter');

//
$xml = xml2array(file_get_contents('system/templates/emulationstation/es_systems_retrobat.cfg'));
//echo `rm -rf retrobat`;
foreach ($xml['systemList']['system'] as $system) {
    $source['platforms'][$system['name']] = [
        'id' => $system['name'],
        'shortName' => $system['name'],
        'name' => $system['fullname'],
        'altNames' => []
    ];
    unset($system['path']);
    unset($system['platform']);
    unset($system['theme']);
    $system['emulators'] = [];
    //echo json_encode($system, getJsonOpts())."\n";
    if (is_array($system['command'])) {
        for ($x = 0; isset($system['command'][$x]); $x++) {
            if (strpos($system['command'][$x], 'EMULATOR_RETROARCH') !== false) {
                $label = 'RetroArch'.(isset($system['command'][$x.'_attr']) ? ' ('.$system['command'][$x.'_attr']['label'].')' : '');
            } elseif (isset($system['command'][$x.'_attr'])) {
                $label = $system['command'][$x.'_attr']['label'];
            } else {
                continue;
            }
            if (preg_match('/ \(Standalone\)/', $label, $matches)) {
                $label = str_replace(' (Standalone)', '', $label);
            }
            $data['emulators'][$label] = $system['command'][$x];
            $system['emulators'][$label] = $system['command'][$x];
            if (!isset($source['emulators'][$label])) {
                $source['emulators'][$label] = [
                    'id' => $label,
                    'name' => $label,
                    'platforms' => []
                ];
            }
            $source['emulators'][$label]['platforms'][] = $system['name'];
        }
    } else {
        if (strpos($system['command'], 'EMULATOR_RETROARCH') !== false || isset($system['command_attr'])) {
            if (strpos($system['command'], 'EMULATOR_RETROARCH') !== false) {
                if (isset($system['command_attr'])) {
                    $label = 'RetroArch ('.$system['command_attr']['label'].')';
                    unset($system['command_attr']);
                } else {
                    $label = 'RetroArch';
                }
                $system['emulators'][$label] = $system['command'];
            } elseif (isset($system['command_attr'])) {
                $label = $system['command_attr']['label'];
                if (preg_match('/ \(Standalone\)/', $label, $matches)) {
                    $label = str_replace(' (Standalone)', '', $label);
                }
            }
            $data['emulators'][$label] = $system['command'];
            $system['emulators'][$label] = $system['command'];
            unset($system['command_attr']);
            if (!isset($source['emulators'][$label])) {
                $source['emulators'][$label] = [
                    'id' => $label,
                    'name' => $label,
                    'platforms' => []
                ];
            }
            $source['emulators'][$label]['platforms'][] = $system['name'];
        }
    }
    unset($system['command']);
    $data['platforms'][$system['name']] = $system;
}
ksort($data['emulators']);
file_put_contents($dataDir.'/esde.json', json_encode($data, getJsonOpts()));
$sources = json_decode(file_get_contents(__DIR__.'/../../../../emurelation/sources.json'), true);
$sources['retrobat']['updatedLast'] = time();
file_put_contents(__DIR__.'/../../../../emurelation/sources.json', json_encode($sources, getJsonOpts()));
file_put_contents(__DIR__.'/../../../../emurelation/sources/retrobat.json', json_encode($source, getJsonOpts()));
