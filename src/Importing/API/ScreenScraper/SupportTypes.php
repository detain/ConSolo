<?php

use Detain\ConSolo\Importing\API\ScreenScraper;
/*
### supportTypesListe.php: List of room types

| Input parameters:\
**devid **: your developer ID\
**devpassword **: your developer password\
**softname **: name of the calling software\
**output **: xml(default),json\
**ssid **(not required): ScreenScraper user ID\
**sspassword **(not required): ScreenScraper password of the user

* * * * *

Items : **room types**

Returned Items:\
**name **: Designation of the type(s) of roms

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
$return = ScreenScraper::api('supportTypesListe');
if ($return['code'] == 200) {
	$romTypes = $return['response']['response']['supporttypes'];
	file_put_contents('supportTypes.json', json_encode($romTypes, JSON_PRETTY_PRINT));
	print_r($romTypes);
}
