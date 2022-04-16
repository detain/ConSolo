<?php
/*
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

Sample call
*/
global $config;
$url = 'https://www.screenscraper.fr/api2/systemesListe.php?devid='.$config['screenscraper']['api_user'].'&devpassword='.$config['screenscraper']['api_pass'].'&softname=ConSolo&output=json';
