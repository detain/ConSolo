<?php

use Detain\ConSolo\Importing\API\ScreenScraper;
/*
### genresList.php: List of genres

| Input parameters:\
**devid **: your developer ID\
**devpassword **: your developer password\
**softname **: name of the calling software\
**output **: xml(default),json\
**ssid **(not required): ScreenScraper user ID\
**sspassword **(not required): ScreenScraper password of the user

* * * * *

Items : **genres**

Returned Items:\
**genre **(xml) / ***id ***(json) {\
  **id **: numeric gender identifier\
  **nom_de **: genus name in German\
  **nom_en **: genre name in English\
  **nom_es **: genus name in Spanish\
  **nom_fr **: genus name in French\
  **nom_it **: name of the genus in Italian\
  **nom_pt **: genus name in Portuguese\
  **parent **: id of the parent genre (0 if main genre)\
  **medias **{\
	**media_pictomonochrome **: media download url: Monochrome Pictogram\
	**media_pictocouleur **: media download url: Color Pictogram\
	**media_background **: media download url: Wallpaper\
  }\
}

* * * * *

Sample call
*/

require_once __DIR__.'/../../../bootstrap.php';


/**
* @var \Workerman\MySQL\Connection
*/
global $db;
global $config;
global $queriesRemaining;
global $dataDir;
global $curl_config;
$curl_config = [];
global $userInfo;
$return = ScreenScraper::api('genresListe');
if ($return['code'] == 200) {
	//echo "Response:".print_r($return,true)."\n";
	$genres = $return['response']['response']['genres'];
	file_put_contents('genres.json', json_encode($genres, getJsonOpts()));
	print_r($genres);
}
