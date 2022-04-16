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
