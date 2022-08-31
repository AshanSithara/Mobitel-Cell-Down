-- MySQL dump 10.13  Distrib 5.7.11, for osx10.9 (x86_64)
--
-- Host: 127.0.0.1    Database: mobitel_cell_db
-- ------------------------------------------------------
-- Server version	5.7.11

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
-- Table structure for table `cell_down_log`
--

DROP TABLE IF EXISTS `cell_down_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cell_down_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `vender` varchar(600) DEFAULT NULL,
  `remark` varchar(1500) DEFAULT NULL,
  `type` varchar(400) DEFAULT NULL,
  `time_down_cell` time DEFAULT NULL,
  `date_down_cell` date DEFAULT NULL,
  `reported_to` varchar(300) DEFAULT NULL,
  `reported_by` varchar(300) DEFAULT NULL,
  `site_name` varchar(800) DEFAULT NULL,
  `l_1escalation` varchar(800) DEFAULT NULL,
  `l_2escalation` varchar(800) DEFAULT NULL,
  `l_3escalation` varchar(800) DEFAULT NULL,
  `down_cell_name` varchar(800) DEFAULT NULL,
  `region` varchar(800) DEFAULT NULL,
  `status` int(11) DEFAULT '0' COMMENT '0 - Active,\n1 - Deleted',
  `cell_status` int(11) DEFAULT '0' COMMENT '1 - Down ,\n0 - UP',
  `fault_type` varchar(100) DEFAULT NULL,
  `fault_type2` varchar(300) DEFAULT NULL,
  `date_of_clear` date DEFAULT NULL,
  `fault_clear_action` varchar(1000) DEFAULT NULL,
  `inoc_tl_name` varchar(1000) DEFAULT NULL,
  `remark_clear` varchar(1000) DEFAULT NULL,
  `cell_up_reported_by` varchar(266) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cell_down_log`
--

