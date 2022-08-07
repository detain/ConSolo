<?php

function loadRegularIni($fileName) {
    sanitizeEncoding($fileName);
    $ini = parse_ini_string($fileName, true, INI_SCANNER_RAW);
    return $ini;
}

function loadQuotedIni($fileName) {
    sanitizeEncoding($fileName);
    $ini = [];
    $fileStr = file_get_contents($fileName);
    preg_match_all('/^\[(?P<section>[^\]]+)\]$\n(?P<settings>(^[^\[].*$\n)*)/mu', $fileStr, $matches);
    foreach ($matches['section'] as $idx => $section) {
        $settings = $matches['settings'][$idx];
        $ini[$section]  = [];
        if (trim($settings) != '') {
            preg_match_all('/^(?P<field>\w+)\s*=\s*"(?P<value>.*)"$/msuU', $settings, $fieldMatches);
            foreach ($fieldMatches['field'] as $fieldIdx => $field) {
                $value = $fieldMatches['value'][$fieldIdx];
                $ini[$section][$field] = trim($value);
            }
        }
    }
    return $ini;
}

function loadIni($fileName) {
    sanitizeEncoding($fileName);
    $iniStr = file_get_contents($fileName);
    $iniArr = explode("\n", $iniStr);
    $ini = []; // to hold the categories, and within them the entries
    $last = '';
    foreach ($iniArr as $i) {
        if (@preg_match('/\[(.+)\]/', $i, $matches)) {
            $last = stripQuotes(trim($matches[1]));
        } elseif (@preg_match('/^([^;=][^=]+)=(.*)$/', $i, $matches)) {
            $key = stripQuotes(trim($matches[1]));
            if (strlen($key)>0) {
                $val=stripQuotes(trim($matches[2]));
                if (strlen($last) > 0) {
                    $ini[$last][$key] = trim($val);
                } else {
                    $ini[$key] = trim($val);
                }
            }
        }
    }
    return $ini;
}

function sanitizeEncoding($iniFile) {
    // check for  ISO or Non-ISO text and convert to utf8
    if (strpos(`file {$iniFile}`, 'ISO') !== false) {
        echo "Fixing {$iniFile} encoding\n";
        `iconv -f ISO-8859-14 -t UTF-8 {$iniFile} -o {$iniFile}_new || rm -fv {$iniFile}_new && mv -fv {$iniFile}_new {$iniFile}`;
    }
}

function stripQuotes($text) {
    return preg_replace('/^(\'(.*)\'|"(.*)")$/', '$2$3', $text);
}

function camelSnake($input) {
    preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
    $ret = $matches[0];
    foreach ($ret as &$match)
        $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
    return implode('_', $ret);
}

$data = [
    'emulators' => [],
    'platforms' => [],
    'countries' => [],
    'languages' => [],
];
echo "Loading Language/Countriy Data..\n";
foreach (($ini = loadIni('emuDownloadCenter/edc_conversion_language.ini'))['COUNTRY'] as $id => $value)
    $data['countries'][$id] = $value;
foreach ($ini['LANGUAGE'] as $id => $value)
    $data['languages'][$id] = $value;
echo "Loading Platform Ids..\n";
foreach (($ini = loadIni('emuDownloadCenter/ecc_platform_id.ini'))['ECCID'] as $id => $value)
    $data['platforms'][(string)$id] = ['id' => (string)$id, 'name' => $value, 'category' => null, 'emulators' => [], 'images' => []];
echo "Loading Platform Categories..\n";
foreach (($ini = loadIni('emuDownloadCenter/ecc_platform_categories.ini'))['ECCID'] as $id => $value)
    $data['platforms'][$id]['category'] = $value;
echo "Loading Platform <=> emulator matchups..\n";
foreach ($ini = loadIni('emuDownloadCenter/ecc_platform_emulators.ini') as $id => $value)
    $data['platforms'][$id]['emulators'] = array_keys($value);
echo "Loading Platforms...\n";
foreach ($data['platforms'] as $id => $platform) {
    echo "  Platform {$id}....";
    echo " (images)";
    foreach (glob('emuDownloadCenter.wiki/images_platform/ecc_'.$id.'_*') as $imagePath)
        $data['platforms'][$id]['images'][] = $imagePath;
    foreach (glob('emuControlCenter/ecc-system/images/platform/ecc_'.$id.'_*') as $imagePath)
        $data['platforms'][$id]['images'][] = $imagePath;
    // import info system user ecc  and iamges
    foreach (['info', 'system', 'user'] as $type) {
        echo ' ('.$type.' ini)';
        $data['platforms'][$id][$type] = [];
        foreach (glob('emuControlCenter/ecc-system/system/ecc_'.$id.'_'.$type.'.ini') as $imagePath) {
            if ($type == 'system') {
                //$ini = loadRegularIni($imagePath);
                $ini = loadIni($imagePath);
            } else {
                $ini = loadQuotedIni($imagePath);
            }
            foreach ($ini as $section => $value) {
                $section = camelSnake($section);
                $data['platforms'][$id][$type][$section] = $value;
            }
        }
    }
    echo "\n";
}
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

$json = json_encode($data, JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE |  JSON_UNESCAPED_SLASHES);
if ($json === false) {
    echo json_last_error_msg().PHP_EOL;
    exit;
}
file_put_contents('emuControlCenter.json', $json);
