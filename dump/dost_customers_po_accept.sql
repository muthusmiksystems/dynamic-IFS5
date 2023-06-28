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
-- Table structure for table `dost_customers_po_accept`
--

DROP TABLE IF EXISTS `dost_customers_po_accept`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dost_customers_po_accept` (
  `a_id` int(11) NOT NULL AUTO_INCREMENT,
  `a_poeno` int(11) NOT NULL,
  `a_status` int(11) NOT NULL,
  `a_option` int(11) NOT NULL,
  `a_remarks` varchar(255) NOT NULL,
  `a_user` varchar(255) NOT NULL,
  `a_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`a_id`)
) ENGINE=MyISAM AUTO_INCREMENT=59 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dost_customers_po_accept`
--

LOCK TABLES `dost_customers_po_accept` WRITE;
/*!40000 ALTER TABLE `dost_customers_po_accept` DISABLE KEYS */;
INSERT INTO `dost_customers_po_accept` VALUES (1,2,1,2,'','Admin','2020-07-20 11:15:47'),(2,1,1,1,'','Admin','2022-02-04 07:38:09'),(3,10,1,1,'','Admin','2022-02-04 07:38:59'),(4,5,1,3,'','Admin','2022-02-04 07:40:45'),(5,11,1,2,'','Admin','2022-02-04 23:45:44'),(6,12,1,1,'','Admin','2022-02-04 23:47:10'),(7,13,1,3,'','Admin','2022-05-21 19:17:10'),(8,42,1,2,'','Admin','2023-03-22 16:04:24'),(9,42,1,2,'','Admin','2023-03-22 16:26:24'),(10,42,1,1,'','Admin','2023-03-22 16:26:38'),(11,44,1,1,'','Admin','2023-03-23 20:59:17'),(12,44,1,1,'','Admin','2023-03-23 21:01:35'),(13,44,1,1,'','Admin','2023-03-23 21:05:01'),(14,44,1,1,'','Admin','2023-03-23 21:05:04'),(15,44,1,1,'','Admin','2023-03-23 21:05:52'),(16,44,1,1,'','Admin','2023-03-23 21:16:56'),(17,44,1,1,'','Admin','2023-03-23 21:21:19'),(18,42,1,1,'','Admin','2023-03-23 21:22:53'),(19,40,1,1,'','Admin','2023-03-23 21:25:35'),(20,43,1,2,'','Admin','2023-03-23 21:28:16'),(21,41,1,1,'','Admin','2023-03-24 10:56:03'),(22,41,1,1,'','Admin','2023-03-24 10:59:00'),(23,39,1,2,'','Admin','2023-03-24 11:03:39'),(24,38,1,2,'','Admin','2023-03-24 11:23:30'),(25,45,1,2,'','Admin','2023-03-25 12:24:42'),(26,45,1,2,'','Admin','2023-03-25 12:29:04'),(27,45,1,2,'','Admin','2023-03-25 12:34:44'),(28,46,1,2,'','Admin','2023-03-25 12:40:45'),(29,50,1,3,'','Admin','2023-03-30 12:19:08'),(30,49,1,2,'','Admin','2023-03-30 12:20:45'),(31,52,1,1,'','AdminTester','2023-04-12 17:38:21'),(32,51,1,2,'','AdminTester','2023-04-12 17:41:41'),(33,53,1,2,'','Admin','2023-04-12 18:37:08'),(34,53,1,3,'','Admin','2023-04-12 18:42:57'),(35,53,1,3,'','Admin','2023-04-12 18:49:09'),(36,53,1,1,'','Admin','2023-04-12 18:49:23'),(37,47,1,3,'','Admin','2023-04-12 19:22:50'),(38,37,1,1,'','Admin','2023-04-12 19:23:35'),(39,32,1,2,'','Admin','2023-04-12 19:26:37'),(40,54,1,3,'','AdminTester','2023-04-13 13:57:41'),(41,36,1,1,'','AdminTester','2023-04-13 14:27:57'),(42,55,1,3,'','Admin','2023-04-13 16:50:57'),(43,55,1,3,'','Admin','2023-04-13 16:51:13'),(44,55,1,2,'','Admin','2023-04-13 16:51:28'),(45,27,1,2,'','Admin','2023-04-13 16:58:49'),(46,56,1,2,'','Admin','2023-04-13 17:02:51'),(47,57,1,2,'','Admin','2023-04-13 17:08:54'),(48,25,1,3,'','Admin','2023-04-13 17:09:59'),(49,58,1,1,'','Admin','2023-04-13 17:15:17'),(50,59,1,2,'','Admin','2023-04-14 12:38:15'),(51,64,1,2,'','Admin','2023-04-14 13:59:50'),(52,68,1,1,'','AdminTester','2023-04-18 11:29:25'),(53,67,1,1,'','Admin','2023-04-18 11:29:26'),(54,66,1,2,'','AdminTester','2023-04-18 11:59:02'),(55,70,1,2,'','AdminTester','2023-04-24 11:03:58'),(56,62,1,2,'','Admin','2023-04-25 16:51:31'),(57,62,1,2,'','Admin','2023-04-25 16:54:16'),(58,71,1,2,'','Admin','2023-04-25 17:45:22');
/*!40000 ALTER TABLE `dost_customers_po_accept` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-04-25 13:01:47
