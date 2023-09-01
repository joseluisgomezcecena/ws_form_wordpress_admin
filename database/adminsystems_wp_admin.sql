-- MariaDB dump 10.19  Distrib 10.4.24-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: adminsystems_wp_admin
-- ------------------------------------------------------
-- Server version	10.4.24-MariaDB

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
-- Table structure for table `client_company`
--

DROP TABLE IF EXISTS `client_company`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `client_company` (
                                  `id` int(11) NOT NULL AUTO_INCREMENT,
                                  `company_name` varchar(255) NOT NULL,
                                  `company_site` varchar(255) NOT NULL,
                                  `company_db` varchar(255) NOT NULL,
                                  `db_prefix` varchar(255) NOT NULL,
                                  `user_id` int(11) NOT NULL,
                                  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `client_company`
--

LOCK TABLES `client_company` WRITE;
/*!40000 ALTER TABLE `client_company` DISABLE KEYS */;
INSERT INTO `client_company` VALUES (2,'Dr. Carlos ochoa','https://drcarlosocchoa.com','drcarlosochoa','wpxw_',2),(3,'Admin Systems MX','https://adminsystems.mx/','adminsystemsmx','kdn_',3),(4,'Dr. Carlos Ochoa','https://https://drcarlosochoa.com','drcarlosochoa','wpxw_',5);
/*!40000 ALTER TABLE `client_company` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contacts` (
                            `id` int(11) NOT NULL AUTO_INCREMENT,
                            `name` varchar(255) NOT NULL,
                            `last_name` varchar(255) NOT NULL,
                            `email` varchar(255) NOT NULL,
                            `phone` varchar(255) NOT NULL,
                            `client_company_id` int(11) NOT NULL,
                            `dob` date NOT NULL,
                            `contact_reason` text NOT NULL,
                            PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contacts`
--

LOCK TABLES `contacts` WRITE;
/*!40000 ALTER TABLE `contacts` DISABLE KEYS */;
/*!40000 ALTER TABLE `contacts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
                         `user_id` int(11) NOT NULL AUTO_INCREMENT,
                         `user_email` varchar(255) NOT NULL,
                         `password` varchar(255) NOT NULL,
                         `user_phone` varchar(255) NOT NULL,
                         `staff` int(1) NOT NULL DEFAULT 0,
                         `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
                         `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                         PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (2,'jgomez@martechmedical.com','$2y$10$w4zCuH3Bn8LYS/R2abaCuOnISwwtmEmg6pBQtQUN3UDK1h4iCcF9C','+526862594318',1,'2023-08-18 21:30:30','2023-08-24 20:57:14'),(5,'drcarlosochoa@drcarlosochoa.com','$2y$10$IrPAZHFnxoXlGWk5ELGZl.N.VUqQ/1.w0S80Jvg/HksfpcAv72Fae','6868939841',0,'2023-08-23 23:10:32','2023-08-25 20:33:53'),(7,'julian@adminsystems.mx','$2y$10$d3ztrycJfAshdV0rBVBHTuxHftwgKiavkrlF13K0nBL7G1oqT0j5e','6861990001',1,'2023-08-23 23:42:36','2023-08-25 20:36:43');
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

-- Dump completed on 2023-09-01 15:15:10
