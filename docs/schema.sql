-- MySQL dump 10.13  Distrib 5.7.26, for Linux (x86_64)
--
-- Host: localhost    Database: consolo
-- ------------------------------------------------------
-- Server version	5.7.26-0ubuntu0.19.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `config`
--

DROP TABLE IF EXISTS `config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `config` (
  `key` varchar(191) COLLATE utf8mb4_bin NOT NULL,
  `value` text COLLATE utf8mb4_bin,
  PRIMARY KEY (`key`),
  UNIQUE KEY `key_UNIQUE` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dat_biossets`
--

DROP TABLE IF EXISTS `dat_biossets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dat_biossets` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `game` int(10) unsigned NOT NULL,
  `name` varchar(300) COLLATE utf8mb4_bin DEFAULT NULL,
  `description` varchar(300) COLLATE utf8mb4_bin DEFAULT NULL,
  `default` enum('yes','no') COLLATE utf8mb4_bin DEFAULT 'no',
  PRIMARY KEY (`id`),
  KEY `dat_game_biosset_fk_idx` (`game`),
  CONSTRAINT `dat_game_biosset_fk` FOREIGN KEY (`game`) REFERENCES `dat_games` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dat_disks`
--

DROP TABLE IF EXISTS `dat_disks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dat_disks` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `game` int(10) unsigned NOT NULL,
  `name` varchar(300) COLLATE utf8mb4_bin DEFAULT NULL,
  `sha1` char(40) COLLATE utf8mb4_bin DEFAULT NULL,
  `md5` char(32) COLLATE utf8mb4_bin DEFAULT NULL,
  `merge` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `status` enum('baddump','nodump','good','verified') COLLATE utf8mb4_bin DEFAULT 'good',
  PRIMARY KEY (`id`),
  KEY `dat_game_disk_fk_idx` (`game`),
  CONSTRAINT `dat_game_disk_fk` FOREIGN KEY (`game`) REFERENCES `dat_games` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dat_files`
--

DROP TABLE IF EXISTS `dat_files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dat_files` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(30) COLLATE utf8mb4_bin NOT NULL,
  `name` varchar(120) COLLATE utf8mb4_bin DEFAULT NULL,
  `description` varchar(150) COLLATE utf8mb4_bin DEFAULT NULL,
  `category` varchar(30) COLLATE utf8mb4_bin DEFAULT NULL,
  `version` varchar(30) COLLATE utf8mb4_bin DEFAULT NULL,
  `date` varchar(30) COLLATE utf8mb4_bin DEFAULT NULL,
  `author` varchar(500) COLLATE utf8mb4_bin DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `homepage` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `url` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `comment` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `clrmamepro_forcepackaging` enum('zip','unzip') COLLATE utf8mb4_bin DEFAULT 'zip',
  `clrmamepro_forcenodump` enum('obsolete','required','ignored') COLLATE utf8mb4_bin DEFAULT 'obsolete',
  `clrmamepro_forcemerging` enum('none','split','full') COLLATE utf8mb4_bin DEFAULT 'split',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7889 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dat_games`
--

DROP TABLE IF EXISTS `dat_games`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dat_games` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `file` int(10) unsigned NOT NULL,
  `name` varchar(230) COLLATE utf8mb4_bin DEFAULT NULL,
  `description` varchar(230) COLLATE utf8mb4_bin DEFAULT NULL,
  `category` varchar(30) COLLATE utf8mb4_bin DEFAULT NULL,
  `sourcefile` varchar(230) COLLATE utf8mb4_bin DEFAULT NULL,
  `isbios` enum('yes','no') COLLATE utf8mb4_bin DEFAULT 'no',
  `cloneof` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `romof` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `sampleof` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `board` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `rebuildto` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `year` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `manufacturer` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `game_id` varchar(30) COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `dat_file_fk_idx` (`file`),
  CONSTRAINT `dat_file_fk` FOREIGN KEY (`file`) REFERENCES `dat_files` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2042872 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dat_releases`
--

DROP TABLE IF EXISTS `dat_releases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dat_releases` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `game` int(10) unsigned NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `region` varchar(10) COLLATE utf8mb4_bin DEFAULT NULL,
  `language` varchar(30) COLLATE utf8mb4_bin DEFAULT NULL,
  `date` varchar(70) COLLATE utf8mb4_bin DEFAULT NULL,
  `default` enum('yes','no') COLLATE utf8mb4_bin DEFAULT 'no',
  PRIMARY KEY (`id`),
  KEY `dat_game_release_fk_idx` (`game`),
  CONSTRAINT `dat_game_release_fk` FOREIGN KEY (`game`) REFERENCES `dat_games` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dat_roms`
--

