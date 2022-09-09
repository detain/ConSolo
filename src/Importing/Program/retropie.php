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
if (!file_exists(__DIR__.'/../../../data/json/retropie'))
    mkdir(__DIR__.'/../../../data/json/retropie', 0777, true);
$data = [
    'emulators' => [],
    'platforms' => [],
];
$source = [
    'platforms' => [],
    'emulators' => []
];
gitSetup('https://github.com/RetroPie/RetroPie-Setup');
// RetroPie-Setup/platforms.cfg
$lines = loadIni('RetroPie-Setup/platforms.cfg');
foreach ($lines as $key => $value) {
    list($id, $field) = explode('_', $key);
    if ($field == 'fullname') {
        $field = 'name';
    } elseif ($field == 'exts') {
        $value = explode(' ', $value);
    } elseif ($field == 'platform' && $value != $id) {
        $source['platforms'][$value]['altNames'][] = $id;
        unset($source['platforms'][$id]);
    } elseif ($field == 'theme') {
        continue;
    }
    if (!array_key_exists($id, $data['platforms'])) {
        $data['platforms'][$id] = [
            'id' => $id,
            $field => $value
        ];
        $source['platforms'][$id] = [
            'id' => $id,
            'shortName' => $id,
            'name' => $id,
            'altNames' => [],
        ];
    }
    $source['platforms'][$id][$field] = $value;
}
foreach (['emulators', 'libretrocores'] as $section) {
    foreach (glob('RetroPie-Setup/scriptmodules/'.$section.'/*.sh') as $fileName) {
        $file = file_get_contents($fileName);
        $emulator = [];
        $emulator['platforms'] = [];
        preg_match_all('/(^rp_module_(?P<field>[a-z_]*)="(?P<value>.*)"$)+\n/msUu', $file, $matches);
        foreach ($matches['field'] as $idx => $key) {
            $value = $matches['value'][$idx];
            $emulator[$key] = $value;
        }
        preg_match_all('/(^\s*addSystem "(?P<platform>.*)"$)+\n/msUu', $file, $matches);
        foreach ($matches['platform'] as $idx => $platform) {
            echo "[{$emulator['id']}] Adding platform {$platform}\n";
            if ($platform == '$system') {
                echo "\$system plat!\n";
                if (preg_match('/for system in (.*); do/', $file, $systemMatches)) {
                    echo "[{$emulator['id']}] found system matches:".$systemMatches[1]."\n";
                    $platforms = explode(' ', trim(str_replace('"', '', $systemMatches[1])));
                    foreach ($platforms as $systemPlatform) {
                        echo "[{$emulator['id']}] Adding system platform {$systemPlatform}\n";
                        $emulator['platforms'][] = $systemPlatform;
                    }
                }
            } elseif ($platform == '$sys' && $emulator['id'] == 'lr-flycast') {
                $emulator['platforms'] = ['dreamcast', 'arcade'];
            } else {
                $emulator['platforms'][] = $platform;
            }
        }
        $data['emulators'][$emulator['id']] = $emulator;
        $source['emulators'][$emulator['id']] = [
            'id' => $emulator['id'],
            'shortName' => $emulator['id'],
            'name' => $emulator['desc'],
            'platforms' => $emulator['platforms'],
            'altNames' => []
        ];
        if ($section == 'libretrocores') {
            $source['emulators'][$emulator['id']]['altNames'][] = str_replace('-', '_', substr($emulator['id'], 3)).'_libretro';
        }
    }
}
echo `rm -rf RetroPie-Setup`;
file_put_contents(__DIR__.'/../../../data/json/retropie/retropie.json', json_encode($data, getJsonOpts()));
$sources = json_decode(file_get_contents(__DIR__.'/../../../../emurelation/sources.json'), true);
$sources['retropie']['updatedLast'] = time();
file_put_contents(__DIR__.'/../../../../emurelation/sources.json', json_encode($sources, getJsonOpts()));
file_put_contents(__DIR__.'/../../../../emurelation/sources/retropie.json', json_encode($source, getJsonOpts()));