LOCK TABLES `cell_down_log` WRITE;
/*!40000 ALTER TABLE `cell_down_log` DISABLE KEYS */;
INSERT INTO `cell_down_log` VALUES (1,'CD1','ZTE','check remark','1','02:00:00','2021-08-05','reported to','Uvindu','site name','1','2','3','1','1',1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-08-04 20:30:52','2021-08-04 20:30:52'),(2,'CD2','Huawei','sssss Remark','Hua - 4G','14:10:00','2021-08-13','Kamal','Uvindu','sssssssss','L1','L2','L3','Uvindu','Region - 04',0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-08-05 07:39:55','2021-08-05 07:39:55'),(3,'CD3','Huawei','sdxcx','Hua - 2G','13:51:00','2021-08-20','reported to','Uvindu Mohotti','sssssssss','1','2','L3','Uvindu','Region - 03',0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-08-06 08:17:25','2021-08-06 08:17:25'),(4,'CD4','ZTE','bhhbhhbbhb','Hua - 2G','17:17:00','2021-08-11','bhbhhbbhb','Uvindu','bhbhbbh','bhbh','bhb','bhbhb','njnjnjjnn','Region - 06',0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-08-06 08:48:02','2021-08-06 08:48:02'),(5,'CD5','Huawei',NULL,'Hua - 2G/4G','19:56:22','2021-08-06',NULL,'Uvindu Mohotti',NULL,NULL,NULL,NULL,NULL,'Region - 01',1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-08-06 14:26:24','2021-08-06 14:26:24'),(6,'CD6','ZTE','sdds','Hua - 2G/4G','22:56:07','2021-08-06','Kamal','Uvindu Mohotti','sssssssss','1','L2','cccccc','Uvindu','Region - 03',0,0,'none',NULL,'2021-08-06','action','TL','remark new','Uvindu Mohotti','2021-08-06 17:26:27','2021-08-06 17:26:27'),(7,'CD7','Huawei','sdsd','Hua - 2G/4G','23:07:49','2021-08-06','sdsdsds','Uvindu Mohotti','bhbhbbh','wdsdsd','sddsd','sdsdd','ddsdd','Region - 03',0,0,'aasasa',NULL,'2021-08-13','ssdssd','sdsdsdsd','sdsdsd','Uvindu Mohotti','2021-08-06 17:38:12','2021-08-06 17:38:12'),(8,'CD8','ZTE','sddf','ZTE - 2G/4G','23:16:02','2021-08-06','dfdffddfd','Uvindu Mohotti','ddfddf','sdds','sdds','sdds','ddfff','Region - 01',0,0,'Env Effect','RAIN FD','2021-08-07','ssdssd','jjjhjhj','kkkkkknnn','Kamal Gune','2021-08-06 17:46:21','2021-08-06 17:46:21'),(9,'CD9','Huawei','sdssd','Hua - 2G/4G','20:28:10','2021-08-08','Kamal','Uvindu Mohotti','bhbhbbh','wdsdsd','ssss','3','ddfff','Region - 02',0,0,'aasasa',NULL,'2021-08-11','dssdsd','sdsddss','sdds','Uvindu Mohotti','2021-08-08 14:58:40','2021-08-08 14:58:40'),(10,'CD10','Huawei','sdds','Hua - 2G/4G','21:08:35','2021-08-08','sdsd','Uvindu Mohotti','sdds','sdds','sdds','sdds','sdds','Region - 01',0,0,'SLT TX','E1/Fiber','2021-08-04','dssdsd','sdsd','dssdsd','Kamal Gune','2021-08-08 15:38:56','2021-08-08 15:38:56');
/*!40000 ALTER TABLE `cell_down_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `region_comment`
--

DROP TABLE IF EXISTS `region_comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `region_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cell_log_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `comment` varchar(4000) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `region_comment`
--

LOCK TABLES `region_comment` WRITE;
/*!40000 ALTER TABLE `region_comment` DISABLE KEYS */;
INSERT INTO `region_comment` VALUES (1,10,7,'Check','2021-08-10 09:17:51','2021-08-10 09:17:51'),(2,10,10,'sdsdsdsdsd','2021-08-10 09:33:25','2021-08-10 09:33:25');
/*!40000 ALTER TABLE `region_comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `usertype` int(11) NOT NULL,
  `mobilenumber` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL COMMENT '1 - Active , 0 - Deleted',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Kamal Gune','uvindu98@gmail.com',1,'0776420633','1628582966_d6b59e5d-36e4-4cca-8418-6b5915d7ee0c_200x200.png','40/10 gaminupura 1st lane, Kottawa',1,NULL,'$2y$10$Tc2MdKIEXWpWqdVLvnAxteIBjauUIH0NSh1zmnSpFaimERS4nUWYm',NULL,'2021-08-05 13:18:12','2021-08-10 08:09:26'),(6,'Uvindu Mohotti','uvindu9sdsd8@gmail.com',3,'0776420633','placeholder.jpg','40/10 gaminupura 1st lane, Kottawa',1,NULL,'$2y$10$pPpVKnUAdOsFNbu0fLpUFeN03w0i.iB8MR8FLYrjpqziBPyhN5XBu',NULL,'2021-08-10 07:28:42','2021-08-10 07:28:42'),(7,'Uvindu Mohotti','uvinduasasa98@gmail.com',3,'0776420633','1628587256_001-use-whatsapp-on-laptop-computer-4051534-20928fb66ee14ae29b06299e3c28220a.jpeg','40/10 gaminupura 1st lane, Kottawa',1,NULL,'$2y$10$2gxV0ntdTTxqILzkZIlKpuSKWHKA.E3giebXkoVmc0XmcLVRN4lV6',NULL,'2021-08-10 07:30:57','2021-08-10 09:20:56'),(8,'Uvindu Mohotti','uvindusdsdsfvcvcv98@gmail.com',3,'0776420633','placeholder.jpg','40/10 gaminupura 1st lane, Kottawa',1,NULL,'$2y$10$TwYCTXe1ZZCOd7fBYOeP.O4ASQWoZvuIE.qk8wKo5HXKZzOfMkAWu',NULL,'2021-08-10 07:37:15','2021-08-10 07:37:15'),(9,'kamal','abc@gmail.com',3,'0776420633','placeholder.jpg','galle',1,NULL,'$2y$10$k6Jd2ia.RkGxHscRlGyOh.0.IJqVVafb.KwernhPwhF9YcVw2zup2',NULL,'2021-08-10 09:27:37','2021-08-10 09:27:37'),(10,'dfgfgnnbvvbv','uvinduxcxcxccxc98@gmail.com',3,'0776420633','placeholder.jpg','40/10 gaminupura 1st lane, Kottawa',1,NULL,'$2y$10$iW296J/fJRkgCov5VfE06OjHi3sKRwuM62RFtpM7mw0DgcTQZ.iS.',NULL,'2021-08-10 09:32:47','2021-08-10 09:34:02'),(13,'Uvindu Mohotti','uvihbbhhndu98@gmail.com',1,'+94776420633','1628622183_001-use-whatsapp-on-laptop-computer-4051534-20928fb66ee14ae29b06299e3c28220a.jpeg','40/10 gaminupura 1st lane\nKottawa',1,NULL,'$2y$10$y9ku24G.mfOqqKxN3H1J1OBBSnBh2eWOcN/Gmxq8T9C3uPWPu3N3W',NULL,'2021-08-10 19:03:03','2021-08-10 19:03:03');
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

-- Dump completed on 2021-08-11  1:23:10
