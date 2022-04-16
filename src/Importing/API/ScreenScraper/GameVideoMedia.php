<?php
/*
### mediaVideoJeu.php: Download game video media

| Settings :\
**devid **: your developer ID\
**devpassword **: your developer password\
**softname **: name of the calling software\
**ssid **: ScreenScraper user ID (optional)\
**sspassword **: ScreenScraper user password (optional)\
**crc **: crc calculation of the existing video locally\
**md5 **: md5 calculation of the existing video locally\
**sha1 **: sha1 calculation of the existing video locally\
**systemeid **: numeric identifier of the system (see systemesListe.php)\
**jeuid **: numerical identifier of the system (see jeuInfos.php)\
**media **: text identifier of the media to return (see gameInfos.php)\
**mediaformat **: format (extension) of the media: ex: jpg, png, mp4, zip, mp3, ... (not compulsory, informative data: does not return the media in the specified format)

* * * * *

Returned Item: **Video MP4**\
Where\
Text **CRCOK **or **MD5OK **or **SHA1OK **if the crc, md5 or sha1 parameter is the same as the crc, md5 or sha1 calculation of the server video (update optimization)\
Where\
Text **NOMEDIA **if the media file was not found

* * * * *

Sample call
*/
global $config;
$url = 'https://www.screenscraper.fr/api2/mediaVideoJeu.php?devid='.$config['screenscraper']['api_user'].'&devpassword='.$config['screenscraper']['api_pass'].'&softname=ConSolo&crc=&md5=&sha1=&systemeid=1&jeuid=3&media=video';

