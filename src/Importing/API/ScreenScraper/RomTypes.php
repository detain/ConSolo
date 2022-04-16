<?php
/*
### romTypesListe.php: List of room types

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
global $config;
$url = 'https://www.screenscraper.fr/api2/romTypesListe.php?devid='.$config['screenscraper']['api_user'].'&devpassword='.$config['screenscraper']['api_pass'].'&softname=ConSolo&output=json';
