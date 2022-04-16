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
