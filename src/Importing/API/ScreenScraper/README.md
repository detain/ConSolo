## ScreenScraper API Docs

### Error Response Codes

**API requests return HTTP error numbers if there is a problem. here they are :**

| **Error** | **Description** | **Cause** |
| --- | --- | --- |
| 400 | problem with url | the API call url does not contain any information |
| 400 | Missing required fields in the url | one of the minimum mandatory fields is missing in the api call url |
| 400 | Error in the name of the rom file: this one contains an access path | the name of the rom file sent is of type "!mnt!sda1!batocera!roms!..." |
| 400 | Wrong crc, md5 or sha1 field | The crc, md5 or sha1 field is not formatted correctly |
| 400 | Problem in rom file name | The name of the rom file is not compliant |
| 401 | API closed for non-members or inactive members | The Server is saturated (CPU usage>60%) |
| 403 | Login error: Check your developer credentials! | incorrect developer credentials |
| 404 | Error: Game not found! / Error: Rom/Iso/Folder not found! | Unable to find a match on the requested rom |
| 423 | Fully closed API | Server has serious problem |
| 426 | The scraping software used has been blacklisted (non-compliant / outdated version) | You have to change the software version |
| 429 | The number of threads allowed for the member has been reached | Query speed should be reduced |
| 429 | The number of threads per minute allowed for the member has been reached | Query speed should be reduced |
| 430 | Your scrape quota is exceeded for today! | The member has scraped more than x (see FAQ) roms during the day |
| 431 | Sort through your rom files and come back tomorrow! | The member has scraped more than x (see FAQ) roms not recognized by ScreenScraper |


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

Sample call\
<https://www.screenscraper.fr/api2/ssuserInfos.php?devid=xxx&devpassword=yyy&softname=zzz&output=xml&ssid=detain&sspassword=c0mpt0n1337>\
 |

### userlevelsListe.php: List of ScreenScraper user levels

| Input parameters:\
**devid **: your developer ID\
**devpassword **: your developer password\
**softname **: name of the calling software\
**output **: xml(default),json\
**ssid **(not required): ScreenScraper user ID\
**sspassword **(not required): ScreenScraper password of the user

* * * * *

Items : **userlevels**

Returned Items:\
**userlevel **(xml) / ***id ***(json) {\
  **id **: numeric identifier of the level\
  **nom_fr **: name of the level in French\
}

* * * * *

Sample call\
<https://www.screenscraper.fr/api2/userlevelsListe.php?devid=xxx&devpassword=yyy&softname=zzz&output=xml&ssid=test&sspassword=test> |


### nbJoueursListe.php: List of numbers of players

| Input parameters:\
**devid **: your developer ID\
**devpassword **: your developer password\
**softname **: name of the calling software\
**output **: xml(default),json\
**ssid **(not required): ScreenScraper user ID\
**sspassword **(not required): ScreenScraper password of the user

* * * * *

Items : **nbplayer**

Returned Items:\
**id **: numerical identifier of the number of players\
**name **: Designation of the number of players\
**parent **: numerical identifier of the number of parent players (0 if no parent)

* * * * *

Sample call\
<https://www.screenscraper.fr/api2/nbJoueursListe.php?devid=xxx&devpassword=yyy&softname=zzz&output=XML&ssid=test&sspassword=test>\
 |

### supportTypesListe.php: List of support types

| Input parameters:\
**devid **: your developer ID\
**devpassword **: your developer password\
**softname **: name of the calling software\
**output **: xml(default),json\
**ssid **(not required): ScreenScraper user ID\
**sspassword **(not required): ScreenScraper password of the user

* * * * *

Items : **supporttypes**

Returned Items:\
**name **: Designation of the support(s)

* * * * *

Sample call\
<https://www.screenscraper.fr/api2/supportTypesListe.php?devid=xxx&devpassword=yyy&softname=zzz&output=XML&ssid=test&sspassword=test>\
 |

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

Sample call\
<https://www.screenscraper.fr/api2/romTypesListe.php?devid=xxx&devpassword=yyy&softname=zzz&output=xml&ssid=test&sspassword=test>\
 |

### genresList.php: List of genres

| Input parameters:\
**devid **: your developer ID\
**devpassword **: your developer password\
**softname **: name of the calling software\
**output **: xml(default),json\
**ssid **(not required): ScreenScraper user ID\
**sspassword **(not required): ScreenScraper password of the user

* * * * *

Items : **genres**

Returned Items:\
**genre **(xml) / ***id ***(json) {\
  **id **: numeric gender identifier\
  **nom_de **: genus name in German\
  **nom_en **: genre name in English\
  **nom_es **: genus name in Spanish\
  **nom_fr **: genus name in French\
  **nom_it **: name of the genus in Italian\
  **nom_pt **: genus name in Portuguese\
  **parent **: id of the parent genre (0 if main genre)\
  **medias **{\
	**media_pictomonochrome **: media download url: Monochrome Pictogram\
	**media_pictocouleur **: media download url: Color Pictogram\
	**media_background **: media download url: Wallpaper\
  }\
}

* * * * *

Sample call\
<https://www.screenscraper.fr/api2/genresListe.php?devid=xxx&devpassword=yyy&softname=zzz&output=xml&ssid=test&sspassword=test>\
 |

### regionsListe.php: List of regions

| Input parameters:\
**devid **: your developer ID\
**devpassword **: your developer password\
**softname **: name of the calling software\
**output **: xml(default),json\
**ssid **(not required): ScreenScraper user ID\
**sspassword **(not required): ScreenScraper password of the user

* * * * *

Items : **regions**

Returned Items:\
**region **(xml) / ***id ***(json) {\
  **id **: numeric identifier of the region\
  **shortname **: short name of the region\
  **nom_de **: name of the region in German\
  **nom_en **: name of the region in English\
  **nom_es **: name of the region in Spanish\
  **nom_fr **: name of the region in French\
  **nom_it **: name of the region in Italian\
  **nom_pt **: name of the region in Portuguese\
  **parent **: id of the parent region (0 if main genre)\
  **medias **{\
	**media_pictomonochrome **: media download url: Monochrome Pictogram\
	**media_pictocouleur **: media download url: Color Pictogram\
	**media_background **: media download url: Wallpaper\
  }\
}

* * * * *

