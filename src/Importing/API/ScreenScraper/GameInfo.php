<?php

use Detain\ConSolo\Importing\API\ScreenScraper;
/*
### infosJeuListe.php: List of info for games

| Input parameters:\
**devid **: your developer ID\
**devpassword **: your developer password\
**softname **: name of the calling software\
**output **: xml(default),json\
**ssid **(not required): ScreenScraper user ID\
**sspassword **(not required): ScreenScraper password of the user

* * * * *

Items : **infos**

Returned Items:\
**info **(xml) / ***id ***(json) {\
  **id **: numerical identifier of the info\
  **shortname **: short name of the info\
  **name **: long name of the info\
  **category **: info category\
  **platformtypes **: list of system types where the info is present (system type id separated by | , if empty = all system types)\
  **platforms **: list of systems where the info is present (id of the type of system separated by | , if empty = all systems)\
  **type **: type d'info\
  **autogen **: auto-generated info (0=no,1=yes)\
  **multiregions **: multi-region info (0=no,1=yes)\
  **multi **-media: multi-media info (0=no,1=yes)\
  **multiversions **: multi-version info (0=no,1=yes)\
  **multichoice **: multichoice info (0=no,1=yes)\
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
$return = ScreenScraper::api('infosJeuListe');
if ($return['code'] == 200) {
	//echo "Response:".print_r($return,true)."\n";
	$infos = $return['response']['response']['infos'];
	file_put_contents('infos.json', json_encode($infos, JSON_PRETTY_PRINT));
	print_r($infos);
}
