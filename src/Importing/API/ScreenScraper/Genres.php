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
<https://www.screenscraper.fr/api2/genresListe.php?devid=xxx&devpassword=yyy&softname=zzz&output=json&ssid=test&sspassword=test>\
 |