Sample call\
<https://www.screenscraper.fr/api2/regionsListe.php?devid=xxx&devpassword=yyy&softname=zzz&output=xml&ssid=test&sspassword=test>\
 |

### languagesList.php: List of languages

| Input parameters:\
**devid **: your developer ID\
**devpassword **: your developer password\
**softname **: name of the calling software\
**output **: xml(default),json\
**ssid **(not required): ScreenScraper user ID\
**sspassword **(not required): ScreenScraper password of the user

* * * * *

Items : **languages**

Returned Items:\
**language **(xml)/ ***id ***(json) {\
  **id **: numeric identifier of the language\
  **shortname **: short name of the language\
  **nom_de **: language name in German\
  **name_en **: name of the language in English\
  **nom_es **: name of the language in Spanish\
  **nom_fr **: name of the language in French\
  **nom_it **: name of the language in Italian\
  **nom_pt **: name of the language in Portuguese\
  **parent **: parent language id (0 if main genre)\
  **medias **{\
	**media_pictomonochrome **: media download url: Monochrome Pictogram\
	**media_pictocouleur **: media download url: Color Pictogram\
	**media_background **: media download url: Wallpaper\
  }\
}

* * * * *

Sample call\
<https://www.screenscraper.fr/api2/languesListe.php?devid=xxx&devpassword=yyy&softname=zzz&output=xml&ssid=test&sspassword=test>\
 |

classificationListe.php : Liste des Classification (Game Rating)

| Input parameters:\
**devid **: your developer ID\
**devpassword **: your developer password\
**softname **: name of the calling software\
**output **: xml(default),json\
**ssid **(not required): ScreenScraper user ID\
**sspassword **(not required): ScreenScraper password of the user

* * * * *

Items : **classifications**

Returned Items:\
**language **(xml)/ ***id ***(json) {\
  **id **: numerical identifier of the classification\
  **shortname **: short name of the classification\
  **nom_de **: name of the classification in German (if existing)\
  **nom_en **: name of the classification in English (if existing)\
  **nom_es **: name of the classification in Spanish (if existing)\
  **nom_fr **: name of the classification in French (if existing)\
  **name_it **: name of the classification in Italian (if existing)\
  **nom_pt **: name of the classification in Portuguese (if existing)\
  **parent **: parent classification id (0 if main genre)\
  **medias **{\
	**media_pictomonochrome **: media download url: Monochrome Pictogram\
	**media_pictocouleur **: media download url: Color Pictogram\
	**media_background **: media download url: Wallpaper\
  }\
}

* * * * *

Sample call\
<https://www.screenscraper.fr/api2/classificationListe.php?devid=xxx&devpassword=yyy&softname=zzz&output=xml&ssid=test&sspassword=test>\
 |

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

Sample call\
<https://www.screenscraper.fr/api2/mediasSystemeListe.php?devid=xxx&devpassword=yyy&softname=zzz&output=xml&ssid=test&sspassword=test>\
 |

### mediasJeuListe.php: List of media for games

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

Sample call\
<https://www.screenscraper.fr/api2/mediasJeuListe.php?devid=xxx&devpassword=yyy&softname=zzz&output=xml&ssid=test&sspassword=test>\
 |

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

Sample call\
<https://www.screenscraper.fr/api2/infosJeuListe.php?devid=xxx&devpassword=yyy&softname=zzz&output=xml&ssid=test&sspassword=test>\
 |

### infosRomListe.php: List of info for roms

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

Sample call\
<https://www.screenscraper.fr/api2/infosRomListe.php?devid=xxx&devpassword=yyy&softname=zzz&output=xml&ssid=test&sspassword=test>\
 |

### mediaGroup.php: Download image media from game groups

| Input parameters:\
**devid **: your developer ID\
**devpassword **: your developer password\
**softname **: name of the calling software\
**ssid **(not required): ScreenScraper user ID\
**sspassword **(not required): ScreenScraper password of the user\
**crc **: crc calculation of the existing image locally\
**md5 **: md5 calculation of the existing image locally\
**sha1 **: sha1 calculation of the existing image locally\
**groupid **: numerical identifier of the groups (see genreListe.php, modeListe.php,... / type of groups = genre, mode, family, theme, style)\
**media **: text identifier of the media to return (see genreListe.php, modeListe.php,... / type of groups = genre, mode, family, theme, style)\
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

Sample call\
<https://www.screenscraper.fr/api2/mediaGroup.php?devid=xxx&devpassword=yyy&softname=zzz&ssid=test&sspassword=test&crc=&md5=&sha1=&groupid=1&media=logo-monochrome> |


### mediaCompagnie.php: Download media images of game companies

| Input parameters:\
**devid **: your developer ID\
**devpassword **: your developer password\
**softname **: name of the calling software\
**ssid **(not required): ScreenScraper user ID\
**sspassword **(not required): ScreenScraper password of the user\
**crc **: crc calculation of the existing image locally\
**md5 **: md5 calculation of the existing image locally\
**sha1 **: sha1 calculation of the existing image locally\
**companyid **: numerical identifier of the company\
**media **: text identifier of the media to return\
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

Sample call\
<https://www.screenscraper.fr/api2/mediaCompagnie.php?devid=xxx&devpassword=yyy&softname=zzz&ssid=test&sspassword=test&crc=&md5=&sha1=&companyid=3&media=logo-monochrome>\
 |

### systemsList.php: List of systems / system information / system media information

| Input parameters:\
**devid **: your developer ID\
**devpassword **: your developer password\
**softname **: name of the calling software\
**output **: xml(default),json\
**ssid **(not required): ScreenScraper user ID\
**sspassword **(not required): ScreenScraper password of the user

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

Items : **systems **(xml) / **systemes **(json)

