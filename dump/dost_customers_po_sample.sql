-- MySQL dump 10.19  Distrib 10.3.38-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: ifs5
-- ------------------------------------------------------
-- Server version	10.3.38-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `dost_customers_po_sample`
--

DROP TABLE IF EXISTS `dost_customers_po_sample`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dost_customers_po_sample` (
  `s_id` int(11) NOT NULL AUTO_INCREMENT,
  `s_poeno` int(11) NOT NULL,
  `s_status` int(11) NOT NULL,
  `s_option` int(11) DEFAULT NULL,
  `s_remarks` varchar(255) NOT NULL,
  `s_final_remarks` varchar(255) DEFAULT NULL,
  `s_user` varchar(255) NOT NULL,
  `s_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`s_id`)
) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dost_customers_po_sample`
--

LOCK TABLES `dost_customers_po_sample` WRITE;
/*!40000 ALTER TABLE `dost_customers_po_sample` DISABLE KEYS */;
INSERT INTO `dost_customers_po_sample` VALUES (1,2,1,0,'','','Admin','2020-07-20 11:15:47'),(2,1,2,0,'','','Admin','2022-02-04 07:38:09'),(3,10,2,0,'','','Admin','2022-02-04 07:38:59'),(4,5,3,1,'','DONOT MAKE IT MORE DARKER','Admin','2022-02-04 07:47:09'),(5,11,2,0,'','','Admin','2022-02-04 23:45:44'),(6,12,2,0,'','','Admin','2022-02-04 23:47:10'),(7,13,3,1,'','test by yasss','AdminTester','2023-04-13 14:01:20'),(8,44,2,NULL,'',NULL,'Admin','2023-03-23 21:21:19'),(9,42,2,NULL,'',NULL,'Admin','2023-03-23 21:22:53'),(10,40,2,NULL,'',NULL,'Admin','2023-03-23 21:25:35'),(11,43,1,NULL,'',NULL,'Admin','2023-03-23 21:28:16'),(12,41,2,NULL,'',NULL,'Admin','2023-03-24 10:59:00'),(13,39,1,NULL,'',NULL,'Admin','2023-03-24 11:03:39'),(14,38,1,NULL,'',NULL,'Admin','2023-03-24 11:23:30'),(15,45,1,NULL,'',NULL,'Admin','2023-03-25 12:24:42'),(16,45,1,NULL,'',NULL,'Admin','2023-03-25 12:29:04'),(17,45,1,NULL,'',NULL,'Admin','2023-03-25 12:34:44'),(18,46,1,NULL,'',NULL,'Admin','2023-03-25 12:40:45'),(19,50,1,NULL,'',NULL,'Admin','2023-03-30 12:19:08'),(20,49,1,NULL,'',NULL,'Admin','2023-03-30 12:20:45'),(21,52,2,NULL,'',NULL,'AdminTester','2023-04-12 17:38:21'),(22,51,4,NULL,'',NULL,'AdminTester','2023-04-12 17:41:41'),(23,53,2,NULL,'',NULL,'Admin','2023-04-12 18:37:08'),(24,53,2,NULL,'',NULL,'Admin','2023-04-12 18:42:57'),(25,53,2,NULL,'',NULL,'Admin','2023-04-12 18:49:09'),(26,53,2,NULL,'',NULL,'Admin','2023-04-12 18:49:23'),(27,47,2,NULL,'',NULL,'Admin','2023-04-12 19:22:50'),(28,37,4,NULL,'',NULL,'Admin','2023-04-12 19:23:35'),(29,32,4,NULL,'',NULL,'Admin','2023-04-12 19:26:37'),(30,54,4,NULL,'',NULL,'AdminTester','2023-04-13 13:57:41'),(31,36,4,NULL,'',NULL,'AdminTester','2023-04-13 14:27:57'),(32,55,4,NULL,'',NULL,'Admin','2023-04-13 16:50:57'),(33,55,4,NULL,'',NULL,'Admin','2023-04-13 16:51:13'),(34,55,4,NULL,'',NULL,'Admin','2023-04-13 16:51:28'),(35,27,4,NULL,'',NULL,'Admin','2023-04-13 16:58:49'),(36,56,4,NULL,'',NULL,'Admin','2023-04-13 17:02:51'),(37,57,4,NULL,'',NULL,'Admin','2023-04-13 17:08:54'),(38,25,4,NULL,'',NULL,'Admin','2023-04-13 17:09:59'),(39,58,2,NULL,'',NULL,'Admin','2023-04-13 17:15:17'),(40,59,4,NULL,'',NULL,'Admin','2023-04-14 12:38:15'),(41,64,1,NULL,'',NULL,'Admin','2023-04-14 13:59:50'),(42,68,4,NULL,'',NULL,'AdminTester','2023-04-18 11:29:25'),(43,67,4,NULL,'',NULL,'Admin','2023-04-18 11:29:26'),(44,66,1,NULL,'',NULL,'AdminTester','2023-04-18 11:59:02'),(45,70,1,NULL,'',NULL,'AdminTester','2023-04-24 11:03:58'),(46,62,1,NULL,'',NULL,'Admin','2023-04-25 16:51:31'),(47,62,1,NULL,'',NULL,'Admin','2023-04-25 16:54:16'),(48,71,1,NULL,'',NULL,'Admin','2023-04-25 17:45:22');
/*!40000 ALTER TABLE `dost_customers_po_sample` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-04-25 13:02:28
