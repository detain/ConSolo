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
$allRepos = in_array('-a', $_SERVER['argv']) || in_array('--all', $_SERVER['argv']);
$skipDb = in_array('--no-db', $_SERVER['argv']);
$useCache = !in_array('--no-cache', $_SERVER['argv']);
$data = [
    'emulators' => [],
];
$source = [
    'emulators' => [],
];
gitSetup('https://github.com/detain/scoop-emulators');
echo "Loading Game DAT Files\n";
foreach (glob('scoop-emulators/bucket/*.json') as $fileName) {
    echo "  {$fileName}...";
    $id = basename($fileName, '.json');
    $json = json_decode(file_get_contents($fileName), true);
    $data['emulators'][$id] = $json;
    $source['emulators'][$id] = [
        'id' => $id,
        'name' => $id,
    ];
}
echo "Writing JSON...\n";
if (!$keep) {
    echo "Cleaning up repo..\n";
    echo `rm -rf scoop-emulators;`;
}
$sources = json_decode(file_get_contents(__DIR__.'/../../../../emurelation/sources.json'), true);
$sources['scoop-emulators']['updatedLast'] = time();
file_put_contents(__DIR__.'/../../../../emurelation/sources.json', json_encode($sources, getJsonOpts()));
foreach ($source as $type => $data) {
    file_put_contents(__DIR__.'/../../../../emurelation/'.$type.'/scoop-emulators.json', json_encode($data, getJsonOpts()));
}
file_put_contents(__DIR__.'/../../../../emulation-data/scoop-emulators.json', json_encode($data, getJsonOpts()));