DROP TABLE IF EXISTS `dat_roms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dat_roms` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `game` int(10) unsigned NOT NULL,
  `name` varchar(300) COLLATE utf8mb4_bin DEFAULT NULL,
  `size` bigint(20) DEFAULT NULL,
  `crc` char(8) COLLATE utf8mb4_bin DEFAULT NULL,
  `sha1` char(40) COLLATE utf8mb4_bin DEFAULT NULL,
  `md5` char(32) COLLATE utf8mb4_bin DEFAULT NULL,
  `status` enum('baddump','nodump','good','verified') COLLATE utf8mb4_bin DEFAULT 'good',
  `date` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `serial` varchar(80) COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `dat_game_rom_fk_idx` (`game`),
  CONSTRAINT `dat_game_rom_fk` FOREIGN KEY (`game`) REFERENCES `dat_games` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3390910 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dat_samples`
--

DROP TABLE IF EXISTS `dat_samples`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dat_samples` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `game` int(10) unsigned NOT NULL,
  `name` varchar(300) COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `dat_game_sample_fk_idx` (`game`),
  CONSTRAINT `dat_game_sample_fk` FOREIGN KEY (`game`) REFERENCES `dat_games` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `files`
--

DROP TABLE IF EXISTS `files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `files` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `path` varchar(500) COLLATE utf8mb4_bin NOT NULL,
  `size` bigint(20) unsigned NOT NULL,
  `mtime` bigint(20) NOT NULL DEFAULT '0',
  `md5` char(32) COLLATE utf8mb4_bin DEFAULT NULL,
  `sha1` char(40) COLLATE utf8mb4_bin DEFAULT NULL,
  `crc32` char(8) COLLATE utf8mb4_bin DEFAULT NULL,
  `parent` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `file_id_UNIQUE` (`id`),
  KEY `files_parent_fk_idx` (`parent`),
  FULLTEXT KEY `file_path` (`path`),
  CONSTRAINT `files_parent_fk` FOREIGN KEY (`parent`) REFERENCES `files` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1083896 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `launchbox_emulatorplatforms`
--

DROP TABLE IF EXISTS `launchbox_emulatorplatforms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `launchbox_emulatorplatforms` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Emulator` varchar(22) COLLATE utf8mb4_bin DEFAULT NULL,
  `Platform` varchar(36) COLLATE utf8mb4_bin DEFAULT NULL,
  `CommandLine` varchar(42) COLLATE utf8mb4_bin DEFAULT NULL,
  `ApplicableFileExtensions` varchar(83) COLLATE utf8mb4_bin DEFAULT NULL,
  `Recommended` varchar(6) COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `launchbox_emulators`
--

DROP TABLE IF EXISTS `launchbox_emulators`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `launchbox_emulators` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(22) COLLATE utf8mb4_bin DEFAULT NULL,
  `CommandLine` varchar(109) COLLATE utf8mb4_bin DEFAULT NULL,
  `ApplicableFileExtensions` varchar(83) COLLATE utf8mb4_bin DEFAULT NULL,
  `URL` varchar(47) COLLATE utf8mb4_bin DEFAULT NULL,
  `BinaryFileName` varchar(33) COLLATE utf8mb4_bin DEFAULT NULL,
  `NoQuotes` varchar(6) COLLATE utf8mb4_bin DEFAULT NULL,
  `NoSpace` varchar(6) COLLATE utf8mb4_bin DEFAULT NULL,
  `HideConsole` varchar(6) COLLATE utf8mb4_bin DEFAULT NULL,
  `FileNameOnly` varchar(6) COLLATE utf8mb4_bin DEFAULT NULL,
  `AutoExtract` varchar(6) COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `launchbox_files`
--

DROP TABLE IF EXISTS `launchbox_files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `launchbox_files` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Platform` varchar(36) COLLATE utf8mb4_bin DEFAULT NULL,
  `FileName` varchar(150) COLLATE utf8mb4_bin DEFAULT NULL,
  `GameName` varchar(150) COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=85830 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `launchbox_gamealternatenames`
--

DROP TABLE IF EXISTS `launchbox_gamealternatenames`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `launchbox_gamealternatenames` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `AlternateName` varchar(140) COLLATE utf8mb4_bin DEFAULT NULL,
  `DatabaseID` bigint(20) DEFAULT NULL,
  `Region` varchar(16) COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16476 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `launchbox_gameimages`
--

DROP TABLE IF EXISTS `launchbox_gameimages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `launchbox_gameimages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `DatabaseID` bigint(20) DEFAULT NULL,
  `FileName` varchar(41) COLLATE utf8mb4_bin DEFAULT NULL,
  `Type` varchar(30) COLLATE utf8mb4_bin DEFAULT NULL,
  `CRC32` bigint(20) DEFAULT NULL,
  `Region` varchar(16) COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=410090 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `launchbox_games`
--

DROP TABLE IF EXISTS `launchbox_games`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `launchbox_games` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(118) COLLATE utf8mb4_bin DEFAULT NULL,
  `ReleaseYear` bigint(20) DEFAULT NULL,
  `Overview` text COLLATE utf8mb4_bin,
  `MaxPlayers` bigint(20) DEFAULT NULL,
  `Cooperative` varchar(6) COLLATE utf8mb4_bin DEFAULT NULL,
  `VideoURL` text COLLATE utf8mb4_bin,
  `DatabaseID` bigint(20) DEFAULT NULL,
  `CommunityRating` varchar(20) COLLATE utf8mb4_bin DEFAULT NULL,
  `Platform` varchar(38) COLLATE utf8mb4_bin DEFAULT NULL,
  `ESRB` varchar(21) COLLATE utf8mb4_bin DEFAULT NULL,
  `CommunityRatingCount` bigint(20) DEFAULT NULL,
  `Genres` varchar(119) COLLATE utf8mb4_bin DEFAULT NULL,
  `Developer` varchar(101) COLLATE utf8mb4_bin DEFAULT NULL,
  `Publisher` varchar(101) COLLATE utf8mb4_bin DEFAULT NULL,
  `ReleaseDate` varchar(26) COLLATE utf8mb4_bin DEFAULT NULL,
  `WikipediaURL` text COLLATE utf8mb4_bin,
  `DOS` varchar(6) COLLATE utf8mb4_bin DEFAULT NULL,
  `StartupFile` varchar(32) COLLATE utf8mb4_bin DEFAULT NULL,
  `StartupMD5` varchar(33) COLLATE utf8mb4_bin DEFAULT NULL,
  `SetupFile` varchar(33) COLLATE utf8mb4_bin DEFAULT NULL,
  `SetupMD5` varchar(33) COLLATE utf8mb4_bin DEFAULT NULL,
  `StartupParameters` varchar(23) COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=83154 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `launchbox_mamefiles`
--

DROP TABLE IF EXISTS `launchbox_mamefiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `launchbox_mamefiles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `FileName` varchar(30) COLLATE utf8mb4_bin DEFAULT NULL,
  `Name` varchar(141) COLLATE utf8mb4_bin DEFAULT NULL,
  `Status` varchar(12) COLLATE utf8mb4_bin DEFAULT NULL,
  `Developer` varchar(1) COLLATE utf8mb4_bin DEFAULT NULL,
  `Publisher` varchar(77) COLLATE utf8mb4_bin DEFAULT NULL,
  `Year` varchar(6) COLLATE utf8mb4_bin DEFAULT NULL,
  `IsMechanical` varchar(6) COLLATE utf8mb4_bin DEFAULT NULL,
  `IsBootleg` varchar(6) COLLATE utf8mb4_bin DEFAULT NULL,
  `IsPrototype` varchar(6) COLLATE utf8mb4_bin DEFAULT NULL,
  `IsHack` varchar(6) COLLATE utf8mb4_bin DEFAULT NULL,
  `IsMature` varchar(6) COLLATE utf8mb4_bin DEFAULT NULL,
  `IsQuiz` varchar(6) COLLATE utf8mb4_bin DEFAULT NULL,
  `IsFruit` varchar(6) COLLATE utf8mb4_bin DEFAULT NULL,
  `IsCasino` varchar(6) COLLATE utf8mb4_bin DEFAULT NULL,
  `IsRhythm` varchar(6) COLLATE utf8mb4_bin DEFAULT NULL,
  `IsTableTop` varchar(6) COLLATE utf8mb4_bin DEFAULT NULL,
  `IsPlayChoice` varchar(6) COLLATE utf8mb4_bin DEFAULT NULL,
  `IsMahjong` varchar(6) COLLATE utf8mb4_bin DEFAULT NULL,
  `IsNonArcade` varchar(6) COLLATE utf8mb4_bin DEFAULT NULL,
  `Genre` varchar(48) COLLATE utf8mb4_bin DEFAULT NULL,
  `PlayMode` varchar(16) COLLATE utf8mb4_bin DEFAULT NULL,
  `Language` varchar(21) COLLATE utf8mb4_bin DEFAULT NULL,
  `Source` varchar(49) COLLATE utf8mb4_bin DEFAULT NULL,
  `Version` varchar(115) COLLATE utf8mb4_bin DEFAULT NULL,
  `Region` varchar(14) COLLATE utf8mb4_bin DEFAULT NULL,
  `Series` varchar(35) COLLATE utf8mb4_bin DEFAULT NULL,
  `CloneOf` varchar(14) COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40258 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `launchbox_mamelistitems`
--

DROP TABLE IF EXISTS `launchbox_mamelistitems`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `launchbox_mamelistitems` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `FileName` varchar(13) COLLATE utf8mb4_bin DEFAULT NULL,
  `GameName` varchar(116) COLLATE utf8mb4_bin DEFAULT NULL,
  `ListName` varchar(23) COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4542 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `launchbox_platformalternatenames`
--

DROP TABLE IF EXISTS `launchbox_platformalternatenames`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `launchbox_platformalternatenames` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(36) COLLATE utf8mb4_bin DEFAULT NULL,
  `Alternate` varchar(40) COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=423 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `launchbox_platforms`
--

DROP TABLE IF EXISTS `launchbox_platforms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `launchbox_platforms` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(38) COLLATE utf8mb4_bin DEFAULT NULL,
  `Emulated` varchar(6) COLLATE utf8mb4_bin DEFAULT NULL,
  `ReleaseDate` varchar(26) COLLATE utf8mb4_bin DEFAULT NULL,
  `Developer` varchar(47) COLLATE utf8mb4_bin DEFAULT NULL,
  `Manufacturer` varchar(29) COLLATE utf8mb4_bin DEFAULT NULL,
  `Cpu` varchar(127) COLLATE utf8mb4_bin DEFAULT NULL,
  `Memory` varchar(104) COLLATE utf8mb4_bin DEFAULT NULL,
  `Graphics` text COLLATE utf8mb4_bin,
  `Sound` varchar(140) COLLATE utf8mb4_bin DEFAULT NULL,
  `Display` varchar(145) COLLATE utf8mb4_bin DEFAULT NULL,
  `Media` varchar(67) COLLATE utf8mb4_bin DEFAULT NULL,
  `MaxControllers` varchar(28) COLLATE utf8mb4_bin DEFAULT NULL,
  `Notes` text COLLATE utf8mb4_bin,
  `Category` varchar(10) COLLATE utf8mb4_bin DEFAULT NULL,
  `UseMameFiles` varchar(6) COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=186 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mame_machines`
--

DROP TABLE IF EXISTS `mame_machines`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mame_machines` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(500) COLLATE utf8mb4_bin DEFAULT NULL,
  `year` varchar(6) COLLATE utf8mb4_bin DEFAULT NULL,
  `manufacturer` varchar(80) COLLATE utf8mb4_bin DEFAULT NULL,
  `name` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `sourcefile` varchar(70) COLLATE utf8mb4_bin DEFAULT NULL,
  `sampleof` varchar(30) COLLATE utf8mb4_bin DEFAULT NULL,
  `romof` varchar(30) COLLATE utf8mb4_bin DEFAULT NULL,
  `cloneof` varchar(30) COLLATE utf8mb4_bin DEFAULT NULL,
  `ismechanical` varchar(4) COLLATE utf8mb4_bin DEFAULT NULL,
  `isbios` varchar(4) COLLATE utf8mb4_bin DEFAULT NULL,
  `isdevice` varchar(4) COLLATE utf8mb4_bin DEFAULT NULL,
  `runnable` varchar(3) COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40493 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mame_software`
--

DROP TABLE IF EXISTS `mame_software`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mame_software` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `platform` varchar(30) COLLATE utf8mb4_bin DEFAULT NULL,
  `platform_description` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `description` varchar(300) COLLATE utf8mb4_bin DEFAULT NULL,
  `year` varchar(6) COLLATE utf8mb4_bin DEFAULT NULL,
  `publisher` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `name` varchar(30) COLLATE utf8mb4_bin DEFAULT NULL,
  `serial` varchar(150) COLLATE utf8mb4_bin DEFAULT NULL,
  `supported` varchar(10) COLLATE utf8mb4_bin DEFAULT NULL,
  `cloneof` varchar(30) COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=108759 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `platforms`
--

DROP TABLE IF EXISTS `platforms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `platforms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_bin DEFAULT NULL,
  `release_date` varchar(191) COLLATE utf8mb4_bin DEFAULT NULL,
  `developer` varchar(191) COLLATE utf8mb4_bin DEFAULT NULL,
  `manufacturer` varchar(191) COLLATE utf8mb4_bin DEFAULT NULL,
  `cpu` varchar(191) COLLATE utf8mb4_bin DEFAULT NULL,
  `memory` varchar(191) COLLATE utf8mb4_bin DEFAULT NULL,
  `graphics` varchar(191) COLLATE utf8mb4_bin DEFAULT NULL,
  `sound` varchar(191) COLLATE utf8mb4_bin DEFAULT NULL,
  `display` varchar(191) COLLATE utf8mb4_bin DEFAULT NULL,
  `media` varchar(191) COLLATE utf8mb4_bin DEFAULT NULL,
  `maxcontrollers` varchar(191) COLLATE utf8mb4_bin DEFAULT NULL,
  `notes` text COLLATE utf8mb4_bin,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-07-17  1:45:30
