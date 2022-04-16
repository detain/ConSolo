<?php
/*
### ssuserInfos.php: ScreenScraper user information

| Input parameters:\
**devid **: your developer ID\
**devpassword **: your developer password\
**softname **: name of the calling software\
**output **: xml(default),json\
**ssid **: ScreenScraper user ID\
**sspassword **: User's ScreenScraper password

* * * * *

Item : **ssuser **(ScreenScraper user information)

Returned Items:\
**id **: username of the user on ScreenScraper\
**numid **: numerical identifier of the user on ScreenScraper\
**level **: user level on ScreenScraper\
**contribution **: level of financial contribution on ScreenScraper (2 = 1 Additional Thread / 3 and + = 5 Additional Threads)\
**uploadsysteme **: Counter of valid contributions (system media) proposed by the user\
**uploadinfos **: Counter of valid contributions (text info) proposed by the user\
**romasso **: Counter of valid contributions (association of roms) proposed by the user\
**uploadmedia **: Counter of valid contributions (game media) submitted by the user\
**propositionok **: Number of user propositions validated by a moderator\
**propositionko **: Number of user propositions refused by a moderator\
**quotarefu **: Percentage of user proposal

Threads\
**maxthreads **: Number of threads allowed for the user (also indicated for non-registered)\
**maxdownloadspeed **: Download speed (in KB/s) authorized for the user (also indicated for non-subscribers)

Quotas\
**requeststoday **: Total number of calls to the api during the current day\
**requestskotoday **: Number of api calls with negative feedback (rom/game not found) during the current day\
**maxrequestspermin **: Maximum number of calls to the api authorized per minute for the user (see FAQ)\
**maxrequestsperday **: Maximum number of calls to the api authorized per day for the user (see FAQ)\
**maxrequestskoperday **: Number of calls to the api with a negative return (rom/game not found) maximum authorized per day for the user (see FAQ)

**visits **: number of user visits to ScreenScraper\
**datelastvisit **: date of the user's last visit to ScreenScraper (format: yyyy-mm-dd hh:mm:ss)\
**favregion **: favorite region of visits of the user on ScreenScraper (france, europe, usa, japan)

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
$return = ssApi('ssuserInfos', '&ssid='.$config['screenscraper']['my_user'].'&sspassword='.$config['screenscraper']['my_pass']);
if ($return['code'] == 200) {
	////echo "Response:".print_r($return,true)."\n";
	$userInfo = $return['response']['response']['ssuser'];
	file_put_contents('user.json', json_encode($userInfo, JSON_PRETTY_PRINT));
	print_r($userInfo);
}
/*
Array
(
	[id] => detain
	[numid] => 100453
	[niveau] => 1
	[contribution] => 0
	[uploadsysteme] => 0
	[uploadinfos] => 0
	[romasso] => 0
	[uploadmedia] => 0
	[propositionok] => 0
	[propositionko] => 0
	[quotarefu] => 0
	[maxthreads] => 1
	[maxdownloadspeed] => 128
	[requeststoday] => 3
	[requestskotoday] => 1
	[maxrequestspermin] => 768
	[maxrequestsperday] => 20000
	[maxrequestskoperday] => 2000
	[visites] => 8
	[datedernierevisite] => 2022-04-16 07:35:14
	[favregion] => us
)

**id **: username of the user on ScreenScraper\
**numid **: numerical identifier of the user on ScreenScraper\
**level **: user level on ScreenScraper\
**contribution **: level of financial contribution on ScreenScraper (2 = 1 Additional Thread / 3 and + = 5 Additional Threads)\
**uploadsysteme **: Counter of valid contributions (system media) proposed by the user\
**uploadinfos **: Counter of valid contributions (text info) proposed by the user\
**romasso **: Counter of valid contributions (association of roms) proposed by the user\
**uploadmedia **: Counter of valid contributions (game media) submitted by the user\
**propositionok **: Number of user propositions validated by a moderator\
**propositionko **: Number of user propositions refused by a moderator\
**quotarefu **: Percentage of user proposal
**visits **: number of user visits to ScreenScraper\
**datelastvisit **: date of the user's last visit to ScreenScraper (format: yyyy-mm-dd hh:mm:ss)\
**favregion **: favorite region of visits of the user on ScreenScraper (france, europe, usa, japan)

Threads\
**maxthreads **: Number of threads allowed for the user (also indicated for non-registered)\
**maxdownloadspeed **: Download speed (in KB/s) authorized for the user (also indicated for non-subscribers)

Quotas\
**requeststoday **: Total number of calls to the api during the current day\
**requestskotoday **: Number of api calls with negative feedback (rom/game not found) during the current day\
**maxrequestspermin **: Maximum number of calls to the api authorized per minute for the user (see FAQ)\
**maxrequestsperday **: Maximum number of calls to the api authorized per day for the user (see FAQ)\
**maxrequestskoperday **: Number of calls to the api with a negative return (rom/game not found) maximum authorized per day for the user (see FAQ)



*/