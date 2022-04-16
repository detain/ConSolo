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
<https://www.screenscraper.fr/api2/regionsListe.php?devid=xxx&devpassword=yyy&softname=zzz&output=json&ssid=test&sspassword=test>\
 |
