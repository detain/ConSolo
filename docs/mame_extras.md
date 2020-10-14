## MAME EXTRAs

Jump to: [navigation](http://wiki.pleasuredome.org.uk/index.php/MAME_EXTRAs#mw-head), [search](http://wiki.pleasuredome.org.uk/index.php/MAME_EXTRAs#p-search)

This torrent is a compilation made by the Pleasuredome staff of files from different sources.

The files are used by the [MAME](http://wiki.pleasuredome.org.uk/index.php/MAME) emulator or by [frontends](http://wiki.pleasuredome.org.uk/index.php/Frontend). They improve the playing experience.

All the contents of this torrent can be obtained from the websites of the original authors.

From the very beginning this torrent was made to be instantly usable while seeding back the contents.

  
 

<table><tbody><tr><td><h2>Contents</h2></td></tr></tbody></table>

<table><tbody><tr><td><ul><li><a href="http://wiki.pleasuredome.org.uk/index.php/MAME_EXTRAs#Releases">1 Releases</a></li><li><a href="http://wiki.pleasuredome.org.uk/index.php/MAME_EXTRAs#Reproducing_the_torrent.27s_contents">2 Reproducing the torrent's contents</a></li><li><a href="http://wiki.pleasuredome.org.uk/index.php/MAME_EXTRAs#Details">3 Details</a></li><li><a href="http://wiki.pleasuredome.org.uk/index.php/MAME_EXTRAs#See_also">4 See also</a></li><li><a href="http://wiki.pleasuredome.org.uk/index.php/MAME_EXTRAs#References">5 References</a></li></ul></td></tr></tbody></table>

## Releases

The MAME EXTRAs is usually released about two weeks after each MAME release. This has always been the case, as it's necessary to wait until all the content is up-to-date and made available by all the sources used. Do not ask when or if a new version of this torrent will be released, it will be released when it's ready.

The [VideoSnaps](http://www.progettosnaps.net/videosnaps/) (short videos intended to be played by frontends as previews) and [Soundtracks](http://www.progettosnaps.net/soundtrack/) (in MP3 format) are actually part of the MAME EXTRAs, but due to the size they are in a separate torrent named MAME Multimedia that is released together with the full MAME EXTRAs torrent.

The "MAME EXTRAs Update" torrent has only the new files required to update both the MAME EXTRAs and MAME Multimedia torrents from one version to the next version. The files that are provided by [progetto-SNAPS](http://www.progettosnaps.net/) can be easily downloaded with [Arcade Database Tools](http://wiki.pleasuredome.org.uk/index.php/Arcade_Database_Tools).

  
 

## Reproducing the torrent's contents

Below are three methods to reproduce the torrent's contents using [ROM Managers](http://wiki.pleasuredome.org.uk/index.php/ROM_Manager):

  
 

<table><tbody><tr><td><strong>Method 1</strong></td></tr><tr><td><p>- Download the update set, if available.</p><p>- If you own a previous set, unzip all the existing zipfiles that contain the non-zipped content into a folder of the same name (in 7-zip -&gt; Extract to "*\").</p><p>- Create a temporary folder called "_scan" in the parent folder.</p><p>- Move all the (extracted) folders with the non-zipped content into the "_scan" folder.</p><p>- Load the "all_non-zipped_content.dat" into CMP and in the Settings, point at the temporary "_scan" folder.</p><p>- Scan/Fix*/Rebuild the content until it's 100% complete and use the update content as rebuild source.</p><p>* Note: In case of Datfile Problem messages -&gt; Yes To All</p><p>- Zip the internal content of all the individual folders in the temporary "_scan" folder and torrentzip (64-bit) them afterwards.</p><p>- Move the zipfiles from the temporary "_scan" folder to the parent folder.</p><p>- When all is finished, delete the temporary "_scan" folder.</p></td></tr></tbody></table>

  
 

<table><tbody><tr><td><strong>Method 2 (fastest)</strong></td></tr><tr><td><p>- download the Update EXTRAs</p><p>- create a folder "MAME 0.xxx EXTRAs\_scan"</p><p>note: replace 0.xxx by the current MAME EXTRAs version</p><p>- load the all_non-zipped_content.dat in CMP and point it at "MAME 0.xxx EXTRAs\_scan" in the Settings</p><p>- scan (New Scan without fixing) the empty "MAME 0.xxx EXTRAs\_scan" folder</p><p>- rebuild from the previous full version and from the current Update EXTRAs</p><p>- scan (New Scan) the result, which should now be 100% complete</p><p>- zip the internal content of each folder (except ctrlr, dats and folders) in "MAME 0.xxx EXTRAs\_scan"</p><p>- move the zipfiles and the dats, folder, ctrlr folders to "MAME 0.xxx EXTRAs\" and delete the _scan folder</p><p>- drag 'n drop the zipfiles on Torrenzip.NET (way faster!) or trrntzip64.exe</p><p>- scan/fix/rebuild and torrenzip the artwork and samples, using their datfiles</p><p>- copy the cheat.7z to "MAME 0.xxx EXTRAs\"</p><p>- copy the _ReadMe_.txt to "MAME 0.xxx EXTRAs\"</p><p>- check if it matches the torrent and join.</p></td></tr></tbody></table>

  
 

<table><tbody><tr><td><strong>Method 3 - Using RomVault and a script created by member kdin6tl3nm</strong></td></tr><tr><td><ol><li>Download the MAME EXTRAs dat-files zip from the MAME forum topic in the <a href="http://forum.pleasuredome.org.uk/index.php?showforum=7">New Torrents section</a>.</li><li>Use the <a href="http://forum.pleasuredome.org.uk/index.php?showtopic=31185">script</a> to generate a single dat-file from the dat-files of the previous step.</li><li>Copy the new dat-file to the <strong>RomVault\DATRoot</strong> folder.</li><li>Copy the "MAME Extras" torrent files of the previous version to the <strong>RomVault\RomRoot</strong> folder.</li><li>Copy the latest "MAME Update Extras" torrent files to the <strong>RomVault\ToSort</strong> folder.</li><li>Delete all <strong>cheat.7z</strong> files from the RomRoot and ToSort folders. They would take hours to process.</li><li>Run <a href="http://wiki.pleasuredome.org.uk/index.php/RomVault">RomVault</a> and press the "Update DATs" button on the left. Then press the "Scan ROMs" button. Then press the "Find Fixes" button. Then press the "Fix ROMs" button.</li><li>Close RomVault.</li><li>Copy the latest cheat.7z to the <strong>RomVault\ROMRoot</strong> folder. Remember that RomVault always creates torrentzipped zip files, but this archive must be left untouched.</li><li><a href="http://wiki.pleasuredome.org.uk/index.php/TorrentCheck">TorrentCheck</a> will tell you that <strong>ctrl.zip</strong>, <strong>dats.zip</strong> and <strong>folders.zip</strong> should be unzipped. Also, don't forget to copy <strong>_ReadMe_.txt</strong>.</li><li>The <strong>RomVault\ROMRoot</strong> folder contains the result. Move its contents to another folder so that you can <a href="http://forum.pleasuredome.org.uk/index.php?showtopic=28308">seed with your bittorrent client</a>.</li></ol></td></tr></tbody></table>

  
 

## Details

There is a [forum topic](http://forum.pleasuredome.org.uk/index.php?showtopic=30715) with links to each of the download locations of the resources.

Some folders/archives are used by the [MAME](http://wiki.pleasuredome.org.uk/index.php/MAME) emulator (see [MAME installation](http://wiki.pleasuredome.org.uk/index.php/MAME_installation) for instructions):

| File or Folder | Description |
| --- | --- |
| **artwork** folder | contains: bezels, control panels, marquees, instruction cards, backdrops, overlays, lamps and LEDs |
| **ctrlr** folder | controller configurations |
| **samples** folder | zipped WAV files for systems that don't have audio emulated yet; see [Mame samples](http://wiki.pleasuredome.org.uk/index.php/Mame_samples) |
| **cheat.7z** archive | compilation of cheats |

  
The **dats** folder has text files displayed by MAME or frontends. Its contents are:

| File | Description |
| --- | --- |
| **command.dat** | list of the commands (e.g. how to do a Hadouken in Street Fighter) |
| **gameinit.dat** | initialization procedures for games that are not playable on the first run |
| **hiscore.dat** | unofficial highest scores achieved |
| **history.dat** | history information text file |
| **mameinfo.dat** | information text file of arcade games |
| **messinfo.dat** | information text file of non-arcade games; also lists changes in "whatsnew" and SVN |
| **story.dat** | MAMESCORE top scores |
| **sysinfo.dat** | systems information text file; contains details of the original machines and basic usage instructions |

  
The **folders** folder has INI files. Each INI file appears in MAME (or frontends) as one or more folders with systems inside according to specific criteria. Its contents are:

| File | Description |
| --- | --- |
| **arcade.ini** | arcade games |
| **arcade\_NOBIOS.ini** | arcade games that don't require a BIOS to run |
| **category.ini** | systems in about 235 categories |
| **catlist.ini** | systems in about 224 categories (with slightly different criteria) |
| **genre.ini** | systems in about 28 categories |
| **languages.ini** | systems in about 16 languages |
| **mamescore.ini** | games with MAMESCORE entries |
| **mess.ini** | non-arcade systems |
| **monochrome.ini** | games with two colors in three categories: "Black and White Games", "Monochromatic Games" and "Vectorial Black and White" |
| **nplayers.ini** | how many players the game supports and if it's simultaneous play or not |
| **screenless.ini** | systems without video output |
| **series.ini** | lists series of games |
| **version.ini** | lists of games that were added on every MAME version |

  
The other archives are used by the MAME emulator or frontends:

| Zip | Description |
| --- | --- |
| **artpreview** | artwork preview screenshots |
| **bosses** | boss (final and hardest enemy of a level) screenshots |
| **cabinets** | cabinets screenshots |
| **covers\_SL** | covers of the [Software List](http://wiki.pleasuredome.org.uk/index.php/MAME_torrents#List_of_MAME_torrents) |
| **cpanel** | images of control panels |
| **devices** | images of electronic gadgets that are attached to main systems |
| **ends** | screenshot of the end of each game (when the game is completed) |
| **flyers** | scanned paper advertisement intended for wide distribution to promote the systems |
| **gameover** | screenshot of the game over message of every game |
| **howto** | screenshot of the general instructions that the games display |
| **icons** | icons of arcade games and the other systems |
| **logo** | screenshot of the logo of the company that created every game |
| **manuals** | manuals in PDF (usage and operational) |
| **manuals\_SL** | manuals in PDF (usage and operational) of Software List |
| **marquees** | photos of the brand of the cab that is on the top of the cabinet, usually back-lit neon sign |
| **pcb** | Printed Circuit Board snapshots; photos of the motherboards of the systems |
| **scores** | screenshot of the default high score of every game |
| **select** | screenshot of one selection menu of every game (character, country, level, gun, tool, language etc) |
| **snap** | in-game screenshots |
| **snap\_SL** | in-game Software List screenshots |
| **titles** | title screenshots, usually taken when the name of the game is shown during attract mode |
| **titles\_SL** | title screenshots of Software List, usually taken when the name of the game is shown during attract mode |
| **versus** | screenshot of the presentation of the characters that will play against each other |
| **warning** | screenshots of warnings displayed by the games |

  
 
