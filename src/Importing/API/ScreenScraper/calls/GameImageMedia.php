<?php

use Detain\ConSolo\Importing\ScreenScraper;
/*
### mediaJeu.php: Download game image media

| Input parameters:\
**devid **: your developer ID\
**devpassword **: your developer password\
**softname **: name of the calling software\
**ssid **(not required): ScreenScraper user ID\
**sspassword **(not required): ScreenScraper password of the user\
**crc **: crc calculation of the existing image locally\
**md5 **: md5 calculation of the existing image locally\
**sha1 **: sha1 calculation of the existing image locally\
**systemeid **: numeric identifier of the system (see systemesListe.php)\
**jeuid **: numerical identifier of the game (see jeuInfos.php)\
**media **: text identifier of the media to return (see gameInfos.php)\
**mediaformat **(not compulsory): format (extension) of the media: ex: jpg, png, mp4, zip, mp3, ... (informative data: does not return the media in the specified format)\
Output parameters:\
**maxwidth **(not mandatory): Maximum width in pixels of the returned image\
**maxheight **(not mandatory): Maximum height in pixels of the returned image\
**outputformat **(not mandatory): Format (extension) of the returned image: **png **or **jpg**

* * * * *

Returned Item: **Image PNG**\
Where\
Text **CRCOK **or **MD5OK **or **SHA1OK **if the crc, md5 or sha1 parameter is identical to the crc, md5 or sha1 calculation of the server image (update optimization)\
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
$url = 'https://www.screenscraper.fr/api2/mediaJeu.php?devid='.$config['screenscraper']['api_user'].'&devpassword='.$config['screenscraper']['api_pass'].'&softname=ConSolo&crc=&md5=&sha1=&systemeid=1&jeuid=3&media=wheel-hd(wor)';

