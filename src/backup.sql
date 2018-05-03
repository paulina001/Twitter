-- MySQL dump 10.13  Distrib 5.7.22, for Linux (x86_64)
--
-- Host: localhost    Database: twitter
-- ------------------------------------------------------
-- Server version	5.7.22-0ubuntu0.16.04.1

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
-- Table structure for table `Comment`
--

DROP TABLE IF EXISTS `Comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `postId` int(11) NOT NULL,
  `creationDate` datetime NOT NULL,
  `text` varchar(60) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `postId` (`postId`),
  CONSTRAINT `Comment_ibfk_1` FOREIGN KEY (`postId`) REFERENCES `Tweets` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Comment`
--

LOCK TABLES `Comment` WRITE;
/*!40000 ALTER TABLE `Comment` DISABLE KEYS */;
INSERT INTO `Comment` VALUES (1,2,5,'2018-05-01 20:03:51','Sed ut perspiciatis unde omnis iste natus error.'),(2,2,5,'2018-05-01 20:04:22','Quasi architecto beatae vitae dicta sunt explicabo. '),(3,3,4,'2018-05-01 20:10:18','Et quasi architecto beatae vitae dicta sunt explicabo. '),(4,3,3,'2018-05-01 20:10:48','Sed ut perspiciatis unde omnis iste natus.'),(5,3,1,'2018-05-01 20:11:06','As quasi architecto beatae vitae dicta sunt explicabo. '),(6,3,1,'2018-05-01 20:11:16','Sed ut perspiciatis unde omnis.'),(7,3,2,'2018-05-01 20:11:33','Architecto beatae vitae dicta sunt explicabo. '),(8,3,2,'2018-05-01 20:11:52','Beatae vitae dicta sunt explicabo. '),(9,1,4,'2018-05-01 20:15:44','Lorem ipsum dolor sit amet.'),(10,1,4,'2018-05-01 20:16:00','Quis nostrud exercitation ullamco'),(11,1,7,'2018-05-01 20:16:18','Ut enim ad minim veniam, quis nostrud exercitation ullamco'),(12,1,7,'2018-05-01 20:16:41','Lorem ipsum dolor sit amet, consectetur adipiscing elit.'),(13,1,6,'2018-05-01 20:16:54','Quis nostrud exercitation ullamco'),(14,1,6,'2018-05-01 20:17:08','Lorem ipsum dolor sit amet.'),(15,1,1,'2018-05-01 20:17:32','Lorem ipsum dolor sit amet, consectetur adipiscing el.'),(16,1,1,'2018-05-01 20:17:39','Nostrud exercitation ullamco');
/*!40000 ALTER TABLE `Comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Messages`
--

DROP TABLE IF EXISTS `Messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userIdSend` int(11) NOT NULL,
  `userIdGet` int(11) NOT NULL,
  `text` varchar(300) NOT NULL,
  `creationDate` datetime NOT NULL,
  `isRead` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `userIdSend` (`userIdSend`),
  KEY `userIdGet` (`userIdGet`),
  CONSTRAINT `Messages_ibfk_1` FOREIGN KEY (`userIdSend`) REFERENCES `Users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `Messages_ibfk_2` FOREIGN KEY (`userIdGet`) REFERENCES `Users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Messages`
--

LOCK TABLES `Messages` WRITE;
/*!40000 ALTER TABLE `Messages` DISABLE KEYS */;
INSERT INTO `Messages` VALUES (1,2,1,'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut.','2018-05-01 20:03:05',1),(2,2,1,'Dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.','2018-05-01 20:03:16',1),(3,2,1,'Veritatis et quasi architecto beatae vitae dicta sunt explicabo. ','2018-05-01 20:08:14',1),(4,3,2,'Totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. ','2018-05-01 20:09:56',0),(5,3,2,'Ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. ','2018-05-01 20:10:05',0),(6,3,2,'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. ','2018-05-01 20:12:01',0),(7,3,2,'Inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. ','2018-05-01 20:12:11',0),(8,3,1,'Ne vitae dicta sunt explicabo. ','2018-05-01 20:12:28',1),(9,3,1,'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium.','2018-05-01 20:12:38',1),(10,1,2,'Illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. ','2018-05-01 20:14:31',1),(11,1,2,'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.','2018-05-01 20:14:48',1),(12,1,2,'Ad minim veniam, quis nostrud exercitation ullamco','2018-05-01 20:17:56',0);
/*!40000 ALTER TABLE `Messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Tweets`
--

DROP TABLE IF EXISTS `Tweets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Tweets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `text` varchar(140) NOT NULL,
  `creationDate` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `userId` (`userId`),
  CONSTRAINT `Tweets_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `Users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Tweets`
--

LOCK TABLES `Tweets` WRITE;
/*!40000 ALTER TABLE `Tweets` DISABLE KEYS */;
INSERT INTO `Tweets` VALUES (1,1,'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmo.','2018-05-01 20:01:27'),(2,1,' Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.','2018-05-01 20:01:37'),(3,1,'Laboris nisi ut aliquip ex ea commodo consequat.','2018-05-01 20:01:52'),(4,2,'Lorem ipsum dolor sit amet elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.','2018-05-01 20:02:48'),(5,2,'Ullamco laboris nisi ut aliquip ex ea commodo consequat.','2018-05-01 20:02:55'),(6,3,'Ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. ','2018-05-01 20:10:29'),(7,1,'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod.','2018-05-01 20:16:08');
/*!40000 ALTER TABLE `Tweets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Users`
--

DROP TABLE IF EXISTS `Users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `hash_pass` varchar(60) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Users`
--

LOCK TABLES `Users` WRITE;
/*!40000 ALTER TABLE `Users` DISABLE KEYS */;
INSERT INTO `Users` VALUES (1,'test@gmail.com','test','$2y$10$8gnyEfWUkZkq1ho544W2v.HKONJSDHudFGJtPj4JAfQTzjhOsUZti'),(2,'test4@gmail.com','test4','$2y$10$s3iLlR4uq/gERMAFMClyo.ydUlapcgkWg29jSlIt2SHsoBpTBtSyS'),(3,'test1@gmail.com','test1','$2y$10$c0J/1chIQ2MS36Wdc2932OCko3wYkUOkkDAUTdxgxpmYr/asXNwGO');
/*!40000 ALTER TABLE `Users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-05-01 21:03:08
