<?php
require_once __DIR__.'/../src/bootstrap.php';

/**
* @var \Workerman\MySQL\Connection
*/
global $db;

$tables = [
	'Files' => [
		'files',
	],
	'Movies' => [
		'imdb',
		'tmdb_collection',
		'tmdb_keyword',
		'tmdb_movie',
		'tmdb_movie_genre',
		'tmdb_person',
		'tmdb_production_company',
		'yts',
		'yts_torrents',
		'movie_titles',
		'movies',
	],
	'TV' => [
		'tmdb_tv_episodes',
		'tmdb_tv_genre',
		'tmdb_tv_network',
		'tmdb_tv_seasons',
		'tmdb_tv_series',
	],
	'Emulation' => [
		'launchbox_emulatorplatforms',
		'launchbox_emulators',
		'launchbox_files',
		'launchbox_gamealternatenames',
		'launchbox_gameimages',
		'launchbox_games',
		'launchbox_mamefiles',
		'launchbox_mamelistitems',
		'launchbox_platformalternatenames',
		'launchbox_platforms',
		'mame_machine_roms',
		'mame_machines',
		'mame_software',
		'mame_software_roms',
		'dat_biossets',
		'dat_disks',
		'dat_files',
		'dat_games',
		'dat_releases',
		'dat_roms',
		'dat_samples',
		'platform_matches',
		'platforms',
		'tgdb_developers',
		'tgdb_game_alternates',
		'tgdb_game_developers',
		'tgdb_game_genres',
		'tgdb_game_publishers',
		'tgdb_games',
		'tgdb_genres',
		'tgdb_platforms',
		'tgdb_publishers',
		'oldcomputers_emulator_platforms',
		'oldcomputers_emulators',
		'oldcomputers_platforms',
	],
	'Settings' => [
		'handlers',
		'config',
		'documents',
		'hosts',
		'paths',        
	],
];
/**
* @var \Twig\Environment
*/
global $twig;

