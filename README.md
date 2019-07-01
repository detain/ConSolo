# ConSolo

## from ROMs to Installed Populated Emulators and Frontends in under 12 parsecs!

Scrape Emulator/Rom/Platform/etc Info from Multiple Sources (No-Intro, TOSEC, Redump, MAME, GamesDb, etc) and Intelligently matchs up your media to figure out what you have and writes out configuration files for various Frontends/Emulators/Tools such as LaunchBox/HyperSpin/RocketLauncher/RetroArch/MAMEUI/etc. It maintains a list of most emulators and how to use each one allowing automated/quick installs of 1 to every emulator/rom tool. Pluggable/Extensible architecture and a central repo of user submitted plugins.

Currently its a mass of scripts loosely tied together and development will be focused on a clean interface. Several UI's are planned although too soon to tell if they'll ever get finished. A web-ui which works the same but incorperates browser-based emulators.


## Components

*   Data Sources
    *   MAME - platforms, rom lists
    *   LaunchBox - platforms
    *   No-Intro DATs - platforms, rom lists
    *   Redump DATs - platforms, rom lists
    *   TOSEC DATs - platforms, rom lists
    *   GoodTools - platforms, rom lists
    *   emuControlCenter - rom lists
    *   emuDownloadCenter - platforms, emulators
    *   TheGamesDB.net - platforms, games, publishers, developers
*   Configuration Builders
    *   LaunchBox
    *   HyperSpin
    *   RetroArch
    *   RocketLaunch
    *   Negatron
    *   RomCenter
    *   RomVault
    *   ClrMamePro
*   ROMs
    *   ROM Scanning
    *   Compressed File Scanning
    *   Inventory
    *   Deduplication
*   Matching
    *   Match platforms between data sources
    *   Match games between data sources
    *   Match roms to games in data sources


     

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



### **emuDownloadCenter**

[**Home**](https://github.com/PhoenixInteractiveNL/edc-masterhook/wiki)

[**Emulator Downloads (by platform)**](https://github.com/PhoenixInteractiveNL/edc-masterhook/wiki/EDC-Platform-List)

[**Emulator Downloads (by name)**](https://github.com/PhoenixInteractiveNL/edc-masterhook/wiki/EDC-Emulator-List)

[**Statistics**](https://github.com/PhoenixInteractiveNL/edc-masterhook/wiki/EDC-Statistics)

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

[https://thegamesdb.net/](TGDB - Homepage)
[https://api.thegamesdb.net/#/Platforms/PlatformsImages](Swagger UI)
[https://github.com/TheGamesDB/TheGamesDB/pulls](Pull Requests · TheGamesDB/TheGamesDB)
[https://github.com/TheGamesDB/TheGamesDBv2](TheGamesDB/TheGamesDBv2: Version 2 of TGDB)
[https://github.com/jfern01/tgdb-scrape](jfern01/tgdb-scrape: Scrapes thegamesdb.net API.)
[https://thegamesdb.net/browse.php](TGDB - Browser)
[https://thegamesdb.net/list_platforms.php](TGDB - Browse - Platforms)
[https://thegamesdb.net/list_devs.php](TGDB - Browse - Developers)
[https://thegamesdb.net/list_pubs.php](TGDB - Browse - Publishers)