Returned Items:\
**id **: numeric identifier of the system (to be provided in other API requests)\
**parentid **: numeric identifier of the parent system\
**names **{\
  **name_xx **: System name Region xx (xx = "shortname" variable from the regionsListe.php API)\
  ...\
  **nom_recalbox **: Name of the system in the Recalbox front-end\
  **retropie_name **: System name in the Retropie front-end\
  **name_launchbox **: Name of the system in the Launchbox front-end\
  **name_hyperspin **: Name of the system in the Hyperspin front-end\
  **common_names **: Common names given to the system in general\
}\
**extensions **: extensions of usable rom files (all emulators combined)\
**company **: Name of the system production company\
**type **: System type (Arcade, Console, Portable Console, Arcade Emulation, Pinball, Online, Computer, Smartphone)\
**startdate **: Year of start of production\
**enddate **: Year of end of production\
**romtype **: Type(s) of roms (see **romTypesList **)\
**supporttype **: Type of the system's original support(s) (see request **supportTypesList **)\
**medias **{\
**media_logosmonochrome **{\
  **media_logomonochrome_xx **: media download url: Logo Monochrome region xx (xx = "shortname" variable of the regionsListe.php API)\
  **media_logomonochrome_xx_crc **: CRC32 identifier of the media file (allows you to check if the online media is the same as local before downloading it)\
  **media_logomonochrome_xx_md5 **: md5 identifier of the media file (allows you to check if the online media is the same as local before downloading it)\
  **media_logomonochrome_xx_sha1 **: sha1 identifier of the media file (allows you to check if the online media is the same as local before downloading it)\
  ...\
}\
**media_wheels **{\
  **media_wheel_xx **: media download url: Logo Color region xx (xx = "shortname" variable of the regionsListe.php API)\
  **media_wheel_xx_crc **: CRC32 identifier of the media file (allows you to check if the online media is the same as local before downloading it)\
  **media_wheel_xx_md5 **: md5 identifier of the media file (allows you to check if the online media is the same as local before downloading it)\
  **media_wheel_xx_sha1 **: sha1 identifier of the media file (allows you to check if the online media is the same as local before downloading it)\
  ...\
}\
**media_wheelscarbon **{\
  **media_wheelcarbon_xx **: media download url: Wheel Carbon region xx (xx = "shortname" variable of the regionsListe.php API)\
  **media_wheelcarbon_xx_crc **: CRC32 identifier of the media file (allows you to check if the online media is the same as local before downloading it)\
  **media_wheelcarbon_xx_md5 **: md5 identifier of the media file (allows you to check if the online media is the same as local before downloading it)\
  **media_wheelcarbon_xx_sha1 **: sha1 identifier of the media file (allows you to check if the online media is the same as local before downloading it)\
  ...\
}\
**media_wheelscarbonvierge **{\
  **media_wheelcarbonvirgin_xx **: media download url: Wheel Carbon virgin region xx (xx = variable "shortname" of the regionsListe.php API)\
  **media_wheelcarbonvirge_xx_crc **: CRC32 identifier of the media file (allows you to check if the online media is the same as local before downloading it)\
  **media_wheelcarbonvirge_xx_md5 **: md5 identifier of the media file (allows you to check if the online media is the same as local before downloading it)\
  **media_wheelcarbonvirge_xx_sha1 **: sha1 identifier of the media file (allows you to check if the online media is the same as local before downloading it)\
  ...\
}\
**media_wheelssteel **{\
  **media_wheelsteel_xx **: media download url: Wheel Steel region xx (xx = "shortname" variable from the regionsListe.php API)\
  **media_wheelsteel_xx_crc **: CRC32 identifier of the media file (allows you to check if the online media is the same as local before downloading it)\
  **media_wheelsteel_xx_md5 **: md5 identifier of the media file (allows you to check if the online media is the same as local before downloading it)\
  **media_wheelsteel_xx_sha1 **: sha1 identifier of the media file (allows you to check if the online media is the same as local before downloading it)\
  ..\
}\
**media_wheelssteelvierge **{\
  **media_wheelsteelvirgin_xx **: media download url: Wheel Steel virgin region xx (xx = variable "shortname" of the regionsListe.php API)\
  **media_wheelsteelvirge_xx_crc **: CRC32 identifier of the media file (allows you to check if the online media is the same as local before downloading it)\
  **media_wheelsteelvirge_xx_md5 **: md5 identifier of the media file (allows you to check if the online media is the same as local before downloading it)\
  **media_wheelsteelvirge_xx_sha1 **: sha1 identifier of the media file (allows you to check if the online media is the same as local before downloading it)\
  ...\
}\
**media_photos **{\
  **media_photo_xx **: media download url: Region xx system photo (xx = "shortname" variable of the regionsListe.php API)\
  **media_photo_xx_crc **: CRC32 identifier of the media file (allows you to check if the online media is the same as locally before downloading it)\
  **media_photo_xx_md5 **: md5 identifier of the media file (allows you to check if the online media is the same as local before downloading it)\
  **media_photo_xx_sha1 **: sha1 identifier of the media file (allows you to check if the online media is the same as local before downloading it)\
  ...\
}\
**media_video **: media download url: System Overview Video\
  **media_video_crc **: CRC32 identifier of the media file (allows you to check if the online media is the same as local before downloading it)\
  **media_video_md5 **: md5 identifier of the media file (allows you to check if the online media is the same as local before downloading it)\
  **media_video_sha1 **: sha1 identifier of the media file (allows you to check if the online media is the same as local before downloading it)

**media_fanart **: media download url: game fanart (custom wallpaper)\
  **media_fanart_crc **: CRC32 identifier of the media file (allows you to check if the online media is the same as local before downloading it)\
  **media_fanart_md5 **: md5 identifier of the media file (allows you to check if the online media is the same as local before downloading it)\
  **media_fanart_sha1 **: sha1 identifier of the media file (allows you to check if the online media is the same as local before downloading it)\
