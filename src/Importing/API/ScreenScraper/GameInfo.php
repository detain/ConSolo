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
<https://www.screenscraper.fr/api2/infosJeuListe.php?devid=xxx&devpassword=yyy&softname=zzz&output=json&ssid=test&sspassword=test>\
