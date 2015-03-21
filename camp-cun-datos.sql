CREATE DATABASE  IF NOT EXISTS `camp_cun` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `camp_cun`;
-- MySQL dump 10.13  Distrib 5.6.17, for osx10.6 (i386)
--
-- Host: localhost    Database: camp_cun
-- ------------------------------------------------------
-- Server version	5.5.41-0+wheezy1

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
-- Table structure for table `place`
--

DROP TABLE IF EXISTS `place`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `place` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(200) COLLATE latin1_spanish_ci DEFAULT NULL,
  `address` varchar(400) COLLATE latin1_spanish_ci DEFAULT NULL,
  `latitude` varchar(60) COLLATE latin1_spanish_ci DEFAULT NULL,
  `longitude` varchar(60) COLLATE latin1_spanish_ci DEFAULT NULL,
  `company` varchar(100) COLLATE latin1_spanish_ci DEFAULT NULL,
  `phone` varchar(45) COLLATE latin1_spanish_ci DEFAULT NULL,
  `email` varchar(100) COLLATE latin1_spanish_ci DEFAULT NULL,
  `url` varchar(200) COLLATE latin1_spanish_ci DEFAULT NULL,
  `img_url` varchar(200) COLLATE latin1_spanish_ci DEFAULT NULL,
  `pets` tinyint(1) DEFAULT NULL,
  `price_per_person` varchar(45) COLLATE latin1_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `place`
--

LOCK TABLES `place` WRITE;
/*!40000 ALTER TABLE `place` DISABLE KEYS */;
INSERT INTO `place` VALUES (1,NULL,'Cancun Jungle Camp','Carr Costera del Golfo, 77540 Leona Vicario, Q.R','21.002357','-87.170852',NULL,'984 100 9904','','http://www.cancunjunglecamp.com.mx/','',1,'15'),(2,NULL,'Izamal Campil','Calle 33 x 16,  Colonia Santo Domingo, 97540 Izamal, Yuc','20.929516','-89.007475',NULL,'988 967 6136','','http://campingmexico.jimdo.com','',0,'0'),(3,NULL,'Palula Beach','YUC 27, 97999 San Crisanto, Yuc.','21.353204','-89.172267',NULL,'999 944 6815','','http://www.palula.com/','',1,'23'),(4,NULL,'Wotoch Aayin','24919 Isla Arena, Calkini, Camp.','20.703164','-90.45165',NULL,'044 999 163 4047','','http://www.wotochaayin.com/','',0,'0'),(5,NULL,'Uma Finca San Luis','Uma Finca San Luis Temoz&oacute;n, Yuc M&eacute;x. KM 4.5 Terracer&iacute;a desde X-Uch hacia el oriente, 97740 Temoz&oacute;n.','20.804177','-88.202739',NULL,'985 100 7040','','https://www.facebook.com/cea.umasanluis/timeline','',0,'0'),(6,NULL,'Yucatan Mayan Retreat','Yokdzonot, 97922 Chichen-itza','20.70706','-88.730554',NULL,'044 969 100 0703','','http://yucatanmayanretreat.webs.com/contactuscontactenos.htm','',1,'45'),(7,NULL,'Ba\'alche\'','Quintana Roo El Cafetal-Mahahual, 77940 Mahahual, Q.R.','19.26042','-87.491766',NULL,'55 5689 9978','','baalche.com','',0,'310'),(8,NULL,'Golden Paradise','Calle Geronimo de Aguilar Mz. 122, Lote 2, 77310 Isla Holbox','21.515698','-87.388513',NULL,'984 875 2426','','','',0,'58'),(9,NULL,'Isla de Holbox','','21.525996','21.525996',NULL,'','','','',0,'10'),(10,NULL,'Punta Bete','','20.700161','-87.011964',NULL,'','','','',0,'5'),(11,NULL,'Bacalar','','18.723226','-88.365567',NULL,'','','','',0,'5'),(12,NULL,'Boca Pila','','20.026028','-87.477151',NULL,'','','','',0,'5'),(13,NULL,'Punta Allen','','19.802847','-87.4795',NULL,'','','','',0,'7');
/*!40000 ALTER TABLE `place` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staff`
--

DROP TABLE IF EXISTS `staff`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `staff` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(200) COLLATE latin1_spanish_ci DEFAULT NULL,
  `password` varchar(64) COLLATE latin1_spanish_ci DEFAULT NULL,
  `role` enum('admin','staff') COLLATE latin1_spanish_ci DEFAULT 'staff',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff`
--

LOCK TABLES `staff` WRITE;
/*!40000 ALTER TABLE `staff` DISABLE KEYS */;
INSERT INTO `staff` VALUES (1,'admin@mail.com','f422cb231f20f7d47632d311aebf9dfc6af59bfa01e065817058d90abe4bfeb5','admin'),(2,'staff@mail.com','f422cb231f20f7d47632d311aebf9dfc6af59bfa01e065817058d90abe4bfeb5','staff');
/*!40000 ALTER TABLE `staff` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `todo`
--

DROP TABLE IF EXISTS `todo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `todo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `todo` varchar(200) COLLATE latin1_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `todo`
--

LOCK TABLES `todo` WRITE;
/*!40000 ALTER TABLE `todo` DISABLE KEYS */;
INSERT INTO `todo` VALUES (1,'Casa de Campa&ntilde;a'),(2,'L&aacute;mpara'),(3,'Navaja'),(4,'F&oacute;sforos o Encendedor'),(5,'Botiqu&iacute;n de Primeros Auxilios'),(6,'Repelente de Insectos'),(7,'Comida'),(8,'Agua'),(9,'Cocina (cubiertos y/o cacerolas)');
/*!40000 ALTER TABLE `todo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE latin1_spanish_ci DEFAULT NULL,
  `email` varchar(200) COLLATE latin1_spanish_ci DEFAULT NULL,
  `password` varchar(64) COLLATE latin1_spanish_ci DEFAULT NULL,
  `state` varchar(45) COLLATE latin1_spanish_ci DEFAULT NULL,
  `city` varchar(45) COLLATE latin1_spanish_ci DEFAULT NULL,
  `company` varchar(200) COLLATE latin1_spanish_ci DEFAULT NULL,
  `confirmed` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-03-21  8:47:49