**media_bezels **{\
  **media_bezels4-3 **{\
	**media_bezel4-3_xx **: media download url: Bezel 4:3 for horizontal games region xx (xx = variable "shortname" of the regionsListe.php API)\
	**media_bezel4-3_xx_crc **: CRC32 identifier of the media file (allows you to check if the online media is the same as local before downloading it)\
	**media_bezel4-3_xx_md5 **: md5 identifier of the media file (allows you to check if the online media is the same as local before downloading it)\
	**media_bezel4-3_xx_sha1 **: sha1 identifier of the media file (allows you to check if the online media is the same as local before downloading it)\
	...\
  }\
  **media_bezels4-3v **{\
	**media_bezel4-3v_xx **: media download url: Bezel 4:3 for vertical games region xx (xx = variable "shortname" of the regionsListe.php API)\
	**media_bezel4-3v_xx_crc **: CRC32 identifier of the media file (allows you to check if the online media is the same as local before downloading it)\
	**media_bezel4-3v_xx_md5 **: md5 identifier of the media file (allows you to check if the online media is the same as local before downloading it)\
	**media_bezel4-3v_xx_sha1 **: sha1 identifier of the media file (allows you to check if the online media is the same as local before downloading it)\
	...\
  }\
  **media_bezels16-9 **{\
	**media_bezel16-9_xx **: media download url: Bezel 16:9 for horizontal games region xx (xx = variable "shortname" of the regionsListe.php API)\
	**media_bezel16-9_xx_crc **: CRC32 identifier of the media file (allows you to check if the online media is the same as local before downloading it)\
	**media_bezel16-9_xx_md5 **: md5 identifier of the media file (allows you to check if the online media is the same as local before downloading it)\
	**media_bezel16-9_xx_sha1 **: sha1 identifier of the media file (allows you to check if the online media is the same as local before downloading it)\
	...\
  }\
  **media_bezels16-9v **{\
	**media_bezel16-9v_xx **: media download url: Bezel 16:9 for vertical games region xx (xx = "shortname" variable of the regionsListe.php API)\
	**media_bezel16-9v_xx_crc **: CRC32 identifier of the media file (allows you to check if the online media is the same as local before downloading it)\
	**media_bezel16-9v_xx_md5 **: md5 identifier of the media file (allows you to check if the online media is the same as local before downloading it)\
	**media_bezel16-9v_xx_sha1 **: sha1 identifier of the media file (allows you to check if the online media is the same as local before downloading it)\
	...\
  }\
  **media_bezels16-10 **{\
	**media_bezel16-10_xx **: media download url: Bezel 16:10 for horizontal games region xx (xx = "shortname" variable of the regionsListe.php API)\
	**media_bezel16-10_xx_crc **: CRC32 identifier of the media file (allows you to check if the online media is the same as local before downloading it)\
	**media_bezel16-10_xx_md5 **: md5 identifier of the media file (allows you to check if the online media is the same as local before downloading it)\
	**media_bezel16-10_xx_sha1 **: sha1 identifier of the media file (allows you to check if the online media is the same as local before downloading it)\
	...\
  }\
  **media_bezels16-10 **{\
	**media_bezel16-10v_xx **: media download url: Bezel 16:10 for vertical games region xx (xx = variable "shortname" of the regionsListe.php API)\
	**media_bezel16-10v_xx_crc **: CRC32 identifier of the media file (allows you to check if the online media is the same as local before downloading it)\
	**media_bezel16-10v_xx_md5 **: md5 identifier of the media file (allows you to check if the online media is the same as local before downloading it)\
	**media_bezel16-10v_xx_sha1 **: sha1 identifier of the media file (allows you to check if the online media is the same as local before downloading it)\
	...\
  }\
}\
**media_backgrounds **{\
  **media_background_xx **: media download url: System background region xx (xx = "shortname" variable of the regionsListe.php API)\
  **media_background_crc **: CRC32 identifier of the media file (allows you to check if the online media is the same as local before downloading it)\
  **media_background_md5 **: md5 identifier of the media file (allows you to check if the online media is the same as local before downloading it)\
  **media_background_sha1 **: sha1 identifier of the media file (allows you to check if the online media is the same as local before downloading it)\
  ...\
  }\
**media_screenmarquees **{\
  **media_screenmarquee_xx **: media download url: ScreenMarquee of the system region xx (xx = "shortname" variable of the regionsListe.php API)\
  **media_screenmarquee_crc **: CRC32 identifier of the media file (allows you to check if the online media is the same as local before downloading it)\
  **media_screenmarquee_md5 **: md5 identifier of the media file (allows you to check if the online media is the same as local before downloading it)\
  **media_screenmarquee_sha1 **: sha1 identifier of the media file (allows you to check if the online media is the same as local before downloading it)\
  ...\
  }\
**media_screenmarqueevierges **{\
  **media_screenmarqueeblank_xx **: media download url: ScreenMarquee Blank System Blank Region\
  **media_screenmarqueevierge_crc **: CRC32 identifier of the media file (allows you to check if the online media is the same as local before downloading it)\
  **media_screenmarqueevierge_md5 **: md5 identifier of the media file (allows you to check if the online media is the same as local before downloading it)\
  **media_screenmarqueevierge_sha1 **: sha1 identifier of the media file (allows you to check if the online media is the same as local before downloading it)\
  ...\
  }\
**media_boxs3dvierge **{\
  **media_box3dvirge_xx **: media download url: Image of the box in virgin 3D view region xx (xx = "shortname" variable of the regionsListe.php API)\
  **media_box3dvirge_crc **: CRC32 identifier of the media file (allows you to check if the online media is the same as locally before downloading it)\
  **media_box3dvirge_md5 **: md5 identifier of the media file (allows you to check if the online media is the same as local before downloading it)\
  **media_box3dvirge_sha1 **: sha1 identifier of the media file (allows you to check if the online media is the same as local before downloading it)\
  ...\
}\
**media_supports2dvierge **{\
  **media_support2dvirge_xx **: media download url: Media image in virgin front view region xx (xx = variable "shortname" of the regionsListe.php API)\
  **media_support2dvirge_crc **: CRC32 identifier of the media file (allows you to check if the online media is the same as local before downloading it)\
  **media_support2dvirge_md5 **: md5 identifier of the media file (allows you to check if the online media is the same as local before downloading it)\
  **media_support2dvirge_sha1 **: sha1 identifier of the media file (allows you to check if the online media is the same as local before downloading it)\
  ...\
}\
**media_checker **{\
  **media_controleur_xx **: media download url: Image of the controller (or the entire portable console) in front view region xx (xx = "shortname" variable of the regionsListe.php API)\
  **media_controleur_crc **: CRC32 identifier of the media file (allows you to check if the online media is the same as locally before downloading it)\
  **media_controleur_md5 **: md5 identifier of the media file (allows you to check if the online media is the same as locally before downloading it)\
  **media_controleur_sha1 **: sha1 identifier of the media file (allows you to check if the online media is the same as locally before downloading it)\
  ...\
}\
**media_illustration **{\
  **media_illustration_xx **: media download url: Image of the system in isometric view above/before region xx (xx = "shortname" variable of the regionsListe.php API)\
  **media_illustration_crc **: CRC32 identifier of the media file (allows you to check if the online media is the same as local before downloading it)\
  **media_illustration_md5 **: md5 identifier of the media file (allows you to check if the online media is the same as local before downloading it)\
  **media_illustration_sha1 **: sha1 identifier of the media file (allows you to check if the online media is the same as local before downloading it)\
  ...\
}

