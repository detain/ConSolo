<?php

require_once __DIR__.'/../../bootstrap.php';

if (in_array('-h', $_SERVER['argv']) || in_array('--help', $_SERVER['argv'])) {
    die("Syntax:
    php ".$_SERVER['argv'][0]." <options>

Options:
    -h, --help  this screen
    -f          force update even if already latest version
    -k          keep git checkout dir
    --no-db     skip the db updates/inserts
    --no-cache  disables use of the file cache

");
}
/**
* @var \Workerman\MySQL\Connection
*/
global $db;
$dataDir = __DIR__.'/../../../data/json/emulationstation-de';
if (!file_exists($dataDir))
    mkdir($dataDir, 0777, true);
$force = in_array('-f', $_SERVER['argv']);
$skipDb = in_array('--no-db', $_SERVER['argv']);
$useCache = !in_array('--no-cache', $_SERVER['argv']);
$keep = in_array('-k', $_SERVER['argv']);
$data = [
    'emulators' => [],
    'platforms' => [],
];
$source = [
    'platforms' => [],
    'emulators' => []
];

gitSetup('https://gitlab.com/es-de/emulationstation-de.git');
$xml = xml2array(file_get_contents('emulationstation-de/resources/systems/windows/es_find_rules_portable.xml'), true, 'attribute');
$emuBins = [];
$stripPathOrig = '%ESPATH%\\Emulators\\';
//$stripPath = str_replace('\\', '/DIR/', $stripPathOrig);
//print_r($xml);exit;
foreach ($xml['ruleList']['emulator'] as $emu) {
    $name = $emu['attr']['name'];
    if (isset($emu['rule']['attr'])) {
        $emu['rule'] = [$emu['rule']];
    }
    //echo "Processing Name {$name}: ".print_r($emu,true)."\n";
    foreach ($emu['rule'] as $rule) {
        if (in_array($rule['attr']['type'], ['staticpath', 'systempath'])) {
            if (isset($rule['entry']['value'])) {
                $entry = $rule['entry'];
                $rule['entry'] = [];
                $rule['entry'][] = $entry;
            }
            foreach ($rule['entry'] as $entry) {
                if (!isset($entry['value'])) {
                    echo "missing value ".print_r($entry,true)."\n";
                }
                $entry = $entry['value'];
                //echo "Entry:{$entry['value']}\nStripPath:{$stripPathOrig}\n";
                if ($rule['attr']['type'] == 'systempath' || substr($entry, 0, strlen($stripPathOrig)) == $stripPathOrig) {
                    if ($rule['attr']['type'] != 'systempath') {
                        $entry = substr($entry, strlen($stripPathOrig));
                        //$entry = str_replace('\\', '/DIR/', $entry['value']);
                    }
                    //echo "Got here with {$entry} for {$name}\n";
                    if (!array_key_exists($name, $emuBins)) {
                        $emuBins[$name] = [
                            'dirs' => [],
                            'bins' => [],
                        ];
                    }
                    $bin = basename(str_replace('\\', '/', $entry));
                    if (!in_array($bin, $emuBins[$name]['bins'])) {
                        $emuBins[$name]['bins'][] = $bin;
                    }
                    if ($rule['attr']['type'] != 'systempath') {
                        $dir = explode('\\', $entry)[0];
                        if (!in_array($dir, $emuBins[$name]['dirs'])) {
                            $emuBins[$name]['dirs'][] = $dir;
                        }
                    }
                }
            }
        } else {
            //echo "Hiding: ".print_r($rule,true)."\n";
        }
    }
}
//print_r($emuBins);exit;
$xml = xml2array(file_get_contents('emulationstation-de/resources/systems/windows/es_systems.xml'));
if (!$keep) {
    echo `rm -rf emulationstation-de`;
}
foreach ($xml['systemList']['system'] as $system) {
    $source['platforms'][$system['name']] = [
        'id' => $system['name'],
        'shortName' => $system['name'],
        'name' => $system['fullname'],
        'altNames' => []
    ];
    if ($system['platform'] != $system['name']) {
        $system['parent'] = $system['platform'];
        if (strpos($system['parent'], ', ') !== false) {
            $system['parent'] = explode(', ', $system['parent'])[1];
        }
        $source['platforms'][$system['name']]['parent'] = $system['parent'];
    }

    unset($system['path']);
    unset($system['platform']);
    unset($system['theme']);
    $system['emulators'] = [];
    //echo json_encode($system, getJsonOpts())."\n";
    if (!is_array($system['command'])) {
        $command = $system['command'];
        $system['command'] = [0 => $command];
        if (isset($system['command_attr'])) {
            $system['command']['0_attr'] = ['label' => $system['command_attr']['label']];
            unset($system['command_attr']);
        }
    }
    if (is_array($system['command'])) {
        for ($x = 0; isset($system['command'][$x]); $x++) {
            $retroarch = false;
            $command = false;
            $label = false;
            if (strpos($system['command'][$x], 'EMULATOR_RETROARCH') !== false) {
                $retroarch = true;
                $label = 'RetroArch'.(isset($system['command'][$x.'_attr']) ? ' ('.$system['command'][$x.'_attr']['label'].')' : '');
            } elseif (isset($system['command'][$x.'_attr'])) {
                $label = $system['command'][$x.'_attr']['label'];
                if (preg_match('/ \(Standalone\)/', $label, $matches)) {
                    $label = str_replace(' (Standalone)', '', $label);
                }
            } else {
                //echo "Skipping {$system['name']} ".json_encode($system['command'][$x])."\n";
                //continue;
            }
            if (preg_match('/%EMULATOR_(?P<emulator>[^%]+)%/', $system['command'][$x], $matches)) {
                $system['command'][$x] = str_replace($matches[0], '%BIN%', $system['command'][$x]);
            } else {
                //echo "Couldnt find emulator match for {$label} in {$system['command'][$x]}\n";
                //continue;
            }
            if ($label) {
                if (strpos($label, 'ES-DE') !== false) {
                    //echo "Skipping {$system['name']} {$label} ".json_encode($system['command'][$x])."\n";
                    continue;
                }
                if (!array_key_exists($label, $data['emulators'])) {
                    $data['emulators'][$label] = [
                        'id' => $label,
                        'name' => $label,
                        'platforms' => [],
                        'dirs' => [],
                        'bins' => [],
                        'cmds' => [],
                    ];
                }
                if (!in_array($system['command'][$x], $data['emulators'][$label]['cmds'])) {
                    $data['emulators'][$label]['cmds'][] = $system['command'][$x];
                }
                if (!in_array($system['name'], $data['emulators'][$label]['platforms'])) {
                    $data['emulators'][$label]['platforms'][] = $system['name'];
                }
                foreach (['dirs', 'bins'] as $field) {
                    foreach ($emuBins[$matches['emulator']][$field] as $value) {
                        if (!in_array($value, $data['emulators'][$label][$field])) {
                            $data['emulators'][$label][$field][] = $value;
                        }
                    }
                }
                $system['emulators'][] = $label;
                if (!isset($source['emulators'][$label])) {
                    $source['emulators'][$label] = [
                        'id' => $label,
                        'name' => $label,
                        'platforms' => [],
                        'altNames' => []
                    ];
                }
                $source['emulators'][$label]['platforms'][] = $system['name'];
                if ($retroarch === true && !in_array(preg_replace('/^.*\\\\(.*)\.dll.*$/', '$1', $system['command'][$x]), $source['emulators'][$label]['altNames'])) {
                    $source['emulators'][$label]['altNames'][] = preg_replace('/^.*\\\\(.*)\.dll.*$/', '$1', $system['command'][$x]);
                }
            } else {
                //echo "Got here with {$system['name']} and no emulators\n";
                if ($system['command'][$x] != 'PLACEHOLDER %ROM%') {
                    $system['cmd'] = $system['command'][$x];
                }
            }
        }
    }
    unset($system['command']);
    $data['platforms'][$system['name']] = $system;
}
ksort($data['emulators']);
file_put_contents($dataDir.'/emulationstation-de.json', json_encode($data, getJsonOpts()));
$sources = json_decode(file_get_contents(__DIR__.'/../../../../emurelation/sources.json'), true);
$sources['emulationstation-de']['updatedLast'] = time();
file_put_contents(__DIR__.'/../../../../emurelation/sources.json', json_encode($sources, getJsonOpts()));
file_put_contents(__DIR__.'/../../../../emurelation/sources/emulationstation-de.json', json_encode($source, getJsonOpts()));
