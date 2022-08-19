<?php

require_once __DIR__.'/../../../bootstrap.php';

/**
* @var \Workerman\MySQL\Connection
*/
global $db;
$dataDir = __DIR__.'/../../../../data/json/emucontrolcenter';
if (!file_exists($dataDir))
    mkdir($dataDir, 0777, true);
// emuControlCenter emuControlCenter.wiki emuDownloadCenter emuDownloadCenter.wiki ecc-datfiles ecc-toolsused ecc-updates
// edc-repo0001 edc-repo0002 edc-repo0003 edc-repo0004 edc-repo0005 edc-repo0006 edc-repo0007 edc-repo0008 edc-repo0009
$repos = ['emuDownloadCenter', 'emuDownloadCenter.wiki', 'emuControlCenter'];
$data = [
    'emulators' => [],
    'platforms' => [],
    'countries' => [],
    'languages' => [],
];
gitSetup('emuDownloadCenter');
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
gitSetup('emuDownloadCenter.wiki');
gitSetup('emuControlCenter');
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
        foreach (glob('emuDownloadCenter/hooks/'.$id.'/*.'.$ext) as $imagePath)
            $emulator['images'][] = $imagePath;
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
    unset($emulator['downloads']['INFO']);
    unset($emulator['frontend']['INFO']);
    $data['emulators'][$id] = $emulator;
    echo "\n";
}
echo "Loading misc Images..\n";
$data['misc_images'] = glob('emuDownloadCenter.wiki/images_misc/*');
echo "Writing JSON...\n";
$jsonOpts = JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE |  JSON_UNESCAPED_SLASHES;
file_put_contents($dataDir.'/emucontrolcenter.json', json_encode($data, $jsonOpts));
foreach ($data as $key => $value) {
    file_put_contents($dataDir.'/'.$key.'.json', json_encode($value, $jsonOpts));
    if (in_array($key, ['emulators', 'platforms']))
        foreach ($value as $subKey => $subValue) {
            if (!file_exists($dataDir.'/'.$key))
                mkdir($dataDir.'/'.$key);
                file_put_contents($dataDir.'/'.$key.'/'.$subKey.'.json', json_encode($subValue, $jsonOpts));
        }
}
echo "Cleaning up repos..\n";
foreach ($repos as $repo)
    echo `rm -rf {$repo};`;