* * * * *

Sample call\
<https://www.screenscraper.fr/api2/systemesListe.php?devid=xxx&devpassword=yyy&softname=zzz&output=XML&ssid=test&sspassword=test> |


### mediaSysteme.php: Download system image media

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
**media **: text identifier of the media to return (see systemesListe.php)\
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

Sample call\
<https://www.screenscraper.fr/api2/mediaSysteme.php?devid=xxx&devpassword=yyy&softname=zzz&ssid=test&sspassword=test&crc=&md5=&sha1=&systemeid=1&media=wheel(wor)>\
 |

### mediaVideoSysteme.php: Download system video media

| Input parameters:\
**devid **: your developer ID\
**devpassword **: your developer password\
**softname **: name of the calling software\
**ssid **(not required): ScreenScraper user ID\
**sspassword **(not required): ScreenScraper password of the user\
**crc **: crc calculation of the existing video locally\
**md5 **: md5 calculation of the existing video locally\
**sha1 **: sha1 calculation of the existing video locally\
**systemeid **: numeric identifier of the system (see systemesListe.php)\
**media **: text identifier of the media to return (see systemesListe.php)\
**mediaformat **: format (extension) of the media: ex: jpg, png, mp4, zip, mp3, ... (not compulsory, informative data: does not return the media in the specified format)

* * * * *

Returned Item: **Video MP4**\
Where\
Text **CRCOK **or **MD5OK **or **SHA1OK **if the crc, md5 or sha1 parameter is the same as the crc, md5 or sha1 calculation of the server video (update optimization)\
Where\
Text **NOMEDIA **if the media file was not found

* * * * *

Sample call\
<https://www.screenscraper.fr/api2/mediaVideoSysteme.php?devid=xxx&devpassword=yyy&softname=zzz&ssid=test&sspassword=test&crc=&md5=&sha1=&systemeid=1&media=video>\
 |

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
<https://www.screenscraper.fr/api2/jeuRecherche.php?devid=xxx&devpassword=yyy&softname=zzz&output=xml&ssid=test&sspassword=test&systemeid=1&recherche=sonic> |


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

Sample call\
<https://www.screenscraper.fr/api2/mediaJeu.php?devid=xxx&devpassword=yyy&softname=zzz&ssid=test&sspassword=test&crc=&md5=&sha1=&systemeid=1&jeuid=3&media=wheel-hd(wor)>\
 |

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

Sample call\
<https://www.screenscraper.fr/api2/mediaVideoJeu.php?devid=xxx&devpassword=yyy&softname=zzz&ssid=test&sspassword=test&crc=&md5=&sha1=&systemeid=1&jeuid=3&media=video>\
 |

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

Sample call\
<https://www.screenscraper.fr/api2/mediaManuelJeu.php?devid=xxx&devpassword=yyy&softname=zzz&ssid=test&sspassword=test&crc=&md5=&sha1=&systemeid=1&jeuid=3&media=manuel(eu)> |


### jeuInfos.php: Information on a game / Media of a game

| Input parameters:\
**devid **: your developer ID\
**devpassword **: your developer password\
**softname **: name of the calling software\
**output **: xml(default),json\
**ssid **(not required): ScreenScraper user ID\
**sspassword **(not required): ScreenScraper password of the user\
**crc ***: crc calculation of the existing rom/iso file/folder locally\
**md5 ***: md5 calculation of existing rom/iso file/folder locally\
**sha1 ***: sha1 calculation of the existing rom/iso file/folder locally\
**systemeid **: numeric identifier of the system (see systemesListe.php)\
**romtype **: Type of "rom": single rom file / single iso file / folder\
**romname **: file name (with extension) or folder name\
**romsize **: Size in bytes of the file or folder\
**serialnum **: Force the search for the game with the serial number of the associated rom (iso)\
**gameid ****: Force the search for the game with its numerical identifier\
** unless there is a waiver, you must send at least one (the best would be 3) of these calculations (crc,md5,sha1) of rom/iso file or folder identification with your request.*\
*** No rom information is sent in this case.*

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

Item : **Game**

Returned Items:\
**id **: numerical identifier of the game\
**romid **: numeric identifier of the rom\
**notgame **: (true/false) indicates if the rom is assigned to a game or to a NON game (demo/app/...)\
**name **: Game name (internal ScreenScraper)\
**names **{\
  **name_ss **: Game name (internal ScreenScraper)\
  **nom_xx **: Game title region xx (xx = "shortname" variable from the regionsListe.php API)\
  ...\
}

*If the rom is assigned to a NON game, the "ZZZ(notgame):" tag is added in front of the ScreenScraper internal name and names by region*

