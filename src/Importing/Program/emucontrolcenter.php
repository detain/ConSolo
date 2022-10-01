<?php

require_once __DIR__.'/../../bootstrap.php';

if (in_array('-h', $_SERVER['argv']) || in_array('--help', $_SERVER['argv'])) {
    die("Syntax:
    php ".$_SERVER['argv'][0]." <options>

Options:
    -h, --help      this screen
    -f, --force     force update even if already latest version
    -a, --all       download all related repos
    -k, --keep      keep the repos
    --no-db         skip the db updates/inserts
    --no-cache      disables use of the file cache

");
}
/**
* @var \Workerman\MySQL\Connection
*/
global $db;
$force = in_array('-f', $_SERVER['argv']) || in_array('--force', $_SERVER['argv']);
$keep = in_array('-k', $_SERVER['argv']) || in_array('--keep', $_SERVER['argv']);
$useAllRepos = in_array('-a', $_SERVER['argv']) || in_array('--all', $_SERVER['argv']);
$skipDb = in_array('--no-db', $_SERVER['argv']);
$useCache = !in_array('--no-cache', $_SERVER['argv']);
$repos = ['emuDownloadCenter', 'emuDownloadCenter.wiki', 'emuControlCenter', 'ecc-datfiles'];
$data = [
    'platforms' => [],
    'companies' => [],
    'emulators' => [],
    'games' => [],
    'countries' => [],
    'languages' => [],
];
$source = [
    'platforms' => [],
    'companies' => [],
    'emulators' => [],
    'games' => [],
];
$gameFields = ['name', 'extension', 'crc32', 'running', 'bugs', 'trainer', 'intro', 'usermod', 'freeware', 'multiplayer', 'netplay',
    'year', 'usk', 'category', 'languages', 'creator', 'hardware', 'doublettes', 'info', 'info_id', 'publisher', 'storage', 'filesize',
    'programmer', 'musican', 'graphics', 'media_type', 'media_current', 'media_count', 'region', 'category_base', 'dump_type'];
$gameBools = ['running', 'bugs', 'intro', 'usermod', 'freeware', 'netplay'];
$gameInts = ['trainer', 'multiplayer', 'category', 'storage', 'media_type', 'dump_type', 'media_count', 'media_current', 'filesize', 'usk'];
$allRepos = ['emuControlCenter', 'emuDownloadCenter', 'emuControlCenter.wiki', 'emuDownloadCenter.wiki', 'ecc-datfiles', 'ecc-toolsused', 'ecc-updates',
    'edc-repo0001', 'edc-repo0002', 'edc-repo0003', 'edc-repo0004', 'edc-repo0005', 'edc-repo0006', 'edc-repo0007', 'edc-repo0008', 'edc-repo0009'];
if ($useAllRepos === true) {
    foreach ($allRepos as $repo) {
        gitSetup('https://github.com/PhoenixInteractiveNL/'.$repo);
    }
}
gitSetup('https://github.com/PhoenixInteractiveNL/ecc-datfiles');
echo "Exctracting Game DAT Files\n";
foreach (glob('ecc-datfiles/*.7z') as $fileName) {
    echo `7z x -aoa -oecc-datfiles {$fileName};`;
}
echo "Loading Game DAT Files\n";
foreach (glob('ecc-datfiles/*.eccDat') as $fileName) {
    echo "  Loading and parsing {$fileName}...";
    echo `iconv -f ISO-8859-14 -t UTF-8 "{$fileName}" -o "{$fileName}_new" || rm -fv "{$fileName}_new" && mv -fv "{$fileName}_new" "{$fileName}";`;
    echo `dos2unix "{$fileName}";`;
    if (!preg_match_all('/^(?P<eccident>[^;\s]*);(?P<name>[^;]*);(?P<extension>[^;]*);(?P<crc32>[^;]*);(?P<running>[^;]*);(?P<bugs>[^;]*);(?P<trainer>[^;]*);(?P<intro>[^;]*);(?P<usermod>[^;]*);(?P<freeware>[^;]*);(?P<multiplayer>[^;]*);(?P<netplay>[^;]*);(?P<year>[^;]*);(?P<usk>[^;]*);(?P<category>[^;]*);(?P<languages>[^;]*);(?P<creator>[^;]*);(?P<hardware>[^;]*);(?P<doublettes>[^;]*);(?P<info>[^;]*);(?P<info_id>[^;]*);(?P<publisher>[^;]*);(?P<storage>[^;]*);(?P<filesize>[^;]*);(?P<programmer>[^;]*);(?P<musican>[^;]*);(?P<graphics>[^;]*);(?P<media_type>[^;]*);(?P<media_current>[^;]*);(?P<media_count>[^;]*);(?P<region>[^;]*);(?P<category_base>[^;]*);(?P<dump_type>[^;]*);#$/mu', file_get_contents($fileName), $matches)) {
        echo "Couldnt find matches in {$fileName}\n";
    } else {
        echo count($matches['eccident'])." matches found\n";
        foreach ($matches['eccident'] as $idx => $platId) {
            if ($platId == 'eccident') {
                continue;
            }
            $gameId = $platId.'_'.$idx;
            $game = [
                'id' => $gameId,
                'platform' => $platId,
            ];
            foreach ($gameFields as $field) {
                if (isset($matches[$field][$idx]) && $matches[$field][$idx] != '') {
                    $game[$field] = $matches[$field][$idx];
                    if (in_array($field, $gameBools)) {
                        $game[$field] = $game[$field] == "1";
                    } elseif (in_array($field, $gameInts)) {
                        $game[$field] = intval($game[$field]);
                    }
                }
            }
            if (isset($game['languages'])) {
                $game['languages'] = explode('|', $game['languages']);
            }
            $data['games'][$gameId] = $game;
            $source['games'][$gameId] = [
                'id' => $gameId,
                'name' => $game['name'],
                'platform' => $game['platform']
            ];
        }
    }
    @unlink($fileName);
}
gitSetup('https://github.com/PhoenixInteractiveNL/emuDownloadCenter');
echo "Loading Language/Countriy Data..\n";
foreach (($ini = loadIni('emuDownloadCenter/edc_conversion_language.ini'))['COUNTRY'] as $id => $value)
    $data['countries'][$id] = $value;
foreach ($ini['LANGUAGE'] as $id => $value)
    $data['languages'][$id] = $value;
echo "Loading Platform Ids..\n";
foreach (($ini = loadIni('emuDownloadCenter/ecc_platform_id.ini'))['ECCID'] as $id => $value)
    $data['platforms'][(string)$id] = ['id' => (string)$id, 'name' => $value, 'category' => null];
echo "Loading Platform Categories..\n";
foreach (($ini = loadIni('emuDownloadCenter/ecc_platform_categories.ini'))['ECCID'] as $id => $value)
    $data['platforms'][$id]['category'] = $value;
gitSetup('https://github.com/PhoenixInteractiveNL/emuDownloadCenter.wiki');
gitSetup('https://github.com/PhoenixInteractiveNL/emuControlCenter');
echo "Loading Platforms...\n";
foreach ($data['platforms'] as $id => $platform) {
    echo "  Platform {$id}....";
    // import info system user ecc  and iamges
    foreach (['info', 'system', 'user'] as $type) {
        echo ' ('.$type.' ini)';
        foreach (glob('emuControlCenter/ecc-system/system/ecc_'.$id.'_'.$type.'.ini') as $imagePath) {
            $ini = $type == 'system' ? loadIni($imagePath) : loadQuotedIni($imagePath);
            foreach ($ini as $section => $value) {
                $section = camelSnake($section);
                if ($type == 'user' && $section == 'platform')
                    continue;
                if ($type == 'info' && $section == 'resources') {
                    if (isset($value['web']))
                        $data['platforms'][$id]['web'] = $value['web'] == '' ? [] : explode("\n", $value['web']);
                    continue;
                }
                if ($type == 'info' && $section == 'general') {
                    //if ($value['type'] != $data['platforms'][$id]['category'])
                        //echo "\nCategory {$value['type']} != {$data['platforms'][$id]['category']}\n";
                    unset($value['type']);
                    foreach ($value as $subKey => $subValue)
                        $data['platforms'][$id][$subKey] = $subValue;
                    continue;
                }
                if (!array_key_exists($type, $data['platforms'][$id]))
                    $data['platforms'][$id][$type] = [];
                $data['platforms'][$id][$type][$section] = $value;
            }
        }
    }
    echo " (images)";
    $data['platforms'][$id]['emulators'] = [];
    $data['platforms'][$id]['images'] = [];
    foreach (glob('emuDownloadCenter.wiki/images_platform/ecc_'.$id.'_*') as $imagePath)
        $data['platforms'][$id]['images'][] = $imagePath;
    foreach (glob('emuControlCenter/ecc-system/images/platform/ecc_'.$id.'_*') as $imagePath)
        $data['platforms'][$id]['images'][] = $imagePath;
    echo "\n";
}
echo "Loading Platform <=> emulator matchups..\n";
foreach ($ini = loadIni('emuDownloadCenter/ecc_platform_emulators.ini') as $id => $value)
    $data['platforms'][$id]['emulators'] = array_keys($value);
echo "Loading Emulators...\n";
foreach (($ini = loadIni('emuDownloadCenter/ecc_emulators_id.ini'))['EMUID'] as $id => $value)
    $data['emulators'][(string)$id] = ['id' => (string)$id, 'name' => $value];
foreach ($data['emulators'] as $id => $emulator) {
    echo "  Emulator {$id}....";
    $ini = loadIni('emuDownloadCenter/hooks/'.$id.'/emulator_info.ini');
    foreach (['INFO', 'EMULATOR'] as $section) {
        echo ' ('.$section.' ini)';
        foreach ($ini[$section] as $pascalCase => $value) {
            if ($pascalCase == 'InfoVersion')
                continue;
            $snakeCase = camelSnake($pascalCase);
            if ($snakeCase == 'contact')
                $value = str_replace(['#', '*'], ['@', '.'], $value);
            $emulator[$snakeCase] = $value;
        }
    }
    echo ' (images)';
    $emulator['images'] = [];
    foreach (['png', 'jpg'] as $ext)
        foreach (glob('emuDownloadCenter/hooks/'.$id.'/*.'.$ext) as $imagePath) {
            $emulator['images'][] = $imagePath;
            if (basename($imagePath, '.'.$ext) == 'emulator_logo') {
                $emulator['logo'] = $imagePath; // $id.'.'.$ext;
            } elseif (basename($imagePath, '.'.$ext) == 'emulator_screen_01') {
                $emulator['screenshot'] = $imagePath; // $id.'.'.$ext;
            }
        }
    foreach (glob('emuDownloadCenter.wiki/images_emulator/'.$id.'_*') as $imagePath)
        $emulator['images'][] = $imagePath;
    echo ' (frontend)';
    $emulator['frontend'] = loadIni('emuDownloadCenter/hooks/'.$id.'/configs_frontend_ecc.ini');
    if (isset($emulator['frontend']['GLOBAL'])) {
        $emulator['frontend']['global'] = $emulator['frontend']['GLOBAL'];
        unset($emulator['frontend']['GLOBAL']);
    }
    echo ' (downloads)';
    $emulator['downloads'] = loadIni('emuDownloadCenter/hooks/'.$id.'/emulator_downloads.ini');
    $emulator['platforms'] = trim($emulator['platform']) == '' ? [] : explode(',',  $emulator['platform']);
    unset($emulator['platform']);
    unset($emulator['downloads']['INFO']);
    $emulator['bin'] = [$emulator['downloads'][array_keys($emulator['downloads'])[0]]['EMU_ExecutableFile']];
    $emulator['versions'] = [];
    foreach ($emulator['downloads'] as $version => $dl) {
        if (isset($dl['FILE_ContentType']) && $dl['FILE_ContentType'] == 'Source')
            continue;
        $emulator['versions'][$version] = [];
        foreach ($dl as $field => $value) {
            $field = strtolower(substr(str_replace('__', '_', preg_replace('/([A-Z]+)/', '_$1', str_replace('OS', 'Os', preg_replace('/^(FILE_Content|EMU_|INFO_)(.*)$/', '$2', $field)))), 1));
            $emulator['versions'][$version][$field] = $value;
        }
    }
    unset($emulator['downloads']);
    $emulator['cmd'] = ['%BIN% '.$emulator['frontend']['global']['CFG_param']];
    if (trim($emulator['website']) != '') {
        $emulator['web'] = [trim($emulator['website']) => strpos($emulator['website'], 'github.com') !== false ? 'repo' : 'home'];
    }
    if (isset($emulator['notes'])) {
        $emulator['description'] = $emulator['notes'];
        unset($emulator['notes']);
    }
    unset($emulator['website']);
    unset($emulator['frontend']['INFO']);
    $data['emulators'][$id] = $emulator;
    echo "\n";
}
echo "Loading misc Images..\n";
$data['misc_images'] = glob('emuDownloadCenter.wiki/images_misc/*');
echo "Writing JSON...\n";
file_put_contents(__DIR__.'/../../../../emulation-data/emucontrolcenter.json', json_encode($data, getJsonOpts()));
/*
foreach ($data as $key => $value) {
    file_put_contents(__DIR__.'/../../../data/json/'.$key.'.json', json_encode($value, getJsonOpts()));
    if (in_array($key, ['emulators', 'platforms']))
        foreach ($value as $subKey => $subValue) {
            if (!file_exists(__DIR__.'/../../../data/json/'.$key))
                mkdir(__DIR__.'/../../../data/json/'.$key);
                file_put_contents(__DIR__.'/../../../data/json/'.$key.'/'.$subKey.'.json', json_encode($subValue, getJsonOpts()));
        }
}
*/
if ($keep !== true) {
    echo "Cleaning up repos..\n";
    if ($useAllRepos === true) {
        foreach ($allRepos as $repo) {
            echo `rm -rf {$repo};`;
        }
    } else {
        foreach ($repos as $repo) {
            echo `rm -rf {$repo};`;
        }
    }
}
foreach ($data['emulators'] as $idx => $emuData) {
    $source['emulators'][$emuData['id']] = [
        'id' => $emuData['id'],
        'name' => $emuData['name'],
        'shortName' => $emuData['id'],
        'platforms' => []
    ];
    /*
    foreach (['logo', 'screenshot'] as $field) {
        if (isset($emuData[$field])) {
            $source['emulators'][$emuData['id']][$field] = $emuData[$field];
        }
    }
    */
}
foreach ($data['platforms'] as $idx => $platData) {
    $source['platforms'][$platData['id']] = [
        'id' => $platData['id'],
        'name' => $platData['name'],
        'shortName' => $platData['id'],
    ];
    if (isset($platData['manufacturer']) && !in_array($platData['manufacturer'], ['-', '----------'])) {
        $source['platforms'][$platData['id']]['manufacturer'] = $platData['manufacturer'];
        $source['companies'][$platData['manufacturer']] = [
            'id' => $platData['manufacturer'],
            'name' => $platData['manufacturer']
        ];
        $data['companies'][$platData['manufacturer']] = $source['companies'][$platData['manufacturer']];
    }
    if (isset($platData['emulators'])) {
        foreach ($platData['emulators'] as $emulator) {
            $source['emulators'][$emulator]['platforms'][] = $platData['id'];
        }
    }
}
$sources = json_decode(file_get_contents(__DIR__.'/../../../../emurelation/sources.json'), true);
$sources['emucontrolcenter']['updatedLast'] = time();
file_put_contents(__DIR__.'/../../../../emurelation/sources.json', json_encode($sources, getJsonOpts()));
foreach ($source as $type => $data) {
    file_put_contents(__DIR__.'/../../../../emurelation/'.$type.'/emucontrolcenter.json', json_encode($data, getJsonOpts()));
}
