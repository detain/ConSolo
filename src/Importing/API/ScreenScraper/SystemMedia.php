<?php
/*
### mediasSystemeListe.php: List of media for systems

| Input parameters:\
**devid **: your developer ID\
**devpassword **: your developer password\
**softname **: name of the calling software\
**output **: xml(default),json\
**ssid **(not required): ScreenScraper user ID\
**sspassword **(not required): ScreenScraper password of the user

* * * * *

Items : **medias**

Returned Items:\
**media **(xml) / ***id ***(json) {\
  **id **: digital identifier of the media\
  **shortname **: short name of the media\
  **name **: long name of the media\
  **category **: media category\
  **platformtypes **: list of system types where the media is present (system type id separated by | , if empty = all system types)\
  **platforms **: list of systems where the media is present (system type id separated by | , if empty = all systems)\
  **type **: media type\
  **fileformat **: media file format\
  **fileformat2 **: 2nd file format of the media accepted at the proposal\
  **autogen **: auto-generated media (0=no,1=yes)\
  **multiregions **: multi-region media (0=no,1=yes)\
  **multi **-media: multi-media media (0=no,1=yes)\
  **multiversions **: multi-version media (0=no,1=yes)\
  **extrainfostxt **: additional media information\
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
$return = ssApi('mediasSystemeListe');
if ($return['code'] == 200) {
	//echo "Response:".print_r($return,true)."\n";
	$medias = $return['response']['response']['medias'];
	file_put_contents('medias.json', json_encode($medias, JSON_PRETTY_PRINT));
	print_r($medias);
}
