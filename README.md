![Screenshot](http://i.is.cc/storage/1FidsZ47.png)

# **ConSolo**
from ROMs to Installed Populated Emulators and Frontends in under 12 parsecs!

Scrape Emulator/Rom/Platform/etc Info from Multiple Sources (No-Intro, TOSEC, Redump, MAME, GamesDb, etc) and Intelligently matchs up your media to figure out what you have and writes out configuration files for various Frontends/Emulators/Tools such as LaunchBox/HyperSpin/RocketLauncher/RetroArch/MAMEUI/etc. It maintains a list of most emulators and how to use each one allowing automated/quick installs of 1 to every emulator/rom tool. Pluggable/Extensible architecture and a central repo of user submitted plugins.

Currently its a mass of scripts loosely tied together and development will be focused on a clean interface. Several UI's are planned although too soon to tell if they'll ever get finished. A web-ui which works the same but incorperates browser-based emulators.


## Features

### Automatic Discovery and Importing of Updating Data Sources

* Data Sources
  * MAME - platforms, rom lists
  * LaunchBox - platforms
  * No-Intro DATs - platforms, rom lists
  * Redump DATs - platforms, rom lists
  * TOSEC DATs - platforms, rom lists
  * GoodTools - platforms, rom lists
  * emuControlCenter - rom lists
  * emuDownloadCenter - platforms, emulators
  * TheGamesDB.net - platforms, games, publishers, developers

### Powerful yet Simple APIs providing JsonRpc, REST, and Socket.IO Interfaces

### Platform Mapping between All Data Sources

### Redundant File Detection / De-Duplication

### Multi-OS Multi-Version Simple Emulator Installation and Discovery

### Emulator and Loader Configuration Mapping

* Configuration Builders
  * LaunchBox
  * HyperSpin
  * RetroArch
  * RocketLaunch
  * Negatron
  * RomCenter
  * RomVault
  * ClrMamePro

### Easily Customized or Expanded using Plugins

### File Path Scanner and Watcher

* ROMs
  * ROM Scanning
  * Compressed File Scanning
  * Inventory
  * Deduplication

### Game and Emulator Launcher

### In-Browser Emulators and Remote Playing

### File Matching using Hashing and AI String Handling

* Matching
  * Match platforms between data sources
  * Match games between data sources
  * Match roms to games in data sources


