## mediaGroup.php: Download image media from game groups

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

Sample call
*/
global $config;
$url = 'https://www.screenscraper.fr/api2/mediaGroup.php?devid='.$config['screenscraper']['api_user'].'&devpassword='.$config['screenscraper']['api_pass'].'&softname=ConSolo&crc=&md5=&sha1=&groupid=1&media=logo-monochrome';
