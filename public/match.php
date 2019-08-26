<?php
require_once __DIR__.'/../src/bootstrap.php';
require_once __DIR__.'/../src/Matching/MatchFilesToSets.php';

$matches = \Detain\ConSolo\Matching\MatchFilesToSets();
$stats = [];
$typeStats = [];
foreach ($matches as $type => $typeData) {
    $stats[$type] = [];
    $typeStats[$type] = ['games' => 0, 'good' => 0, 'bad' => 0, 'partial' => 0];
    foreach ($typeData as $platform => $platformData) {
        $stats[$type][$platform] = ['games' => count($platformData), 'good' => 0, 'bad' => 0, 'partial' => 0];
        foreach ($platformData as $gameId => $gameData) {
            if ($gameData[1] == 0)
                $stats[$type][$platform]['good']++;
            elseif ($gameData[0] == 0)
                $stats[$type][$platform]['bad']++;
            else
                $stats[$type][$platform]['partial']++;
        }
        $typeStats[$type]['games'] += $stats[$type][$platform]['games'];
        if ($stats[$type][$platform]['bad'] == 0)
            $typeStats[$type]['good']++;
        elseif ($stats[$type][$platform]['good'] == 0)
            $typeStats[$type]['bad']++;
        else
            $typeStats[$type]['partial']++;
    }    
}
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
        <a class="nes-btn is-disabled" href="match.php">Matches</a>
        <a class="nes-btn is-primary" href="emulators.php">Emulators</a>
        <a class="nes-btn is-default" href="platforms.php">Platforms</a>
        <a class="nes-btn is-warning" href="games.php">Games</a>
        <a class="nes-btn is-primary" href="roms.php">ROMs</a>
        <a class="nes-btn is-error" href="https://nostalgic-css.github.io/NES.css/" target="_blank">Theme</a>
    </p>
    <br>    
    <section class="showcase">
        <section class="nes-container with-title">
            <h3 class="title">Status</h3>
            <h3>Source Matches Overview</h3>
            <div class="nes-table-responsive">
                <table class="nes-table is-bordered is-centered">
                    <thead>
                        <tr>
                            <th>Source</th>
                            <th>Games</th>
                            <th>Good</th>
                            <th>Bad</th>
                            <th>Partial</th>
                        </tr>
                    </thead>
                    <tbody>
<?php
foreach ($typeStats as $key => $data) {
    echo '
                        <tr>
                            <td>'.$key.'</td>
                            <td>'.$data['games'].'</td>
                            <td>'.$data['good'].'</td>
                            <td>'.$data['bad'].'</td>
                            <td>'.$data['partial'].'</td>
                        </tr>';
}                        
?>                    
                    </tbody>
                </table>
            </div>            
            <br>
            <h3>Platform Matches Overview</h3>
            <div class="nes-table-responsive">
                <table class="nes-table is-bordered is-centered">
                    <thead>
                        <tr>
                            <th>Source</th>
                            <th>Platform</th>
                            <th>Games</th>
                            <th>Good</th>
                            <th>Bad</th>
                            <th>Partial</th>
                        </tr>
                    </thead>
                    <tbody>
<?php
foreach ($stats as $type => $typeData) {
    foreach ($typeData as $platform => $data) {
        echo '
                        <tr>
                            <td>'.$type.'</td>
                            <td>'.$platform.'</td>
                            <td>'.$data['games'].'</td>
                            <td>'.$data['good'].'</td>
                            <td>'.$data['bad'].'</td>
                            <td>'.$data['partial'].'</td>
                        </tr>';
    }
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
