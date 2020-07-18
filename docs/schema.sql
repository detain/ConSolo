-- MySQL dump 10.13  Distrib 8.0.20, for Linux (x86_64)
--
-- Host: 174.138.179.251    Database: consolo
-- ------------------------------------------------------
-- Server version	8.0.21

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
  `key` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  PRIMARY KEY (`key`),
  UNIQUE KEY `key_UNIQUE` (`key`)
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
  PRIMARY KEY (`id`)
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
  PRIMARY KEY (`id`)
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
) ENGINE=InnoDB AUTO_INCREMENT=3125 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1019826 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=689 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2074551 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
  `mtime` bigint NOT NULL DEFAULT '0',
  `magic` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `md5` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `sha1` char(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `crc32` char(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `host` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `files_parent_fk_idx` (`parent`),
  KEY `files_md5_key` (`md5`),
  KEY `files_crc_key` (`crc32`),
  KEY `files_sha_key` (`sha1`),
  KEY `files_file_path` (`path`)
) ENGINE=InnoDB AUTO_INCREMENT=6275230 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `handlers`
--

DROP TABLE IF EXISTS `handlers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `handlers` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(5000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
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
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
) ENGINE=InnoDB AUTO_INCREMENT=444 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
) ENGINE=InnoDB AUTO_INCREMENT=164 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
) ENGINE=InnoDB AUTO_INCREMENT=600806 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
) ENGINE=InnoDB AUTO_INCREMENT=170516 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
) ENGINE=InnoDB AUTO_INCREMENT=3830571 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
) ENGINE=InnoDB AUTO_INCREMENT=696202 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
) ENGINE=InnoDB AUTO_INCREMENT=293457 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
) ENGINE=InnoDB AUTO_INCREMENT=31790 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
) ENGINE=InnoDB AUTO_INCREMENT=2957 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
) ENGINE=InnoDB AUTO_INCREMENT=1298 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
) ENGINE=InnoDB AUTO_INCREMENT=2183002 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
) ENGINE=InnoDB AUTO_INCREMENT=292316 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
) ENGINE=InnoDB AUTO_INCREMENT=867730 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
) ENGINE=InnoDB AUTO_INCREMENT=1420709 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
) ENGINE=InnoDB AUTO_INCREMENT=16040 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `oldcomputers_emulators`
--

DROP TABLE IF EXISTS `oldcomputers_emulators`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oldcomputers_emulators` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `host` varchar(5000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2964 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
) ENGINE=InnoDB AUTO_INCREMENT=8739 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
  `path` varchar(2000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=81483 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
) ENGINE=InnoDB AUTO_INCREMENT=374405 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
) ENGINE=InnoDB AUTO_INCREMENT=574073 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
) ENGINE=InnoDB AUTO_INCREMENT=369589 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-07-18 16:04:21
