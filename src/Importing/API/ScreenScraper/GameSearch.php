### jeuRecherche.php: Search for a game with its name (returns a table of games (limited to 30 games) classified by probability)

| Input parameters:\
**devid **: your developer ID\
**devpassword **: your developer password\
**softname **: name of the calling software\
**output **: xml(default),json\
**ssid **(not required): ScreenScraper user ID\
**sspassword **(not required): ScreenScraper password of the user\
**systemeid **(not compulsory): numerical identifier of the system (see systemesListe.php)\
**search **: name of the game you are looking for

* * * * *

Item : **servers **(ScreenScraper server information)

Returned Items:\
**cpuserver1 **: % of user CPUs on the current main server\
**servercpu2 **: % of user CPUs on the current secondary server\
**threadsmin **: number of API accesses in the last 60 seconds\
**nbscrapers **: number of API users currently\
**apiacces **: number of API accesses today (French time)

* * * * *

Item : **ssuser **(ScreenScraper user information)

Returned Items:\
**id **: username of the user on ScreenScraper\
**level **: user level on ScreenScraper\
**contribution **: level of financial contribution on ScreenScraper (2 = 1 Additional Thread/3 and + = 5 Additional Threads)\
**uploadsysteme **: Counter of valid contributions (system media) proposed by the user\
**uploadinfos **: Counter of valid contributions (text info) proposed by the user\
**romasso **: Counter of valid contributions (association of roms) proposed by the user\
**uploadmedia **: Counter of valid contributions (game media) submitted by the user\
**maxthreads **: Number of threads allowed for the user (also indicated for non-registered)\
**maxdownloadspeed **: Download speed (in KB/s) authorized for the user (also indicated for non-subscribers)\
**requeststoday **: Number of calls to the api during the current day\
**requestskotoday **: Number of api calls with negative feedback (rom/game not found) during the current day\
**maxrequestsperdmin **: Maximum number of API calls allowed per minute for the user (see FAQ)\
**maxrequestsperday **: Maximum number of calls to the api authorized per day for the user (see FAQ)\
**maxrequestskoperday **: Number of calls to the api with a negative return (rom/game not found) maximum authorized per day for the user (see FAQ)\
**visits **: number of user visits to ScreenScraper\
**datelastvisit **: date of the user's last visit to ScreenScraper (format: yyyy-mm-dd hh:mm:ss)\
**favregion **: favorite region of visits of the user on ScreenScraper (france, europe, usa, japan)

* * * * *

Item XML : **games **(table) then **game**\
Item JSON : **games **(table)

Returned Items:\
Same as jeuInfos API but without rom info

* * * * *

Sample call\
<https://www.screenscraper.fr/api2/jeuRecherche.php?devid=xxx&devpassword=yyy&softname=zzz&output=json&ssid=test&sspassword=test&systemeid=1&recherche=sonic> |
