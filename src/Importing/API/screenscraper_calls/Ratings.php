<?php

use Detain\ConSolo\Importing\ScreenScraper;
/*
### classificationListe.php : Liste des Classification (Game Rating)

| Input parameters:\
**devid **: your developer ID\
**devpassword **: your developer password\
**softname **: name of the calling software\
**output **: xml(default),json\
**ssid **(not required): ScreenScraper user ID\
**sspassword **(not required): ScreenScraper password of the user

* * * * *

Items : **classifications**

Returned Items:\
**language **(xml)/ ***id ***(json) {\
  **id **: numerical identifier of the classification\
  **shortname **: short name of the classification\
  **nom_de **: name of the classification in German (if existing)\
  **nom_en **: name of the classification in English (if existing)\
  **nom_es **: name of the classification in Spanish (if existing)\
  **nom_fr **: name of the classification in French (if existing)\
  **name_it **: name of the classification in Italian (if existing)\
  **nom_pt **: name of the classification in Portuguese (if existing)\
  **parent **: parent classification id (0 if main genre)\
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
$return = ScreenScraper::api('classificationListe');
if ($return['code'] == 200) {
	//echo "Response:".print_r($return,true)."\n";
	$classifications = $return['response']['response']['classifications'];
	file_put_contents('classifications.json', json_encode($classifications, getJsonOpts()));
	print_r($classifications);
}
