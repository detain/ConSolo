<?php
require_once __DIR__.'/../src/bootstrap.php';
/* Platform Tables
dat_files
ss_platforms
launchbox_platforms
launchbox_p9latformalternatives
tgdb_platforms
platforms
platform_matches
oc_platforms
mame_software_platforms
*/


/**
* @var \Workerman\MySQL\Connection
*/
global $db;
/**
* @var \Twig\Environment
*/
global $twig;
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
	if ($data['field'] == 'launchbox') {
		$data['value'] = date('Y-m-d', $data['value']);
	} elseif ($data['field'] == 'mame') {
		$data['value'] = substr($data['value'], 0, 1).'.'.substr($data['value'], 1);
	} elseif ($data['field'] == 'tosec') {
		$data['value'] = substr($data['value'], 0, 4).'-'.substr($data['value'], 4, 2).'-'.substr($data['value'], 6, 2);
	}
	$source = $newSource;
	$source['name'] = array_key_exists($data['field'], $names) ? $names[$data['field']] : ucwords($data['field']);
	$source['version'] = $data['value'];
	$sources[$data['field']] = $source;
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
$sources['oldcomputers'] = $newSource;
$sources['oldcomputers']['name'] = 'Old-Computers';
$sources['oldcomputers']['platforms'] = ($db->column("SELECT count(*) FROM oldcomputers_platforms"))[0];
$sources['oldcomputers']['emulators'] = ($db->column("SELECT count(*) FROM oldcomputers_emulators"))[0];

//echo '<pre style="text-align: left;">';print_r($versions);echo '</pre>';exit;

echo $twig->render('status.twig', array(
	'sources' => $sources,
//    'client_id' => $_GET['client_id'],
//    'response_type' => $_GET['response_type'],
	'queryString' => $_SERVER['QUERY_STRING']
));
