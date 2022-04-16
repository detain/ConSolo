<?php
/*
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
/*
crc *: crc calculation of the existing rom/iso file/folder locally
md5 *: md5 calculation of existing rom/iso file/folder locally
sha1 *: sha1 calculation of the existing rom/iso file/folder locally
systemeid : numeric identifier of the system (see systemesListe.php)
romtype : Type of "rom": single rom file / single iso file / folder
romname : file name (with extension) or folder name
romsize : Size in bytes of the file or folder
serialnum : Force the search for the game with the serial number of the associated rom (iso)
gameid **: Force the search for the game with its numerical identifier
* unless there is a waiver, you must send at least one (the best would be 3) of these calculations (crc,md5,sha1) of rom/iso file or folder identification with your request.
** No rom information is sent in this case.
*/
$return = ssApi('jeuInfos');
if ($return['code'] == 200) {
	//echo "Response:".print_r($return,true)."\n";
	$romTypes = $return['response']['response']['jeu'];
	file_put_contents('romTypes.json', json_encode($romTypes, JSON_PRETTY_PRINT));
	print_r($romTypes);
}
$url = 'https://www.screenscraper.fr/api2/jeuInfos.php?devid='.$config['screenscraper']['api_user'].'&devpassword='.$config['screenscraper']['api_pass'].'&softname=ConSolo&output=json&crc=50ABC90A&systemeid=1&romtype=rom&romnom=Sonic%20The%20Hedgehog%202%20(World).zip&romtaille=749652';

