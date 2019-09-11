-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.38-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for property_match_db
CREATE DATABASE IF NOT EXISTS `property_match_db` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `property_match_db`;

-- Dumping structure for table property_match_db.properties
CREATE TABLE IF NOT EXISTS `properties` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `latitude` decimal(10,8) NOT NULL DEFAULT '0.00000000',
  `longitude` decimal(11,8) NOT NULL DEFAULT '0.00000000',
  `price` decimal(11,2) NOT NULL DEFAULT '0.00',
  `bedrooms` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `bathrooms` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;

-- Dumping data for table property_match_db.properties: ~2 rows (approximately)
/*!40000 ALTER TABLE `properties` DISABLE KEYS */;
INSERT INTO `properties` (`id`, `created_at`, `updated_at`, `latitude`, `longitude`, `price`, `bedrooms`, `bathrooms`) VALUES
	(24, '2019-09-11 05:41:41', '2019-09-11 05:41:41', 12.87969000, 77.59571600, 350000.00, 7, 2),
	(25, '2019-09-11 09:38:27', '2019-09-11 09:38:27', 12.87889100, 77.49405100, 500000.00, 3, 3),
	(33, '2019-09-11 10:39:09', '2019-09-11 10:39:09', 13.01409300, 77.56587900, 350000.00, 3, 2),
	(34, '2019-09-11 12:08:06', '2019-09-11 12:08:06', 13.05505400, 77.47926400, 425000.00, 5, 6);
/*!40000 ALTER TABLE `properties` ENABLE KEYS */;

