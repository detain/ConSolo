<?php

require_once __DIR__.'/../bootstrap.php';
require_once __DIR__.'/emurelation.inc.php';

/**
* @var \Workerman\MySQL\Connection
*/
global $db, $mysqlLinkId;
$source = loadSourceId('local', true);
$commentFields = ['name', 'author', 'cmd', 'logo', 'screenshot', 'screenshots'];
// loop through emulators to find emulators with enough data to generate a scoop app
foreach ($source['emulators'] as $emuId => $emuData) {
    // skip emulators that have 'parent' set
    if (isset($emuData['parent']))
        continue;
    // skip emulators without downloadable versions
    if (!isset($emuData['versions']))
        continue;
    // skip emulators already setup in scoop
    if (isset($emuData['matches']) && isset($emuData['matches']['scoop-emulators']))
        continue;
    // find versions to add
    foreach ($emuData['versions'] as $emuVer => $verData) {
        // skip versions with no os set (usually source)
        if (!isset($verData['os']))
            continue;
        // skip versions that are not for Windows or DOS
        if (!in_array($verData['os'], ['Windows', 'DOS']))
            continue;
        // skip emulators that have neither an emulator bin nor a version bin set
        if (!isset($emuData['bin']) && !isset($verData['bin']))
            continue;
        $bin = isset($emuData['bin']) ? $emuData['bin'] : $verData['bin'];
        //echo "Emu '{$emuId}' Ver '{$emuVer}' Os '{$verData['os']}'\n";
        $homePage = '';
        $license = 'Unknown';
        $description = '';
        if (isset($emuData['description']))
            $description =  $emuData['description'];
        if (isset($emuData['shortDesc']))
            $description =  $emuData['shortDesc'];
        if (isset($emuData['web'])) {
            foreach ($emuData['web'] as $webUrl => $webType) {
                if ($homePage == '' || $webType == 'home') {
                    $homePage = $webUrl;
                }
            }
        }
        if (isset($emuData['license'])) {
            $license= $emuData['license'];
        }
        $comments = [];
        foreach ($commentFields as $field) {
            if (isset($emuData[$field])) {
                $comments[] = $field.':'.(is_array($emuData[$field]) ? implode(',', $emuData[$field]) : $emuData[$field]);
            }
        }
        $localFile = str_replace('https://consolo.is.cc/', __DIR__.'/../../public/', $verData['url']);
        $sha256sum = substr(trim(`sha256sum "{$localFile}"`), 0, 65);
        $scoop = [
            '##' => $comments,
            'version' => $emuVer,
            'description' => $description,
            'homepage' => $homePage,
            'license' => $license,
            'url' => $verData['url'],
            'hash' => $sha256sum,
            'bin' => $bin
        ];
        echo "I wanted to create scoop app for {$emuId}: ".json_encode($scoop, getJsonOpts())."\n";
        file_put_contents(__DIR__.'/../../../scoop-emulators/bucket/'.$emuId.'.json', json_encode($scoop, getJsonOpts()));
        $source['emulators'][$emuId]['matches']['scoop-emulators'][] = $emuId;
        break;
    }
}
/*{
    "version": "1.56.2625",
    "description": "An assembler for the legendary 6502 processor and it's derivatives ",
    "homepage": "https://sourceforge.net/projects/tass64/",
    "license": {
        "identifier": "GPLv2"
    },
    "url": "https://sourceforge.net/projects/tass64/files/binaries/64tass-1.56.2625.zip/download#/64tass.zip",
    "hash": "cc2029f0f3f11901863729ec62f6506ceba68fae3f43aba9db5926453e07d264",
    "extract_dir": "64tass-1.56.2625",
    "bin": "64tass.exe",
    "checkver": {
        "url": "https://sourceforge.net/projects/tass64/rss?path=/binaries",
        "re": "64tass-(.*)\\.zip"
    },
    "autoupdate": {
        "url": "https://sourceforge.net/projects/tass64/files/binaries/64tass-$version.zip/download#/64tass.zip",
        "extract_dir": "64tass-$version"
    }
}*/
file_put_contents(__DIR__.'/../../../emurelation/emulators/local.json', json_encode($source['emulators'], getJsonOpts()));
