<?php

use Detain\ConSolo\Importing\ScreenScraper;
/*
### mediaManuelJeu.php: Download game manuals

| Settings :\
**devid **: your developer ID\
**devpassword **: your developer password\
**softname **: name of the calling software\
**ssid **: ScreenScraper user ID (optional)\
**sspassword **: ScreenScraper user password (optional)\
**crc **: crc calculation of the existing manual file locally\
**md5 **: md5 calculation of the existing manual file locally\
**sha1 **: sha1 calculation of the manual file existing locally\
**systemeid **: numeric identifier of the system (see systemesListe.php)\
**jeuid **: numerical identifier of the system (see jeuInfos.php)\
**media **: text identifier of the media to return (see gameInfos.php)\
**mediaformat **: format (extension) of the media: ex: jpg, png, mp4, zip, mp3, pdf, ... (not mandatory, informative data: does not return the media in the specified format)

* * * * *

Returned Item: **Manual PDF**\
Where\
Text **CRCOK **or **MD5OK **or **SHA1OK **if the crc, md5 or sha1 parameter is the same as the crc, md5 or sha1 calculation of the server video (update optimization)\
Where\
Text **NOMEDIA **if the media file was not found

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
$return = ScreenScraper::api('romTypesListe');
if ($return['code'] == 200) {
	//echo "Response:".print_r($return,true)."\n";
	$romTypes = $return['response']['response']['romtypes'];
	file_put_contents('romTypes.json', json_encode($romTypes, getJsonOpts()));
	print_r($romTypes);
}
$url = 'https://www.screenscraper.fr/api2/mediaManuelJeu.php?devid='.$config['screenscraper']['api_user'].'&devpassword='.$config['screenscraper']['api_pass'].'&softname=ConSolo&crc=&md5=&sha1=&systemeid=1&jeuid=3&media=manuel(eu)';