**regionshortnames **{\
  **regionshortname **: Short name of the region of the rom (if available)\
}\
**cloneof **: Clone ID (if available)\
**systems **{\
  **id **: Numerical identifier of the game system\
  **name **: Game system name\
  **parentid **: Numerical identifier of the parent system of the game system\
}\
**publisher **: name of publisher\
**mediaeditor **{\
  **editeurmedia_pictomonochrome **: media download url: Monochrome logo of the publisher\
  **editeurmedia_pictocouleur **: media download url: Publisher's color logo\
}

**developer **: Name of developer\
**developpeurmedias **{\
  **developpeurmedia_pictomonochrome **: media download url: Monochrome developer logo\
  **developpeurmedia_pictocouleur **: media download url: Color logo of the developer\
}

**players **: Number of players\
**notemedias **{\
  **playersmedia_pictoliste **: media download url: List pictogram\
  **playersmedia_pictomonochrome **: media download url: Monochrome Pictogram\
  **playersmedia_pictocouleur **: media download url: Color Pictogram\
}\
**rating **: Rating out of 20\
**notemedias **{\
  **notemedia_pictoliste **: media download url: List pictogram\
  **notemedia_pictomonochrome **: media download url: Logo Monochrome\
  **notemedia_pictocouleur **: media download url: Color Logo\
}

**topstaff **: Game included in the TOP Staff ScreenScraper *(0: not included, 1: included)*\
**rotation **: rotation of the game screen *(only for arcade games)*\
**resolution **: game resolution *(only for arcade games)*\
**controls **: info on game controls *(only for arcade games)*\
**colors **: control colors *(only for arcade games)*\
**synopsis **{\
  **synopsis_xx **: Description of the game in language xx (xx = "shortname" variable of the languagesList.php API)\
  ...\
}\
**classifications **{\
  **classifications_ *organization ***Classification of the game\
  **classifications_ *organization *_media **{\
	**classifications_ *organization *_media_pictoliste **: media download url: List pictogram\
	**classifications_ *organization *_media_pictomonochrome **: media download url: Monochrome Pictogram\
	**classifications_ *organization *_media_pictocouleur **: media download url: Color Pictogram\
  }\
}\
**dates **{\
  **id text region (france=date_fr,europe=date_eu,usa=date_us,japon=date_jp,...) **: Release date in the region indicated\
}\
**genres **{\
  **genres_id **[\
	**genre_id **: Numerical identifier of the genre of the game (See genresList.php)\
	**shortname **: Digital identifier "standard gender" version (See [wikipedia ](https://en.wikipedia.org/wiki/List_of_video_game_genres)+ 20: gender = "Adult")\
	**Main **: Main Genre (0: non-main, 1: Main)\
	**parentid **: Numeric identifier of the main genre of the genre (See genresList.php)\
  ]

  **genre_ *id *_medias **{ *id: numerical identifier of the genre (See genresList.php)*\
	**genre_ *id *_media_pictoliste **: media download url: List pictogram\
	**genre_ *id *_media_pictomonochrome **: media download url: Monochrome Pictogram\
	**genre_ *id *_media_pictocouleur **: media download url: Color Pictogram\
  }

  **genres_xx **[\
	**genre_xx **: Genre of the game in language xx (xx = "shortname" variable of the languagesList API.php) (See genresList.php)\
  ]\
  ...\
}\
**modes **{\
  **modes_id **[\
	**mode_id **: Numerical identifier of the game mode\
  ]

  **mode_ *id *_medias **{ *id: numerical identifier of the game mode*\
	**mode_ *id *_media_pictoliste **: media download url: List pictogram\
	**mode_ *id *_media_pictomonochrome **: media download url: Monochrome Pictogram\
	**mode_ *id *_media_pictocouleur **: media download url: Color Pictogram\
  }

  **modes_xx **[\
	**mode_xx **: Game mode in language xx (xx = "shortname" variable of the languagesList.php API)\
  ]\
  ...\
}\
**families **{\
  **families_id **[\
	**family_id **: Numerical identifier of the family of the game\
  ]

  **family_ *id *_medias **{ *id: numerical identifier of the game family*\
	**family_ *id *_media_pictoliste **: media download url: List pictogram\
	**family_ *id *_media_pictomonochrome **: media download url: Monochrome Pictogram\
	**family_ *id *_media_pictocouleur **: media download url: Color Pictogram\
  }

  **families_xx **[\
	**family_xx **: Family of the game in language xx (xx = "shortname" variable of the languagesList.php API) (ex: "Sonic & Knuckles" Family: "Sonic the Hedgehog")\
  ]\
  ...\
}\
**numbers **{\
  **numbers_id **[\
	**numero_id **: Numeric identifier of the game number\
  ]

  **numero_ *id *_medias **{ *id: numerical identifier of the game number*\
	**numero_ *id *_media_pictoliste **: media download url: List pictogram\
	**numero_ *id *_media_pictomonochrome **: media download url: Monochrome Pictogram\
	**numero_ *id *_media_pictocouleur **: media download url: Color Pictogram\
  }

  **numbers_xx **[\
	**numero_xx **: Number in the series of the game in language xx (xx = "shortname" variable of the languagesList.php API)\
  ]\
  ...\
}\
**themes **{\
  **themes_id **[\
	**theme_id **: Numerical ID of the game theme\
  ]

  **theme_ *id *_medias **{ *id: numeric identifier of the game theme*\
	**theme_ *id *_media_pictoliste **: media download url: List pictogram\
	**theme_ *id *_media_pictomonochrome **: media download url: Monochrome Pictogram\
	**theme_ *id *_media_pictocouleur **: media download url: Color Pictogram\
  }

  **themes_xx **[\
	**theme_xx **: Game theme in language xx (xx = "shortname" variable of the languagesList.php API)\
  ]\
  ...\
}\
**styles **{\
  **styles_id **[\
	**style_id **: Numerical identifier of the style of the game in French (See genresListe.php)\
  ]

  **style_ *id *_medias **{ *id: numeric game style identifier*\
	**style_ *id *_media_pictoliste **: media download url: List pictogram\
	**style_ *id *_media_pictomonochrome **: media download url: Monochrome Pictogram\
	**style_ *id *_media_pictocouleur **: media download url: Color Pictogram\
  }

  **styles_xx **[\
	**style_xx **: Style of the game in language xx (xx = "shortname" variable of the languagesList.php API)\
  ]\
  ...\
}\
**sp2kcfg **: Text content of config file .p2k (Pad2Keyboard) recalbox

**actions **[\
  **action **{\
	**id **: Numerical identifier of the action\
	**control **[\
; **language **: Action language\
; **text **: Text of the action in the specified language\
; **recalboxtext **: Text of the action in the indicated language and standardized buttons recalbox\
	]\
  }\
  ...\
]\
**medias **{\
  **media_screenshot **: media download url: Screenshot\
  **media_fanart **: media download url: game fanart (custom wallpaper)\
  **media_video **: media download url: Game Video Capture\
  **media_marquee **: media download url: Marquee\
  **media_screenmarquee **: media download url: Screen Marquee\
**media_wheels **{\
  **media_wheel_xx **: media download url: Logo Color region region xx (xx = "shortname" variable of the regionsListe.php API)\
  ...\
}\
**media_wheelscarbon **{\
  **media_wheelcarbon_xx **: media download url: Wheel Carbon version region region xx (xx = "shortname" variable from the regionsListe.php API)\
  ...\
}\
**media_wheelssteel **{\
  **media_wheelsteel_xx **: media download url: Wheel Steel version region region xx (xx = "shortname" variable from the regionsListe.php API)\
  ...\
}\
**media_boxes **{\
  **media_boxes_texture **{\
	**media_box_texture_xx **: media download url: Texture image of the box region region xx (xx = variable "short name" of the regionsListe.php API)\
	...\
  }\
  **media_boxes_2d **{\
	**media_boitier_2d_xx **: media download url: Image Boitier 2D version region region xx (xx = "shortname" variable of the regionsListe.php API)\
	...\
  }\
  **media_boxes_3d **{\
	**media_boitier_3d_xx **: media download url: Image Boitier 3D version region region xx (xx = "shortname" variable of the regionsListe.php API)\
	...\
  }\
}\
**media_supports **{\
  **media_supports_texture **{\
	**media_support_texture_xx **: media download url: Image Texture of support region region xx (xx = variable "short name" of the regionsListe.php API)\
	...\
  }\
  **media_supports_2d **{\
	**media_support_2d_xx **: media download url: Image Support 2D version region xx (xx = "shortname" variable of the regionsListe.php API)\
	...\
  }\
}

For multi-support Games (example on several CDs), add the support number, example: **media_support_texture_fr1 **or **media_support_2d_eu2**

**media_flyer **{\
  **media_flyer_xx **: media download url: Image of the flyer region xx (xx = "shortname" variable of the regionsListe.php API)\
  ...\
}

For multi-page Flyers, add the page number, example: **media_flyer_wor1 **, **media_flyer_wor2 **, ...

**media_manuel **{\
  **media_manuel_xx **: media download url: Manual in PDF format - region xx (xx = "shortname" variable of the regionsListe.php API)\
  ...\
}\
**media_bezels **{\
  **media_bezel4-3 **{\
	**media_bezel4-3_xx **: media download url: Bezel 4:3 of the game region xx (xx = variable "shortname" of the regionsListe.php API)\
	...\
  }\
  **media_bezel16-9 **{\
	**media_bezel16-9_xx **: media download url: Bezel 16:9 of the game region xx (xx = variable "shortname" of the regionsListe.php API)\
	...\
  }\
  **media_bezel16-10 **{\
	**media_bezel16-10_xx **: media download url: Bezel 16:10 of the game region xx (xx = "shortname" variable of the regionsListe.php API)\
	...\
  }\
}

**roms **[ *List of known roms associated with the game*\
  **rom **(xml) / **romid **(json) {\
	**id **: numerical identifier of the rom\
	**romnumsupport **: support number (ex: 1 = diskette 01 or CD 01)\
	**romtotalsupport **: total number of supports (ex: 2 = 2 floppies or 2 CDs)\
	**romfilename **: name of the rom file or folder\
	**romsize **: size in bytes of the rom file or size of the contents of the folder\
	**romcrc **: result of the CRC32 calculation of the rom file or the largest file in the "rom" folder\
	**rommd5 **: result of the MD5 calculation of the rom file or the largest file in the "rom" folder\
	**romsha1 **: result of the SHA1 calculation of the rom file or the largest file in the "rom" folder\
	**romcloneof **: numerical identifier of the parent rom if the rom is a clone (Arcade Systems)\
	**beta **: Beta version of the game (0=no / 1=yes)\
	**demo **: Demo version of the game (0=no / 1=yes)\
	**trad **: Translated version of the game (0=no / 1=yes)\
	**hack **: Modified version of the game (0=no / 1=yes)\
	**unl **: Game not "Official" (0=no / 1=yes)\
	**alt **: Alternative version of the game (0=no / 1=yes)\
	**best **: Best version of the game (0=no / 1=yes)\
	**netplay **: Netplay compatible (0=no / 1=yes)\
]

**rom **{ *Information about scraped rom (if found in database)*\
  **rom **(xml) / **romid **(json) {\
	**id **: numerical identifier of the rom\
	**romnumsupport **: support number (ex: 1 = diskette 01 or CD 01)\
	**romtotalsupport **: total number of supports (ex: 2 = 2 floppies or 2 CDs)\
	**romfilename **: name of the rom file or folder\
	**romserial **: serial number of the manufacturer\
	**romregions **: region(s) de la rom ou du dossier (ex : "fr,us,sp" )\
	**romlangues **: language(s) of the rom or of the folder (ex: "fr,en,es" )\
	**room type **: type of room\
	**romsupporttype **: type de support\
	**romsize **: size in bytes of the rom file or size of the contents of the folder\
	**romcrc **: result of the CRC32 calculation of the rom file or the largest file in the "rom" folder\
	**rommd5 **: result of the MD5 calculation of the rom file or the largest file in the "rom" folder\
	**romsha1 **: result of the SHA1 calculation of the rom file or the largest file in the "rom" folder\
	**romcloneof **: numerical identifier of the parent rom if the rom is a clone (Arcade Systems)\
	**beta **: Beta version of the game (0=no / 1=yes)\
	**demo **: Demo version of the game (0=no / 1=yes)\
	**trad **: Translated version of the game (0=no / 1=yes)\
	**hack **: Modified version of the game (0=no / 1=yes)\
	**unl **: Game not "Official" (0=no / 1=yes)\
	**alt **: Alternative version of the game (0=no / 1=yes)\
	**best **: Best version of the game (0=no / 1=yes)\
	**netplay **: Netplay compatible (0=no / 1=yes)\
	**players **: Number of players specific to the rom (if different from the "original" game)\
	**dates **{\
	  **id text region (france=date_fr,europe=date_eu,usa=date_us,japon=date_jp,...) **: Release date specific to the rom (if different from the "original" game) in the region indicated\
	}\
	**publisher **: Name of the rom-specific publisher (if different from the "original" game)\
	**developer **: Name of the developer specific to the rom (if different from the "original" game)\
	**synopsis **{\
	  **synopsis_xx **: Description specific to the rom (if different from the "original" game) in language xx (xx = variable "shortname" of the languagesList.php API)\
	  ...\
	}\
	**clonetypes **{\
	  **clonetypes_id **: numeric identifier of the clone type\
	  **clonetypes_xx **: designation of the region xx hack type (xx = "shortname" variable from the regionsListe.php API)\
	  ...\
	}\
	**hacktypes **{\
	  **hacktypes_id **: numeric identifier of the hack type\
	  **hacktypes_xx **: designation of the region xx hack type (xx = "shortname" variable of the regionsListe.php API)\
	  ...\
	}\
  }\
}

* * * * *

Sample call\
<https://www.screenscraper.fr/api2/jeuInfos.php?devid=xxx&devpassword=yyy&softname=zzz&output=xml&ssid=test&sspassword=test&crc=50ABC90A&systemeid=1&romtype=rom&romnom=Sonic%20The%20Hedgehog%202%20(World).zip&romtaille=749652> |


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

Sample call\
<https://www.screenscraper.fr/api2/mediaJeu.php?devid=xxx&devpassword=yyy&softname=zzz&ssid=test&sspassword=test&crc=&md5=&sha1=&systemeid=1&jeuid=3&media=wheel-hd(wor)>\
 |

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

Sample call\
<https://www.screenscraper.fr/api2/mediaVideoJeu.php?devid=xxx&devpassword=yyy&softname=zzz&ssid=test&sspassword=test&crc=&md5=&sha1=&systemeid=1&jeuid=3&media=video>\
 |

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

Sample call\
<https://www.screenscraper.fr/api2/mediaManuelJeu.php?devid=xxx&devpassword=yyy&softname=zzz&ssid=test&sspassword=test&crc=&md5=&sha1=&systemeid=1&jeuid=3&media=manuel(eu)> |


## Lists of Types

### List of text info types for games (modiftypeinfo)

| Type | Designation | Region | Tongue | Multiple choice | Format |
| --- | --- | --- | --- | --- | --- |
| name | Game Name (by Region) | mandatory | | | Text |
| editor | Editor | | | | Text |
| developer | Developer | | | | Text |
| players | Numbers of players) | | | | Group name (see groups) |
| score | Note | | | | Score out of 20 from 0 to 20 |
| rating | Classification | | | yes | Group name (see groups) |
| genres | Genre(s) | | | yes | French name of the group (see groups) |
| datessortie | Release date(s) | mandatory | | | Format: yyyy-mm-dd ("xxxx-01-01" if year only) |
| rotation | Rotation | | | | 0 a 360 |
| resolution | Resolution | | | | Text: Width x height in pixels (ex: 320x240) |
| modes | Game Mode(s) | | | yes | Text |
| families | Family(ies) | | | yes | Nom de la famille (ex: "Sonic" pour "Sonic 3D pinball") |
| number | Number | | | yes | Name of the series + Number in the series (ex: "sonic the Hedgehog 2") |
| styles | Style(s) | | | yes | Text: Graphic Style |
| themes | Theme(s) | | | | Text: Game theme (e.g. "Vampire") |
| description | Synopsis | | mandatory | | Text |

### List of text info types for roms (modiftypeinfo)

| Type | Designation | Region | Tongue | Multiple choice | Format |
| --- | --- | --- | --- | --- | --- |
| developer | Developer | | | | Text |
| editor | Editor | | | | Text |
| datessortie | Release date(s) | mandatory | | | Format: yyyy-mm-dd ("xxxx-01-01" if year only) |
| players | Numbers of players) | | | | Group name (see groups) |
| regions | Region (s) | | | yes | French name of the group (see groups) |
| languages | Language (s) | | | yes | French name of the group (see groups) |
| clonetype | Type(s) de Clone | | | yes | Text |
| hacktype | Type(s) de Hack | | | yes | Text |
| friendly | Friend with... | | | yes | Text |
| serial | Manufacturer serial number | | | yes | Text |
| description | Synopsis | | mandatory | | Text |

### List of media types (regionsList)

| Type | Designation | Format | Region | Num Support | Multi-Version |
| --- | --- | --- | --- | --- | --- |
| sstitle | Screenshot Titre | jpg | mandatory | | |
| ss | Screenshot | jpg | mandatory | | |
| fanart | Fan Art | jpg | | | |
| video | Video | mp4 | | | |
| themehs | Hyperspin Theme | zip | | | |
| marquee | Marquee | png | | | |
| screenmarquee | ScreenMarquee | png | mandatory | | |
| overlay | Overlay | png | mandatory | | |
| manuel | Manuel | pdf | mandatory | | |
| flyer | Flyer | png | mandatory | mandatory | |
| steamgrid | Steam Grid | jpg | | | |
| maps | Maps | jpg | | | yes |
| wheel | Wheel | png | mandatory | | |
| wheel-hd | Logos HD | png | mandatory | | |
| box-2D | Case: Front | png | mandatory | mandatory | |
| box-2D-side | Case: Edge | png | mandatory | mandatory | |
| box-2D-back | Case: Back | png | mandatory | mandatory | |
| box-texture | Case: Textured | png | mandatory | mandatory | |
| support-texture | Support : Texture | png | mandatory | mandatory | |
| box-scan | Case: Source(s) | png | mandatory | mandatory | yes |
| support-scan | Support : Source(s) | png | mandatory | mandatory | yes |
| bezel-4-3 | Bezel 4:3 Horizontal | png | mandatory | | |
| bezel-4-3-v | Bezel 4:3 Vertical | png | mandatory | | |
| bezel-4-3-cocktail | Bezel 4:3 Cocktail | png | mandatory | | |
| bezel-16-9 | Bezel 16:9 Horizontal | png | mandatory | | |
| bezel-16-9-v | Bezel 16:9 Vertical | png | mandatory | | |
| bezel-16-9-cocktail | Bezel 16:9 Cocktail | png | mandatory | | |
| wheel-tarcisios | Wheel Tarcisio's | png | | | |
| videotable | Video Table (FullHD) | mp4 | | | |
| videotable4k | Video Table (4k) | mp4 | | | |
| videofronton16-9 | Video Fronton (3 Screens) | mp4 | | | |
| videofronton4-3 | Video Fronton (2 Screens) | mp4 | | | |
| videodmd | DMD video | mp4 | | | |
| video tops | Video Topper | mp4 | | | |
| sstable | Screenshot Table | png | | | |
| ssfronton1-1 | Screenshot Fronton 1:1 | png | | | |
| ssfronton4-3 | Screenshot Fronton 4:3 | png | | | |
| ssfronton16-9 | Screenshot Fronton 16:9 | png | | | |
| ssdmd | Screenshot DMD | png | | | |
| stops | Screenshot Topper | png | | | |
