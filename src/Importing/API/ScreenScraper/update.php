<?php
/**
* grabs latest ScreenScraper.fr data and updates db
*/

use Detain\ConSolo\Importing\API\ScreenScraper;

require_once __DIR__.'/../../../bootstrap.php';

if (in_array('-h', $_SERVER['argv'])) {
    die("Syntax:
    php ".$_SERVER['argv'][0]." <options>

Options:
    -h          this screen
    -f          force update even if already latest version
    --no-db     skip the db updates/inserts

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
$usePrivate = false;
$useCache = true;
$dataDir = __DIR__.'/../../../../data';
@mkdir($dataDir.'/json/screenscraper', 0775, true);
if (file_exists($dataDir.'/json/screenscraper/queries.json')) {
	$queriesRemaining = json_decode(file_Get_contents($dataDir.'/json/screenscraper/queries.json'), true);
} else {
	$queriesRemaining = ['yearmonth' => 0];
}
if (date('Ym') > $queriesRemaining['yearmonth']) {
	$queriesRemaining['yearmonth'] = date('Ym');
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
echo "Mapping Platforms to db\n";
$db->query('truncate ss_platforms');
foreach ($platforms as $platform) {
	$db->insert('ss_platforms')
	->cols(['doc' => json_encode($platform, getJsonOpts())])
	->query();
}
exit;
foreach (['Genres', 'Developers', 'Publishers'] as $type) {
	if ($useCache == true && file_exists($dataDir.'/json/screenscraper/'.$type.'.json')) {
		$var = strtolower($type);
		$$var = json_decode(file_get_contents($dataDir.'/json/screenscraper/'.$type.'.json'), true);
	} else {
		$json = apiGet($type.'?apikey='.($usePrivate == true ? $config['tgdb']['private_key'] : $config['tgdb']['public_key']));
		file_put_contents($dataDir.'/json/screenscraper/'.$type.'.json', json_encode($json, getJsonOpts()));
		$lower = strtolower($type);
		$db->query('delete from tgdb_'.$lower);
		foreach ($json['data'][$lower] as $idx => $data) {
			$db->insert('tgdb_'.$lower)->cols($data)->lowPriority($config['db']['low_priority'])->query();
		}
	}
}
$platformIds = array_keys($platforms['data']['platforms']);
if ($useCache == true && file_exists($dataDir.'/json/screenscraper/PlatformImages.json')) {
	$platformImages = json_decode(file_get_contents($dataDir.'/json/screenscraper/PlatformImages.json'), true);
} else {
	$platformImages = apiGet('Platforms/Images?apikey='.($usePrivate == true ? $config['tgdb']['private_key'] : $config['tgdb']['public_key']).'&platforms_id='.urlencode(implode(',',$platformIds)));
	file_put_contents($dataDir.'/json/screenscraper/PlatformImages.json', json_encode($platformImages, getJsonOpts()));
}
$fields = ['players', 'publishers', 'genres', 'overview', 'last_updated', 'rating', 'platform', 'coop', 'youtube', 'os', 'processor', 'ram', 'hdd', 'video', 'sound', 'alternates'];
$subfields = ['developers', 'genres', 'publishers', 'alternates'];
$db->query('delete from tgdb_games');
foreach ($subfields as $field)
	$db->query('truncate tgdb_game_'.$field);
foreach ($platforms['data']['platforms'] as $platformIdx => $platformData) {
	$platformId = $platformData['id'];
	echo 'Platform #'.$platformId.' '.$platformData['name'].' ';
	if ($useCache == true && file_exists($dataDir.'/json/screenscraper/platform/'.$platformId.'.json')) {
		$games = json_decode(file_get_contents($dataDir.'/json/screenscraper/platform/'.$platformId.'.json'), true);
	} else {
		$games = apiGet('Games/ByPlatformID?apikey='.($usePrivate == true ? $config['tgdb']['private_key'] : $config['tgdb']['public_key']).'&id='.$platformId.'&fields='.urlencode(implode(',',$fields)), 'games', false);
		file_put_contents($dataDir.'/json/screenscraper/platform/'.$platformId.'.json', json_encode($games, getJsonOpts()));
	}
	echo 'Inserting DB Data..';
	foreach ($games['data']['games'] as $idx => $game) {
		$cols = $game;
		foreach ($subfields as $field) {
			unset($cols[$field]);
		}
		if (isset($cols['overview'])) {
			$cols['overview'] = utf8_encode($cols['overview']);
		}
		$gameId = $db->insert('tgdb_games')->cols($cols)->lowPriority($config['db']['low_priority'])->query();
		foreach ($subfields as $field) {
			if (isset($game[$field])) {
				foreach ($game[$field] as $fieldData) {
					$db->insert('tgdb_game_'.$field)->cols([
						'game' => $gameId,
						($field == 'alternates' ? 'name' : substr($field, 0, -1)) => $fieldData
					])->lowPriority($config['db']['low_priority'])->query();
				}
			}
		}
	}
	echo ' done'.PHP_EOL;
}
