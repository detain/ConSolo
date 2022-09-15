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
$dataDir = __DIR__.'/../../../data/json';
if (!file_exists($dataDir))
    mkdir($dataDir, 0777, true);
$data = [
    'companies' => [],
    'platforms' => [],
];
$source = [
    'companies' => [],
    'platforms' => [],
];
$systemLists = [
    'tgdb',
    'screenscraper',
    'mobygames',
    'launchbox',
    'igdb',
    'hfsdb',
    'gametdb',
    'gamesdatabase',
    'bezels_project',
    'attractmode' => 'attractmode_association'
];
$baseDir = '/mnt/c/Users/joehu/AppData/Roaming/Nexouille Soft/arrm/Database/';
preg_match_all('/^(?P<id>[^#][^;]*);(?P<name>[^;]*);(?P<manufacturer>[^;]*);(?P<released>[^;]*);(?P<type>[^;]*);(?P<sort>\d+)$/muU', str_replace("\r\n", "\n", file_get_contents($baseDir.'/systems_sorting.txt')), $matches);
$arcadeSystems = explode(';', trim(str_replace("\r\n", "\n", file_get_contents($baseDir.'/arcade_systems_list.txt'))));
$daphneSystems = explode(';', trim(str_replace("\r\n", "\n", file_get_contents($baseDir.'/daphne_systems_list.txt'))));
foreach ($matches['id'] as $idx => $id) {
    $name = $matches['name'][$idx];
    $manufacturer = $matches['manufacturer'][$idx];
    $released = $matches['released'][$idx];
    $type = $matches['type'][$idx];
    $sort = $matches['sort'][$idx];
    if (!isset($data['companies'][$manufacturer])) {
        $data['companies'][$manufacturer] = [
            'id' => $manufacturer,
            'name' => $manufacturer
        ];
        $source['companies'][$manufacturer] = [
            'id' => $manufacturer,
            'name' => $manufacturer
        ];
    }
    $data['platforms'][$id] = [
        'id' => $id,
        'shortName' => $id,
        'name' => $name,
        'manufacturer' => $manufacturer,
        'released' => $released,
        'type' => $type,
        'arcade' => in_array($id, $arcadeSystems),
        'daphne' => in_array($id, $daphneSystems),
        'ext' => [],
        'matches' => [],
    ];
    $source['platforms'][$id] = [
        'id' => $id,
        'shortName' => $id,
        'name' => $name,
        'manufacturer' => $manufacturer,
        'matches' => [],
    ];

}
$sources = [];
foreach ($systemLists as $idx => $system) {
    if (!is_numeric($idx)) {
        $fileName = $system;
        $system = $idx;
    } else {
        $fileName = 'systemes_'.$system;
    }
    if (!isset($sources[$system])) {
        $sources[$system] = [
            'placeholder' => true,
            'platforms' => []
        ];
    }
    preg_match_all('/^(?P<local>[^\|]+)\|(?P<remote>.+)$/mU', str_replace("\r\n", "\n", file_get_contents($baseDir.'/'.$fileName.'.txt')), $matches);
    echo "System {$system} File {$fileName} found ".count($matches['local'])." Systems\n";
    foreach ($matches['local'] as $idx => $arrmId) {
        $id = $matches['remote'][$idx];
        $sources[$system]['platforms'][$id] = [
            'id' => $id
        ];
        if (isset($source['platforms'][$arrmId])) {
            if (!isset($source['platforms'][$arrmId]['matches'][$system])) {
                $data['platforms'][$arrmId]['matches'][$system] = [];
                $source['platforms'][$arrmId]['matches'][$system] = [];
            }
            $data['platforms'][$arrmId]['matches'][$system][] = $id;
            $source['platforms'][$arrmId]['matches'][$system][] = $id;
        } else {
            //echo "Not found {$arrmId}\n";
        }
    }
    $systemFile = __DIR__.'/../../../../emurelation/sources/'.$system.'.json';
    $writeSource = true;
    if (file_exists($systemFile)) {
        $json = json_decode(file_get_contents($systemFile), true);
        if (!isset($json['placeholder'])) {
            $writeSource = false;
        }
    }
    if ($writeSource === true) {
        echo "Writing placeholder {$system} json\n";
        file_put_contents(__DIR__.'/../../../../emurelation/sources/'.$system.'.json', json_encode($sources[$system], getJsonOpts()));
    }
}
preg_match_all('/^(?P<local>[^\|]+)\|(?P<remote>.+)$/mU', str_replace("\r\n", "\n", file_get_contents($baseDir.'/systemes_extensions.txt')), $matches);
foreach ($matches['local'] as $idx => $arrmId) {
    $extensions = explode(';', trim($matches['remote'][$idx]));
    if (isset($data['platforms'][$arrmId])) {
        $data['platforms'][$arrmId]['ext'] = $extensions;
    }
}
file_put_contents($dataDir.'/arrm.json', json_encode($data, getJsonOpts()));
$sources = json_decode(file_get_contents(__DIR__.'/../../../../emurelation/sources.json'), true);
$sources['arrm']['updatedLast'] = time();
file_put_contents(__DIR__.'/../../../../emurelation/sources.json', json_encode($sources, getJsonOpts()));
file_put_contents(__DIR__.'/../../../../emurelation/sources/arrm.json', json_encode($source, getJsonOpts()));
