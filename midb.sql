-- MySQL dump 10.13  Distrib 8.0.34, for Win64 (x86_64)
--
-- Host: localhost    Database: midb
-- ------------------------------------------------------
-- Server version	8.0.35

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `assessment_types`
--

DROP TABLE IF EXISTS `assessment_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `assessment_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `assessment_type` varchar(150) DEFAULT NULL,
  `assessment_type_desc` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `assessment_types`
--

LOCK TABLES `assessment_types` WRITE;
/*!40000 ALTER TABLE `assessment_types` DISABLE KEYS */;
INSERT INTO `assessment_types` VALUES (1,'Success Factor',NULL),(2,'SWOT Analysis',NULL),(3,'Competitors Features',NULL);
/*!40000 ALTER TABLE `assessment_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `asset_sizes`
--

DROP TABLE IF EXISTS `asset_sizes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `asset_sizes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `asset_size` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asset_sizes`
--

LOCK TABLES `asset_sizes` WRITE;
/*!40000 ALTER TABLE `asset_sizes` DISABLE KEYS */;
INSERT INTO `asset_sizes` VALUES (1,'Below PHP100,000'),(2,'PHP100,001 - PHP500,000'),(3,'PHP500,001 - PHP1,500,000'),(4,'PHP1,500,001 - PHP3,000,000'),(5,'PHP3,000,001 - PHP5,000,000'),(6,'PHP5,000,001 - PHP10,000,000');
/*!40000 ALTER TABLE `asset_sizes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cfms`
--

DROP TABLE IF EXISTS `cfms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cfms` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cfm` varchar(150) DEFAULT NULL,
  `cfm_desc` text,
  `cfm_code` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cfms`
--

LOCK TABLES `cfms` WRITE;
/*!40000 ALTER TABLE `cfms` DISABLE KEYS */;
/*!40000 ALTER TABLE `cfms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cfsms`
--

DROP TABLE IF EXISTS `cfsms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cfsms` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sfm_id` int DEFAULT NULL,
  `cfsm_code` varchar(45) DEFAULT NULL,
  `cfsm` varchar(150) DEFAULT NULL,
  `cfsm_desc` text,
  PRIMARY KEY (`id`),
  KEY `cfsm_cfms_idx` (`sfm_id`),
  CONSTRAINT `cfsm_cfms` FOREIGN KEY (`sfm_id`) REFERENCES `cfms` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cfsms`
--

LOCK TABLES `cfsms` WRITE;
/*!40000 ALTER TABLE `cfsms` DISABLE KEYS */;
/*!40000 ALTER TABLE `cfsms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `edt_levels`
--

DROP TABLE IF EXISTS `edt_levels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `edt_levels` (
  `id` int NOT NULL AUTO_INCREMENT,
  `edt_level` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `edt_levels`
--

LOCK TABLES `edt_levels` WRITE;
/*!40000 ALTER TABLE `edt_levels` DISABLE KEYS */;
INSERT INTO `edt_levels` VALUES (1,'Level 0 - Entrepreneurial Mind Setting'),(2,'Level 1.1 - Nurturing Start Up (Not Registered)'),(3,'Level 1.1 - Nurturing Start Up (Partially Registered)'),(4,'Level 2 - Growing Enterprises'),(5,'Level 3 - Expanding Enterprises'),(6,'Level 4 - Sustaining Enterprises');
/*!40000 ALTER TABLE `edt_levels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `industry_clusters`
--

DROP TABLE IF EXISTS `industry_clusters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `industry_clusters` (
  `id` int NOT NULL AUTO_INCREMENT,
  `industry_cluster` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `industry_clusters`
--

LOCK TABLES `industry_clusters` WRITE;
/*!40000 ALTER TABLE `industry_clusters` DISABLE KEYS */;
INSERT INTO `industry_clusters` VALUES (1,'PFN'),(2,'Wearables and Homestyle'),(3,'Processed Fruits');
/*!40000 ALTER TABLE `industry_clusters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `msmes`
--

DROP TABLE IF EXISTS `msmes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `msmes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `msme_code` varchar(45) DEFAULT NULL,
  `first_name` varchar(150) DEFAULT NULL,
  `middle_name` varchar(150) DEFAULT NULL,
  `last_name` varchar(150) DEFAULT NULL,
  `phone` varchar(150) DEFAULT NULL,
  `province_id` int DEFAULT NULL,
  `industry_cluster` int DEFAULT NULL,
  `business_name` varchar(150) DEFAULT NULL,
  `edt_level` int DEFAULT NULL,
  `asset_size_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `msme_users_idx` (`user_id`),
  KEY `msme_province_idx` (`province_id`),
  KEY `msme_industry_cluster_idx` (`industry_cluster`),
  KEY `msme_edt_level_idx` (`edt_level`),
  KEY `msme-assets-size_idx` (`asset_size_id`),
  CONSTRAINT `msme-assets-size` FOREIGN KEY (`asset_size_id`) REFERENCES `asset_sizes` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `msme_edt_level` FOREIGN KEY (`edt_level`) REFERENCES `edt_levels` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `msme_industry_cluster` FOREIGN KEY (`industry_cluster`) REFERENCES `industry_clusters` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `msme_province` FOREIGN KEY (`province_id`) REFERENCES `provinces` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `msme_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `msmes`
--

LOCK TABLES `msmes` WRITE;
/*!40000 ALTER TABLE `msmes` DISABLE KEYS */;
INSERT INTO `msmes` VALUES (1,1,NULL,'Dan Alfrei','Celestial','Fuerte','09818098637',6,NULL,'dois coffee',NULL,NULL,'2024-02-19 14:30:33','2024-02-19 14:30:33'),(2,1,NULL,'Dan','Cel','Fue','091234567890',6,NULL,'MJ Furnitures',NULL,NULL,'2024-02-19 15:29:13','2024-02-19 15:29:13');
/*!40000 ALTER TABLE `msmes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `provinces`
--

DROP TABLE IF EXISTS `provinces`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `provinces` (
  `id` int NOT NULL AUTO_INCREMENT,
  `province` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `provinces`
--

LOCK TABLES `provinces` WRITE;
/*!40000 ALTER TABLE `provinces` DISABLE KEYS */;
INSERT INTO `provinces` VALUES (1,'Iloilo Regional Office'),(2,'Aklan Provincial Office'),(3,'Antique Provincial Office'),(4,'Capiz Provincial Office'),(5,'Guimaras Provincial Office'),(6,'Iloilo Provincial Office'),(7,'Negros Occidental Provincial Office');
/*!40000 ALTER TABLE `provinces` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `responses`
--

DROP TABLE IF EXISTS `responses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `responses` (
  `id` int NOT NULL,
  `msme_id` int DEFAULT NULL,
  `assessment_type_id` int DEFAULT NULL,
  `sfm_id` int DEFAULT NULL,
  `sfsm_id` int DEFAULT NULL,
  `swot_id` int DEFAULT NULL,
  `cfm_id` int DEFAULT NULL,
  `cfsm_id` int DEFAULT NULL,
  `value` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `responses_msme_idx` (`msme_id`),
  KEY `responses_assessment_types_idx` (`assessment_type_id`),
  KEY `responses_sfms_idx` (`sfm_id`),
  KEY `responses_swots_idx` (`swot_id`),
  KEY `responses_sfsms_idx` (`sfsm_id`),
  KEY `responses_cfms_idx` (`cfm_id`),
  KEY `responses_sfsms_idx1` (`cfsm_id`),
  CONSTRAINT `responses_assessment_types` FOREIGN KEY (`assessment_type_id`) REFERENCES `assessment_types` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `responses_cfms` FOREIGN KEY (`cfm_id`) REFERENCES `cfms` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `responses_cfsms` FOREIGN KEY (`cfsm_id`) REFERENCES `cfsms` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `responses_msme` FOREIGN KEY (`msme_id`) REFERENCES `msmes` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `responses_sfms` FOREIGN KEY (`sfm_id`) REFERENCES `sfms` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `responses_sfsms` FOREIGN KEY (`sfsm_id`) REFERENCES `sfsms` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `responses_swots` FOREIGN KEY (`swot_id`) REFERENCES `swots` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `responses`
--

LOCK TABLES `responses` WRITE;
/*!40000 ALTER TABLE `responses` DISABLE KEYS */;
/*!40000 ALTER TABLE `responses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `role` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'admin'),(2,'msme');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sfms`
--

DROP TABLE IF EXISTS `sfms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sfms` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sfm_code` varchar(45) DEFAULT NULL,
  `sfm` varchar(150) DEFAULT NULL,
  `sfm_desc` text,
  `rank` int DEFAULT NULL,
  `weight` float(67,10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sfms`
--

LOCK TABLES `sfms` WRITE;
/*!40000 ALTER TABLE `sfms` DISABLE KEYS */;
/*!40000 ALTER TABLE `sfms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sfsms`
--

DROP TABLE IF EXISTS `sfsms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sfsms` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sfm_id` int DEFAULT NULL,
  `sfsm_code` varchar(45) DEFAULT NULL,
  `sfsm` varchar(150) DEFAULT NULL,
  `sfsm_desc` text,
  `rank` int DEFAULT NULL,
  `weight` float(67,10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sfsm_sfms_idx` (`sfm_id`),
  CONSTRAINT `sfsm_sfms` FOREIGN KEY (`sfm_id`) REFERENCES `sfms` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sfsms`
--

LOCK TABLES `sfsms` WRITE;
/*!40000 ALTER TABLE `sfsms` DISABLE KEYS */;
/*!40000 ALTER TABLE `sfsms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `swots`
--

DROP TABLE IF EXISTS `swots`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `swots` (
  `id` int NOT NULL AUTO_INCREMENT,
  `swot_category` enum('Strengths','Weaknesses','Opportunities','Threats') DEFAULT NULL,
  `swot` varchar(150) DEFAULT NULL,
  `swot_desc` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `swots`
--

LOCK TABLES `swots` WRITE;
/*!40000 ALTER TABLE `swots` DISABLE KEYS */;
/*!40000 ALTER TABLE `swots` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(150) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `temp_password` varchar(150) DEFAULT NULL,
  `temp_password_exp` timestamp NULL DEFAULT NULL,
  `active` tinyint DEFAULT NULL,
  `role_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `users_role_idx` (`role_id`),
  CONSTRAINT `users_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'msme1','msme1@gmail.com','pass','',NULL,1,2,'2024-02-19 14:28:53','2024-02-19 14:29:00');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-02-20  9:02:48
