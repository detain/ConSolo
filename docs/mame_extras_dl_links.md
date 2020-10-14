![TOP_MAME_logo.png](http://forum.pleasuredome.org.uk/Logos/TOP_MAME_logo.png)

  
  
**This set contains the basic MAME EXTRAs that can be used in MAME GUIs.**  
   
The latest available content is used at creation time.  
The png content is zipped and can be used directly in MAME's own MEWUI GUI.  
We are aware that the choice for zipped content makes rebuilding this set hard(er) and joining with a previous/partial set at a low percentage inevitable.  
We plan to provide an update set along with this set for those willing to rebuild their previous set.  
   
**Directory/File structure:**

Quote

> MAME 0.xxx EXTRAs  
> ├───artwork  
> ├───ctrlr  
> ├───dats  
> ├───folders  
> ├───samples  
> ├─artpreview.zip  
> ├─bosses.zip  
> ├─cabinets.zip  
> ├─cheat.7z\*  
> ├─covers\_SL.zip  
> ├─cpanel.zip  
> ├─devices.zip  
> ├─ends.zip  
> ├─flyers.zip  
> ├─gameover.zip  
> ├─howto.zip  
> ├─icons.zip  
> ├─logo.zip  
> ├─manuals.zip  
> ├─manuals\_SL.zip  
> ├─marquees.zip  
> ├─pcb.zip  
> ├─scores.zip  
> ├─select.zip  
> ├─snap.zip  
> ├─snap\_SL.zip  
> ├─titles.zip  
> ├─titles\_SL.zip
> 
> ├─versus.zip  
> └─warning.zip

\* the 7zipfile is untouched, so not Torrent7zipped.  
All zipfiles are Torrentzipped.  
Files with \_SL in their name have MAME Software List content.  
   
**Reproducing the zipped content with Clrmamepro:**  
   
**Method 1.**  
Download the update set, if available.  
If you own a previous set, unzip all the existing zipfiles that contain the non-zipped content into a folder of the same name (in 7-zip -> Extract to "\*\\").  
Create a temporary folder called "\_scan" in the parent folder.  
Move all the (extracted) folders with the non-zipped content into the "\_scan" folder.  
Load the "all\_non-zipped\_content.dat" into CMP and in the Settings, point at the temporary "\_scan" folder.  
Scan/Fix\*/Rebuild the content until it's 100% complete and use the update content as rebuild source.  
\* In case of Datfile Problem messages -> Yes To All  
Zip the internal content of all the individual folders in the temporary "\_scan" folder and torrentzip (64-bit) them afterwards.  
Move the zipfiles from the temporary "\_scan" folder to the parent folder.  
When all is finished, delete the temporary "\_scan" folder.  
   
**Method 2 (fastest).**  
\- download the Update EXTRAs  
\- create a folder "MAME 0.xxx EXTRAs\\\_scan"  
_note: replace 0.xxx by the current MAME EXTRAs version_  
\- load the all\_non-zipped\_content.dat in CMP and point it at "MAME 0.xxx EXTRAs\\\_scan" in the Settings  
\- scan (New Scan without fixing) the empty "MAME 0.xxx EXTRAs\\\_scan" folder  
\- rebuild from the previous full version and from the current Update EXTRAs  
\- scan (New Scan) the result, which should now be 100% complete  
\- zip the internal content of each folder (except ctrlr, dats and folders) in "MAME 0.xxx EXTRAs\\\_scan"  
\- move the zipfiles and the dats, folder, ctrlr folders to "MAME 0.xxx EXTRAs\\" and delete the \_scan folder  
\- drag 'n drop the zipfiles on Torrenzip.NET (way faster!) or trrntzip64.exe  
\- scan/fix/rebuild and torrenzip the artwork and samples, using their datfiles  
\- copy the cheat.7z to "MAME 0.xxx EXTRAs\\"  
\- copy the \_ReadMe\_.txt to "MAME 0.xxx EXTRAs\\"  
\- check if it matches the torrent and join.  
  
Make sure CMP has the correct (default) settings, otherwise the end result may not match.  
   
**Applications used:**  
clrmamepro  
[Torrentzip.NET](http://forum.pleasuredome.org.uk/index.php?showtopic=29033)  
[qBittorent](http://forum.pleasuredome.org.uk/index.php?showtopic=27734)  
  
**Links to the authors of the sources used:**  
   
AntoPISA's "All progetto-SNAPS" datfile from his [MAME Resources DATs](http://www.progettosnaps.net/dats/) is used for this set.  
   
_**Folders:**_  
[artwork](http://www.progettosnaps.net/artworks/): AntoPISA's MAME Artworks  
[ctrlr](http://www.kutek.net/mame32_config_files.php): Pierre Kutec's  
[samples](http://www.progettosnaps.net/samples/): AntoPISA's progetto-SNAPS MAME SAMPLEs  
   
_**Zipped folders:**_  
[artpreview](http://www.progettosnaps.net/snapshots/): AntoPISA's progetto-SNAPS MAME Snapshots - Artwork Preview  
[bosses](http://www.progettosnaps.net/snapshots/): AntoPISA's progetto-SNAPS MAME Snapshots - Bosses  
[cabinets](http://www.progettosnaps.net/cabinets/): AntoPISA's progetto-SNAPS CABINETs  
[covers\_SL](http://www.progettosnaps.net/softwareresources/): AntoPISA's progetto-SNAPS MAME Software List Resources  
[cpanel](http://www.progettosnaps.net/cpanel/): AntoPISA's progetto-SNAPS MAME CONTROL PANELs  
[devices](http://www.progettosnaps.net/devices/): AntoPISA's progetto-SNAPS MAME DEVICEs  
[ends](http://www.progettosnaps.net/snapshots/): AntoPISA's progetto-SNAPS MAME Snapshots - Ends  
[flyers](http://www.progettosnaps.net/flyers/): AntoPISA's progetto-SNAPS MAME FLYERs  
[gameover](http://www.progettosnaps.net/snapshots/): AntoPISA's progetto-SNAPS MAME Snapshots - GameOver  
[howto](http://www.progettosnaps.net/snapshots/): AntoPISA's progetto-SNAPS MAME Snapshots - HowTo  
[icons](http://www.progettosnaps.net/icons/): AntoPISA's progetto-SNAPS MAME MAMu\_'s Icons + Extended Version Icons  
[logo](http://www.progettosnaps.net/snapshots/): AntoPISA's progetto-SNAPS MAME Snapshots - Logo  
[manuals](http://www.progettosnaps.net/manuals/): AntoPISA's progetto-SNAPS MAME MANUALs  
[manuals\_SL](http://www.progettosnaps.net/manuals/): AntoPISA's progetto-SNAPS MAME Software List Resources  
[marquees](http://www.progettosnaps.net/marquees/): AntoPISA's progetto-SNAPS MAME MARQUEEs  
[pcb](http://www.progettosnaps.net/PCB/): AntoPISA's progetto-SNAPS MAME PCBs  
[scores](http://www.progettosnaps.net/snapshots/): AntoPISA's progetto-SNAPS MAME Snapshots - Scores  
[select](http://www.progettosnaps.net/snapshots/): AntoPISA's progetto-SNAPS MAME Snapshots - Select  
[snap](http://www.progettosnaps.net/snapshots/): AntoPISA's progetto-SNAPS MAME Snapshots - Snap  
[snap\_SL](http://www.progettosnaps.net/softwareresources/): AntoPISA's progetto-SNAPS MAME Software List Resources  
[titles](http://www.progettosnaps.net/snapshots/): AntoPISA's progetto-SNAPS MAME Snapshots - Titles  
[titles\_SL](http://www.progettosnaps.net/softwareresources/): AntoPISA's progetto-SNAPS MAME Software List Resources  
[versus](http://www.progettosnaps.net/snapshots/): AntoPISA's progetto-SNAPS MAME Snapshots - Versus

[warning](http://www.progettosnaps.net/snapshots/): AntoPISA's progetto-SNAPS MAME Snapshots - Warning  
   
_**MAME support files (dats & folders):**_  
[arcade.ini](http://www.progettosnaps.net/support/): AntoPISA's progetto-SNAPS (part of version.ini)

[arcade\_BIOS.ini](http://www.progettosnaps.net/support/): AntoPISA's progetto-SNAPS (part of version.ini)  
[arcade\_NOBIOS.ini](http://www.progettosnaps.net/support/): AntoPISA's progetto-SNAPS (part of version.ini)  
[bestgames.ini](http://www.progettosnaps.net/support/): AntoPISA's progetto-SNAPS  
[category.ini](http://www.progettosnaps.net/support/): AntoPISA's progetto-SNAPS  
[catlist.ini](http://www.progettosnaps.net/support/): AntoPISA's progetto-SNAPS  
[cheat.7z](http://www.mamecheat.co.uk/index.htm): Pugsy's Cheats  
[command.dat](http://www.progettosnaps.net/support/): AntoPISA's progetto-SNAPS (short-hand)  
[gameinit.dat](http://www.progettosnaps.net/support/): AntoPISA's progetto-SNAPS  
[genre.ini](http://www.progettosnaps.net/support/): AntoPISA's progetto-SNAPS  
[hiscore.dat](http://mamedev.org/release.php): Official MAMEdev Hiscore.dat (MAME-Source\\Plugins\\hiscore)  
[history.dat](https://www.arcade-history.com/index.php?page=download): Arcade History  
[languages.ini](http://www.progettosnaps.net/support/): AntoPISA's progetto-SNAPS  
[mameinfo.dat](http://mameinfo.mameworld.info/): MASH's MAMEINFO  
[mamescore.ini](https://www.arcadehits.net/mamescore/rss/mamescore.ini): MAMESCORE  
[mess.ini](http://www.progettosnaps.net/support/): AntoPISA's progetto-SNAPS (part of version.ini)  
[messinfo.dat](http://www.progettosnaps.net/support/): AntoPISA's progetto-SNAPS  
[monochrome.ini](http://www.progettosnaps.net/support/): AntoPISA's progetto-SNAPS (part of category.ini)

[multiplayer.ini](http://nplayers.arcadebelgium.be/): Nplayers32  
[nplayers.ini](http://nplayers.arcadebelgium.be/): Nplayers  
[screenless.ini](http://www.progettosnaps.net/support/): AntoPISA's progetto-SNAPS (part of category.ini)  
[series.ini](http://www.progettosnaps.net/support/): AntoPISA's progetto-SNAPS  
[story.dat](https://www.arcadehits.net/mamescore/rss/story.dat): MAMESCORE  
[sysinfo.dat](http://www.progettoemma.net/mess/extra.html): Progetto EMMA  
[version.ini](http://www.progettosnaps.net/support/): AntoPISA's progetto-SNAPS

_**MAME Multimedia files:**_

[VideoSnaps](http://www.progettosnaps.net/videosnaps/): AntoPISA's progetto-SNAPS

[VideoSnaps\_SL](http://www.progettosnaps.net/softwareresources/): AntoPISA's progetto-SNAPS

[SoundTracks](http://www.progettosnaps.net/soundtrack/): AntoPISA's progetto-SNAPS
