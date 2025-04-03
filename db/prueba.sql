-- MySQL dump 10.13  Distrib 8.0.41, for Win64 (x86_64)
--
-- Host: localhost    Database: prueba
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

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
-- Table structure for table `helados`
--

DROP TABLE IF EXISTS `helados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `helados` (
  `id` varchar(45) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `imagen` varchar(256) NOT NULL,
  `precio` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `helados`
--

LOCK TABLES `helados` WRITE;
/*!40000 ALTER TABLE `helados` DISABLE KEYS */;
INSERT INTO `helados` VALUES ('1','Ensalada de frutas','image/helado1.webp','12.000'),('10','Bum-Rosa','image/helado10.webp','16.000'),('11','Waffle-arequipe','image/helado11.webp','12.000'),('12','Waffle-chocolate','image/helado12.webp','12.000'),('13','Waffle-nutella','image/helado13.webp','12.000'),('14','Waffle-queso','image/helado14.webp','12.000'),('2','Bananín','image/helado2.webp','11.000'),('3','Banana Split','image/helado3.webp','14.000'),('4','Batido de cacaguate','image/helado4.webp','11.500'),('5','Copa melon','image/helado5.webp','12.000'),('6','Merlín','image/helado6.webp','12.000'),('7','Malteado-licor','image/helado7.webp','14.000'),('8','Payaso','image/helado8.webp','8.000'),('9','Raton','image/helado9.webp','8.000');
/*!40000 ALTER TABLE `helados` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-03-15 18:08:30
