<?php
require_once __DIR__.'/../../../bootstrap.php';
$imdbFields = ['alsoknow','cast','colors','comment','composer','country','crazy_credits','director','episodes','genre','genres','get_episode_details','goofs','imdbsite','is_serial','keywords','languages','locations','main_url','movietype','mpaa','mpaa_reason','orig_title','photo_localurl','plot','plotoutline','producer','quotes','rating','runtime','seasons','sound','soundtrack','tagline','taglines','title','trailers','trivia','votes','writing','year'];
/**
* @var \Workerman\MySQL\Connection
*/
global $db;
global $config, $curl_config;
$series = json_decode($db->single("select doc from tmdb_tv_series where id={$_SERVER['argv'][1]} limit 1"), true);
print_r($series);
$seasons = $db->column("select doc from tmdb_tv_seasons where tv_id={$series['id']} order by season_number");
foreach ($seasons as $idx => $season) {
	$season = json_decode($season, true);
	//echo "{$series['name']} {$season['season_number']} {$season['name']}\n";
	//print_r($season);
	foreach ($season['episodes'] as $epIdx => $episode) {
		echo "{$series['name']} {$season['season_number']} {$season['name']} EP #{$episode['id']} {$episode['episode_number']} {$episode['name']}\n"; 
	}
}
