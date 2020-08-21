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




?>
<ul>
	<li>Music
		<ul>
		</ul>
	</li>
	<li>Images
		<ul>
		</ul>
	</li>
	<li>Books
		<ul>
		</ul>
	</li>
	<li>Snippets
		<ul>
		</ul>
	</li>
	<li>Bookmarks
		<ul>
		</ul>
	</li>
	<li>Images
		<ul>
		</ul>
	</li>
	<li>Files
		<ul>
			<li>files</li>
			<li>documents</li>
		</ul>
	</li>
	<li>Settings
		<ul>
			<li>config</li>
			<li>paths</li>
			<li>handlers</li>
			<li>hosts</li>
		</ul>
	</li>
	<li>Movies
		<ul>
			<li>movie titles</li>
			<li>movies</li>
			<li><img src="https://vault3.is.cc/consolo/public/images/imdb.svg" height="24" alt="YTS"></li>
		</ul>
	</li>
	<li><img src="https://vault3.is.cc/consolo/public/images/yts.svg" height="24" alt="YTS">
		<ul>
			<li>yts</li>
			<li>yts torrents</li>
		</ul>
	</li>
	<li><strong>TheMovieDB</strong>
		<ul>
			<li>collection</li>
			<li>keyword</li>
			<li>movie</li>
			<li>movie genre</li>
			<li>person</li>
			<li>production company</li>
			<li>tv episodes</li>
			<li>tv genre</li>
			<li>tv network</li>
			<li>tv seasons</li>
			<li>tv series</li>
		</ul>
	</li>
	<li>Emulation
		<ul>
			<li>platform_matches</li>
			<li>platforms</li>
		</ul>
	</li>
	<li>DATs
		<ul>
			<li>biossets</li>
			<li>disks</li>
			<li>files</li>
			<li>games</li>
			<li>releases</li>
			<li>roms</li>
			<li>samples</li>
		</ul>
	</li>
	<li><img src="https://vault3.is.cc/consolo/public/images/launchbox.png" height="24" alt="LaunchBox"> <strong>LaunchBox</strong>
		<ul>
			<li>emulator platforms</li>
			<li>emulators</li>
			<li>files</li>
			<li>game alternate names</li>
			<li>game images</li>
			<li>games</li>
			<li>mame files</li>
			<li>mame list items</li>
			<li>platform alternate names</li>
			<li>platforms</li>
		</ul>
	</li>
	<li><img src="https://vault3.is.cc/consolo/public/images/mame.svg" height="24" alt="MAME">
		<ul>
			<li>machine roms</li>
			<li>machines</li>
			<li>software</li>
			<li>software roms</li>
		</ul>
	</li>
	<li>OldComputers
		<ul>
			<li>emulator platforms</li>
			<li>emulators</li>
			<li>platforms</li>
		</ul>
	</li>
	<li>TheGamesDB
		<ul>
			<li>developers</li>
			<li>game alternates</li>
			<li>game developers</li>
			<li>game genres</li>
			<li>game publishers</li>
			<li>games</li>
			<li>genres</li>
			<li>platforms</li>
			<li>publishers</li>
		</ul>
	</li>
</ul>