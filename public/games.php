<?php
require_once __DIR__.'/../src/bootstrap.php';

/**
* @var \Workerman\MySQL\Connection
*/
global $db;
$results = $db->query("select * from config");
$sources = [];
$newSource = [
    'name' => '',
    'version' => '',
    'games' => 0,
    'roms' => 0,
    'platforms' => 0,
    'emulators' => 0,
];
$names = [
    'launchbox' => 'LaunchBox',
    'mame' => 'MAME',
    'tosec' => 'TOSEC',
];
foreach ($results as $data) {
    if ($data['key'] == 'launchbox') {
        $data['value'] = date('Y-m-d', $data['value']);
    } elseif ($data['key'] == 'mame') {
        $data['value'] = substr($data['value'], 0, 1).'.'.substr($data['value'], 1);
    } elseif ($data['key'] == 'tosec') {
        $data['value'] = substr($data['value'], 0, 4).'-'.substr($data['value'], 4, 2).'-'.substr($data['value'], 6, 2);
    }
    $source = $newSource;
    $source['name'] = array_key_exists($data['key'], $names) ? $names[$data['key']] : ucwords($data['key']);
    $source['version'] = $data['value'];
    $sources[$data['key']] = $source;
}
$sources['toseciso'] = $sources['tosec'];
$sources['toseciso']['name'] = 'TOSEC-ISO';
$sources['launchbox']['platforms'] = ($db->column("SELECT count(*) as count FROM launchbox_platforms"))[0];
$sources['launchbox']['games'] = ($db->column("SELECT count(*) FROM launchbox_games"))[0];
$sources['launchbox']['emulators'] = ($db->column("SELECT count(*) FROM launchbox_emulators"))[0];
$sources['mame']['games'] = ($db->column("SELECT count(*) FROM mame_software"))[0] + ($db->column("SELECT count(*) FROM mame_machines"))[0];
$sources['mame']['platforms'] = count($db->query("SELECT platform_description FROM mame_software GROUP BY platform_description")) + 1;
$sources['mame']['roms'] = ($db->column("SELECT count(*) FROM mame_software_roms"))[0] + ($db->column("SELECT count(*) FROM mame_machine_roms"))[0];
$sources['mame']['emulators'] = 1;
$sources['nointro']['platforms'] = ($db->column("SELECT count(*) FROM dat_files where type='No-Intro'"))[0];
$sources['tosec']['platforms'] = ($db->column("SELECT count(*) FROM dat_files where type='TOSEC'"))[0];
$sources['toseciso']['platforms'] = ($db->column("SELECT count(*) FROM dat_files where type='TOSEC-ISO'"))[0];
$sources['redump']['platforms'] = ($db->column("SELECT count(*) FROM dat_files where type='Redump'"))[0];
$sources['nointro']['games'] = ($db->column("SELECT count(*) FROM dat_files left join dat_games on dat_files.id=file where type='No-Intro' and dat_games.id is not null"))[0];
$sources['tosec']['games'] = ($db->column("SELECT count(*) FROM dat_files left join dat_games on dat_files.id=file where type='TOSEC' and dat_games.id is not null"))[0];
$sources['toseciso']['games'] = ($db->column("SELECT count(*) FROM dat_files left join dat_games on dat_files.id=file where type='TOSEC-ISO' and dat_games.id is not null"))[0];
$sources['redump']['games'] = ($db->column("SELECT count(*) FROM dat_files left join dat_games on dat_files.id=file where type='Redump' and dat_games.id is not null"))[0];
$sources['nointro']['roms'] = ($db->column("SELECT count(*) FROM dat_files left join dat_games on dat_files.id=file left join dat_roms on dat_games.id=game where type='No-Intro' and dat_games.id is not null and dat_roms.id is not null"))[0];
$sources['tosec']['roms'] = ($db->column("SELECT count(*) FROM dat_files left join dat_games on dat_files.id=file left join dat_roms on dat_games.id=game where type='TOSEC' and dat_games.id is not null and dat_roms.id is not null"))[0];
$sources['toseciso']['roms'] = ($db->column("SELECT count(*) FROM dat_files left join dat_games on dat_files.id=file left join dat_roms on dat_games.id=game where type='TOSEC-ISO' and dat_games.id is not null and dat_roms.id is not null"))[0];
$sources['redump']['roms'] = ($db->column("SELECT count(*) FROM dat_files left join dat_games on dat_files.id=file left join dat_roms on dat_games.id=game where type='Redump' and dat_games.id is not null and dat_roms.id is not null"))[0];
//echo '<pre style="text-align: left;">';print_r($versions);echo '</pre>';exit;  
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="Lang" content="en">
    <meta name="author" content="Joe Huss">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <title>ConSolo</title>
    <link rel="stylesheet" type="text/css" href="my.css">
    <link href="https://fonts.googleapis.com/css?family=Press+Start+2P" rel="stylesheet">
    <link href="https://unpkg.com/nes.css@latest/css/nes.min.css" rel="stylesheet" />
    <link href="https://nostalgic-css.github.io/NES.css/style.css" rel="stylesheet" />
    <link href="https://unpkg.com/dialog-polyfill@latest/dist/dialog-polyfill.css" rel="stylesheet" />
</head>
<body>
    <div style="height: 50px;">
        <i style="float: left; margin-left: 10px;" class="nes-logo"></i>
        <h1 style="float: left; margin-left: 10px;">ConSolo</h1>
        <i style="float: left; margin-left: 10px;" class="snes-logo"></i>
    </div>
    <br>
    <p>
        <a class="nes-btn is-success" href="index.html">About</a>
        <a class="nes-btn is-warning" href="status.php">Status</a>
        <a class="nes-btn is-error" href="match.php">Matches</a>
        <a class="nes-btn is-primary" href="emulators.php">Emulators</a>
        <a class="nes-btn is-default" href="platforms.php">Platforms</a>
        <a class="nes-btn is-disabled" href="games.php">Games</a>
        <a class="nes-btn is-primary" href="roms.php">ROMs</a>
        <a class="nes-btn is-error" href="https://nostalgic-css.github.io/NES.css/" target="_blank">Theme</a>
    </p>
    <br>    
    <section class="showcase">
        <section class="nes-container with-title">
            <h3 class="title">Status</h3>
            <h3>Data Sources</h3>
            <div class="nes-table-responsive">
                <table class="nes-table is-bordered is-centered">
                    <thead>
                        <tr>
                            <th>Source</th>
                            <th>Version</th>
                            <th>Platforms</th>
                            <th>Emulators</th>
                            <th>Games</th>
                            <th>ROMs</th>
                        </tr>
                    </thead>
                    <tbody>
<?php
foreach ($sources as $key => $data) {
    echo '
                        <tr>
                            <td>'.$data['name'].'</td>
                            <td>'.$data['version'].'</td>
                            <td>'.$data['platforms'].'</td>
                            <td>'.$data['emulators'].'</td>
                            <td>'.$data['games'].'</td>
                            <td>'.$data['roms'].'</td>
                        </tr>';
}                        
?>                    
                    </tbody>
                </table>
            </div>            
        </section>
    </section>
    <script src="https://unpkg.com/dialog-polyfill@latest/dist/dialog-polyfill.js"></script>
    <script>
        var dialogs = document.querySelectorAll('dialog');
        for (var dialog in dialogs) {
            if (typeof dialogs[dialog] == "object") {
                dialogPolyfill.registerDialog(dialogs[dialog]);
            }
        }
    </script>  
</body>
</html>
