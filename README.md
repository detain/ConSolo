# ConSolo

## from ROMs to Installed Populated Emulators and Frontends in under 12 parsecs!

Scrape Emulator/Rom/Platform/etc Info from Multiple Sources (No-Intro, TOSEC, Redump, MAME, GamesDb, etc) and Intelligently matchs up your media to figure out what you have and writes out configuration files for various Frontends/Emulators/Tools such as LaunchBox/HyperSpin/RocketLauncher/RetroArch/MAMEUI/etc. It maintains a list of most emulators and how to use each one allowing automated/quick installs of 1 to every emulator/rom tool. Pluggable/Extensible architecture and a central repo of user submitted plugins.

Currently its a mass of scripts loosely tied together and development will be focused on a clean interface. Several UI's are planned although too soon to tell if they'll ever get finished. A web-ui which works the same but incorperates browser-based emulators.


## Components

* Data Sources
** MAME - platforms, rom lists
** LaunchBox - platforms
** No-Intro DATs - platforms, rom lists
** Redump DATs - platforms, rom lists
** TOSEC DATs - platforms, rom lists
** GoodTools - platforms, rom lists
** emuControlCenter - rom lists
** emuDownloadCenter - platforms, emulators
** TheGamesDB.net - platforms, games, publishers, developers
* Configuration Builders
** LaunchBox
** HyperSpin
** RetroArch
** RocketLaunch
** Negatron
** RomCenter
** RomVault
** ClrMamePro
* ROMs
** ROM Scanning
** Compressed File Scanning
** Inventory
** Deduplication
* Matching
** Match platforms between data sources
** Match games between data sources
** Match roms to games in data sources


     

### MAME

### LaunchBox

### No-Intro

### Redump

### TOSEC - The Old School Emulation Center

https://www.tosecdev.org/ TOSECDev Home

### GoodTools

### emuControlCenter

