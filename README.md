# **🎮ConSolo🕹**

from ROMs to Installed Populated Emulators and Frontends in under 12 parsecs!

Scrape Emulator/Rom/Platform/etc Info from Multiple Sources (No-Intro, TOSEC, Redump, MAME, GamesDb, etc) and Intelligently matchs up your media to figure out what you have and writes out configuration files for various Frontends/Emulators/Tools such as LaunchBox/HyperSpin/RocketLauncher/RetroArch/MAMEUI/etc. It maintains a list of most emulators and how to use each one allowing automated/quick installs of 1 to every emulator/rom tool. Pluggable/Extensible architecture and a central repo of user submitted plugins.

Currently its a mass of scripts loosely tied together and development will be focused on a clean interface. Several UI's are planned although too soon to tell if they'll ever get finished. A web-ui which works the same but incorperates browser-based emulators.

### Dev Workspace

- Main list of platforms should come from sources that supply the actual games/roms to ensure we have whats needed without going too overboard:
  - No-Intro
  - TOSEC
  - Redump
  - MAME
- Types to match between sources:
  - Companies
  - Platforms
  - Emulators
  - Games
- Sources list will define each source with (* required):
  - id*
  - name*
  - type*
  - provides[]*
  - info
  - updatedLast
  - updateTrigger
  - web<url, name>
- each Source will have (* required):
  - id*
  - name*
  - shortName (dirname)
  - description
  - company
  - manufacturer
  - developer
  - altNames[]
  - images<url,type>
  - web<url, name>
  - matches<source,id>

##### TODO

- Update updatedLast field in Sources list
- Setup source exports for
  - emuControlCenter
  - EmulationKing
  - LaunchBox
  - ScreenScraper
  - TheGamesDB
  - EmuCR
  - EmuTopia
  - EmuParadise
  - Old-Computers
- Update matches utilizing new source exports
- Add local platforms for any unmatched nointro/redump/tosec/mame sources
- remove excess local platforms without at least 1 nointro/redump/tosec/mame match



![Screenshot](http://i.is.cc/storage/1FidsZ47.png)

#### Dev Links

- [FieldsLinker](http://consolo.is.cc/FieldsLinker/)
- [linksMaker](http://consolo.is.cc/LinksMaker/)
- [detain/emurelation: Emu⬅re➡lation is project with 1 simple purpose; to provide a mapping in JSON format of platforms accross different sources. There are several varied naming conventions used and many different programs and sites and this aims to allow you an easy way to convert or map the data from one type to another. It will eventually expand to include emulators, games, etc; but for now the initial focus is simply platform matching accross all sources.](https://github.com/detain/emurelation)
- [detain/emurelator: Emu<re>lator maps+links your games, media, etc into into the names+layout needed by the target.](https://github.com/detain/emurelator)

#### API Code to look at for other sources

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
