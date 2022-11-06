<?php

use Detain\ConSolo\Importing\API\ScreenScraper;
/*
### languagesList.php: List of languages

| Input parameters:\
**devid **: your developer ID\
**devpassword **: your developer password\
**softname **: name of the calling software\
**output **: xml(default),json\
**ssid **(not required): ScreenScraper user ID\
**sspassword **(not required): ScreenScraper password of the user

* * * * *

Items : **languages**

Returned Items:\
**language **(xml)/ ***id ***(json) {\
  **id **: numeric identifier of the language\
  **shortname **: short name of the language\
  **nom_de **: language name in German\
  **name_en **: name of the language in English\
  **nom_es **: name of the language in Spanish\
  **nom_fr **: name of the language in French\
  **nom_it **: name of the language in Italian\
  **nom_pt **: name of the language in Portuguese\
  **parent **: parent language id (0 if main genre)\
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
$return = ScreenScraper::api('languesListe');
if ($return['code'] == 200) {
	echo "Response:".print_r($return,true)."\n";
	$langs = $return['response']['response']['langues'];
	file_put_contents('langs.json', json_encode($langs, getJsonOpts()));
	print_r($langs);
}
