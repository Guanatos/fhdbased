-- MySQL dump 10.13  Distrib 5.5.43, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: fhdbased
-- ------------------------------------------------------
-- Server version	5.6.19-0ubuntu0.14.04.1

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci PACK_KEYS=0;
/*!40101 SET character_set_client = @saved_cs_client */;

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
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-06-30 16:02:23
