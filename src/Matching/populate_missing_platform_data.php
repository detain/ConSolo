<?php
include '/storage/ConSolo/src/bootstrap.php';
$matches = $db->query("select * from platform_matches where type in ('LaunchBox', 'TheGamesDB')");
$fields = [
    'LaunchBox' => [
        'ReleaseDate' => 'release_date',
        'Developer' => 'developer',
        'Manufacturer' => 'manufacturer',
        'Cpu' => 'cpu',
        'Memory' => 'memory',
        'Graphics' => 'graphics',
        'Sound' => 'sound',
        'Display' => 'display',
        'Media' => 'media',
        'MaxControllers' => 'maxcontrollers',
        'Notes' => 'notes',
    ],
    'TheGamesDB' => [
        'developer' => 'developer',
        'manufacturer' => 'manufacturer',
        'media' => 'media',
        'cpu' => 'cpu',
        'memory' => 'memory',
        'graphics' => 'graphics',                                                                                                                                                                                                                      
        'sound' => 'sound',
        'maxcontrollers' => 'maxcontrollers',
        'display' => 'display',
        'overview' => 'notes',
    ]
];
$tables = [
    'TheGamesDB' => 'tgdb_platforms',
    'LaunchBox' => 'launchbox_platforms',
];
foreach ($matches as $data) {
    $platformData = $db->query("select * from platforms where id={$data['platform_id']}");
    $platformData = $platformData[0];
    $updates = [];
    $name = str_replace('\'', '\\\'', $data['name']);
    $matchData = $db->query("select * from {$tables[$data['type']]} where Name='{$name}'");
    $matchData = $matchData[0];
    foreach ($fields[$data['type']] as $srcField => $destField) {
        if (is_null($platformData[$destField]) || $platformData[$destField] == '') {
            $updates[$destField] = $matchData[$srcField];
        }
    }
    if (count($updates) > 0) {
        $db->update('platforms')->cols(array_keys($updates))->where('id='.$data['platform_id'])->bindValues($updates)->query();
    }
}

