# **🎮ConSolo🕹**

from ROMs to Installed Populated Emulators and Frontends in under 12 parsecs!

Scrape Emulator/Rom/Platform/etc Info from Multiple Sources (No-Intro, TOSEC, Redump, MAME, GamesDb, etc) and Intelligently matchs up your media to figure out what you have and writes out configuration files for various Frontends/Emulators/Tools such as LaunchBox/HyperSpin/RocketLauncher/RetroArch/MAMEUI/etc. It maintains a list of most emulators and how to use each one allowing automated/quick installs of 1 to every emulator/rom tool. Pluggable/Extensible architecture and a central repo of user submitted plugins.

Currently its a mass of scripts loosely tied together and development will be focused on a clean interface. Several UI's are planned although too soon to tell if they'll ever get finished. A web-ui which works the same but incorperates browser-based emulators.

* [Dev Workspace](#dev-workspace)
  * [Scoop and Bucket Links](#scoop-and-bucket-links)
  * [Other Emulator Links](#other-emulator-links)
  * [Vault View VPS Pages](#vault-view-vps-pages)
  * [Infinite Gallery](#infinite-gallery)
  * [Skyscraper](#skyscraper)

### Dev Workspace

- Main list of platforms should come from sources that supply the actual games/roms to ensure we have whats needed without going too overboard:
  - No-Intro
  - TOSEC
  - Redump
  - MAME
- Types to match between sources:
  - Manufacturers
  - Platforms
  - Emulators
  - Games
- each Type will have (* required):
  - id*
  - name*
  - shortName (dirname)
  - description
  - altNames[]
  - images<url,type>
  - urls<url, name>
- local repo will also have this type:
  - Matches<source,id>

![Screenshot](http://i.is.cc/storage/1FidsZ47.png)

#### Scoop and Bucket Links

- [Scoop Folder Layout · ScoopInstaller/Scoop Wiki](https://github.com/ScoopInstaller/Scoop/wiki/Scoop-Folder-Layout)
- [detain/scoop-emulators-temlate: a scoop bucket 🪣for console 🎮and arcade 🕹emulators.](https://github.com/detain/scoop-emulators-temlate)
- [Buckets · ScoopInstaller/Scoop Wiki](https://github.com/ScoopInstaller/Scoop/wiki/Buckets)
- [Buckets · ScoopInstaller/Scoop Wiki](https://github.com/ScoopInstaller/Scoop/wiki/Buckets#creating-your-own-bucket)
- [Persistent data · ScoopInstaller/Scoop Wiki](https://github.com/ScoopInstaller/Scoop/wiki/Persistent-data)
- [App Manifest Autoupdate · ScoopInstaller/Scoop Wiki](https://github.com/ScoopInstaller/Scoop/wiki/App-Manifest-Autoupdate)
- [nightly.link](https://nightly.link/)
- [updates · detain/scoop-emulators@ffe8e4b](https://github.com/detain/scoop-emulators/runs/7245573270?check_suite_focus=true)

#### Other Emulator Links

- [reactmay/videogames: Application powered by IGDB API](https://github.com/reactmay/videogames)
- [n795113/IGDB-videogame: Play with IGDB API](https://github.com/n795113/IGDB-videogame)
- [bryceandy/games-db: Video games aggregator using IGDB](https://github.com/bryceandy/games-db)
- [emlycool/game-app: Consumed igdb game api v4](https://github.com/emlycool/game-app)
- [Kris-Kuiper/IGDB-v4-API: Wrapper for IGDB API v4](https://github.com/Kris-Kuiper/IGDB-v4-API)
- [Murfy-uk/igdb-API](https://github.com/Murfy-uk/igdb-API)
- [isaacyeboah/video_game_aggregator: A Video Game Aggregator with IGDB Data](https://github.com/isaacyeboah/video_game_aggregator)
- [nialltiernan/igdb-api-wrapper: PHP wrapper for the IGDB API v4](https://github.com/nialltiernan/igdb-api-wrapper)
- [legionth/igdb-reactphp-client: Asynchrounous event-event driven implementation of the - [IGDB API](https://api.igdb.com/) on top of ReactPHP.](https://github.com/legionth/igdb-reactphp-client)
- [s1njar/igdb: This PHP extension works as a wrapper for interface queries at the IGDB API. It contains a query builder where you can add search criteria.](https://github.com/s1njar/igdb)
- [bachzz/IGDb_Internet-Games-Database: IMDb for games](https://github.com/bachzz/IGDb_Internet-Games-Database)
- [Requests – IGDB API docs](https://api-docs.igdb.com/#requests)
- [API Documentation](https://www.mobygames.com/info/api)
- [MobyGames | Tracy Poff](https://www.mobygames.com/user/sheet/userSheetId,82693/)
- [FieldsLinker](http://consolo.is.cc/FieldsLinker/)
- [linksMaker](http://consolo.is.cc/LinksMaker/)
- [detain/emurelation: Emu⬅re➡lation is project with 1 simple purpose; to provide a mapping in JSON format of platforms accross different sources. There are several varied naming conventions used and many different programs and sites and this aims to allow you an easy way to convert or map the data from one type to another. It will eventually expand to include emulators, games, etc; but for now the initial focus is simply platform matching accross all sources.](https://github.com/detain/emurelation)
- [detain/emurelator: Emu<re>lator maps+links your games, media, etc into into the names+layout needed by the target.](https://github.com/detain/emurelator)

### Infinite Gallery

- [bizarro/infinite-webl-gallery: Infinite Auto-Scrolling Gallery using WebGL and GLSL Shaders.](https://github.com/bizarro/infinite-webl-gallery)
- [messier102/portico: Source-agnostic infinite-scrolling media gallery.](https://github.com/messier102/portico)

## Features

### Video Players

<link href="/lib/video.js/dist/video-js.min.css" rel="stylesheet">
<script src="/lib/video.js/dist/video.min.js"></script>
<video id="my-player" class="video-js" controls preload="auto" poster="//vjs.zencdn.net/v/oceans.png" data-setup='{}'>
  <source src="//vjs.zencdn.net/v/oceans.mp4" type="video/mp4"></source>
  <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
</video>

https://github.com/videojs/video.js
https://videojs.com/
https://github.com/google/shaka-player
https://shaka-player-demo.appspot.com/docs/api/tutorial-welcome.html


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

* File Scanner
  * Supports Multiple Hosts
  * Stores file 'magic' info
  * Stores file 'exif' info
  * Stores file 'mediainfo' data
  * Supports recursive compressed file scanning of 7z, zip, and rar files
  * File Removal Detection

* API Scrapper
  * IMDB info
  * TMDB info
	* Movies
	* Persons
	* TV Shows


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


