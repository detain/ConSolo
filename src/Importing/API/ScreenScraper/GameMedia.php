<?php
/*
### mediasJeuListe.php: List of media for games

| Input parameters:\
**devid **: your developer ID\
**devpassword **: your developer password\
**softname **: name of the calling software\
**output **: xml(default),json\
**ssid **(not required): ScreenScraper user ID\
**sspassword **(not required): ScreenScraper password of the user

* * * * *

Items : **medias**

Returned Items:\
**media **(xml) / ***id ***(json) {\
  **id **: digital identifier of the media\
  **shortname **: short name of the media\
  **name **: long name of the media\
  **category **: media category\
  **platformtypes **: list of system types where the media is present (system type id separated by | , if empty = all system types)\
  **platforms **: list of systems where the media is present (system type id separated by | , if empty = all systems)\
  **type **: media type\
  **fileformat **: media file format\
  **fileformat2 **: 2nd file format of the media accepted at the proposal\
  **autogen **: auto-generated media (0=no,1=yes)\
  **multiregions **: multi-region media (0=no,1=yes)\
  **multi **-media: multi-media media (0=no,1=yes)\
  **multiversions **: multi-version media (0=no,1=yes)\
  **extrainfostxt **: additional media information\
}

* * * * *

Sample call
*/
global $config;
$url = 'https://www.screenscraper.fr/api2/mediasJeuListe.php?devid='.$config['screenscraper']['api_user'].'&devpassword='.$config['screenscraper']['api_pass'].'&softname=ConSolo&output=json';
