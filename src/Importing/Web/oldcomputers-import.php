<?php

require_once __DIR__.'/../../bootstrap.php';
require_once __DIR__.'/../../Matching/emurelation.inc.php';

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
$allRepos = in_array('-a', $_SERVER['argv']) || in_array('--all', $_SERVER['argv']);
$skipDb = in_array('--no-db', $_SERVER['argv']);
$useCache = !in_array('--no-cache', $_SERVER['argv']);
$sources = loadSources(true);
$basePath = __DIR__.'/../../../../';
$missing = json_decode(file_get_contents($basePath.'emurelation/unmatched/emulators/oldcomputers.json'), true);
$json = json_decode(file_get_contents($basePath.'emulation-data/oldcomputers.json'), true);
$newRows = [];
foreach ($missing as $id) {
    $data = $json['emulators'][$id];
    if (!preg_match('/^([hft]+tp[s]?:\/\/)(www\.|)(?P<url>.*)\/?$/Uui', $data['web'][0]['url'], $matches))
        continue;
    $url = mb_strtolower($matches['url']);
    foreach ($sources['local']['emulators'] as $emuId => $emuData) {
        if (!isset($emuData['web']))
            continue;
        foreach ($emuData['web'] as $webUrl => $webType) {
            if (stripos($webUrl, $url) !== false) {
                echo "Matched ({$url}) '{$id}' to '{$emuId}'\n";
            }
        }
    }
    /*
    $cmd = 'grep -i '.escapeshellarg(str_replace(['.'], ['\\.'], $url)).' '.$basePath.'emurelation/emulators/* '.$basePath.'emulation-data/* | grep -v /oldcomputers.json';
    $out = str_replace($basePath, '', trim(`$cmd`));
    if ($out != '') {
        echo "🎮🕹 $id : $url\n$out\n";
    }
    */
    /*
    $row =[
        'id' => $id,
        'shortName' => $id,
        'name' => $id,
        'description' => $data['description'],
        'license' => $data['license'],
        'platforms' => [],
        'matches' => [
            'oldcomputers' => [
                $id
            ]
        ],
        'bin' => [],
        'web' => [],
        'versions' => [
        ],
        'eol' => false
    ];
    $row['web'][$data['homepage']] = strpos($data['homepage'], 'github.com') !== false || strpos($data['homepage'], 'gitlab.com') !== false ? 'repo' : 'home';
    $bits = 64;
    if (isset($data['architecture'])) {
        if (!isset($data['architecture']['64bit'])) {
            $data['url'] = $data['architecture']['32bit']['url'];
            if (isset($data['architecture']['32bit']['bin']))
                $data['bin'] = $data['architecture']['32bit']['bin'];
            $bits = 32;
        } else {
            $data['url'] = $data['architecture']['64bit']['url'];
            if (isset($data['architecture']['64bit']['bin']))
                $data['bin'] = $data['architecture']['64bit']['bin'];
        }
    }
    if (isset($data['bin'])) {
        if (!is_array($data['bin']))
            $data['bin'] = [$data['bin']];
        foreach ($data['bin'] as $idx => $bin) {
            $row['bin'][] = is_array($bin) ? $bin[0] : $bin;
        }
    }
    if (count($row['bin']) == 0)
        unset($row['bin']);
    $version = [
        'url' => $data['url'],
        'os' => 'Windows',
        'bits' => $bits,
        'date' => date('Y-m-d')
    ];
    $row['versions'][$data['version']] = $version;
    $sources['local']['emulators'][$id] = $row;
    $newRows[$id] = $row;
    echo "Added emu {$id}\n";
    */
}
//print_r($newRows);
//file_put_contents($basePath.'emurelation/emulators/local.json', json_encode($sources['local']['emulators'], getJsonOpts()));
