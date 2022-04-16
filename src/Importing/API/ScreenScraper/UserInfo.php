<?php
/*
ssuserInfos.php: ScreenScraper user information
Input parameters:
devid : your developer ID
devpassword : your developer password
softname : name of the calling software
output : xml(default),json
ssid : ScreenScraper user ID
sspassword : User's ScreenScraper password
Item : ssuser (ScreenScraper user information)

Returned Items:
id : username of the user on ScreenScraper
numid : numerical identifier of the user on ScreenScraper
level : user level on ScreenScraper
contribution : level of financial contribution on ScreenScraper (2 = 1 Additional Thread / 3 and + = 5 Additional Threads)
uploadsysteme : Counter of valid contributions (system media) proposed by the user
uploadinfos : Counter of valid contributions (text info) proposed by the user
romasso : Counter of valid contributions (association of roms) proposed by the user
uploadmedia : Counter of valid contributions (game media) submitted by the user
propositionok : Number of user propositions validated by a moderator
propositionko : Number of user propositions refused by a moderator
quotarefu : Percentage of user proposal

Threads
maxthreads : Number of threads allowed for the user (also indicated for non-registered)
maxdownloadspeed : Download speed (in KB/s) authorized for the user (also indicated for non-subscribers)

Quotas
requeststoday : Total number of calls to the api during the current day
requestskotoday : Number of api calls with negative feedback (rom/game not found) during the current day
maxrequestspermin : Maximum number of calls to the api authorized per minute for the user (see FAQ)
maxrequestsperday : Maximum number of calls to the api authorized per day for the user (see FAQ)
maxrequestskoperday : Number of calls to the api with a negative return (rom/game not found) maximum authorized per day for the user (see FAQ)

visits : number of user visits to ScreenScraper
datelastvisit : date of the user's last visit to ScreenScraper (format: yyyy-mm-dd hh:mm:ss)
favregion : favorite region of visits of the user on ScreenScraper (france, europe, usa, japan)
Sample call 
https://www.screenscraper.fr/api2/ssuserInfos.php?devid=xxx&devpassword=yyy&softname=zzz&output=xml&ssid=detain&sspassword=c0mpt0n1337 
