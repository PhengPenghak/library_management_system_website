-- MySQL dump 10.13  Distrib 8.0.30, for Win64 (x86_64)
--
-- Host: localhost    Database: library_management_system
-- ------------------------------------------------------
-- Server version	8.0.30

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
-- Current Database: `library_management_system`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `library_management_system` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `library_management_system`;

--
-- Table structure for table `book`
--

DROP TABLE IF EXISTS `book`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `book` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_book_id` int NOT NULL,
  `location_id` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `author` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sponse` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `img_url` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `created_by` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `book`
--

LOCK TABLES `book` WRITE;
/*!40000 ALTER TABLE `book` DISABLE KEYS */;
INSERT INTO `book` VALUES (1,1,1,'សៀវភៅភាសាខ្មែរថ្នាក់ទី១','ក្រសួងអប់រំ','ក្រសួងអប់រំ',NULL,100,1,'2024-07-07 19:04:23','2024-07-07 19:05:16',0,0),(2,1,1,'សៀវភៅគណិត ថ្នាក់ទី១','ក្រសួងអប់រំ','ក្រសួងអប់រំ',NULL,100,1,'2024-07-07 19:05:05','2024-07-07 19:05:05',0,NULL),(3,1,1,'សៀវភៅសិក្សាសង្គម ថ្នាក់ទី១','ក្រសួងអប់រំ','ក្រសួងអប់រំ',NULL,100,1,'2024-07-07 19:05:56','2024-07-07 19:05:56',0,NULL),(4,1,1,'សៀវភៅវិទ្យាសាស្រ្ត ថ្នាក់ទី១','សៀវភៅវិទ្យាសាស្រ្ត ថ្នាក់ទី១','សៀវភៅវិទ្យាសាស្រ្ត ថ្នាក់ទី១',NULL,100,1,'2024-07-07 19:07:18','2024-07-07 19:07:18',0,NULL),(6,4,1,'សៀវភៅភាសាខ្មែរថ្នាក់ទី១','ក្រសួងអប់រំ','ក្រសួងអប់រំ',NULL,100,1,'2024-07-12 19:50:21','2024-07-12 19:50:21',1,NULL);
/*!40000 ALTER TABLE `book` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `book_distribution_by_grade`
--

DROP TABLE IF EXISTS `book_distribution_by_grade`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `book_distribution_by_grade` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `information_distribution_by_grade_id` int NOT NULL,
  `book_id` int NOT NULL,
  `start` date NOT NULL,
  `end` date NOT NULL,
  `quantity` int DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `created_by` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `book_distribution_by_grade`
--

LOCK TABLES `book_distribution_by_grade` WRITE;
/*!40000 ALTER TABLE `book_distribution_by_grade` DISABLE KEYS */;
INSERT INTO `book_distribution_by_grade` VALUES (1,'002',1,1,'2024-07-21','2024-07-23',15,1,'2024-07-16 15:24:53','2024-07-16 15:24:53',NULL,NULL),(2,NULL,1,2,'2024-07-21','2024-07-23',10,1,'2024-07-16 15:28:06','2024-07-16 15:28:06',NULL,NULL);
/*!40000 ALTER TABLE `book_distribution_by_grade` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `borrow_book`
--

DROP TABLE IF EXISTS `borrow_book`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `borrow_book` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `information_borrower_book_id` int NOT NULL,
  `book_id` int NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `quantity` int DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `created_by` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `missing_books` int DEFAULT NULL,
  `is_read` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `borrow_book`
--

LOCK TABLES `borrow_book` WRITE;
/*!40000 ALTER TABLE `borrow_book` DISABLE KEYS */;
INSERT INTO `borrow_book` VALUES (1,'00001',1,1,'2024-07-01 00:00:00','2024-07-08 00:00:00',1,1,'2024-07-15 00:03:38','2024-07-15 00:03:38',NULL,NULL,0,NULL),(2,'00002',1,1,'2024-07-15 00:00:00','2024-07-23 00:00:00',1,1,'2024-07-15 00:04:01','2024-07-15 00:04:01',NULL,NULL,0,NULL),(3,'00003',1,1,'2024-04-01 00:00:00','2024-04-03 00:00:00',1,1,'2024-07-15 00:04:01','2024-07-15 00:04:01',NULL,NULL,0,NULL),(4,'00004',2,2,'2024-01-01 00:00:00','2024-01-02 00:00:00',1,1,'2024-07-17 16:06:52','2024-07-17 16:06:52',NULL,NULL,NULL,NULL),(5,'00005',2,3,'2024-07-20 23:27:14','2024-07-18 00:00:00',1,1,'2024-07-17 16:06:52','2024-07-17 16:06:52',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `borrow_book` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category_book`
--

DROP TABLE IF EXISTS `category_book`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `category_book` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `sponse` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `created_by` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category_book`
--

LOCK TABLES `category_book` WRITE;
/*!40000 ALTER TABLE `category_book` DISABLE KEYS */;
INSERT INTO `category_book` VALUES (1,'សៀវភៅ​​ គោល',NULL,NULL,1,'2024-07-07 18:49:39','2024-07-07 18:52:36',0,0),(2,'សៀវភៅ អក្សរសិល្ប៍',NULL,NULL,1,'2024-07-07 18:51:07','2024-07-07 18:52:29',0,0),(3,'សៀវភៅ ព័ត៌មាន',NULL,NULL,1,'2024-07-07 18:52:24','2024-07-07 18:52:24',0,NULL),(4,'សៀវភៅ សាបយក្សកប័ត្រ',NULL,NULL,1,'2024-07-07 18:54:04','2024-07-07 18:54:04',0,NULL),(5,'សៀវភៅគោល001',NULL,NULL,1,'2024-07-12 19:11:05','2024-07-12 19:11:05',1,NULL),(6,'តេស្ត',NULL,NULL,1,'2024-07-21 14:17:41','2024-07-21 14:17:41',2,NULL);
/*!40000 ALTER TABLE `category_book` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event`
--

DROP TABLE IF EXISTS `event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `event` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime DEFAULT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event`
--

LOCK TABLES `event` WRITE;
/*!40000 ALTER TABLE `event` DISABLE KEYS */;
INSERT INTO `event` VALUES (3,'test001','2024-07-01 00:00:00','2024-07-02 00:00:00','test001','2024-07-13 07:32:09','2024-07-13 07:32:09');
/*!40000 ALTER TABLE `event` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grade`
--

DROP TABLE IF EXISTS `grade`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `grade` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `created_by` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grade`
--

LOCK TABLES `grade` WRITE;
/*!40000 ALTER TABLE `grade` DISABLE KEYS */;
INSERT INTO `grade` VALUES (1,'ថ្នាក់ទី ១ \'ក\'',1,'2024-07-07 18:55:00','2024-07-07 18:55:00',0,NULL),(2,'ថ្នាក់ទី ២ \'ក\'',1,'2024-07-07 18:55:11','2024-07-07 18:55:11',0,NULL),(3,'ថ្នាក់ទី ៣ \'ក\'',1,'2024-07-07 18:55:19','2024-07-07 18:55:19',0,NULL),(4,'ថ្នាក់ទី ៤ \'ក\'',1,'2024-07-07 18:55:37','2024-07-07 18:55:37',0,NULL);
/*!40000 ALTER TABLE `grade` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `infomation_book_distribution_by_grade`
--

DROP TABLE IF EXISTS `infomation_book_distribution_by_grade`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `infomation_book_distribution_by_grade` (
  `id` int NOT NULL AUTO_INCREMENT,
  `grade_id` int NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `gender` enum('male','female') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'male',
  `status` tinyint(1) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `created_by` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `infomation_book_distribution_by_grade`
--

LOCK TABLES `infomation_book_distribution_by_grade` WRITE;
/*!40000 ALTER TABLE `infomation_book_distribution_by_grade` DISABLE KEYS */;
INSERT INTO `infomation_book_distribution_by_grade` VALUES (1,2,'គ្រូថ្នាំខ្មែរ','male',1,'2024-07-15 15:42:44','2024-07-15 16:25:54',1,1);
/*!40000 ALTER TABLE `infomation_book_distribution_by_grade` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `infomation_borrower_book`
--

DROP TABLE IF EXISTS `infomation_borrower_book`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `infomation_borrower_book` (
  `id` int NOT NULL AUTO_INCREMENT,
  `grade_id` int NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `gender` enum('male','female') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'male',
  `status` tinyint(1) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `created_by` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `infomation_borrower_book`
--

LOCK TABLES `infomation_borrower_book` WRITE;
/*!40000 ALTER TABLE `infomation_borrower_book` DISABLE KEYS */;
INSERT INTO `infomation_borrower_book` VALUES (1,1,'សេសេរឈ្មោះជាភាសារខ្មែរ','male',1,'2024-07-14 23:25:33','2024-07-17 15:53:38',1,1),(2,2,'ឡេង ប៉េងជា','male',1,'2024-07-17 16:06:13','2024-07-17 16:06:13',1,NULL);
/*!40000 ALTER TABLE `infomation_borrower_book` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `location_book`
--

DROP TABLE IF EXISTS `location_book`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `location_book` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `created_by` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `location_book`
--

LOCK TABLES `location_book` WRITE;
/*!40000 ALTER TABLE `location_book` DISABLE KEYS */;
INSERT INTO `location_book` VALUES (1,'ក្នុងបណ្ណាល័យជាន់ទី​ ១',1,'2024-07-07 18:56:36','2024-07-07 18:56:36',0,NULL),(2,'ក្នុងបណ្ណាល័យជាន់ទី​ ២',0,'2024-07-07 18:56:43','2024-07-08 09:46:26',0,0),(3,'ក្នុងបណ្ណាល័យជាន់ទី​ ៣',1,'2024-07-07 18:56:49','2024-07-07 18:56:49',0,NULL),(4,'ក្នុងបណ្ណាល័យជាន់ទី​ ៤',1,'2024-07-07 18:56:57','2024-07-07 18:56:57',0,NULL),(5,'ក្នុងបណ្ណាល័យជាន់ទី​ ៥',1,'2024-07-07 18:57:04','2024-07-07 18:57:04',0,NULL),(6,'ក្នុងបណ្ណាល័យជាន់ទី​ 6',1,'2024-07-12 19:12:05','2024-07-12 19:12:05',1,NULL);
/*!40000 ALTER TABLE `location_book` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `member_joined_library`
--

DROP TABLE IF EXISTS `member_joined_library`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `member_joined_library` (
  `id` int NOT NULL AUTO_INCREMENT,
  `grade_id` int NOT NULL,
  `type_joined` int DEFAULT NULL,
  `type_member` int DEFAULT NULL,
  `total_member` int NOT NULL,
  `total_member_female` int NOT NULL,
  `dateTime` datetime NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `created_by` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `member_joined_library`
--

LOCK TABLES `member_joined_library` WRITE;
/*!40000 ALTER TABLE `member_joined_library` DISABLE KEYS */;
/*!40000 ALTER TABLE `member_joined_library` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migration`
--

DROP TABLE IF EXISTS `migration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migration` (
  `version` varchar(180) COLLATE utf8mb4_general_ci NOT NULL,
  `apply_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migration`
--

LOCK TABLES `migration` WRITE;
/*!40000 ALTER TABLE `migration` DISABLE KEYS */;
INSERT INTO `migration` VALUES ('m000000_000000_base',1720346306),('m230913_083426_create_upload_image_table',1720346307),('m230913_084741_create_user_profile_table',1720346307),('m230913_085034_create_user_role_table',1720346307),('m230913_085123_create_user_role_action_table',1720346307),('m230913_085317_create_user_role_group_tabel',1720346307),('m230913_085527_create_user_role_permission_table',1720346307),('m230914_100056_create_user_table',1720346307),('m240527_134541_add_new_column_to_table',1720346307),('m240527_134542_add_new_column_to_table',1720346602),('m240527_134543_add_new_column_to_table',1720346693),('m240627_124612_create_book_table',1720346307),('m240627_124624_create_category_book_table',1720346307),('m240627_124722_create_grade_table',1720346307),('m240628_094535_create_event_table',1720346307),('m240630_053855_create_infomation_borrower_book_table',1720346307),('m240630_053911_create_borrow_book_table',1720974259),('m240706_153405_create_infomation_book_distribution_by_grade_table',1720346307),('m240706_153447_create_book_distribution_by_grade_table',1720346307),('m240706_154039_create_location_book_table',1720346307),('m240710_063931_add_new_column_to_table_name',1720593644),('m240710_064456_add_new_column_to_table_name',1720593995),('m240710_065044_create_member_joined_library_table',1720594756),('m240715_075707_add_new_column_to_table_borrow_book',1721030569),('m240718_100355_add_column_name_to_table_borrow_book',1721297132);
/*!40000 ALTER TABLE `migration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `upload_image`
--

DROP TABLE IF EXISTS `upload_image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `upload_image` (
  `id` int NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `size` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `type` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `path` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `user_id` varchar(36) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `blurhash` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `upload_image`
--

LOCK TABLES `upload_image` WRITE;
/*!40000 ALTER TABLE `upload_image` DISABLE KEYS */;
/*!40000 ALTER TABLE `upload_image` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` char(36) COLLATE utf8mb4_general_ci NOT NULL,
  `role_id` int DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `auth_key` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `password_hash` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password_reset_token` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` tinyint DEFAULT NULL,
  `user_type_id` int DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `is_master` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES ('1',1,'admin','0CND4BU83dmhdGqE71RCOlK4mNxd1PT','2023-11-06 02:46:07','2024-07-08 10:14:02','$2y$10$SJis8Fk4h2ezv5SPj.clduFz8kMYpAnaEC.AjLDgBbQ4VKt36dH2K','1','phengpenghak1@gmail.com',1,1,'Pheng','Penghak','0712131789',1),('2',2,'library','0CND4BU83dmhdGqE71RCOlK4mNxd1PT','2023-11-06 02:46:07','2024-07-18 10:33:31','$2y$10$KYWRGkhI/u0xyIUOdW6hjuHIswN8vxzSwYsUNhY0hrzYxCC.2mT06','1','phengpenghak2@gmail.com',1,1,'library','library','0712131789',1);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_profile`
--

DROP TABLE IF EXISTS `user_profile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_profile` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` varchar(36) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `upload_image_id` int DEFAULT NULL,
  `first_name` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `last_name` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `gender` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phone_number` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `city_id` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_profile`
--

LOCK TABLES `user_profile` WRITE;
/*!40000 ALTER TABLE `user_profile` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_profile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_role`
--

DROP TABLE IF EXISTS `user_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_role` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `is_master` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_role`
--

LOCK TABLES `user_role` WRITE;
/*!40000 ALTER TABLE `user_role` DISABLE KEYS */;
INSERT INTO `user_role` VALUES (1,'super_admin',1),(2,'library',1);
/*!40000 ALTER TABLE `user_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_role_action`
--

DROP TABLE IF EXISTS `user_role_action`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_role_action` (
  `id` int NOT NULL AUTO_INCREMENT,
  `group_id` int DEFAULT NULL,
  `name` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `controller` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `action` text COLLATE utf8mb4_general_ci,
  `status` tinyint DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_role_action`
--

LOCK TABLES `user_role_action` WRITE;
/*!40000 ALTER TABLE `user_role_action` DISABLE KEYS */;
INSERT INTO `user_role_action` VALUES (1,1,'View','book','view',1),(2,1,'Create','book','create',1),(3,1,'Edit','book','update',1),(4,1,'Delete','book','delete',1);
/*!40000 ALTER TABLE `user_role_action` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_role_group`
--

DROP TABLE IF EXISTS `user_role_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_role_group` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sort` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_role_group`
--

LOCK TABLES `user_role_group` WRITE;
/*!40000 ALTER TABLE `user_role_group` DISABLE KEYS */;
INSERT INTO `user_role_group` VALUES (1,'Book',1);
/*!40000 ALTER TABLE `user_role_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_role_permission`
--

DROP TABLE IF EXISTS `user_role_permission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_role_permission` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_role_id` tinyint DEFAULT NULL,
  `action_id` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_role_permission`
--

LOCK TABLES `user_role_permission` WRITE;
/*!40000 ALTER TABLE `user_role_permission` DISABLE KEYS */;
INSERT INTO `user_role_permission` VALUES (1,2,1),(2,2,1),(3,2,1),(4,2,1);
/*!40000 ALTER TABLE `user_role_permission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'library_management_system'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-07-23 18:41:31
