<?php

require_once __DIR__.'/../bootstrap.php';
require_once __DIR__.'/emurelation.inc.php';

/**
* @var \Workerman\MySQL\Connection
*/
global $db, $mysqlLinkId;
$sourceData = json_decode(file_get_contents(__DIR__.'/../../../emulation-data/emucontrolcenter.json'), true);
$localSource = loadSourceId('local', true);
$localPlatFromSource = [];
foreach ($localSource['platforms'] as $localPlatId => $localPlatData) {
    if (isset($localPlatData['matches']) && isset($localPlatData['matches']['emucontrolcenter'])) {
        $localPlatFromSource[$localPlatData['matches']['emucontrolcenter'][0]] = $localPlatId;
    }
}
$noChanges = ['altirra/2.90-test5', 'dapple2-emuii/0.27-source', 'dapple2-emuii/0.31', 'dapple2-emuii/0.31-source', 'demul/0.5.2-win32', 'demul/0.5.2-win64', 'dsvz200/20XX.XX.XX-installer', 'mz700win/0.2-source', 'prosystem/1.3-source', 'stella/3.4.1-win32'];
$missing = [];
foreach ($localSource['emulators'] as $localEmuId => $localEmuData) {
    if (isset($localEmuData['matches']) && isset($localEmuData['matches']['emucontrolcenter'])) {
        foreach ($localEmuData['matches']['emucontrolcenter'] as $sourceEmuId) {
            $sourceEmuData = $sourceData['emulators'][$sourceEmuId];
            foreach (['logo', 'screenshot', 'author', 'contact', 'license', 'bin', 'cmd', 'web', 'description'] as $field) {
                if (!isset($localSource['emulators'][$localEmuId][$field]) && isset($sourceEmuData[$field])
                && (
                    (is_array($sourceEmuData[$field]) && count($sourceEmuData[$field]) > 0)
                    || (!is_array($sourceEmuData[$field]) && trim($sourceEmuData[$field]) != '')
                )) {
                    $localSource['emulators'][$localEmuId][$field] = $sourceEmuData[$field];
                }
            }
            if (isset($sourceEmuData['versions'])) {
                foreach ($sourceEmuData['versions'] as $versionTag => $versionData) {
                    if (!isset($versionData['type']) || !in_array($versionData['type'], ['Program', 'Installer'])) // skip Extra and unset/null values
                        continue;
                    if (preg_match('/-installer$/', $versionTag) && isset($sourceEmuData['versions'][preg_replace('/-installer$/', '', $versionTag)])) // skip if same version non-installer exists
                        continue;
                    if ($versionData['category'] != 'Emulator') // skip Driver, Plugin, Tool, and unset/null values
                        continue;
                    if (isset($versionData['os']) && in_array($versionData['os'], ['Dos', 'Mac']))
                        $versionData['os'] = strtoupper($versionData['os']);
                    if (isset($versionData['os_version']))
                        $versionData['os_ver'] = str_replace([', XP', ', Vista', 'OSX', 'OS_X', 'OS X'], [',XP', ',Vista', 'OS-X', 'OS-X', 'OS-X'], $versionData['os_version']);
                    $version = [
                        'url' => 'https://consolo.is.cc/emu/'.$localEmuId.'/'.$versionTag.'.7z',
                        'bin' => (isset($versionData['executable_folder']) && $versionData['executable_folder'] != '' ? $versionData['executable_folder'] .'\\' : '').$versionData['executable_file'],
                    ];
                    $versionData['bits'] = isset($versionData['os_architecture']) && $versionData['os_architecture'] == 'x64' ? 64 : 32;
                    if ($versionData['release_date'] != '20??-??-??') {
                        $versionData['date'] = $versionData['release_date'];
                    }
                    if (!in_array($localEmuId.'/'.$versionTag, $noChanges)) {
                        $versionData['changes'] = 'https://consolo.is.cc/emu/'.$localEmuId.'/'.$versionTag.'_changelog.txt';
                    }
                    foreach (['os', 'os_ver', 'bits', 'date', 'changes', 'file_notes', 'notes'] as $field) {
                        if (isset($versionData[$field]) && $versionData[$field] != '') {
                            $version[$field] = $versionData[$field];
                        }
                    }
                    if (!isset($localSource['emulators'][$localEmuId]['versions']))
                        $localSource['emulators'][$localEmuId]['versions'] = [];
                    $localSource['emulators'][$localEmuId]['versions'][$versionTag] = $version;
                }
            }
            if (isset($sourceEmuData['platforms']) && count($sourceEmuData['platforms']) > 0) {
                if (!isset($localSource['emulators'][$localEmuId]['platforms'])) {
                    $localSource['emulators'][$localEmuId]['platforms'] = [];
                }
                foreach ($sourceEmuData['platforms'] as $sourcePlatId) {
                    if (isset($localPlatFromSource[$sourcePlatId])) {
                        if (!in_array($localPlatFromSource[$sourcePlatId], $localSource['emulators'][$localEmuId]['platforms'])) {
                            $localSource['emulators'][$localEmuId]['platforms'][] = $localPlatFromSource[$sourcePlatId];
                        }
                    } else {
                        if (!in_array($sourcePlatId, $missing)) {
                            $missing[] = $sourcePlatId;
                        }
                    }
                }
            }
        }
    }
}
echo "Missing Platforms: ".json_encode($missing)."\n";
file_put_contents(__DIR__.'/../../../emurelation/emulators/local.json', json_encode($localSource['emulators'], getJsonOpts()));
