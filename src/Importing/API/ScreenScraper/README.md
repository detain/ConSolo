# ScreenScraper API Docs

* Web API v2 Docs: https://www.screenscraper.fr/webapi2.php?alpha=0&numpage=0


**API Calls**

*   [ScreenScraper user information](#ssuserinfosphp-screenscraper-user-information)
*   [List of ScreenScraper user levels](#userlevelslistephp-list-of-screenscraper-user-levels)
*   [List of numbers of players](#nbjoueurslistephp-list-of-numbers-of-players)
*   [List of support types](#supporttypeslistephp-list-of-support-types)
*   [List of room types](#romtypeslistephp-list-of-room-types)
*   [List of genres](#genreslistphp-list-of-genres)
*   [List of regions](#regionslistephp-list-of-regions)
*   [List of languages](#languageslistphp-list-of-languages)
*   [Liste des Classification (Game Rating)](#classificationlistephp--liste-des-classification-game-rating)
*   [List of media for systems](#mediassystemelistephp-list-of-media-for-systems)
*   [List of media for games](#mediasjeulistephp-list-of-media-for-games)
*   [List of info for games](#infosjeulistephp-list-of-info-for-games)
*   [List of info for roms](#infosromlistephp-list-of-info-for-roms)
*   [Download image media from game groups](#mediagroupphp-download-image-media-from-game-groups)
*   [Download image media from game groups](#mediacompagniephp-download-media-images-of-game-companies)
*   [List of systems / system information / system media information](#systemslistphp-list-of-systems--system-information--system-media-information)
*   [Download system image media](#mediasystemephp-download-system-image-media)
*   [Download system video media](#mediavideosystemephp-download-system-video-media)
*   [Search for a game with its name (returns a table of games (limited to 30 games) classified by probability)](#jeurecherchephp-search-for-a-game-with-its-name-returns-a-table-of-games-limited-to-30-games-classified-by-probability)
*   [Information on a game / Media of a game](#jeuinfosphp-information-on-a-game--media-of-a-game)
*   [Download game image media](#mediajeuphp-download-game-image-media-1)
*   [Download game video media](#mediavideojeuphp-download-game-video-media-1)
*   [Download game manuals](#mediamanueljeuphp-download-game-manuals-1)


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
