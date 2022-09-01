<?php
/**
* grabs latest ScreenScraper.fr data and updates db
*/

use Detain\ConSolo\Importing\API\ScreenScraper;

require_once __DIR__.'/../../../bootstrap.php';

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
global $config;
global $queriesRemaining;
global $dataDir;
global $curl_config;
$curl_config = [];
$force = in_array('-f', $_SERVER['argv']);
$skipDb = in_array('--no-db', $_SERVER['argv']);
$usePrivate = false;
$useCache = !in_array('--no-cache', $_SERVER['argv']);;
$dataDir = __DIR__.'/../../../../data';
@mkdir($dataDir.'/json/screenscraper', 0775, true);
if (file_exists($dataDir.'/json/screenscraper/queries.json')) {
	$queriesRemaining = json_decode(file_Get_contents($dataDir.'/json/screenscraper/queries.json'), true);
} else {
	$queriesRemaining = ['yearmonth' => 0];
}
if (date('Ymd') > $queriesRemaining['yearmonth']) {
	$queriesRemaining['yearmonthday'] = date('Ymd');
	foreach ($config['ips'] as $ip) {
		$queriesRemaining[$ip] = 40000;
	}
}
if ($useCache == true && file_exists($dataDir.'/json/screenscraper/platforms.json')) {
	$platforms = json_decode(file_get_contents($dataDir.'/json/screenscraper/platforms.json'), true);
} else {
	$return = ScreenScraper::api('systemesListe');
	if ($return['code'] == 200) {
		//echo "Response:".print_r($return,true)."\n";
		$platforms = $return['response']['response']['systemes'];
		file_put_contents($dataDir.'/json/screenscraper/platforms.json', json_encode($platforms, getJsonOpts()));
		//print_r($platforms);
	}
}
$source = [
    'platforms' => []
];
foreach ($platforms as $idx => $platform) {
    $id = intval($platform['id']);
    if (isset($platforms['noms']['noms_commun']) && trim($platforms['noms']['noms_commun']) != '') {
        $altNames = explode(',', trim($platform['noms']['noms_commun']));
    } else {
        $altNames = [];
    }
    $name = false;
    foreach (['nom_us', 'nom_eu', 'nom_jp'] as $field) {
        if ($name === false && isset($platform['noms'][$field])) {
            $name = $platform['noms'][$field];
        } elseif (isset($platform['noms'][$field]) && !in_array($platform['noms'][$field], $altNames)) {
            $altNames[] = $platform['noms'][$field];
        }
    }
    $source['platforms'][$id] = [
        'id' => $id,
        'name' => $name,
        'altNames' => $altNames
    ];
    if (isset($platform['compagnie'])) {
        $source['platforms'][$id]['company'] = $platform['compagnie'];
    }
    foreach (['launchbox', 'retropie', 'recalbox'] as $field) {
        if (isset($platform['noms']['nom_'.$field])) {
            if (!isset($source['platforms'][$platform['id']]['matches'])) {
                $source['platforms'][$id]['matches'] = [];
            }
            if (!isset($source['platforms'][$platform['id']]['matches'][$field])) {
                $source['platforms'][$id]['matches'][$field] = [];
            }
            $matches = explode(',', trim($platform['noms']['nom_'.$field]));
            foreach ($matches as $matchPlatId) {
                $source['platforms'][$id]['matches'][$field][] = $matchPlatId;
            }
        }
    }
}
$sources = json_decode(file_get_contents(__DIR__.'/../../../../../emurelation/sources.json'), true);
$sources['screenscraper']['updatedLast'] = time();
file_put_contents(__DIR__.'/../../../../../emurelation/sources.json', json_encode($sources, getJsonOpts()));
file_put_contents(__DIR__.'/../../../../../emurelation/sources/screenscraper.json', json_encode($source, getJsonOpts()));
if (!$skipDb) {
    echo "Mapping Platforms to db\n";
    $db->query('truncate ss_platforms');
    foreach ($platforms as $platform) {
	    $db->insert('ss_platforms')
	    ->cols(['doc' => json_encode($platform, getJsonOpts())])
	    ->query();
    }
}