-- Dumping structure for table property_match_db.property_requirement_matches
CREATE TABLE IF NOT EXISTS `property_requirement_matches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `property_id` int(11) DEFAULT NULL,
  `requirement_id` int(11) DEFAULT NULL,
  `distance` decimal(20,13) DEFAULT NULL,
  `distance_match_percent` decimal(10,6) DEFAULT NULL,
  `price_match_percent` decimal(10,6) DEFAULT NULL,
  `bedroom_match_percent` decimal(10,6) DEFAULT NULL,
  `bathroom_match_percent` decimal(10,6) DEFAULT NULL,
  `match_percent` decimal(10,6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_property_requirement_matches_properties` (`property_id`),
  KEY `FK_property_requirement_matches_requirements` (`requirement_id`),
  CONSTRAINT `FK_property_requirement_matches_properties` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`),
  CONSTRAINT `FK_property_requirement_matches_requirements` FOREIGN KEY (`requirement_id`) REFERENCES `requirements` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=155 DEFAULT CHARSET=latin1;

-- Dumping data for table property_match_db.property_requirement_matches: ~0 rows (approximately)
/*!40000 ALTER TABLE `property_requirement_matches` DISABLE KEYS */;
INSERT INTO `property_requirement_matches` (`id`, `created_at`, `updated_at`, `property_id`, `requirement_id`, `distance`, `distance_match_percent`, `price_match_percent`, `bedroom_match_percent`, `bathroom_match_percent`, `match_percent`) VALUES
	(82, '2019-09-11 09:37:47', '2019-09-11 09:37:47', 24, 26, 5.3437865742226, 74.921601, 100.000000, 0.000000, 0.000000, 52.476480),
	(83, '2019-09-11 09:38:27', '2019-09-11 09:38:27', 25, 26, 9.2362571037034, 45.728072, 100.000000, 100.000000, 100.000000, 83.718422),
	(92, '2019-09-11 10:18:11', '2019-09-11 10:18:11', 24, 27, 11.2776149004059, 0.000000, 0.000000, 60.000000, 0.000000, 12.000000),
	(93, '2019-09-11 10:18:11', '2019-09-11 10:18:11', 25, 27, 13.0514809257055, 0.000000, 40.000000, 100.000000, 100.000000, 52.000000),
	(115, '2019-09-11 10:39:09', '2019-09-11 10:39:09', 33, 26, 4.8067028689798, 78.949728, 100.000000, 100.000000, 0.000000, 73.684919),
	(116, '2019-09-11 10:39:09', '2019-09-11 10:39:09', 33, 27, 2.5801338722832, 95.648996, 0.000000, 100.000000, 0.000000, 48.694699),
	(125, '2019-09-11 10:52:57', '2019-09-11 10:52:57', 24, 35, 9.5007478684353, 43.744391, 100.000000, 60.000000, 0.000000, 55.123317),
	(126, '2019-09-11 10:52:57', '2019-09-11 10:52:57', 25, 35, 10.5189096926253, 0.000000, 100.000000, 100.000000, 100.000000, 70.000000),
	(127, '2019-09-11 10:52:57', '2019-09-11 10:52:57', 33, 35, 0.0000000000000, 100.000000, 100.000000, 100.000000, 0.000000, 80.000000),
	(144, '2019-09-11 12:01:43', '2019-09-11 12:01:43', 24, 40, 4.7794623753224, 79.154032, 60.000000, 0.000000, 100.000000, 61.746210),
	(145, '2019-09-11 12:01:43', '2019-09-11 12:01:43', 25, 40, 11.4748781153695, 0.000000, 0.000000, 100.000000, 100.000000, 40.000000),
	(146, '2019-09-11 12:01:43', '2019-09-11 12:01:43', 33, 40, 12.6236755837357, 0.000000, 60.000000, 100.000000, 100.000000, 58.000000),
	(147, '2019-09-11 12:03:54', '2019-09-11 12:03:54', 24, 41, 8.8770772809665, 48.421920, 0.000000, 0.000000, 60.000000, 26.526576),
	(148, '2019-09-11 12:03:54', '2019-09-11 12:03:54', 25, 41, 14.9488727147068, 0.000000, 100.000000, 100.000000, 80.000000, 66.000000),
	(149, '2019-09-11 12:03:54', '2019-09-11 12:03:54', 33, 41, 9.9280497262832, 40.539627, 0.000000, 100.000000, 60.000000, 44.161888),
	(150, '2019-09-11 12:08:06', '2019-09-11 12:08:06', 34, 26, 10.9087453230232, 0.000000, 100.000000, 100.000000, 0.000000, 50.000000),
	(151, '2019-09-11 12:08:06', '2019-09-11 12:08:06', 34, 27, 7.5242401718616, 58.568199, 100.000000, 100.000000, 80.000000, 83.570460),
	(152, '2019-09-11 12:08:06', '2019-09-11 12:08:06', 34, 35, 6.4806062175998, 66.395453, 100.000000, 100.000000, 80.000000, 85.918636),
	(153, '2019-09-11 12:08:06', '2019-09-11 12:08:06', 34, 40, 18.4059506731190, 0.000000, 0.000000, 60.000000, 40.000000, 20.000000),
	(154, '2019-09-11 12:08:06', '2019-09-11 12:08:06', 34, 41, 16.4051159801885, 0.000000, 64.000000, 100.000000, 100.000000, 59.200000);
/*!40000 ALTER TABLE `property_requirement_matches` ENABLE KEYS */;

-- Dumping structure for table property_match_db.requirements
CREATE TABLE IF NOT EXISTS `requirements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `latitude` decimal(10,8) NOT NULL DEFAULT '0.00000000',
  `longitude` decimal(11,8) NOT NULL DEFAULT '0.00000000',
  `min_budget` decimal(10,2) DEFAULT NULL,
  `max_budget` decimal(10,2) DEFAULT NULL,
  `min_bedrooms` tinyint(3) unsigned DEFAULT NULL,
  `max_bedrooms` tinyint(3) unsigned DEFAULT NULL,
  `min_bathrooms` tinyint(3) unsigned DEFAULT NULL,
  `max_bathrooms` tinyint(3) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;

-- Dumping data for table property_match_db.requirements: ~0 rows (approximately)
/*!40000 ALTER TABLE `requirements` DISABLE KEYS */;
INSERT INTO `requirements` (`id`, `created_at`, `updated_at`, `latitude`, `longitude`, `min_budget`, `max_budget`, `min_bedrooms`, `max_bedrooms`, `min_bathrooms`, `max_bathrooms`) VALUES
	(26, '2019-09-11 09:37:47', '2019-09-11 09:37:47', 12.95640900, 77.60579400, 300000.00, 600000.00, 2, 5, 3, 4),
	(27, '2019-09-11 10:18:11', '2019-09-11 10:18:11', 13.04283700, 77.59035000, 400000.00, NULL, 3, NULL, 3, NULL),
	(35, '2019-09-11 10:52:57', '2019-09-11 10:52:57', 13.01409300, 77.56587900, 300000.00, 500000.00, 3, NULL, 3, NULL),
	(40, '2019-09-11 12:01:43', '2019-09-11 12:01:43', 12.85783400, 77.66304100, 300000.00, NULL, 1, NULL, 1, NULL),
	(41, '2019-09-11 12:03:54', '2019-09-11 12:03:54', 12.95683300, 77.70113400, NULL, 500000.00, NULL, 5, NULL, 6);
/*!40000 ALTER TABLE `requirements` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