[https://github.com/PhoenixInteractiveNL/emuControlCenter](PhoenixInteractiveNL/emuControlCenter: emuControlCenter)
[https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki/ECC-HowTo-DATfile-examples](ECC HowTo DATfile examples · PhoenixInteractiveNL/emuControlCenter Wiki)
[https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki/HowTo-Convert-XML-to-CLR-MAME-datfile](HowTo Convert XML to CLR MAME datfile · PhoenixInteractiveNL/emuControlCenter Wiki)
[https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki/HowTo-Convert-XML-to-CSV-file](HowTo Convert XML to CSV file · PhoenixInteractiveNL/emuControlCenter Wiki)
[https://github.com/PhoenixInteractiveNL/ecc-toolsused](PhoenixInteractiveNL/ecc-toolsused: Tools used by ECC (archive))
[https://github.com/PhoenixInteractiveNL/ecc-datfiles](PhoenixInteractiveNL/ecc-datfiles: ecc-datfiles)
[https://github.com/PhoenixInteractiveNL/ecc-updates](PhoenixInteractiveNL/ecc-updates: ecc-updates)




[https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki](Home · PhoenixInteractiveNL/emuControlCenter Wiki)
[https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki/Changelog-ECC-3D-Gallery](Changelog ECC 3D Gallery · PhoenixInteractiveNL/emuControlCenter Wiki)
[https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki/Changelog-ECC-Bugreport](Changelog ECC Bugreport · PhoenixInteractiveNL/emuControlCenter Wiki)
[https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki/Changelog-ECC-DATFileUpdater](Changelog ECC DATFileUpdater · PhoenixInteractiveNL/emuControlCenter Wiki)
[https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki/Changelog-ECC-eccCreateStartmenuShortcuts](Changelog ECC eccCreateStartmenuShortcuts · PhoenixInteractiveNL/emuControlCenter Wiki)
[https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki/Changelog-ECC-eccDiagnostics](Changelog ECC eccDiagnostics · PhoenixInteractiveNL/emuControlCenter Wiki)
[https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki/Changelog-ECC-eccScriptSystem](Changelog ECC eccScriptSystem · PhoenixInteractiveNL/emuControlCenter Wiki)
[https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki/Changelog-ECC-eccThirdPartyConfig](Changelog ECC eccThirdPartyConfig · PhoenixInteractiveNL/emuControlCenter Wiki)
[https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki/Changelog-ECC-eccVideoPlayer](Changelog ECC eccVideoPlayer · PhoenixInteractiveNL/emuControlCenter Wiki)
[https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki/Changelog-ECC-emuDownloadCenter](Changelog ECC emuDownloadCenter · PhoenixInteractiveNL/emuControlCenter Wiki)
[https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki/Changelog-ECC-emuMoviesDownloader](Changelog ECC emuMoviesDownloader · PhoenixInteractiveNL/emuControlCenter Wiki)
[https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki/Changelog-ECC-GtkThemeSelect](Changelog ECC GtkThemeSelect · PhoenixInteractiveNL/emuControlCenter Wiki)
[https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki/Changelog-ECC-ICC-ImageInject](Changelog ECC ICC ImageInject · PhoenixInteractiveNL/emuControlCenter Wiki)
[https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki/Changelog-ECC-ImagePackCenter](Changelog ECC ImagePackCenter · PhoenixInteractiveNL/emuControlCenter Wiki)
[https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki/Changelog-ECC-Kameleon-Code-System](Changelog ECC Kameleon Code System · PhoenixInteractiveNL/emuControlCenter Wiki)
[https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki/Changelog-ECC-MobyGames-Importer](Changelog ECC MobyGames Importer · PhoenixInteractiveNL/emuControlCenter Wiki)
[https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki/Changelog-ECC-Startup](Changelog ECC Startup · PhoenixInteractiveNL/emuControlCenter Wiki)
[https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki/Changelog-ECC-Theme-select](Changelog ECC Theme select · PhoenixInteractiveNL/emuControlCenter Wiki)
[https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki/Changelog-ECC-Tool-Variables](Changelog ECC Tool Variables · PhoenixInteractiveNL/emuControlCenter Wiki)
[https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki/Changelog-ECC-Update](Changelog ECC Update · PhoenixInteractiveNL/emuControlCenter Wiki)
[https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki/Changelog-eccLive!](Changelog eccLive! · PhoenixInteractiveNL/emuControlCenter Wiki)
[https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki/Changelog-eccLive!-upd](Changelog eccLive! upd · PhoenixInteractiveNL/emuControlCenter Wiki)
[https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki/Changelogs-2006](Changelogs 2006 · PhoenixInteractiveNL/emuControlCenter Wiki)
[https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki/Changelogs-2007](Changelogs 2007 · PhoenixInteractiveNL/emuControlCenter Wiki)
[https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki/Changelogs-2008](Changelogs 2008 · PhoenixInteractiveNL/emuControlCenter Wiki)
[https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki/Changelogs-2009](Changelogs 2009 · PhoenixInteractiveNL/emuControlCenter Wiki)
[https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki/Changelogs-2010](Changelogs 2010 · PhoenixInteractiveNL/emuControlCenter Wiki)
[https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki/Changelogs-2011](Changelogs 2011 · PhoenixInteractiveNL/emuControlCenter Wiki)
[https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki/Changelogs-2012](Changelogs 2012 · PhoenixInteractiveNL/emuControlCenter Wiki)
[https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki/Changelogs-2013](Changelogs 2013 · PhoenixInteractiveNL/emuControlCenter Wiki)
[https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki/Changelogs-2014](Changelogs 2014 · PhoenixInteractiveNL/emuControlCenter Wiki)
[https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki/Changelogs-2016](Changelogs 2016 · PhoenixInteractiveNL/emuControlCenter Wiki)
[https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki/Changelogs-2019](Changelogs 2019 · PhoenixInteractiveNL/emuControlCenter Wiki)
[https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki/Debug-ECC-PHP-code](Debug ECC PHP code · PhoenixInteractiveNL/emuControlCenter Wiki)
[https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki/Download-emulators](Download emulators · PhoenixInteractiveNL/emuControlCenter Wiki)
[https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki/ECC-Contact](ECC Contact · PhoenixInteractiveNL/emuControlCenter Wiki)
[https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki/ECC-HowTo-code-examples](ECC HowTo code examples · PhoenixInteractiveNL/emuControlCenter Wiki)
[https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki/ECC-HowTo-DATfile-examples](ECC HowTo DATfile examples · PhoenixInteractiveNL/emuControlCenter Wiki)
[https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki/ECC-HowTo-Translate-ECC](ECC HowTo Translate ECC · PhoenixInteractiveNL/emuControlCenter Wiki)
[https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki/ECC-wiki-charset-list](ECC wiki charset list · PhoenixInteractiveNL/emuControlCenter Wiki)
[https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki/ECC-wiki-country-abbreviation](ECC wiki country abbreviation · PhoenixInteractiveNL/emuControlCenter Wiki)
[https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki/Generate-unique-CRC32-CID-string](Generate unique CRC32 CID string · PhoenixInteractiveNL/emuControlCenter Wiki)
[https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki/History](History · PhoenixInteractiveNL/emuControlCenter Wiki)
[https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki/HowTo-Add-checkbox-to-GUI-and-save-data](HowTo Add checkbox to GUI and save data · PhoenixInteractiveNL/emuControlCenter Wiki)
[https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki/HowTo-Add-columns-to-database](HowTo Add columns to database · PhoenixInteractiveNL/emuControlCenter Wiki)
[https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki/HowTo-Add-new-dropdowns-with-options-in-MAIN-GUI](HowTo Add new dropdowns with options in MAIN GUI · PhoenixInteractiveNL/emuControlCenter Wiki)
[https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki/HowTo-Add-quickfilters-for-metadata](HowTo Add quickfilters for metadata · PhoenixInteractiveNL/emuControlCenter Wiki)
[https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki/HowTo-Convert-XML-to-CLR-MAME-datfile](HowTo Convert XML to CLR MAME datfile · PhoenixInteractiveNL/emuControlCenter Wiki)
[https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki/HowTo-Convert-XML-to-CSV-file](HowTo Convert XML to CSV file · PhoenixInteractiveNL/emuControlCenter Wiki)
[https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki/HowTo-DUMP-and-EXTRACT-data-from-database](HowTo DUMP and EXTRACT data from database · PhoenixInteractiveNL/emuControlCenter Wiki)
[https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki/HowTo-Export-column-data-to-DAT-file](HowTo Export column data to DAT file · PhoenixInteractiveNL/emuControlCenter Wiki)
[https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki/HowTo-Extract-XML-list-from-MAME-executable](HowTo Extract XML list from MAME executable · PhoenixInteractiveNL/emuControlCenter Wiki)
[https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki/HowTo-Import-DAT-file-data-to-database](HowTo Import DAT file data to database · PhoenixInteractiveNL/emuControlCenter Wiki)
[https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki/HowTo-Loader-animations](HowTo Loader animations · PhoenixInteractiveNL/emuControlCenter Wiki)
[https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki/HowTo-Set-labels-with-database-data](HowTo Set labels with database data · PhoenixInteractiveNL/emuControlCenter Wiki)
[https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki/HowTo-Textbox-with-search-button](HowTo Textbox with search button · PhoenixInteractiveNL/emuControlCenter Wiki)
[https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki/HowTo-Write-ECC-Platform-DATfiles-from--MAME--XML-list](HowTo Write ECC Platform DATfiles from MAME XML list · PhoenixInteractiveNL/emuControlCenter Wiki)
[https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki/Keyboard-Shortcuts](Keyboard Shortcuts · PhoenixInteractiveNL/emuControlCenter Wiki)
[https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki/Links-and-Partners](Links and Partners · PhoenixInteractiveNL/emuControlCenter Wiki)
[https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki/Misc-Save-INI-data-from-ecc.php](Misc Save INI data from ecc.php · PhoenixInteractiveNL/emuControlCenter Wiki)
[https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki/Notes](Notes · PhoenixInteractiveNL/emuControlCenter Wiki)
[https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki/Programs-Used](Programs Used · PhoenixInteractiveNL/emuControlCenter Wiki)
[https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki/Screenshots](Screenshots · PhoenixInteractiveNL/emuControlCenter Wiki)


### emmuDownloadCenter

[https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki](Home · PhoenixInteractiveNL/emuDownloadCenter Wiki)
[https://github.com/PhoenixInteractiveNL/emuDownloadCenter](PhoenixInteractiveNL/emuDownloadCenter: Emulator downloads, visit the WIKI)
[https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/EDC-Platform-List](EDC Platform List · PhoenixInteractiveNL/emuDownloadCenter Wiki)
[https://github.com/PhoenixInteractiveNL/emuDownloadCenter/tree/master/export/ecc_emu_ini](emuDownloadCenter/export/ecc_emu_ini at master · PhoenixInteractiveNL/emuDownloadCenter)
[https://github.com/PhoenixInteractiveNL/edc-repo0002](PhoenixInteractiveNL/edc-repo0002: Emulator repository)
[https://github.com/PhoenixInteractiveNL/edc-repo0003](PhoenixInteractiveNL/edc-repo0003: Emulator repository)
[https://github.com/PhoenixInteractiveNL/edc-repo0004](PhoenixInteractiveNL/edc-repo0004: Emulator repository)
[https://github.com/PhoenixInteractiveNL/edc-repo0008](PhoenixInteractiveNL/edc-repo0008: Emulator repository)
[https://github.com/PhoenixInteractiveNL/edc-repo0005](PhoenixInteractiveNL/edc-repo0005: Emulator repository)
[https://github.com/PhoenixInteractiveNL/edc-repo0006](PhoenixInteractiveNL/edc-repo0006: Emulator repository)
[https://github.com/PhoenixInteractiveNL/edc-repo0001](PhoenixInteractiveNL/edc-repo0001: Emulator repository)
[https://github.com/PhoenixInteractiveNL/edc-repo0009](PhoenixInteractiveNL/edc-repo0009: Emulator repository)
[https://github.com/PhoenixInteractiveNL/edc-repo0007](PhoenixInteractiveNL/edc-repo0007: Emulator repository)


                                                        
https://github.com/PhoenixInteractiveNL/emuControlCenter PhoenixInteractiveNL/emuControlCenter: emuControlCenter
https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki Home · PhoenixInteractiveNL/emuControlCenter Wiki

https://github.com/PhoenixInteractiveNL/emuDownloadCenter PhoenixInteractiveNL/emuDownloadCenter: Emulator downloads, visit the WIKI
<br>
https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki Home · PhoenixInteractiveNL/emuDownloadCenter Wiki
https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki/ECC-HowTo-DATfile-examples ECC HowTo DATfile examples · PhoenixInteractiveNL/emuControlCenter Wiki
https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki/HowTo-Convert-XML-to-CLR-MAME-datfile HowTo Convert XML to CLR MAME datfile · PhoenixInteractiveNL/emuControlCenter Wiki
https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki/HowTo-Convert-XML-to-CSV-file HowTo Convert XML to CSV file · PhoenixInteractiveNL/emuControlCenter Wiki
https://github.com/PhoenixInteractiveNL/ecc-datfiles PhoenixInteractiveNL/ecc-datfiles: ecc-datfiles
https://github.com/PhoenixInteractiveNL/emuDownloadCenter/tree/master/export/ecc_emu_ini emuDownloadCenter/export/ecc_emu_ini at master · PhoenixInteractiveNL/emuDownloadCenter
https://github.com/PhoenixInteractiveNL/ecc-toolsused PhoenixInteractiveNL/ecc-toolsused: Tools used by ECC (archive)
https://github.com/PhoenixInteractiveNL/ecc-datfiles PhoenixInteractiveNL/ecc-datfiles: ecc-datfiles https://github.com/PhoenixInteractiveNL/ecc-updates PhoenixInteractiveNL/ecc-updates: ecc-updates
https://github.com/PhoenixInteractiveNL/edc-repo0002 PhoenixInteractiveNL/edc-repo0002: Emulator repository
https://github.com/PhoenixInteractiveNL/edc-repo0003 PhoenixInteractiveNL/edc-repo0003: Emulator repository
https://github.com/PhoenixInteractiveNL/edc-repo0004 PhoenixInteractiveNL/edc-repo0004: Emulator repository
https://github.com/PhoenixInteractiveNL/edc-repo0008 PhoenixInteractiveNL/edc-repo0008: Emulator repository
https://github.com/PhoenixInteractiveNL/edc-repo0005 PhoenixInteractiveNL/edc-repo0005: Emulator repository
https://github.com/PhoenixInteractiveNL/edc-repo0006 PhoenixInteractiveNL/edc-repo0006: Emulator repository
https://github.com/PhoenixInteractiveNL/edc-repo0001 PhoenixInteractiveNL/edc-repo0001: Emulator repository
https://github.com/PhoenixInteractiveNL/edc-repo0009 PhoenixInteractiveNL/edc-repo0009: Emulator repository
https://github.com/PhoenixInteractiveNL/edc-repo0007 PhoenixInteractiveNL/edc-repo0007: Emulator repository


*   **[Home](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki)**
*   **[Collecting walktrough](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Collecting-walktrough)**
*   **[Contact](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Contact)**
*   **[EDC Emulator List](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/EDC-Emulator-List)**
*   **[EDC Platform List](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/EDC-Platform-List)**
*   **[EDC Platform List Arcade](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/EDC-Platform-List-Arcade)**
*   **[EDC Platform List Calculator](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/EDC-Platform-List-Calculator)**
*   **[EDC Platform List Computer](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/EDC-Platform-List-Computer)**
*   **[EDC Platform List Console](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/EDC-Platform-List-Console)**
*   **[EDC Platform List Handheld](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/EDC-Platform-List-Handheld)**
*   **[EDC Platform List Misc](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/EDC-Platform-List-Misc)**
*   **[EDC Statistics](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/EDC-Statistics)**
*   **[Emulator 1964](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-1964)**
*   **[Emulator 3dmoo](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-3dmoo)**
*   **[Emulator 3dnes](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-3dnes)**
*   **[Emulator 3doplay](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-3doplay)**
*   **[Emulator 4do](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-4do)**
*   **[Emulator 80five](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-80five)**
*   **[Emulator 88va](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-88va)**
*   **[Emulator ace](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-ace)**
*   **[Emulator ace32](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-ace32)**
*   **[Emulator activegs](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-activegs)**
*   **[Emulator adamem](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-adamem)**
*   **[Emulator adripsx](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-adripsx)**
*   **[Emulator adviem](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-adviem)**
*   **[Emulator aes4all](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-aes4all)**
*   **[Emulator agat](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-agat)**
*   **[Emulator ages](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-ages)**
*   **[Emulator aipc](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-aipc)**
*   **[Emulator akiko](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-akiko)**
*   **[Emulator alice32](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-alice32)**
*   **[Emulator altirra](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-altirra)**
*   **[Emulator anex86](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-anex86)**
*   **[Emulator apfemuw](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-apfemuw)**
*   **[Emulator apollo](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-apollo)**
*   **[Emulator apple1](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-apple1)**
*   **[Emulator applepc](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-applepc)**
*   **[Emulator appler](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-appler)**
*   **[Emulator applewin](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-applewin)**
*   **[Emulator aprnes](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-aprnes)**
*   **[Emulator aqemu](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-aqemu)**
*   **[Emulator aranym](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-aranym)**
*   **[Emulator arcem](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-arcem)**
*   **[Emulator archie](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-archie)**
*   **[Emulator arculator](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-arculator)**
*   **[Emulator arnimedes](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-arnimedes)**
*   **[Emulator arnold](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-arnold)**
*   **[Emulator ascd](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-ascd)**
*   **[Emulator aspectrum](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-aspectrum)**
*   **[Emulator atari800](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-atari800)**
*   **[Emulator atari800winplus](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-atari800winplus)**
*   **[Emulator atariplusplus](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-atariplusplus)**
*   **[Emulator atom](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-atom)**
*   **[Emulator atomulator](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-atomulator)**
*   **[Emulator aurex2](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-aurex2)**
*   **[Emulator basiliskii](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-basiliskii)**
*   **[Emulator beebem](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-beebem)**
*   **[Emulator bem](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-bem)**
*   **[Emulator bfmulator](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-bfmulator)**
*   **[Emulator bgb](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-bgb)**
*   **[Emulator bizhawk](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-bizhawk)**
*   **[Emulator blastem](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-blastem)**
*   **[Emulator bliss](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-bliss)**
*   **[Emulator bloodswan](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-bloodswan)**
*   **[Emulator bluemsx](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-bluemsx)**
*   **[Emulator boycottadv](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-boycottadv)**
*   **[Emulator bsnes](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-bsnes)**
*   **[Emulator bsnesclassic](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-bsnesclassic)**
*   **[Emulator bsnesplus](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-bsnesplus)**
*   **[Emulator bsnessx2](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-bsnessx2)**
*   **[Emulator bws](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-bws)**
*   **[Emulator bzsnes](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-bzsnes)**
*   **[Emulator c4pc](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-c4pc)**
*   **[Emulator calcem](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-calcem)**
*   **[Emulator calice](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-calice)**
*   **[Emulator callus](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-callus)**
*   **[Emulator caprice32](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-caprice32)**
*   **[Emulator ccs64](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-ccs64)**
*   **[Emulator cdiemulator](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-cdiemulator)**
*   **[Emulator cemu](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-cemu)**
*   **[Emulator chankast](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-chankast)**
*   **[Emulator citra](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-citra)**
*   **[Emulator classic99](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-classic99)**
*   **[Emulator cogwheel](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-cogwheel)**
*   **[Emulator colem](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-colem)**
*   **[Emulator coloremu](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-coloremu)**
*   **[Emulator comeback64](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-comeback64)**
*   **[Emulator coolcv](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-coolcv)**
*   **[Emulator copacabana](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-copacabana)**
*   **[Emulator cpcalive](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-cpcalive)**
*   **[Emulator cpce](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-cpce)**
*   **[Emulator cpcem](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-cpcem)**
*   **[Emulator cpcemu](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-cpcemu)**
*   **[Emulator cpe](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-cpe)**
*   **[Emulator cpmbox](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-cpmbox)**
*   **[Emulator cps3emulator](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-cps3emulator)**
*   **[Emulator cpspemu](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-cpspemu)**
*   **[Emulator creativision](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-creativision)**
*   **[Emulator cxbx](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-cxbx)**
*   **[Emulator cxbxreloaded](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-cxbxreloaded)**
*   **[Emulator cygne](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-cygne)**
*   **[Emulator daedalus](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-daedalus)**
*   **[Emulator daphne](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-daphne)**
*   **[Emulator dapple](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-dapple)**
*   **[Emulator dapple2 emuii](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-dapple2-emuii)**
*   **[Emulator dcalice](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-dcalice)**
*   **[Emulator dcexel](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-dcexel)**
*   **[Emulator dchector](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-dchector)**
*   **[Emulator dcmicro](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-dcmicro)**
*   **[Emulator dcmo5](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-dcmo5)**
*   **[Emulator dcmoto](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-dcmoto)**
*   **[Emulator dcvg5k](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-dcvg5k)**
*   **[Emulator dega](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-dega)**
*   **[Emulator demul](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-demul)**
*   **[Emulator desmume](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-desmume)**
*   **[Emulator dgen](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-dgen)**
*   **[Emulator dinoboy](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-dinoboy)**
*   **[Emulator directvms](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-directvms)**
*   **[Emulator dmgboy](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-dmgboy)**
*   **[Emulator dolphin](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-dolphin)**
*   **[Emulator dolwin](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-dolwin)**
*   **[Emulator dosbox](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-dosbox)**
*   **[Emulator dpspemu](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-dpspemu)**
*   **[Emulator dream64](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-dream64)**
*   **[Emulator dreamemu](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-dreamemu)**
*   **[Emulator dreamgba](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-dreamgba)**
*   **[Emulator dreamgbatng](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-dreamgbatng)**
*   **[Emulator dreamvmu](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-dreamvmu)**
*   **[Emulator dsp](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-dsp)**
*   **[Emulator dsvz200](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-dsvz200)**
*   **[Emulator dualis](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-dualis)**
*   **[Emulator dve](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-dve)**
*   **[Emulator eightyone](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-eightyone)**
*   **[Emulator electrem](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-electrem)**
*   **[Emulator elf](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-elf)**
*   **[Emulator elkulator](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-elkulator)**
*   **[Emulator em7](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-em7)**
*   **[Emulator emma02](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-emma02)**
*   **[Emulator emu](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-emu)**
*   **[Emulator emu2001](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-emu2001)**
*   **[Emulator emu64](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-emu64)**
*   **[Emulator emu7800](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-emu7800)**
*   **[Emulator emukon](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-emukon)**
*   **[Emulator emulator3000](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-emulator3000)**
*   **[Emulator emuz2000](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-emuz2000)**
*   **[Emulator emuzwin](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-emuzwin)**
*   **[Emulator enter](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-enter)**
*   **[Emulator ep128emu](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-ep128emu)**
*   **[Emulator ep32](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-ep32)**
*   **[Emulator epsxe](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-epsxe)**
*   **[Emulator euphoric](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-euphoric)**
*   **[Emulator ex68](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-ex68)**
*   **[Emulator exodus](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-exodus)**
*   **[Emulator fakenes](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-fakenes)**
*   **[Emulator fastz80](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-fastz80)**
*   **[Emulator faux1](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-faux1)**
*   **[Emulator fbalpha](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-fbalpha)**
*   **[Emulator fbalphashuffle](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-fbalphashuffle)**
*   **[Emulator fceux](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-fceux)**
*   **[Emulator firegb](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-firegb)**
*   **[Emulator fmsx](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-fmsx)**
*   **[Emulator fnc](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-fnc)**
*   **[Emulator free64](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-free64)**
*   **[Emulator freedo](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-freedo)**
*   **[Emulator frodo](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-frodo)**
*   **[Emulator fsuae](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-fsuae)**
*   **[Emulator funnymu](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-funnymu)**
*   **[Emulator fuse](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-fuse)**
*   **[Emulator futurepinball](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-futurepinball)**
*   **[Emulator galaxywin](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-galaxywin)**
*   **[Emulator gamecomemu](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-gamecomemu)**
*   **[Emulator gamelad](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-gamelad)**
*   **[Emulator gbeplus](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-gbeplus)**
*   **[Emulator gcemu](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-gcemu)**
*   **[Emulator gcube](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-gcube)**
*   **[Emulator gearsystem](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-gearsystem)**
*   **[Emulator geepee32](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-geepee32)**
*   **[Emulator gekko](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-gekko)**
*   **[Emulator gemulator](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-gemulator)**
*   **[Emulator genesisplus](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-genesisplus)**
*   **[Emulator genieous](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-genieous)**
*   **[Emulator gens](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-gens)**
*   **[Emulator gens32](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-gens32)**
*   **[Emulator gensgs](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-gensgs)**
*   **[Emulator gensplus](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-gensplus)**
*   **[Emulator gest](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-gest)**
*   **[Emulator gm2001](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-gm2001)**
*   **[Emulator gsport](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-gsport)**
*   **[Emulator handy](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-handy)**
*   **[Emulator hatari](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-hatari)**
*   **[Emulator hdnes](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-hdnes)**
*   **[Emulator hhugboy](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-hhugboy)**
*   **[Emulator higan](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-higan)**
*   **[Emulator hola](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-hola)**
*   **[Emulator homelab](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-homelab)**
*   **[Emulator horizon](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-horizon)**
*   **[Emulator hoxs64](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-hoxs64)**
*   **[Emulator hpsx64](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-hpsx64)**
*   **[Emulator ht1080z](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-ht1080z)**
*   **[Emulator hu6280](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-hu6280)**
*   **[Emulator hugo](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-hugo)**
*   **[Emulator hyper64](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-hyper64)**
*   **[Emulator ice64](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-ice64)**
*   **[Emulator ideas](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-ideas)**
*   **[Emulator ines](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-ines)**
*   **[Emulator infovectrex](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-infovectrex)**
*   **[Emulator ip6](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-ip6)**
*   **[Emulator ip6plus](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-ip6plus)**
*   **[Emulator ishiirukadolphin](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-ishiirukadolphin)**
*   **[Emulator jackal](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-jackal)**
*   **[Emulator jagulator](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-jagulator)**
*   **[Emulator javacpc](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-javacpc)**
*   **[Emulator jnes](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-jnes)**
*   **[Emulator joyce](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-joyce)**
*   **[Emulator jpcsp](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-jpcsp)**
*   **[Emulator jpemu](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-jpemu)**
*   **[Emulator jum52](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-jum52)**
*   **[Emulator jvz200](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-jvz200)**
*   **[Emulator jynx](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-jynx)**
*   **[Emulator jzintv](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-jzintv)**
*   **[Emulator kat5200](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-kat5200)**
*   **[Emulator kc85emu](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-kc85emu)**
*   **[Emulator kcemu](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-kcemu)**
*   **[Emulator kegafusion](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-kegafusion)**
*   **[Emulator kegs](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-kegs)**
*   **[Emulator kegs32](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-kegs32)**
*   **[Emulator kigb](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-kigb)**
*   **[Emulator kindred](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-kindred)**
*   **[Emulator klive](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-klive)**
*   **[Emulator koleko](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-koleko)**
*   **[Emulator koyote](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-koyote)**
*   **[Emulator lisa](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-lisa)**
*   **[Emulator lisaem](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-lisaem)**
*   **[Emulator luagb](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-luagb)**
*   **[Emulator m2emulator](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-m2emulator)**
*   **[Emulator m88](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-m88)**
*   **[Emulator mahnes](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-mahnes)**
*   **[Emulator makaron](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-makaron)**
*   **[Emulator makaronex](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-makaronex)**
*   **[Emulator mame](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-mame)**
*   **[Emulator mameclassic](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-mameclassic)**
*   **[Emulator mednafen](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-mednafen)**
*   **[Emulator medusa](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-medusa)**
*   **[Emulator mega8](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-mega8)**
*   **[Emulator meisei](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-meisei)**
*   **[Emulator meka](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-meka)**
*   **[Emulator melonds](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-melonds)**
*   **[Emulator mercury](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-mercury)**
*   **[Emulator mesadx](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-mesadx)**
*   **[Emulator mesen](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-mesen)**
*   **[Emulator mess](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-mess)**
*   **[Emulator mfme](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-mfme)**
*   **[Emulator mgba](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-mgba)**
*   **[Emulator micro64](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-micro64)**
*   **[Emulator minimon](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-minimon)**
*   **[Emulator minivmac](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-minivmac)**
*   **[Emulator minus4](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-minus4)**
*   **[Emulator modelb](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-modelb)**
*   **[Emulator modeler](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-modeler)**
*   **[Emulator mtxemu](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-mtxemu)**
*   **[Emulator mupen64k](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-mupen64k)**
*   **[Emulator mupen64plus](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-mupen64plus)**
*   **[Emulator mupen64plusplus](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-mupen64plusplus)**
*   **[Emulator mynes](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-mynes)**
*   **[Emulator mz700win](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-mz700win)**
*   **[Emulator mz800emu](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-mz800emu)**
*   **[Emulator mzxx](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-mzxx)**
*   **[Emulator nanowasp](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-nanowasp)**
*   **[Emulator ncdz](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-ncdz)**
*   **[Emulator nebula](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-nebula)**
*   **[Emulator nekoprojectii](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-nekoprojectii)**
*   **[Emulator nemu64](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-nemu64)**
*   **[Emulator nemulator](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-nemulator)**
*   **[Emulator neocdsdl](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-neocdsdl)**
*   **[Emulator neochip8](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-neochip8)**
*   **[Emulator neonds](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-neonds)**
*   **[Emulator neopocott](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-neopocott)**
*   **[Emulator neopop](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-neopop)**
*   **[Emulator nesemu](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-nesemu)**
*   **[Emulator nesterj](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-nesterj)**
*   **[Emulator nesticle](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-nesticle)**
*   **[Emulator nestopia](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-nestopia)**
*   **[Emulator neusnem](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-neusnem)**
*   **[Emulator neutrinosx2](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-neutrinosx2)**
*   **[Emulator ngae](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-ngae)**
*   **[Emulator nice64](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-nice64)**
*   **[Emulator nintendulator](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-nintendulator)**
*   **[Emulator nlmsx](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-nlmsx)**
*   **[Emulator nnnesterj](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-nnnesterj)**
*   **[Emulator no2k6](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-no2k6)**
*   **[Emulator noc64](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-noc64)**
*   **[Emulator nocpc](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-nocpc)**
*   **[Emulator nogba](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-nogba)**
*   **[Emulator nogmb](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-nogmb)**
*   **[Emulator nomsx](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-nomsx)**
*   **[Emulator nones](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-nones)**
*   **[Emulator nopsx](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-nopsx)**
*   **[Emulator nosns](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-nosns)**
*   **[Emulator nostalgia](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-nostalgia)**
*   **[Emulator nozx](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-nozx)**
*   **[Emulator nucleus](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-nucleus)**
*   **[Emulator nulldc](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-nulldc)**
*   **[Emulator nulldcn](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-nulldcn)**
*   **[Emulator o2em](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-o2em)**
*   **[Emulator ootake](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-ootake)**
*   **[Emulator oricutron](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-oricutron)**
*   **[Emulator osmose](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-osmose)**
*   **[Emulator oswan](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-oswan)**
*   **[Emulator oswanu](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-oswanu)**
*   **[Emulator pale](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-pale)**
*   **[Emulator parajve](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-parajve)**
*   **[Emulator pasofami](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-pasofami)**
*   **[Emulator pc6001v](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-pc6001v)**
*   **[Emulator pc6001vw](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-pc6001vw)**
*   **[Emulator pc6001vx](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-pc6001vx)**
*   **[Emulator pc64](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-pc64)**
*   **[Emulator pc88win](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-pc88win)**
*   **[Emulator pcae](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-pcae)**
*   **[Emulator pcejin](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-pcejin)**
*   **[Emulator pcemacplus](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-pcemacplus)**
*   **[Emulator pcsp](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-pcsp)**
*   **[Emulator pcsx](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-pcsx)**
*   **[Emulator pcsx2](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-pcsx2)**
*   **[Emulator pcsxr](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-pcsxr)**
*   **[Emulator pcsxrr](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-pcsxrr)**
*   **[Emulator pearpc](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-pearpc)**
*   **[Emulator phoenix](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-phoenix)**
*   **[Emulator picodrive](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-picodrive)**
*   **[Emulator pk201](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-pk201)**
*   **[Emulator pkemu](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-pkemu)**
*   **[Emulator plus4emu](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-plus4emu)**
*   **[Emulator pmd85](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-pmd85)**
*   **[Emulator pokemini](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-pokemini)**
*   **[Emulator pom1](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-pom1)**
*   **[Emulator potator](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-potator)**
*   **[Emulator potemkin](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-potemkin)**
*   **[Emulator ppsspp](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-ppsspp)**
*   **[Emulator project64](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-project64)**
*   **[Emulator project64k](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-project64k)**
*   **[Emulator project64k7e](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-project64k7e)**
*   **[Emulator projecttempest](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-projecttempest)**
*   **[Emulator prosystem](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-prosystem)**
*   **[Emulator ps2emu](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-ps2emu)**
*   **[Emulator psinex](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-psinex)**
*   **[Emulator pspe](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-pspe)**
*   **[Emulator psx](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-psx)**
*   **[Emulator psxeven](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-psxeven)**
*   **[Emulator psxjin](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-psxjin)**
*   **[Emulator psyke](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-psyke)**
*   **[Emulator punes](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-punes)**
*   **[Emulator ql2k](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-ql2k)**
*   **[Emulator qlay2](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-qlay2)**
*   **[Emulator qlayw](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-qlayw)**
*   **[Emulator quasi88](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-quasi88)**
*   **[Emulator race](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-race)**
*   **[Emulator radio86](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-radio86)**
*   **[Emulator rainbow](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-rainbow)**
*   **[Emulator rascalboyadv](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-rascalboyadv)**
*   **[Emulator real80pro](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-real80pro)**
*   **[Emulator realityboy](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-realityboy)**
*   **[Emulator reddragon](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-reddragon)**
*   **[Emulator redmsx](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-redmsx)**
*   **[Emulator redsquirrel](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-redsquirrel)**
*   **[Emulator regen](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-regen)**
*   **[Emulator retrocopy](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-retrocopy)**
*   **[Emulator roc](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-roc)**
*   **[Emulator rocknes](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-rocknes)**
*   **[Emulator rocknesx](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-rocknesx)**
*   **[Emulator roland](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-roland)**
*   **[Emulator rpcemu](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-rpcemu)**
*   **[Emulator rpcs3](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-rpcs3)**
*   **[Emulator rxnes](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-rxnes)**
*   **[Emulator saint](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-saint)**
*   **[Emulator satourne](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-satourne)**
*   **[Emulator saturnin](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-saturnin)**
*   **[Emulator scummvm](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-scummvm)**
*   **[Emulator sdltrs](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-sdltrs)**
*   **[Emulator sharp80](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-sharp80)**
*   **[Emulator sharpchip8](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-sharpchip8)**
*   **[Emulator sheepshaver](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-sheepshaver)**
*   **[Emulator shortwaves](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-shortwaves)**
*   **[Emulator simcoupe](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-simcoupe)**
*   **[Emulator simh](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-simh)**
*   **[Emulator sneese](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-sneese)**
*   **[Emulator snem](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-snem)**
*   **[Emulator snes9x](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-snes9x)**
*   **[Emulator snes9xrr](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-snes9xrr)**
*   **[Emulator snes9xsx2](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-snes9xsx2)**
*   **[Emulator snesgt](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-snesgt)**
*   **[Emulator softvms](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-softvms)**
*   **[Emulator sorcerer](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-sorcerer)**
*   **[Emulator speccy](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-speccy)**
*   **[Emulator spud](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-spud)**
*   **[Emulator spudace](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-spudace)**
*   **[Emulator ssf](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-ssf)**
*   **[Emulator steem](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-steem)**
*   **[Emulator steemsse](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-steemsse)**
*   **[Emulator stella](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-stella)**
*   **[Emulator stem](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-stem)**
*   **[Emulator sugarbox](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-sugarbox)**
*   **[Emulator supergcube](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-supergcube)**
*   **[Emulator supermodel](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-supermodel)**
*   **[Emulator swfopener](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-swfopener)**
*   **[Emulator t2k](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-t2k)**
*   **[Emulator takeda](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-takeda)**
*   **[Emulator tgbdual](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-tgbdual)**
*   **[Emulator ti994w](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-ti994w)**
*   **[Emulator tilem](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-tilem)**
*   **[Emulator tronds](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-tronds)**
*   **[Emulator trs80gp](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-trs80gp)**
*   **[Emulator tunix2001](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-tunix2001)**
*   **[Emulator turboengine](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-turboengine)**
*   **[Emulator twombit](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-twombit)**
*   **[Emulator ubee512](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-ubee512)**
*   **[Emulator ubernes](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-ubernes)**
*   **[Emulator ultimo](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-ultimo)**
*   **[Emulator ultrahle](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-ultrahle)**
*   **[Emulator ultrahle2064](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-ultrahle2064)**
*   **[Emulator unrealspeccy](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-unrealspeccy)**
*   **[Emulator unz](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-unz)**
*   **[Emulator uosnes](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-uosnes)**
*   **[Emulator uoyabause](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-uoyabause)**
*   **[Emulator vace](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-vace)**
*   **[Emulator vace3d](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-vace3d)**
*   **[Emulator vaquarius](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-vaquarius)**
*   **[Emulator vb64](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-vb64)**
*   **[Emulator vbam](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-vbam)**
*   **[Emulator vbarr](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-vbarr)**
*   **[Emulator vbjin](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-vbjin)**
*   **[Emulator vbjin ovr](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-vbjin-ovr)**
*   **[Emulator vdmgr](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-vdmgr)**
*   **[Emulator vecx](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-vecx)**
*   **[Emulator vecxgl](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-vecxgl)**
*   **[Emulator vgb](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-vgb)**
*   **[Emulator vgba](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-vgba)**
*   **[Emulator vic20emu](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-vic20emu)**
*   **[Emulator vinter](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-vinter)**
*   **[Emulator virtpanajr](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-virtpanajr)**
*   **[Emulator virtu](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-virtu)**
*   **[Emulator virtual98](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-virtual98)**
*   **[Emulator virtualapf](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-virtualapf)**
*   **[Emulator virtualjaguar](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-virtualjaguar)**
*   **[Emulator virtualmc10](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-virtualmc10)**
*   **[Emulator virtualnectrek](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-virtualnectrek)**
*   **[Emulator virtualt](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-virtualt)**
*   **[Emulator virtuanes](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-virtuanes)**
*   **[Emulator virtuanesplus](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-virtuanesplus)**
*   **[Emulator visualboy](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-visualboy)**
*   **[Emulator visualboyadvance](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-visualboyadvance)**
*   **[Emulator visualboyadvancerr](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-visualboyadvancerr)**
*   **[Emulator visualpinball](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-visualpinball)**
*   **[Emulator vivanonno](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-vivanonno)**
*   **[Emulator vss](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-vss)**
*   **[Emulator vzem](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-vzem)**
*   **[Emulator w88](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-w88)**
*   **[Emulator wataroo](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-wataroo)**
*   **[Emulator whinecube](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-whinecube)**
*   **[Emulator win64](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-win64)**
*   **[Emulator win994a](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-win994a)**
*   **[Emulator winape](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-winape)**
*   **[Emulator winarcadia](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-winarcadia)**
*   **[Emulator winboycott](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-winboycott)**
*   **[Emulator wincpc](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-wincpc)**
*   **[Emulator winfellow](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-winfellow)**
*   **[Emulator winkawaks](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-winkawaks)**
*   **[Emulator wintvc](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-wintvc)**
*   **[Emulator winuae](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-winuae)**
*   **[Emulator winvice](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-winvice)**
*   **[Emulator winvz](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-winvz)**
*   **[Emulator winvz300](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-winvz300)**
*   **[Emulator winx1](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-winx1)**
*   **[Emulator wscamp](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-wscamp)**
*   **[Emulator x88000](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-x88000)**
*   **[Emulator xe](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-xe)**
*   **[Emulator xebra](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-xebra)**
*   **[Emulator xenia](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-xenia)**
*   **[Emulator xeon](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-xeon)**
*   **[Emulator xgs32](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-xgs32)**
*   **[Emulator xm6](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-xm6)**
*   **[Emulator xm7](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-xm7)**
*   **[Emulator xm7dash](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-xm7dash)**
*   **[Emulator xm8](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-xm8)**
*   **[Emulator xmillenium](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-xmillenium)**
*   **[Emulator xpeccy](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-xpeccy)**
*   **[Emulator xqemu](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-xqemu)**
*   **[Emulator xroar](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-xroar)**
*   **[Emulator xsnes](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-xsnes)**
*   **[Emulator yabause](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-yabause)**
*   **[Emulator yabaused](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-yabaused)**
*   **[Emulator yage](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-yage)**
*   **[Emulator yanese](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-yanese)**
*   **[Emulator yape](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-yape)**
*   **[Emulator yapesdl](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-yapesdl)**
*   **[Emulator yoshines](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-yoshines)**
*   **[Emulator z26](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-z26)**
*   **[Emulator z80stealth](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-z80stealth)**
*   **[Emulator zboy](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-zboy)**
*   **[Emulator zero](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-zero)**
*   **[Emulator zesarux](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-zesarux)**
*   **[Emulator zinc](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-zinc)**
*   **[Emulator zsnes](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-zsnes)**
*   **[Emulator zxspin](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-zxspin)**
*   **[Extract 7z files](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Extract-7z-files)**
*   **[Help collecting](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Help-collecting)**
*   **[Platform 32x](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-32x)**
*   **[Platform 3do](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-3do)**
*   **[Platform 3ds](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-3ds)**
*   **[Platform a2600](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-a2600)**
*   **[Platform a5200](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-a5200)**
*   **[Platform a7800](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-a7800)**
*   **[Platform a8bit](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-a8bit)**
*   **[Platform ac](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-ac)**
*   **[Platform acan](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-acan)**
*   **[Platform adam](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-adam)**
*   **[Platform advision](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-advision)**
*   **[Platform alice](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-alice)**
*   **[Platform amiga](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-amiga)**
*   **[Platform amigacd32](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-amigacd32)**
*   **[Platform apple1](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-apple1)**
*   **[Platform apple2](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-apple2)**
*   **[Platform apple2gs](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-apple2gs)**
*   **[Platform apple3](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-apple3)**
*   **[Platform aqua](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-aqua)**
*   **[Platform arc](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-arc)**
*   **[Platform archi](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-archi)**
*   **[Platform atom](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-atom)**
*   **[Platform atomisw](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-atomisw)**
*   **[Platform bbc](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-bbc)**
*   **[Platform bw2](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-bw2)**
*   **[Platform c128](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-c128)**
*   **[Platform c16plus4](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-c16plus4)**
*   **[Platform c64](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-c64)**
*   **[Platform cdi](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-cdi)**
*   **[Platform cdtv](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-cdtv)**
*   **[Platform cg](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-cg)**
*   **[Platform chaf](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-chaf)**
*   **[Platform chip8](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-chip8)**
*   **[Platform clynx](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-clynx)**
*   **[Platform col](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-col)**
*   **[Platform comx35](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-comx35)**
*   **[Platform cpc](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-cpc)**
*   **[Platform cps1](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-cps1)**
*   **[Platform cps2](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-cps2)**
*   **[Platform cps3](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-cps3)**
*   **[Platform cv](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-cv)**
*   **[Platform cybiko](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-cybiko)**
*   **[Platform dc](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-dc)**
*   **[Platform dcvmu](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-dcvmu)**
*   **[Platform dosbox](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-dosbox)**
*   **[Platform dragon](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-dragon)**
*   **[Platform einst](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-einst)**
*   **[Platform enterprise](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-enterprise)**
*   **[Platform etron](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-etron)**
*   **[Platform exl100](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-exl100)**
*   **[Platform falcon](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-falcon)**
*   **[Platform fds](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-fds)**
*   **[Platform flash](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-flash)**
*   **[Platform fm7](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-fm7)**
*   **[Platform fmtowns](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-fmtowns)**
*   **[Platform fp](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-fp)**
*   **[Platform fruit](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-fruit)**
*   **[Platform galplus](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-galplus)**
*   **[Platform gamecom](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-gamecom)**
*   **[Platform gb](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-gb)**
*   **[Platform gba](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-gba)**
*   **[Platform gbc](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-gbc)**
*   **[Platform gc](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-gc)**
*   **[Platform gen](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-gen)**
*   **[Platform gg](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-gg)**
*   **[Platform gm](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-gm)**
*   **[Platform gp32](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-gp32)**
*   **[Platform gx4000](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-gx4000)**
*   **[Platform hcs](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-hcs)**
*   **[Platform homelab4](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-homelab4)**
*   **[Platform ht1080z](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-ht1080z)**
*   **[Platform im](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-im)**
*   **[Platform int](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-int)**
*   **[Platform jag](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-jag)**
*   **[Platform jagcd](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-jagcd)**
*   **[Platform jr200](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-jr200)**
*   **[Platform jupace](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-jupace)**
*   **[Platform kc](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-kc)**
*   **[Platform l100](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-l100)**
*   **[Platform l200](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-l200)**
*   **[Platform l350](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-l350)**
*   **[Platform ld](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-ld)**
*   **[Platform lisa](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-lisa)**
*   **[Platform loopy](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-loopy)**
*   **[Platform lviv](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-lviv)**
*   **[Platform lynx](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-lynx)**
*   **[Platform mame](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-mame)**
*   **[Platform mb](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-mb)**
*   **[Platform mdcb](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-mdcb)**
*   **[Platform mo5](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-mo5)**
*   **[Platform model1](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-model1)**
*   **[Platform model2](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-model2)**
*   **[Platform model3](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-model3)**
*   **[Platform msx](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-msx)**
*   **[Platform msx2](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-msx2)**
*   **[Platform msxtr](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-msxtr)**
*   **[Platform mtosh](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-mtosh)**
*   **[Platform mtx](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-mtx)**
*   **[Platform mz1500](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-mz1500)**
*   **[Platform mz2000](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-mz2000)**
*   **[Platform mz2500](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-mz2500)**
*   **[Platform n64](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-n64)**
*   **[Platform naomi](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-naomi)**
*   **[Platform nds](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-nds)**
*   **[Platform nes](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-nes)**
*   **[Platform ng](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-ng)**
*   **[Platform ngcd](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-ngcd)**
*   **[Platform ngp](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-ngp)**
*   **[Platform ngpc](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-ngpc)**
*   **[Platform onhandpc](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-onhandpc)**
*   **[Platform oric](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-oric)**
*   **[Platform pc6001](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-pc6001)**
*   **[Platform pc8801](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-pc8801)**
*   **[Platform pc9801](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-pc9801)**
*   **[Platform pce](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-pce)**
*   **[Platform pce2](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-pce2)**
*   **[Platform pcecd](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-pcecd)**
*   **[Platform pcfx](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-pcfx)**
*   **[Platform pcw](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-pcw)**
*   **[Platform pdp1](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-pdp1)**
*   **[Platform pdp7](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-pdp7)**
*   **[Platform pet](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-pet)**
*   **[Platform pgm](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-pgm)**
*   **[Platform pico](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-pico)**
*   **[Platform pipbug](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-pipbug)**
*   **[Platform pmd85](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-pmd85)**
*   **[Platform pmini](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-pmini)**
*   **[Platform primo](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-primo)**
*   **[Platform ps1](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-ps1)**
*   **[Platform ps2](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-ps2)**
*   **[Platform ps3](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-ps3)**
*   **[Platform psp](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-psp)**
*   **[Platform pstation](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-pstation)**
*   **[Platform pv1000](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-pv1000)**
*   **[Platform pv2000](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-pv2000)**
*   **[Platform ql](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-ql)**
*   **[Platform r86rk](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-r86rk)**
*   **[Platform s11](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-s11)**
*   **[Platform s16](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-s16)**
*   **[Platform s18](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-s18)**
*   **[Platform s22](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-s22)**
*   **[Platform samc](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-samc)**
*   **[Platform sat](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-sat)**
*   **[Platform sc3000](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-sc3000)**
*   **[Platform scv](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-scv)**
*   **[Platform sg1000](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-sg1000)**
*   **[Platform smcd](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-smcd)**
*   **[Platform sms](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-sms)**
*   **[Platform snes](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-snes)**
*   **[Platform sorcerer](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-sorcerer)**
*   **[Platform sordm5](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-sordm5)**
*   **[Platform st](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-st)**
*   **[Platform studio2](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-studio2)**
*   **[Platform stv](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-stv)**
*   **[Platform sv318](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-sv318)**
*   **[Platform svm](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-svm)**
*   **[Platform svn](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-svn)**
*   **[Platform ti82](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-ti82)**
*   **[Platform ti83](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-ti83)**
*   **[Platform ti85](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-ti85)**
*   **[Platform ti86](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-ti86)**
*   **[Platform ti99](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-ti99)**
*   **[Platform trs80](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-trs80)**
*   **[Platform tutor](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-tutor)**
*   **[Platform tvc](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-tvc)**
*   **[Platform tvgames](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-tvgames)**
*   **[Platform vb](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-vb)**
*   **[Platform vc4000](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-vc4000)**
*   **[Platform vec](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-vec)**
*   **[Platform vg5000](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-vg5000)**
*   **[Platform vg7000](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-vg7000)**
*   **[Platform vg7400](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-vg7400)**
*   **[Platform vic20](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-vic20)**
*   **[Platform vii](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-vii)**
*   **[Platform vip](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-vip)**
*   **[Platform vp](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-vp)**
*   **[Platform wii](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-wii)**
*   **[Platform wiiu](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-wiiu)**
*   **[Platform ws](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-ws)**
*   **[Platform wsc](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-wsc)**
*   **[Platform x1](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-x1)**
*   **[Platform x68000](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-x68000)**
*   **[Platform xbox](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-xbox)**
*   **[Platform xbox360](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-xbox360)**
*   **[Platform zinc](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-zinc)**
*   **[Platform zx81](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-zx81)**
*   **[Platform zxs](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-zxs)**
*   **[Request Data Export](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Request-Data-Export)**
*   **[Request Frontend API](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Request-Frontend-API)**

### **emuDownloadCenter**

[**Home**](https://github.com/PhoenixInteractiveNL/edc-masterhook/wiki)

[**Emulator Downloads (by platform)**](https://github.com/PhoenixInteractiveNL/edc-masterhook/wiki/EDC-Platform-List)

[**Emulator Downloads (by name)**](https://github.com/PhoenixInteractiveNL/edc-masterhook/wiki/EDC-Emulator-List)

[**Statistics**](https://github.com/PhoenixInteractiveNL/edc-masterhook/wiki/EDC-Statistics)

*   **[Home](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki)**
*   **[Collecting walktrough](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Collecting-walktrough)**
*   **[Contact](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Contact)**
*   **[EDC Emulator List](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/EDC-Emulator-List)**
*   **[EDC Platform List](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/EDC-Platform-List)**
*   **[EDC Platform List Arcade](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/EDC-Platform-List-Arcade)**
*   **[EDC Platform List Calculator](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/EDC-Platform-List-Calculator)**
*   **[EDC Platform List Computer](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/EDC-Platform-List-Computer)**
*   **[EDC Platform List Console](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/EDC-Platform-List-Console)**
*   **[EDC Platform List Handheld](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/EDC-Platform-List-Handheld)**
*   **[EDC Platform List Misc](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/EDC-Platform-List-Misc)**
*   **[EDC Statistics](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/EDC-Statistics)**
*   **[Emulator 1964](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-1964)**
*   **[Emulator 3dmoo](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-3dmoo)**
*   **[Emulator 3dnes](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-3dnes)**
*   **[Emulator 3doplay](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-3doplay)**
*   **[Emulator 4do](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-4do)**
*   **[Emulator 80five](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-80five)**
*   **[Emulator 88va](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-88va)**
*   **[Emulator ace](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-ace)**
*   **[Emulator ace32](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-ace32)**
*   **[Emulator activegs](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-activegs)**
*   **[Emulator adamem](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-adamem)**
*   **[Emulator adripsx](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-adripsx)**
*   **[Emulator adviem](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-adviem)**
*   **[Emulator aes4all](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-aes4all)**
*   **[Emulator agat](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-agat)**
*   **[Emulator ages](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-ages)**
*   **[Emulator aipc](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-aipc)**
*   **[Emulator akiko](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-akiko)**
*   **[Emulator alice32](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-alice32)**
*   **[Emulator altirra](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-altirra)**
*   **[Emulator anex86](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-anex86)**
*   **[Emulator apfemuw](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-apfemuw)**
*   **[Emulator apollo](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-apollo)**
*   **[Emulator apple1](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-apple1)**
*   **[Emulator applepc](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-applepc)**
*   **[Emulator appler](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-appler)**
*   **[Emulator applewin](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-applewin)**
*   **[Emulator aprnes](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-aprnes)**
*   **[Emulator aqemu](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-aqemu)**
*   **[Emulator aranym](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-aranym)**
*   **[Emulator arcem](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-arcem)**
*   **[Emulator archie](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-archie)**
*   **[Emulator arculator](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-arculator)**
*   **[Emulator arnimedes](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-arnimedes)**
*   **[Emulator arnold](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-arnold)**
*   **[Emulator ascd](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-ascd)**
*   **[Emulator aspectrum](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-aspectrum)**
*   **[Emulator atari800](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-atari800)**
*   **[Emulator atari800winplus](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-atari800winplus)**
*   **[Emulator atariplusplus](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-atariplusplus)**
*   **[Emulator atom](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-atom)**
*   **[Emulator atomulator](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-atomulator)**
*   **[Emulator aurex2](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-aurex2)**
*   **[Emulator basiliskii](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-basiliskii)**
*   **[Emulator beebem](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-beebem)**
*   **[Emulator bem](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-bem)**
*   **[Emulator bfmulator](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-bfmulator)**
*   **[Emulator bgb](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-bgb)**
*   **[Emulator bizhawk](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-bizhawk)**
*   **[Emulator blastem](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-blastem)**
*   **[Emulator bliss](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-bliss)**
*   **[Emulator bloodswan](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-bloodswan)**
*   **[Emulator bluemsx](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-bluemsx)**
*   **[Emulator boycottadv](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-boycottadv)**
*   **[Emulator bsnes](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-bsnes)**
*   **[Emulator bsnesclassic](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-bsnesclassic)**
*   **[Emulator bsnesplus](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-bsnesplus)**
*   **[Emulator bsnessx2](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-bsnessx2)**
*   **[Emulator bws](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-bws)**
*   **[Emulator bzsnes](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-bzsnes)**
*   **[Emulator c4pc](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-c4pc)**
*   **[Emulator calcem](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-calcem)**
*   **[Emulator calice](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-calice)**
*   **[Emulator callus](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-callus)**
*   **[Emulator caprice32](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-caprice32)**
*   **[Emulator ccs64](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-ccs64)**
*   **[Emulator cdiemulator](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-cdiemulator)**
*   **[Emulator cemu](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-cemu)**
*   **[Emulator chankast](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-chankast)**
*   **[Emulator citra](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-citra)**
*   **[Emulator classic99](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-classic99)**
*   **[Emulator cogwheel](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-cogwheel)**
*   **[Emulator colem](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-colem)**
*   **[Emulator coloremu](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-coloremu)**
*   **[Emulator comeback64](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-comeback64)**
*   **[Emulator coolcv](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-coolcv)**
*   **[Emulator copacabana](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-copacabana)**
*   **[Emulator cpcalive](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-cpcalive)**
*   **[Emulator cpce](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-cpce)**
*   **[Emulator cpcem](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-cpcem)**
*   **[Emulator cpcemu](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-cpcemu)**
*   **[Emulator cpe](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-cpe)**
*   **[Emulator cpmbox](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-cpmbox)**
*   **[Emulator cps3emulator](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-cps3emulator)**
*   **[Emulator cpspemu](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-cpspemu)**
*   **[Emulator creativision](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-creativision)**
*   **[Emulator cxbx](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-cxbx)**
*   **[Emulator cxbxreloaded](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-cxbxreloaded)**
*   **[Emulator cygne](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-cygne)**
*   **[Emulator daedalus](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-daedalus)**
*   **[Emulator daphne](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-daphne)**
*   **[Emulator dapple](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-dapple)**
*   **[Emulator dapple2 emuii](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-dapple2-emuii)**
*   **[Emulator dcalice](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-dcalice)**
*   **[Emulator dcexel](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-dcexel)**
*   **[Emulator dchector](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-dchector)**
*   **[Emulator dcmicro](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-dcmicro)**
*   **[Emulator dcmo5](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-dcmo5)**
*   **[Emulator dcmoto](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-dcmoto)**
*   **[Emulator dcvg5k](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-dcvg5k)**
*   **[Emulator dega](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-dega)**
*   **[Emulator demul](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-demul)**
*   **[Emulator desmume](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-desmume)**
*   **[Emulator dgen](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-dgen)**
*   **[Emulator dinoboy](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-dinoboy)**
*   **[Emulator directvms](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-directvms)**
*   **[Emulator dmgboy](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-dmgboy)**
*   **[Emulator dolphin](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-dolphin)**
*   **[Emulator dolwin](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-dolwin)**
*   **[Emulator dosbox](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-dosbox)**
*   **[Emulator dpspemu](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-dpspemu)**
*   **[Emulator dream64](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-dream64)**
*   **[Emulator dreamemu](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-dreamemu)**
*   **[Emulator dreamgba](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-dreamgba)**
*   **[Emulator dreamgbatng](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-dreamgbatng)**
*   **[Emulator dreamvmu](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-dreamvmu)**
*   **[Emulator dsp](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-dsp)**
*   **[Emulator dsvz200](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-dsvz200)**
*   **[Emulator dualis](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-dualis)**
*   **[Emulator dve](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-dve)**
*   **[Emulator eightyone](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-eightyone)**
*   **[Emulator electrem](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-electrem)**
*   **[Emulator elf](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-elf)**
*   **[Emulator elkulator](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-elkulator)**
*   **[Emulator em7](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-em7)**
*   **[Emulator emma02](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-emma02)**
*   **[Emulator emu](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-emu)**
*   **[Emulator emu2001](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-emu2001)**
*   **[Emulator emu64](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-emu64)**
*   **[Emulator emu7800](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-emu7800)**
*   **[Emulator emukon](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-emukon)**
*   **[Emulator emulator3000](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-emulator3000)**
*   **[Emulator emuz2000](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-emuz2000)**
*   **[Emulator emuzwin](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-emuzwin)**
*   **[Emulator enter](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-enter)**
*   **[Emulator ep128emu](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-ep128emu)**
*   **[Emulator ep32](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-ep32)**
*   **[Emulator epsxe](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-epsxe)**
*   **[Emulator euphoric](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-euphoric)**
*   **[Emulator ex68](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-ex68)**
*   **[Emulator exodus](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-exodus)**
*   **[Emulator fakenes](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-fakenes)**
*   **[Emulator fastz80](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-fastz80)**
*   **[Emulator faux1](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-faux1)**
*   **[Emulator fbalpha](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-fbalpha)**
*   **[Emulator fbalphashuffle](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-fbalphashuffle)**
*   **[Emulator fceux](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-fceux)**
*   **[Emulator firegb](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-firegb)**
*   **[Emulator fmsx](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-fmsx)**
*   **[Emulator fnc](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-fnc)**
*   **[Emulator free64](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-free64)**
*   **[Emulator freedo](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-freedo)**
*   **[Emulator frodo](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-frodo)**
*   **[Emulator fsuae](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-fsuae)**
*   **[Emulator funnymu](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-funnymu)**
*   **[Emulator fuse](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-fuse)**
*   **[Emulator futurepinball](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-futurepinball)**
*   **[Emulator galaxywin](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-galaxywin)**
*   **[Emulator gamecomemu](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-gamecomemu)**
*   **[Emulator gamelad](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-gamelad)**
*   **[Emulator gbeplus](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-gbeplus)**
*   **[Emulator gcemu](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-gcemu)**
*   **[Emulator gcube](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-gcube)**
*   **[Emulator gearsystem](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-gearsystem)**
*   **[Emulator geepee32](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-geepee32)**
*   **[Emulator gekko](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-gekko)**
*   **[Emulator gemulator](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-gemulator)**
*   **[Emulator genesisplus](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-genesisplus)**
*   **[Emulator genieous](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-genieous)**
*   **[Emulator gens](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-gens)**
*   **[Emulator gens32](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-gens32)**
*   **[Emulator gensgs](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-gensgs)**
*   **[Emulator gensplus](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-gensplus)**
*   **[Emulator gest](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-gest)**
*   **[Emulator gm2001](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-gm2001)**
*   **[Emulator gsport](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-gsport)**
*   **[Emulator handy](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-handy)**
*   **[Emulator hatari](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-hatari)**
*   **[Emulator hdnes](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-hdnes)**
*   **[Emulator hhugboy](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-hhugboy)**
*   **[Emulator higan](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-higan)**
*   **[Emulator hola](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-hola)**
*   **[Emulator homelab](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-homelab)**
*   **[Emulator horizon](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-horizon)**
*   **[Emulator hoxs64](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-hoxs64)**
*   **[Emulator hpsx64](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-hpsx64)**
*   **[Emulator ht1080z](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-ht1080z)**
*   **[Emulator hu6280](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-hu6280)**
*   **[Emulator hugo](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-hugo)**
*   **[Emulator hyper64](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-hyper64)**
*   **[Emulator ice64](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-ice64)**
*   **[Emulator ideas](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-ideas)**
*   **[Emulator ines](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-ines)**
*   **[Emulator infovectrex](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-infovectrex)**
*   **[Emulator ip6](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-ip6)**
*   **[Emulator ip6plus](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-ip6plus)**
*   **[Emulator ishiirukadolphin](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-ishiirukadolphin)**
*   **[Emulator jackal](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-jackal)**
*   **[Emulator jagulator](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-jagulator)**
*   **[Emulator javacpc](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-javacpc)**
*   **[Emulator jnes](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-jnes)**
*   **[Emulator joyce](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-joyce)**
*   **[Emulator jpcsp](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-jpcsp)**
*   **[Emulator jpemu](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-jpemu)**
*   **[Emulator jum52](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-jum52)**
*   **[Emulator jvz200](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-jvz200)**
*   **[Emulator jynx](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-jynx)**
*   **[Emulator jzintv](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-jzintv)**
*   **[Emulator kat5200](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-kat5200)**
*   **[Emulator kc85emu](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-kc85emu)**
*   **[Emulator kcemu](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-kcemu)**
*   **[Emulator kegafusion](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-kegafusion)**
*   **[Emulator kegs](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-kegs)**
*   **[Emulator kegs32](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-kegs32)**
*   **[Emulator kigb](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-kigb)**
*   **[Emulator kindred](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-kindred)**
*   **[Emulator klive](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-klive)**
*   **[Emulator koleko](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-koleko)**
*   **[Emulator koyote](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-koyote)**
*   **[Emulator lisa](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-lisa)**
*   **[Emulator lisaem](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-lisaem)**
*   **[Emulator luagb](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-luagb)**
*   **[Emulator m2emulator](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-m2emulator)**
*   **[Emulator m88](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-m88)**
*   **[Emulator mahnes](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-mahnes)**
*   **[Emulator makaron](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-makaron)**
*   **[Emulator makaronex](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-makaronex)**
*   **[Emulator mame](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-mame)**
*   **[Emulator mameclassic](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-mameclassic)**
*   **[Emulator mednafen](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-mednafen)**
*   **[Emulator medusa](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-medusa)**
*   **[Emulator mega8](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-mega8)**
*   **[Emulator meisei](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-meisei)**
*   **[Emulator meka](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-meka)**
*   **[Emulator melonds](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-melonds)**
*   **[Emulator mercury](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-mercury)**
*   **[Emulator mesadx](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-mesadx)**
*   **[Emulator mesen](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-mesen)**
*   **[Emulator mess](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-mess)**
*   **[Emulator mfme](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-mfme)**
*   **[Emulator mgba](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-mgba)**
*   **[Emulator micro64](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-micro64)**
*   **[Emulator minimon](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-minimon)**
*   **[Emulator minivmac](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-minivmac)**
*   **[Emulator minus4](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-minus4)**
*   **[Emulator modelb](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-modelb)**
*   **[Emulator modeler](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-modeler)**
*   **[Emulator mtxemu](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-mtxemu)**
*   **[Emulator mupen64k](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-mupen64k)**
*   **[Emulator mupen64plus](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-mupen64plus)**
*   **[Emulator mupen64plusplus](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-mupen64plusplus)**
*   **[Emulator mynes](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-mynes)**
*   **[Emulator mz700win](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-mz700win)**
*   **[Emulator mz800emu](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-mz800emu)**
*   **[Emulator mzxx](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-mzxx)**
*   **[Emulator nanowasp](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-nanowasp)**
*   **[Emulator ncdz](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-ncdz)**
*   **[Emulator nebula](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-nebula)**
*   **[Emulator nekoprojectii](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-nekoprojectii)**
*   **[Emulator nemu64](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-nemu64)**
*   **[Emulator nemulator](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-nemulator)**
*   **[Emulator neocdsdl](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-neocdsdl)**
*   **[Emulator neochip8](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-neochip8)**
*   **[Emulator neonds](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-neonds)**
*   **[Emulator neopocott](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-neopocott)**
*   **[Emulator neopop](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-neopop)**
*   **[Emulator nesemu](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-nesemu)**
*   **[Emulator nesterj](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-nesterj)**
*   **[Emulator nesticle](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-nesticle)**
*   **[Emulator nestopia](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-nestopia)**
*   **[Emulator neusnem](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-neusnem)**
*   **[Emulator neutrinosx2](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-neutrinosx2)**
*   **[Emulator ngae](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-ngae)**
*   **[Emulator nice64](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-nice64)**
*   **[Emulator nintendulator](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-nintendulator)**
*   **[Emulator nlmsx](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-nlmsx)**
*   **[Emulator nnnesterj](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-nnnesterj)**
*   **[Emulator no2k6](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-no2k6)**
*   **[Emulator noc64](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-noc64)**
*   **[Emulator nocpc](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-nocpc)**
*   **[Emulator nogba](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-nogba)**
*   **[Emulator nogmb](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-nogmb)**
*   **[Emulator nomsx](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-nomsx)**
*   **[Emulator nones](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-nones)**
*   **[Emulator nopsx](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-nopsx)**
*   **[Emulator nosns](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-nosns)**
*   **[Emulator nostalgia](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-nostalgia)**
*   **[Emulator nozx](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-nozx)**
*   **[Emulator nucleus](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-nucleus)**
*   **[Emulator nulldc](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-nulldc)**
*   **[Emulator nulldcn](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-nulldcn)**
*   **[Emulator o2em](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-o2em)**
*   **[Emulator ootake](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-ootake)**
*   **[Emulator oricutron](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-oricutron)**
*   **[Emulator osmose](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-osmose)**
*   **[Emulator oswan](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-oswan)**
*   **[Emulator oswanu](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-oswanu)**
*   **[Emulator pale](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-pale)**
*   **[Emulator parajve](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-parajve)**
*   **[Emulator pasofami](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-pasofami)**
*   **[Emulator pc6001v](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-pc6001v)**
*   **[Emulator pc6001vw](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-pc6001vw)**
*   **[Emulator pc6001vx](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-pc6001vx)**
*   **[Emulator pc64](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-pc64)**
*   **[Emulator pc88win](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-pc88win)**
*   **[Emulator pcae](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-pcae)**
*   **[Emulator pcejin](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-pcejin)**
*   **[Emulator pcemacplus](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-pcemacplus)**
*   **[Emulator pcsp](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-pcsp)**
*   **[Emulator pcsx](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-pcsx)**
*   **[Emulator pcsx2](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-pcsx2)**
*   **[Emulator pcsxr](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-pcsxr)**
*   **[Emulator pcsxrr](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-pcsxrr)**
*   **[Emulator pearpc](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-pearpc)**
*   **[Emulator phoenix](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-phoenix)**
*   **[Emulator picodrive](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-picodrive)**
*   **[Emulator pk201](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-pk201)**
*   **[Emulator pkemu](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-pkemu)**
*   **[Emulator plus4emu](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-plus4emu)**
*   **[Emulator pmd85](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-pmd85)**
*   **[Emulator pokemini](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-pokemini)**
*   **[Emulator pom1](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-pom1)**
*   **[Emulator potator](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-potator)**
*   **[Emulator potemkin](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-potemkin)**
*   **[Emulator ppsspp](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-ppsspp)**
*   **[Emulator project64](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-project64)**
*   **[Emulator project64k](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-project64k)**
*   **[Emulator project64k7e](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-project64k7e)**
*   **[Emulator projecttempest](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-projecttempest)**
*   **[Emulator prosystem](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-prosystem)**
*   **[Emulator ps2emu](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-ps2emu)**
*   **[Emulator psinex](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-psinex)**
*   **[Emulator pspe](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-pspe)**
*   **[Emulator psx](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-psx)**
*   **[Emulator psxeven](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-psxeven)**
*   **[Emulator psxjin](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-psxjin)**
*   **[Emulator psyke](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-psyke)**
*   **[Emulator punes](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-punes)**
*   **[Emulator ql2k](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-ql2k)**
*   **[Emulator qlay2](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-qlay2)**
*   **[Emulator qlayw](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-qlayw)**
*   **[Emulator quasi88](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-quasi88)**
*   **[Emulator race](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-race)**
*   **[Emulator radio86](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-radio86)**
*   **[Emulator rainbow](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-rainbow)**
*   **[Emulator rascalboyadv](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-rascalboyadv)**
*   **[Emulator real80pro](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-real80pro)**
*   **[Emulator realityboy](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-realityboy)**
*   **[Emulator reddragon](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-reddragon)**
*   **[Emulator redmsx](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-redmsx)**
*   **[Emulator redsquirrel](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-redsquirrel)**
*   **[Emulator regen](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-regen)**
*   **[Emulator retrocopy](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-retrocopy)**
*   **[Emulator roc](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-roc)**
*   **[Emulator rocknes](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-rocknes)**
*   **[Emulator rocknesx](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-rocknesx)**
*   **[Emulator roland](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-roland)**
*   **[Emulator rpcemu](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-rpcemu)**
*   **[Emulator rpcs3](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-rpcs3)**
*   **[Emulator rxnes](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-rxnes)**
*   **[Emulator saint](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-saint)**
*   **[Emulator satourne](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-satourne)**
*   **[Emulator saturnin](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-saturnin)**
*   **[Emulator scummvm](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-scummvm)**
*   **[Emulator sdltrs](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-sdltrs)**
*   **[Emulator sharp80](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-sharp80)**
*   **[Emulator sharpchip8](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-sharpchip8)**
*   **[Emulator sheepshaver](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-sheepshaver)**
*   **[Emulator shortwaves](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-shortwaves)**
*   **[Emulator simcoupe](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-simcoupe)**
*   **[Emulator simh](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-simh)**
*   **[Emulator sneese](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-sneese)**
*   **[Emulator snem](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-snem)**
*   **[Emulator snes9x](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-snes9x)**
*   **[Emulator snes9xrr](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-snes9xrr)**
*   **[Emulator snes9xsx2](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-snes9xsx2)**
*   **[Emulator snesgt](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-snesgt)**
*   **[Emulator softvms](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-softvms)**
*   **[Emulator sorcerer](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-sorcerer)**
*   **[Emulator speccy](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-speccy)**
*   **[Emulator spud](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-spud)**
*   **[Emulator spudace](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-spudace)**
*   **[Emulator ssf](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-ssf)**
*   **[Emulator steem](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-steem)**
*   **[Emulator steemsse](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-steemsse)**
*   **[Emulator stella](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-stella)**
*   **[Emulator stem](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-stem)**
*   **[Emulator sugarbox](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-sugarbox)**
*   **[Emulator supergcube](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-supergcube)**
*   **[Emulator supermodel](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-supermodel)**
*   **[Emulator swfopener](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-swfopener)**
*   **[Emulator t2k](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-t2k)**
*   **[Emulator takeda](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-takeda)**
*   **[Emulator tgbdual](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-tgbdual)**
*   **[Emulator ti994w](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-ti994w)**
*   **[Emulator tilem](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-tilem)**
*   **[Emulator tronds](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-tronds)**
*   **[Emulator trs80gp](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-trs80gp)**
*   **[Emulator tunix2001](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-tunix2001)**
*   **[Emulator turboengine](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-turboengine)**
*   **[Emulator twombit](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-twombit)**
*   **[Emulator ubee512](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-ubee512)**
*   **[Emulator ubernes](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-ubernes)**
*   **[Emulator ultimo](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-ultimo)**
*   **[Emulator ultrahle](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-ultrahle)**
*   **[Emulator ultrahle2064](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-ultrahle2064)**
*   **[Emulator unrealspeccy](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-unrealspeccy)**
*   **[Emulator unz](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-unz)**
*   **[Emulator uosnes](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-uosnes)**
*   **[Emulator uoyabause](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-uoyabause)**
*   **[Emulator vace](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-vace)**
*   **[Emulator vace3d](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-vace3d)**
*   **[Emulator vaquarius](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-vaquarius)**
*   **[Emulator vb64](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-vb64)**
*   **[Emulator vbam](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-vbam)**
*   **[Emulator vbarr](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-vbarr)**
*   **[Emulator vbjin](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-vbjin)**
*   **[Emulator vbjin ovr](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-vbjin-ovr)**
*   **[Emulator vdmgr](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-vdmgr)**
*   **[Emulator vecx](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-vecx)**
*   **[Emulator vecxgl](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-vecxgl)**
*   **[Emulator vgb](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-vgb)**
*   **[Emulator vgba](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-vgba)**
*   **[Emulator vic20emu](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-vic20emu)**
*   **[Emulator vinter](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-vinter)**
*   **[Emulator virtpanajr](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-virtpanajr)**
*   **[Emulator virtu](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-virtu)**
*   **[Emulator virtual98](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-virtual98)**
*   **[Emulator virtualapf](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-virtualapf)**
*   **[Emulator virtualjaguar](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-virtualjaguar)**
*   **[Emulator virtualmc10](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-virtualmc10)**
*   **[Emulator virtualnectrek](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-virtualnectrek)**
*   **[Emulator virtualt](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-virtualt)**
*   **[Emulator virtuanes](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-virtuanes)**
*   **[Emulator virtuanesplus](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-virtuanesplus)**
*   **[Emulator visualboy](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-visualboy)**
*   **[Emulator visualboyadvance](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-visualboyadvance)**
*   **[Emulator visualboyadvancerr](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-visualboyadvancerr)**
*   **[Emulator visualpinball](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-visualpinball)**
*   **[Emulator vivanonno](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-vivanonno)**
*   **[Emulator vss](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-vss)**
*   **[Emulator vzem](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-vzem)**
*   **[Emulator w88](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-w88)**
*   **[Emulator wataroo](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-wataroo)**
*   **[Emulator whinecube](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-whinecube)**
*   **[Emulator win64](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-win64)**
*   **[Emulator win994a](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-win994a)**
*   **[Emulator winape](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-winape)**
*   **[Emulator winarcadia](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-winarcadia)**
*   **[Emulator winboycott](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-winboycott)**
*   **[Emulator wincpc](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-wincpc)**
*   **[Emulator winfellow](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-winfellow)**
*   **[Emulator winkawaks](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-winkawaks)**
*   **[Emulator wintvc](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-wintvc)**
*   **[Emulator winuae](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-winuae)**
*   **[Emulator winvice](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-winvice)**
*   **[Emulator winvz](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-winvz)**
*   **[Emulator winvz300](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-winvz300)**
*   **[Emulator winx1](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-winx1)**
*   **[Emulator wscamp](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-wscamp)**
*   **[Emulator x88000](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-x88000)**
*   **[Emulator xe](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-xe)**
*   **[Emulator xebra](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-xebra)**
*   **[Emulator xenia](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-xenia)**
*   **[Emulator xeon](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-xeon)**
*   **[Emulator xgs32](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-xgs32)**
*   **[Emulator xm6](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-xm6)**
*   **[Emulator xm7](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-xm7)**
*   **[Emulator xm7dash](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-xm7dash)**
*   **[Emulator xm8](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-xm8)**
*   **[Emulator xmillenium](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-xmillenium)**
*   **[Emulator xpeccy](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-xpeccy)**
*   **[Emulator xqemu](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-xqemu)**
*   **[Emulator xroar](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-xroar)**
*   **[Emulator xsnes](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-xsnes)**
*   **[Emulator yabause](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-yabause)**
*   **[Emulator yabaused](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-yabaused)**
*   **[Emulator yage](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-yage)**
*   **[Emulator yanese](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-yanese)**
*   **[Emulator yape](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-yape)**
*   **[Emulator yapesdl](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-yapesdl)**
*   **[Emulator yoshines](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-yoshines)**
*   **[Emulator z26](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-z26)**
*   **[Emulator z80stealth](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-z80stealth)**
*   **[Emulator zboy](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-zboy)**
*   **[Emulator zero](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-zero)**
*   **[Emulator zesarux](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-zesarux)**
*   **[Emulator zinc](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-zinc)**
*   **[Emulator zsnes](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-zsnes)**
*   **[Emulator zxspin](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Emulator-zxspin)**
*   **[Extract 7z files](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Extract-7z-files)**
*   **[Help collecting](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Help-collecting)**
*   **[Platform 32x](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-32x)**
*   **[Platform 3do](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-3do)**
*   **[Platform 3ds](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-3ds)**
*   **[Platform a2600](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-a2600)**
*   **[Platform a5200](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-a5200)**
*   **[Platform a7800](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-a7800)**
*   **[Platform a8bit](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-a8bit)**
*   **[Platform ac](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-ac)**
*   **[Platform acan](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-acan)**
*   **[Platform adam](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-adam)**
*   **[Platform advision](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-advision)**
*   **[Platform alice](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-alice)**
*   **[Platform amiga](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-amiga)**
*   **[Platform amigacd32](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-amigacd32)**
*   **[Platform apple1](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-apple1)**
*   **[Platform apple2](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-apple2)**
*   **[Platform apple2gs](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-apple2gs)**
*   **[Platform apple3](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-apple3)**
*   **[Platform aqua](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-aqua)**
*   **[Platform arc](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-arc)**
*   **[Platform archi](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-archi)**
*   **[Platform atom](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-atom)**
*   **[Platform atomisw](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-atomisw)**
*   **[Platform bbc](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-bbc)**
*   **[Platform bw2](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-bw2)**
*   **[Platform c128](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-c128)**
*   **[Platform c16plus4](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-c16plus4)**
*   **[Platform c64](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-c64)**
*   **[Platform cdi](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-cdi)**
*   **[Platform cdtv](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-cdtv)**
*   **[Platform cg](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-cg)**
*   **[Platform chaf](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-chaf)**
*   **[Platform chip8](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-chip8)**
*   **[Platform clynx](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-clynx)**
*   **[Platform col](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-col)**
*   **[Platform comx35](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-comx35)**
*   **[Platform cpc](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-cpc)**
*   **[Platform cps1](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-cps1)**
*   **[Platform cps2](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-cps2)**
*   **[Platform cps3](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-cps3)**
*   **[Platform cv](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-cv)**
*   **[Platform cybiko](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-cybiko)**
*   **[Platform dc](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-dc)**
*   **[Platform dcvmu](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-dcvmu)**
*   **[Platform dosbox](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-dosbox)**
*   **[Platform dragon](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-dragon)**
*   **[Platform einst](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-einst)**
*   **[Platform enterprise](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-enterprise)**
*   **[Platform etron](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-etron)**
*   **[Platform exl100](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-exl100)**
*   **[Platform falcon](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-falcon)**
*   **[Platform fds](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-fds)**
*   **[Platform flash](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-flash)**
*   **[Platform fm7](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-fm7)**
*   **[Platform fmtowns](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-fmtowns)**
*   **[Platform fp](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-fp)**
*   **[Platform fruit](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-fruit)**
*   **[Platform galplus](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-galplus)**
*   **[Platform gamecom](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-gamecom)**
*   **[Platform gb](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-gb)**
*   **[Platform gba](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-gba)**
*   **[Platform gbc](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-gbc)**
*   **[Platform gc](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-gc)**
*   **[Platform gen](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-gen)**
*   **[Platform gg](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-gg)**
*   **[Platform gm](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-gm)**
*   **[Platform gp32](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-gp32)**
*   **[Platform gx4000](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-gx4000)**
*   **[Platform hcs](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-hcs)**
*   **[Platform homelab4](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-homelab4)**
*   **[Platform ht1080z](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-ht1080z)**
*   **[Platform im](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-im)**
*   **[Platform int](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-int)**
*   **[Platform jag](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-jag)**
*   **[Platform jagcd](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-jagcd)**
*   **[Platform jr200](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-jr200)**
*   **[Platform jupace](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-jupace)**
*   **[Platform kc](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-kc)**
*   **[Platform l100](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-l100)**
*   **[Platform l200](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-l200)**
*   **[Platform l350](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-l350)**
*   **[Platform ld](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-ld)**
*   **[Platform lisa](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-lisa)**
*   **[Platform loopy](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-loopy)**
*   **[Platform lviv](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-lviv)**
*   **[Platform lynx](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-lynx)**
*   **[Platform mame](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-mame)**
*   **[Platform mb](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-mb)**
*   **[Platform mdcb](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-mdcb)**
*   **[Platform mo5](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-mo5)**
*   **[Platform model1](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-model1)**
*   **[Platform model2](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-model2)**
*   **[Platform model3](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-model3)**
*   **[Platform msx](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-msx)**
*   **[Platform msx2](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-msx2)**
*   **[Platform msxtr](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-msxtr)**
*   **[Platform mtosh](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-mtosh)**
*   **[Platform mtx](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-mtx)**
*   **[Platform mz1500](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-mz1500)**
*   **[Platform mz2000](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-mz2000)**
*   **[Platform mz2500](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-mz2500)**
*   **[Platform n64](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-n64)**
*   **[Platform naomi](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-naomi)**
*   **[Platform nds](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-nds)**
*   **[Platform nes](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-nes)**
*   **[Platform ng](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-ng)**
*   **[Platform ngcd](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-ngcd)**
*   **[Platform ngp](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-ngp)**
*   **[Platform ngpc](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-ngpc)**
*   **[Platform onhandpc](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-onhandpc)**
*   **[Platform oric](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-oric)**
*   **[Platform pc6001](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-pc6001)**
*   **[Platform pc8801](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-pc8801)**
*   **[Platform pc9801](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-pc9801)**
*   **[Platform pce](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-pce)**
*   **[Platform pce2](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-pce2)**
*   **[Platform pcecd](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-pcecd)**
*   **[Platform pcfx](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-pcfx)**
*   **[Platform pcw](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-pcw)**
*   **[Platform pdp1](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-pdp1)**
*   **[Platform pdp7](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-pdp7)**
*   **[Platform pet](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-pet)**
*   **[Platform pgm](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-pgm)**
*   **[Platform pico](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-pico)**
*   **[Platform pipbug](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-pipbug)**
*   **[Platform pmd85](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-pmd85)**
*   **[Platform pmini](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-pmini)**
*   **[Platform primo](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-primo)**
*   **[Platform ps1](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-ps1)**
*   **[Platform ps2](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-ps2)**
*   **[Platform ps3](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-ps3)**
*   **[Platform psp](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-psp)**
*   **[Platform pstation](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-pstation)**
*   **[Platform pv1000](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-pv1000)**
*   **[Platform pv2000](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-pv2000)**
*   **[Platform ql](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-ql)**
*   **[Platform r86rk](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-r86rk)**
*   **[Platform s11](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-s11)**
*   **[Platform s16](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-s16)**
*   **[Platform s18](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-s18)**
*   **[Platform s22](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-s22)**
*   **[Platform samc](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-samc)**
*   **[Platform sat](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-sat)**
*   **[Platform sc3000](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-sc3000)**
*   **[Platform scv](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-scv)**
*   **[Platform sg1000](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-sg1000)**
*   **[Platform smcd](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-smcd)**
*   **[Platform sms](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-sms)**
*   **[Platform snes](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-snes)**
*   **[Platform sorcerer](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-sorcerer)**
*   **[Platform sordm5](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-sordm5)**
*   **[Platform st](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-st)**
*   **[Platform studio2](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-studio2)**
*   **[Platform stv](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-stv)**
*   **[Platform sv318](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-sv318)**
*   **[Platform svm](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-svm)**
*   **[Platform svn](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-svn)**
*   **[Platform ti82](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-ti82)**
*   **[Platform ti83](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-ti83)**
*   **[Platform ti85](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-ti85)**
*   **[Platform ti86](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-ti86)**
*   **[Platform ti99](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-ti99)**
*   **[Platform trs80](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-trs80)**
*   **[Platform tutor](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-tutor)**
*   **[Platform tvc](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-tvc)**
*   **[Platform tvgames](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-tvgames)**
*   **[Platform vb](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-vb)**
*   **[Platform vc4000](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-vc4000)**
*   **[Platform vec](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-vec)**
*   **[Platform vg5000](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-vg5000)**
*   **[Platform vg7000](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-vg7000)**
*   **[Platform vg7400](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-vg7400)**
*   **[Platform vic20](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-vic20)**
*   **[Platform vii](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-vii)**
*   **[Platform vip](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-vip)**
*   **[Platform vp](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-vp)**
*   **[Platform wii](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-wii)**
*   **[Platform wiiu](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-wiiu)**
*   **[Platform ws](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-ws)**
*   **[Platform wsc](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-wsc)**
*   **[Platform x1](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-x1)**
*   **[Platform x68000](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-x68000)**
*   **[Platform xbox](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-xbox)**
*   **[Platform xbox360](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-xbox360)**
*   **[Platform zinc](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-zinc)**
*   **[Platform zx81](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-zx81)**
*   **[Platform zxs](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Platform-zxs)**
*   **[Request Data Export](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Request-Data-Export)**
*   **[Request Frontend API](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/wiki/Request-Frontend-API)**

### **emuDownloadCenter**

[**Home**](https://github.com/PhoenixInteractiveNL/edc-masterhook/wiki)

[**Emulator Downloads (by platform)**](https://github.com/PhoenixInteractiveNL/edc-masterhook/wiki/EDC-Platform-List)

[**Emulator Downloads (by name)**](https://github.com/PhoenixInteractiveNL/edc-masterhook/wiki/EDC-Emulator-List)

[**Statistics**](https://github.com/PhoenixInteractiveNL/edc-masterhook/wiki/EDC-Statistics)

### **Your Help!**

[**Help collecting!**](https://github.com/PhoenixInteractiveNL/edc-masterhook/wiki/Help-collecting)

[**Collecting walktrough**](https://github.com/PhoenixInteractiveNL/edc-masterhook/wiki/Collecting-walktrough)

### Data Export / API

[**Request Data Export**](https://github.com/PhoenixInteractiveNL/edc-masterhook/wiki/Request-Data-Export)

[**Request Frontend API**](https://github.com/PhoenixInteractiveNL/edc-masterhook/wiki/Request-Frontend-API)

[**Export - ECC EMU INI**](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/tree/master/export/ecc_emu_ini)

### emuControlCenter

[**emuControlCenter**](https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki)

[**Facebook**](https://www.facebook.com/emuControlCenter/)

### **Other**

[**Extract 7z files**](https://github.com/PhoenixInteractiveNL/edc-masterhook/wiki/Extract-7z-files)

[**Contact**](https://github.com/PhoenixInteractiveNL/edc-masterhook/wiki/Contact)

Clone this wiki locally

[**Help collecting!**](https://github.com/PhoenixInteractiveNL/edc-masterhook/wiki/Help-collecting)

[**Collecting walktrough**](https://github.com/PhoenixInteractiveNL/edc-masterhook/wiki/Collecting-walktrough)

### **Data Export / API**

[**Request Data Export**](https://github.com/PhoenixInteractiveNL/edc-masterhook/wiki/Request-Data-Export)

[**Request Frontend API**](https://github.com/PhoenixInteractiveNL/edc-masterhook/wiki/Request-Frontend-API)

[**Export - ECC EMU INI**](https://github.com/PhoenixInteractiveNL/emuDownloadCenter/tree/master/export/ecc_emu_ini)

### **emuControlCenter**

[**emuControlCenter**](https://github.com/PhoenixInteractiveNL/emuControlCenter/wiki)

[**Facebook**](https://www.facebook.com/emuControlCenter/)

### Other

[**Extract 7z files**](https://github.com/PhoenixInteractiveNL/edc-masterhook/wiki/Extract-7z-files)

[**Contact**](https://github.com/PhoenixInteractiveNL/edc-masterhook/wiki/Contact)

Clone this wiki locally

### TheGamesDB.net

https://thegamesdb.net/ TGDB - Homepage
https://api.thegamesdb.net/#/Platforms/PlatformsImages Swagger UI
https://github.com/TheGamesDB/TheGamesDB/pulls TheGamesDB.net Repository - An open, online database for video game fans.
https://github.com/TheGamesDB/TheGamesDBv2 Version 2 of TGDB
https://github.com/jfern01/tgdb-scrape Scrapes thegamesdb.net API.
https://thegamesdb.net/browse.php TGDB - Browser
https://thegamesdb.net/list_platforms.php TGDB - Browse - Platforms
https://thegamesdb.net/list_devs.php TGDB - Browse - Developers
https://thegamesdb.net/list_pubs.php TGDB - Browse - Publishers
https://github.com/muldjord/skyscraper Powerful and versatile game scraper written in c++
 
