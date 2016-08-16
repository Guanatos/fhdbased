-- MySQL dump 10.13  Distrib 5.6.31, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: fhdbased
-- ------------------------------------------------------
-- Server version	5.6.31-0ubuntu0.14.04.2

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
-- Table structure for table `site_calls`
--

DROP TABLE IF EXISTS `site_calls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `site_calls` (
  `call_id` int(11) NOT NULL AUTO_INCREMENT,
  `call_first_name` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `call_last_name` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `call_phone` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `call_email` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `call_department` int(11) NOT NULL DEFAULT '0',
  `call_request` int(11) NOT NULL DEFAULT '0',
  `call_device` int(11) NOT NULL DEFAULT '0',
  `call_details` text COLLATE latin1_general_ci NOT NULL,
  `call_date` int(11) NOT NULL DEFAULT '0',
  `call_date2` int(11) NOT NULL DEFAULT '0',
  `call_status` int(11) NOT NULL DEFAULT '0',
  `call_solution` text COLLATE latin1_general_ci NOT NULL,
  `call_user` int(11) NOT NULL DEFAULT '0',
  `call_staff` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`call_id`),
  KEY `call_department` (`call_department`),
  KEY `call_request` (`call_request`),
  KEY `call_device` (`call_device`),
  KEY `call_status` (`call_status`),
  KEY `call_user` (`call_user`),
  KEY `call_staff` (`call_staff`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `site_calls`
--

LOCK TABLES `site_calls` WRITE;
/*!40000 ALTER TABLE `site_calls` DISABLE KEYS */;
/*!40000 ALTER TABLE `site_calls` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `site_notes`
--

DROP TABLE IF EXISTS `site_notes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `site_notes` (
  `note_id` int(11) NOT NULL AUTO_INCREMENT,
  `note_title` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `note_body` text COLLATE latin1_general_ci NOT NULL,
  `note_relation` int(11) NOT NULL DEFAULT '0',
  `note_type` int(1) NOT NULL DEFAULT '0',
  `note_post_date` int(11) NOT NULL DEFAULT '0',
  `note_post_ip` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `note_post_user` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`note_id`),
  KEY `note_relation` (`note_relation`),
  KEY `note_type` (`note_type`),
  KEY `note_post_user` (`note_post_user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `site_notes`
--

LOCK TABLES `site_notes` WRITE;
/*!40000 ALTER TABLE `site_notes` DISABLE KEYS */;
/*!40000 ALTER TABLE `site_notes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `site_options`
--

DROP TABLE IF EXISTS `site_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `site_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `option_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `option_value` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `option_name` (`option_name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `site_options`
--

LOCK TABLES `site_options` WRITE;
/*!40000 ALTER TABLE `site_options` DISABLE KEYS */;
INSERT INTO `site_options` VALUES (1,'encrypted_passwords','yes','2014-03-16 18:43:19');
/*!40000 ALTER TABLE `site_options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `site_types`
--

DROP TABLE IF EXISTS `site_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `site_types` (
  `type_id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(1) NOT NULL DEFAULT '0',
  `type_name` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `type_email` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `type_location` text COLLATE latin1_general_ci NOT NULL,
  `type_phone` varchar(100) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`type_id`),
  KEY `type` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `site_types`
--

LOCK TABLES `site_types` WRITE;
/*!40000 ALTER TABLE `site_types` DISABLE KEYS */;
INSERT INTO `site_types` VALUES (1,1,'Sales','','',''),(2,1,'Marketing','','',''),(3,2,'Urgent','','',''),(4,2,'Question','','',''),(5,3,'Monitor','','',''),(6,3,'Keyboard','','',''),(8,2,'Non-Urgent','','',''),(9,3,'Mouse','','',''),(10,3,'Network','','',''),(11,3,'Other','','',''),(12,3,'Computer Unit','','',''),(13,3,'Printer','','',''),(14,3,'Software','','',''),(15,1,'Accounting','','',''),(16,1,'Customer Service','','',''),(17,1,'Design','','','');
/*!40000 ALTER TABLE `site_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `site_upload`
--

DROP TABLE IF EXISTS `site_upload`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `site_upload` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `call_id` int(11) NOT NULL,
  `file_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `file_ext` varchar(4) CHARACTER SET utf8 DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `call_id` (`call_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `site_upload`
--

LOCK TABLES `site_upload` WRITE;
/*!40000 ALTER TABLE `site_upload` DISABLE KEYS */;
/*!40000 ALTER TABLE `site_upload` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `site_users`
--

DROP TABLE IF EXISTS `site_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `site_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_login` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `user_password` varchar(225) COLLATE latin1_general_ci DEFAULT NULL,
  `user_name` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `user_address` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `user_city` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `user_state` char(3) COLLATE latin1_general_ci NOT NULL,
  `user_zip` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `user_country` char(3) COLLATE latin1_general_ci NOT NULL,
  `user_phone` varchar(39) COLLATE latin1_general_ci NOT NULL,
  `user_email` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `user_email2` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `user_im_aol` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `user_im_icq` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `user_im_msn` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `user_im_yahoo` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `user_im_other` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `user_status` int(1) NOT NULL DEFAULT '0',
  `user_level` int(1) NOT NULL DEFAULT '0',
  `user_pending` int(11) NOT NULL DEFAULT '0',
  `user_date` int(11) NOT NULL DEFAULT '0',
  `last_login` int(11) NOT NULL DEFAULT '0',
  `last_ip` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `user_msg_send` int(1) NOT NULL DEFAULT '0',
  `user_msg_subject` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `user_protect_delete` int(1) DEFAULT '0',
  `user_protect_edit` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`),
  KEY `user_pending` (`user_pending`),
  KEY `user_level` (`user_level`),
  KEY `user_status` (`user_status`),
  KEY `user_protect_edit` (`user_protect_edit`),
  KEY `user_msg_send` (`user_msg_send`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci PACK_KEYS=0;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `site_users`
--

LOCK TABLES `site_users` WRITE;
/*!40000 ALTER TABLE `site_users` DISABLE KEYS */;
INSERT INTO `site_users` VALUES (1,'admin','$2a$08$vyov3s6rc7a.Gfae4s7ypeJn68obkckDT9gKFN3Sj9yVClblmNqfS','Site Admin','','','','','','','daniel.nuno@gmail.com','daniel.nuno@gmail.com','','','','','4ehegy5u3',0,0,0,0,1471386118,'127.0.0.1',1,'New Message',1,0),(2,'user1','$2a$08$n79e.6LMXxxATIqXQm7gdueqJLYaYVY0xFtJcLd2KcN0ifB4tG4AW','user1','','','','','','','user1@outlook.com','','','','','','',1,1,0,0,1471290331,'127.0.0.1',0,'',0,0),(3,'user2','$2a$08$9PK0L8U0h7/vOZHebxfPNOTn4O964XGK3vIIWoF26G.jbC7Z6MaMm','user2','','','','','','','user2@outlook.com','','','','','','',1,1,0,0,0,'',0,'',0,0),(4,'staff1','$2a$08$ccvH9XT.QQ./gH8wd0HypehCFw9KmgSpHO7I1fVEo.Vu4WS8jUE8m','staff123','','','','','','','staff1@outlook.com','','','','','','',1,2,0,0,1435682724,'127.0.0.1',0,'',0,0),(5,'user3','$2a$08$zPcFJdtKv.VmhgNvj2nEte9qfi.0phcUtloKm7aLRaHOGr79iVDB2','user3','','','','','','','user3@outlook.com','','','','','','',1,1,0,0,0,'',0,'',0,0),(6,'user4','$2a$08$pLqjQEAtNCLQ/zCIO9i9sObH4SpoXdIMNhDwi00LqO62V0TMc0PHW','user4','','','','','','','user4@outlook.com','','','','','','',1,1,1,0,0,'127.0.0.1',1,'',0,0),(7,'user5','$2a$08$ckvELMrM0Rt.ozHEk3G7f.NpuX1fmA1Ga7aXW.zYIrqbu2BJEn4CO','user5','','','','','','','user5@outlook.com','','','','','','',1,1,1,0,0,'127.0.0.1',1,'',0,0),(8,'staff2','$2a$08$oBuXUlp52BI7Uj8Y58.8XeTg4h5SmAMonk3371Ce8sDNzJY5.goxG','staff2','','','','','','','staff2@outlook.com','','','','','','',1,2,1,0,0,'127.0.0.1',1,'',0,0),(9,'danunora','$2a$08$iDJT2cRcs0PGSUJ/V4JGoey8IRdK5WGQknJspXG7daxf2TCPaQ1SW','Daniel Nuno','','','','','','','daniel_nuno@yahoo.com','','','','','','',0,0,0,0,1471386038,'127.0.0.1',1,'',0,0);
/*!40000 ALTER TABLE `site_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `skills`
--

DROP TABLE IF EXISTS `skills`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `skills` (
  `skill_id` int(11) NOT NULL AUTO_INCREMENT,
  `skill_name` varchar(200) CHARACTER SET latin1 NOT NULL,
  `skill_desc` varchar(200) CHARACTER SET latin1 NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`skill_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `skills`
--

LOCK TABLES `skills` WRITE;
/*!40000 ALTER TABLE `skills` DISABLE KEYS */;
INSERT INTO `skills` VALUES (6,'Fontaneria','La Fontaneria','2015-06-19 22:48:11'),(9,'Carpinteria','La Carpenteria','2015-06-22 15:48:30'),(10,'Lawyer','Abogado litigante','2015-06-22 22:16:41');
/*!40000 ALTER TABLE `skills` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_skills`
--

DROP TABLE IF EXISTS `user_skills`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_skills` (
  `usrskills_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `skill_id` int(11) NOT NULL,
  PRIMARY KEY (`usrskills_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_skills`
--

LOCK TABLES `user_skills` WRITE;
/*!40000 ALTER TABLE `user_skills` DISABLE KEYS */;
INSERT INTO `user_skills` VALUES (1,4,6),(2,4,9),(3,8,10);
/*!40000 ALTER TABLE `user_skills` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-08-16 17:37:00
