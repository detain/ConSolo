-- MySQL dump 10.13  Distrib 8.0.21, for Linux (x86_64)
--
-- Host: localhost    Database: consolo
-- ------------------------------------------------------
-- Server version	8.0.21-0ubuntu0.20.04.4

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
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
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `config` (
  `field` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  PRIMARY KEY (`field`),
  UNIQUE KEY `key_UNIQUE` (`field`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dat_biossets`
--

DROP TABLE IF EXISTS `dat_biossets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dat_biossets` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `game` int unsigned NOT NULL,
  `name` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `description` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `default` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT 'no',
  PRIMARY KEY (`id`),
  KEY `fk_dat_biosset_game_idx` (`game`),
  CONSTRAINT `fk_dat_biosset_game` FOREIGN KEY (`game`) REFERENCES `dat_games` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dat_disks`
--

DROP TABLE IF EXISTS `dat_disks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dat_disks` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `game` int unsigned NOT NULL,
  `name` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `sha1` char(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `md5` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `merge` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `status` enum('baddump','nodump','good','verified') CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT 'good',
  PRIMARY KEY (`id`),
  KEY `fk_dat_disk_game_idx` (`game`),
  CONSTRAINT `fk_dat_disk_game` FOREIGN KEY (`game`) REFERENCES `dat_games` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dat_files`
--

DROP TABLE IF EXISTS `dat_files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dat_files` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `name` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `description` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `category` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `version` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `date` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `author` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `homepage` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `url` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `comment` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `clrmamepro_forcepackaging` enum('zip','unzip') CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT 'zip',
  `clrmamepro_forcenodump` enum('obsolete','required','ignored') CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT 'obsolete',
  `clrmamepro_forcemerging` enum('none','split','full') CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT 'split',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4759 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dat_games`
--

DROP TABLE IF EXISTS `dat_games`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dat_games` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `file` int unsigned NOT NULL,
  `name` varchar(230) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `description` varchar(230) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `category` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `sourcefile` varchar(230) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `isbios` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT 'no',
  `cloneof` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `romof` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `sampleof` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `board` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `rebuildto` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `year` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `manufacturer` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `game_id` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_dat_games_file_idx` (`file`),
  CONSTRAINT `fk_dat_games_file` FOREIGN KEY (`file`) REFERENCES `dat_files` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1657752 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dat_releases`
--

DROP TABLE IF EXISTS `dat_releases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dat_releases` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `game` int unsigned NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `region` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `language` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `date` varchar(70) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `default` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT 'no',
  PRIMARY KEY (`id`),
  KEY `fk_dat_releases_game_idx` (`game`),
  CONSTRAINT `fk_dat_releases_game` FOREIGN KEY (`game`) REFERENCES `dat_games` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=99 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dat_roms`
--

DROP TABLE IF EXISTS `dat_roms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dat_roms` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `game` int unsigned NOT NULL,
  `name` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `size` bigint DEFAULT NULL,
  `crc` char(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `sha1` char(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `md5` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `status` enum('baddump','nodump','good','verified') CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT 'good',
  `date` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `serial` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_dat_roms_game_idx` (`game`),
  CONSTRAINT `fk_dat_roms_game` FOREIGN KEY (`game`) REFERENCES `dat_games` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2147798 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dat_samples`
--

DROP TABLE IF EXISTS `dat_samples`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dat_samples` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `game` int unsigned NOT NULL,
  `name` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_dat_samples_game_idx` (`game`),
  CONSTRAINT `fk_dat_samples_game` FOREIGN KEY (`game`) REFERENCES `dat_games` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `documents`
--

DROP TABLE IF EXISTS `documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `documents` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `doc` json NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `slug_UNIQUE` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Extra Information';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `files`
--

DROP TABLE IF EXISTS `files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `files` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `path` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `size` bigint unsigned NOT NULL,
  `parent` bigint unsigned DEFAULT NULL,
  `mtime` bigint unsigned NOT NULL DEFAULT '0',
  `magic` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `md5` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `sha1` char(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `crc32` char(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `host` int unsigned NOT NULL,
  `extra` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `U_files_host_parent_path` (`host`,`parent`,`path`),
  KEY `IDX_files_host` (`host`) /*!80000 INVISIBLE */,
  KEY `IDX_files_parent` (`parent`),
  KEY `IDX_files_path` (`path`),
  CONSTRAINT `FK_files_host` FOREIGN KEY (`host`) REFERENCES `hosts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_files_parent_file` FOREIGN KEY (`parent`) REFERENCES `files` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11092945 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `handlers`
--

DROP TABLE IF EXISTS `handlers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `handlers` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(5000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `hosts`
--

DROP TABLE IF EXISTS `hosts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `hosts` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `imdb`
--

DROP TABLE IF EXISTS `imdb`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `imdb` (
  `id` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(600) COLLATE utf8mb4_unicode_ci GENERATED ALWAYS AS (json_unquote(json_extract(`doc`,_utf8mb4'$.title'))) VIRTUAL,
  `year` varchar(45) COLLATE utf8mb4_unicode_ci GENERATED ALWAYS AS (json_unquote(json_extract(`doc`,_utf8mb4'$.year'))) VIRTUAL,
  `genre` varchar(200) COLLATE utf8mb4_unicode_ci GENERATED ALWAYS AS (json_unquote(json_extract(`doc`,_utf8mb4'$.genre'))) VIRTUAL,
  `rating` varchar(45) COLLATE utf8mb4_unicode_ci GENERATED ALWAYS AS (json_unquote(json_extract(`doc`,_utf8mb4'$.rating'))) VIRTUAL,
  `comment` mediumtext COLLATE utf8mb4_unicode_ci GENERATED ALWAYS AS (json_unquote(json_extract(`doc`,_utf8mb4'$.comment'))) VIRTUAL,
  `tagline` varchar(2000) COLLATE utf8mb4_unicode_ci GENERATED ALWAYS AS (json_unquote(json_extract(`doc`,_utf8mb4'$.tagline'))) VIRTUAL,
  `imdbsite` varchar(200) COLLATE utf8mb4_unicode_ci GENERATED ALWAYS AS (json_unquote(json_extract(`doc`,_utf8mb4'$.imdbsite'))) VIRTUAL,
  `main_url` varchar(2000) COLLATE utf8mb4_unicode_ci GENERATED ALWAYS AS (json_unquote(json_extract(`doc`,_utf8mb4'$.main_url'))) VIRTUAL,
  `movietype` varchar(200) COLLATE utf8mb4_unicode_ci GENERATED ALWAYS AS (json_unquote(json_extract(`doc`,_utf8mb4'$.movietype'))) VIRTUAL,
  `orig_title` varchar(500) COLLATE utf8mb4_unicode_ci GENERATED ALWAYS AS (json_unquote(json_extract(`doc`,_utf8mb4'$.orig_title'))) VIRTUAL,
  `mpaa_reason` varchar(2000) COLLATE utf8mb4_unicode_ci GENERATED ALWAYS AS (json_unquote(json_extract(`doc`,_utf8mb4'$.mpaa_reason'))) VIRTUAL,
  `plotoutline` varchar(5000) COLLATE utf8mb4_unicode_ci GENERATED ALWAYS AS (json_unquote(json_extract(`doc`,_utf8mb4'$.plotoutline'))) VIRTUAL,
  `updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `doc` json NOT NULL,
  `_json_schema` json GENERATED ALWAYS AS (_utf8mb4'{"type":"object"}') VIRTUAL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `year_idx` (`year`) /*!80000 INVISIBLE */,
  KEY `rating_idx` (`rating`) /*!80000 INVISIBLE */,
  KEY `genre_idx` (`genre`),
  KEY `title_idx` (`title`) /*!80000 INVISIBLE */
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `launchbox_emulatorplatforms`
--

DROP TABLE IF EXISTS `launchbox_emulatorplatforms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `launchbox_emulatorplatforms` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `Emulator` varchar(22) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Platform` varchar(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `CommandLine` varchar(42) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ApplicableFileExtensions` varchar(83) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Recommended` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `launchbox_emulators`
--

DROP TABLE IF EXISTS `launchbox_emulators`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `launchbox_emulators` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(22) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `CommandLine` varchar(109) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ApplicableFileExtensions` varchar(83) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `URL` varchar(47) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `BinaryFileName` varchar(33) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `NoQuotes` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `NoSpace` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `HideConsole` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `FileNameOnly` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `AutoExtract` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `launchbox_files`
--

DROP TABLE IF EXISTS `launchbox_files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `launchbox_files` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `Platform` varchar(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `FileName` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `GameName` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=85830 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `launchbox_gamealternatenames`
--

DROP TABLE IF EXISTS `launchbox_gamealternatenames`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `launchbox_gamealternatenames` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `AlternateName` varchar(140) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `DatabaseID` bigint DEFAULT NULL,
  `Region` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24936 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `launchbox_gameimages`
--

DROP TABLE IF EXISTS `launchbox_gameimages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `launchbox_gameimages` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `DatabaseID` bigint DEFAULT NULL,
  `FileName` varchar(41) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Type` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `CRC32` bigint DEFAULT NULL,
  `Region` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=561625 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `launchbox_games`
--

DROP TABLE IF EXISTS `launchbox_games`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `launchbox_games` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(121) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ReleaseYear` bigint DEFAULT NULL,
  `Overview` text COLLATE utf8mb4_unicode_ci,
  `MaxPlayers` bigint DEFAULT NULL,
  `Cooperative` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `VideoURL` text COLLATE utf8mb4_unicode_ci,
  `DatabaseID` bigint DEFAULT NULL,
  `CommunityRating` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Platform` varchar(38) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ESRB` varchar(21) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `CommunityRatingCount` bigint DEFAULT NULL,
  `Genres` varchar(119) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Developer` varchar(101) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Publisher` varchar(101) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ReleaseDate` varchar(26) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `WikipediaURL` text COLLATE utf8mb4_unicode_ci,
  `DOS` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `StartupFile` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `StartupMD5` varchar(33) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `SetupFile` varchar(33) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `SetupMD5` varchar(33) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `StartupParameters` varchar(23) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=101221 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `launchbox_mamefiles`
--

DROP TABLE IF EXISTS `launchbox_mamefiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `launchbox_mamefiles` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `FileName` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Name` varchar(141) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Status` varchar(12) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Developer` varchar(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Publisher` varchar(77) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Year` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `IsMechanical` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `IsBootleg` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `IsPrototype` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `IsHack` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `IsMature` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `IsQuiz` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `IsFruit` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `IsCasino` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `IsRhythm` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `IsTableTop` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `IsPlayChoice` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `IsMahjong` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `IsNonArcade` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Genre` varchar(52) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `PlayMode` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Language` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Source` varchar(54) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Version` varchar(115) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Region` varchar(14) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Series` varchar(38) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `CloneOf` varchar(14) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41923 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `launchbox_mamelistitems`
--

DROP TABLE IF EXISTS `launchbox_mamelistitems`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `launchbox_mamelistitems` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `FileName` varchar(13) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `GameName` varchar(116) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ListName` varchar(23) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4542 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `launchbox_platformalternatenames`
--

DROP TABLE IF EXISTS `launchbox_platformalternatenames`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `launchbox_platformalternatenames` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Alternate` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=423 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `launchbox_platforms`
--

DROP TABLE IF EXISTS `launchbox_platforms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `launchbox_platforms` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(38) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Emulated` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ReleaseDate` varchar(26) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Developer` varchar(47) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Manufacturer` varchar(94) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Cpu` varchar(127) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Memory` varchar(104) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Graphics` text COLLATE utf8mb4_unicode_ci,
  `Sound` varchar(140) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Display` varchar(145) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Media` varchar(67) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `MaxControllers` varchar(29) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Notes` text COLLATE utf8mb4_unicode_ci,
  `Category` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `UseMameFiles` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=186 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mame_machine_roms`
--

DROP TABLE IF EXISTS `mame_machine_roms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mame_machine_roms` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `machine_id` int unsigned NOT NULL,
  `name` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `size` bigint DEFAULT NULL,
  `crc` char(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `sha1` char(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `status` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `region` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `offset` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `bios` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `merge` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `optional` enum('no','yes') CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `mame_machine_rom_machine_fk_idx` (`machine_id`),
  CONSTRAINT `mame_machine_rom_machine_fk` FOREIGN KEY (`machine_id`) REFERENCES `mame_machines` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=316011 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mame_machines`
--

DROP TABLE IF EXISTS `mame_machines`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mame_machines` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `year` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `manufacturer` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `sourcefile` varchar(70) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `sampleof` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `romof` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `cloneof` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `ismechanical` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `isbios` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `isdevice` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `runnable` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42586 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mame_software`
--

DROP TABLE IF EXISTS `mame_software`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mame_software` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `platform` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `platform_description` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `description` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `year` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `publisher` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `serial` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `supported` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `cloneof` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mame_software_platform_key` (`platform_description`)
) ENGINE=InnoDB AUTO_INCREMENT=125192 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mame_software_roms`
--

DROP TABLE IF EXISTS `mame_software_roms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mame_software_roms` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `software_id` int unsigned NOT NULL,
  `name` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `size` bigint DEFAULT NULL,
  `crc` char(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `sha1` char(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `status` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `offset` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `loadflag` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `mame_software_rom_software_fk_idx` (`software_id`),
  CONSTRAINT `mame_software_rom_software_fk` FOREIGN KEY (`software_id`) REFERENCES `mame_software` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=204698 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `oldcomputers_emulator_platforms`
--

DROP TABLE IF EXISTS `oldcomputers_emulator_platforms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oldcomputers_emulator_platforms` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `emulator` int NOT NULL,
  `platform` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16034 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `oldcomputers_emulators`
--

DROP TABLE IF EXISTS `oldcomputers_emulators`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oldcomputers_emulators` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `host` varchar(5000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2958 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `oldcomputers_platforms`
--

DROP TABLE IF EXISTS `oldcomputers_platforms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oldcomputers_platforms` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `type_id` tinyint DEFAULT NULL,
  `computer_id` smallint DEFAULT NULL,
  `name` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `manufacturer` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `origin` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `year` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `cpu` varchar(160) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `io_ports` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `colors` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `power_supply` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `sound` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `ram` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `price` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `graphic_modes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `speed` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `rom` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `type` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `keyboard` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `text_modes` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `size_weight` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `built_in_language` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `built_in_media` varchar(180) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `os` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `peripherals` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `co_processor` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `vram` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `end_of_production` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `controllers` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `media` varchar(160) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `built_in_software_games` varchar(180) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `number_of_games` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `score` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `built_in_games` varchar(160) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `buttons` varchar(140) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `batteries` varchar(65) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `switches` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `gun` varchar(90) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8733 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `paths`
--

DROP TABLE IF EXISTS `paths`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `paths` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `host` int unsigned NOT NULL,
  `handler` int unsigned DEFAULT NULL,
  `path` varchar(2000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `platform_matches`
--

DROP TABLE IF EXISTS `platform_matches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `platform_matches` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `platform_id` int unsigned NOT NULL,
  `name` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `type` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `platform_match_platform_fk_idx` (`platform_id`),
  CONSTRAINT `platform_match_platform_fk` FOREIGN KEY (`platform_id`) REFERENCES `platforms` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1522 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `platforms`
--

DROP TABLE IF EXISTS `platforms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `platforms` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `release_date` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `developer` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `manufacturer` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `cpu` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `memory` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `graphics` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `sound` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `display` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `media` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `maxcontrollers` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `generation` smallint DEFAULT NULL,
  `wikipedia` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `type` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=670 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tgdb_developers`
--

DROP TABLE IF EXISTS `tgdb_developers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tgdb_developers` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10599 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tgdb_game_alternates`
--

DROP TABLE IF EXISTS `tgdb_game_alternates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tgdb_game_alternates` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `game` int unsigned NOT NULL,
  `name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=81477 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tgdb_game_developers`
--

DROP TABLE IF EXISTS `tgdb_game_developers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tgdb_game_developers` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `game` int unsigned NOT NULL,
  `developer` int unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=374399 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tgdb_game_genres`
--

DROP TABLE IF EXISTS `tgdb_game_genres`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tgdb_game_genres` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `game` int unsigned NOT NULL,
  `genre` int unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=574067 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tgdb_game_publishers`
--

DROP TABLE IF EXISTS `tgdb_game_publishers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tgdb_game_publishers` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `game` int unsigned NOT NULL,
  `publisher` int unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=369583 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tgdb_games`
--

DROP TABLE IF EXISTS `tgdb_games`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tgdb_games` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `game_title` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `release_date` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `platform` int unsigned DEFAULT NULL,
  `players` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `overview` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `last_updated` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `rating` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `coop` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `youtube` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `os` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `processor` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `ram` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `hdd` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `video` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `sound` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=74855 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tgdb_genres`
--

DROP TABLE IF EXISTS `tgdb_genres`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tgdb_genres` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tgdb_platforms`
--

DROP TABLE IF EXISTS `tgdb_platforms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tgdb_platforms` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `alias` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `icon` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `console` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `controller` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `developer` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `manufacturer` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `media` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `cpu` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `memory` varchar(130) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `graphics` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `sound` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `maxcontrollers` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `display` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `overview` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `youtube` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4985 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tgdb_publishers`
--

DROP TABLE IF EXISTS `tgdb_publishers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tgdb_publishers` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(101) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8490 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tmdb`
--

DROP TABLE IF EXISTS `tmdb`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tmdb` (
  `id` int unsigned GENERATED ALWAYS AS (json_unquote(json_extract(`doc`,_utf8mb4'$.id'))) STORED NOT NULL,
  `title` varchar(600) COLLATE utf8mb4_unicode_ci GENERATED ALWAYS AS (json_unquote(json_extract(`doc`,_utf8mb4'$.title'))) STORED,
  `adult` tinyint GENERATED ALWAYS AS ((json_unquote(json_extract(`doc`,_utf8mb4'$.adult')) = _utf8mb4'true')) VIRTUAL,
  `backdrop_path` varchar(200) COLLATE utf8mb4_unicode_ci GENERATED ALWAYS AS (json_unquote(json_extract(`doc`,_utf8mb4'$.backdrop_path'))) VIRTUAL,
  `budget` varchar(45) COLLATE utf8mb4_unicode_ci GENERATED ALWAYS AS (json_unquote(json_extract(`doc`,_utf8mb4'$.budget'))) VIRTUAL,
  `homepage` varchar(500) COLLATE utf8mb4_unicode_ci GENERATED ALWAYS AS (json_unquote(json_extract(`doc`,_utf8mb4'$.homepage'))) VIRTUAL,
  `imdb_id` varchar(45) COLLATE utf8mb4_unicode_ci GENERATED ALWAYS AS (json_unquote(json_extract(`doc`,_utf8mb4'$.imdb_id'))) STORED,
  `original_language` varchar(45) COLLATE utf8mb4_unicode_ci GENERATED ALWAYS AS (json_unquote(json_extract(`doc`,_utf8mb4'$.original_language'))) VIRTUAL,
  `original_title` varchar(500) COLLATE utf8mb4_unicode_ci GENERATED ALWAYS AS (json_unquote(json_extract(`doc`,_utf8mb4'$.original_title'))) VIRTUAL,
  `overview` mediumtext COLLATE utf8mb4_unicode_ci GENERATED ALWAYS AS (json_unquote(json_extract(`doc`,_utf8mb4'$.overview'))) VIRTUAL,
  `popularity` float GENERATED ALWAYS AS (json_unquote(json_extract(`doc`,_utf8mb4'$.popularity'))) VIRTUAL,
  `poster_path` varchar(200) COLLATE utf8mb4_unicode_ci GENERATED ALWAYS AS (json_unquote(json_extract(`doc`,_utf8mb4'$.poster_path'))) VIRTUAL,
  `release_date` varchar(45) COLLATE utf8mb4_unicode_ci GENERATED ALWAYS AS (json_unquote(json_extract(`doc`,_utf8mb4'$.release_date'))) VIRTUAL,
  `revenue` varchar(45) COLLATE utf8mb4_unicode_ci GENERATED ALWAYS AS (json_unquote(json_extract(`doc`,_utf8mb4'$.revenue'))) VIRTUAL,
  `runtime` varchar(45) COLLATE utf8mb4_unicode_ci GENERATED ALWAYS AS (json_unquote(json_extract(`doc`,_utf8mb4'$.runtime'))) VIRTUAL,
  `status` varchar(45) COLLATE utf8mb4_unicode_ci GENERATED ALWAYS AS (json_unquote(json_extract(`doc`,_utf8mb4'$.status'))) VIRTUAL,
  `tagline` varchar(2000) COLLATE utf8mb4_unicode_ci GENERATED ALWAYS AS (json_unquote(json_extract(`doc`,_utf8mb4'$.tagline'))) VIRTUAL,
  `vote_average` float GENERATED ALWAYS AS (json_unquote(json_extract(`doc`,_utf8mb4'$.vote_average'))) VIRTUAL,
  `vote_count` int GENERATED ALWAYS AS (json_unquote(json_extract(`doc`,_utf8mb4'$.vote_count'))) VIRTUAL,
  `video` tinyint GENERATED ALWAYS AS ((json_unquote(json_extract(`doc`,_utf8mb4'$.video')) = _utf8mb4'true')) VIRTUAL,
  `updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `doc` json NOT NULL,
  `_json_schema` json GENERATED ALWAYS AS (_utf8mb4'{"type":"object"}') VIRTUAL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `title_idx` (`title`),
  KEY `imdb_id_idx` (`imdb_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `yts`
--

DROP TABLE IF EXISTS `yts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `yts` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `imdb_code` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_english` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_long` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `year` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rating` float DEFAULT NULL,
  `runtime` int DEFAULT NULL,
  `genres` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `download_count` int DEFAULT NULL,
  `like_count` int DEFAULT NULL,
  `summary` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `description_full` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `synopsis` varchar(10000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `yt_trailer_code` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `language` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mpa_rating` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `background_image` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `background_image_original` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `small_cover_image` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `medium_cover_image` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `large_cover_image` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_uploaded` datetime DEFAULT NULL,
  `date_uploaded_unix` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20132 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `yts_torrents`
--

DROP TABLE IF EXISTS `yts_torrents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `yts_torrents` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `yts_id` int unsigned NOT NULL,
  `url` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `hash` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `quality` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `seeds` int DEFAULT NULL,
  `peers` int DEFAULT NULL,
  `size` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `size_bytes` bigint DEFAULT NULL,
  `date_uploaded` datetime DEFAULT NULL,
  `date_uploaded_unix` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `yts_torrent_yts_idx` (`yts_id`),
  CONSTRAINT `yts_torrent_yts` FOREIGN KEY (`yts_id`) REFERENCES `yts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=80446 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-08-12 11:07:04
