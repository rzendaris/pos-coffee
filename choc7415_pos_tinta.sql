-- MySQL dump 10.16  Distrib 10.1.44-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: choc7415_pos_tinta
-- ------------------------------------------------------
-- Server version	10.1.44-MariaDB-cll-lve

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
-- Table structure for table `branch`
--

DROP TABLE IF EXISTS `branch`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `branch` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_name` varchar(255) NOT NULL,
  `address` longtext NOT NULL,
  `telp` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `fax` varchar(255) DEFAULT NULL,
  `head_office` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '1 = Active; 2 = Inactive',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(255) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `branch`
--

LOCK TABLES `branch` WRITE;
/*!40000 ALTER TABLE `branch` DISABLE KEYS */;
INSERT INTO `branch` VALUES (1,'Centro Harko','6203 Lindgren Drive Suite 505\r\nTerryberg, IN 77108','844-788-2945','moore.amelia@jones.org','+5646610843484','Darmadi',1,'2019-08-25 13:48:39','Admin Tester','2019-08-25 14:05:22','Admin Tester'),(2,'Centro Alam Sutra','203 Eleanora Views\r\nSouth Lucious, AZ 92268-3230','1-855-504-3655','dconroy@yahoo.com','+4245609408783','Mba Dita',1,'2019-08-25 13:50:09','Admin Tester','2019-08-25 13:50:09',NULL);
/*!40000 ALTER TABLE `branch` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `branch_id` bigint(20) NOT NULL,
  `customer_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `telp` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES (1,1,'Prof. Adan Jones','0','482 McGlynn PineMcClurehaven, KS 14656-0234','877-785-1155','Greenholt-Paucek','2019-07-26 03:54:38',NULL,'2019-10-01 10:51:00','Admin Tester'),(2,2,'Brenden Oberbrunner','0','619 Donnelly Manors\nSouth Unaville, MD 92992','866-528-8694','McCullough Inc','2019-07-26 03:54:38',NULL,'2019-07-26 03:54:38',''),(3,1,'Haleigh Spencer','0','4092 Schroeder Ramp Suite 622\nStrosinberg, PA 36891','888-722-0876','Barrows-Braun','2019-07-26 03:54:38',NULL,'2019-07-26 03:54:38',''),(4,2,'Mr. Jonathan Ratke','0','5808 Harris Parks\nWest Addiemouth, OH 00741-5136','888.529.8535','Kovacek and Sons','2019-07-26 03:54:38',NULL,'2019-07-26 03:54:38',''),(5,1,'Lyda Okuneva','0','9080 Johnny Corner\nLake Dalemouth, NJ 86808-2553','844.645.0035','DuBuque-Heidenreich','2019-07-26 03:54:38',NULL,'2019-07-26 03:54:38',''),(6,2,'Dixie Reynolds MD','0','8240 Lindsay Roads Suite 029\nPeterton, SC 33452-8121','1-866-665-0596','Abshire, Weissnat and Gerlach','2019-07-26 03:54:38',NULL,'2019-07-26 03:54:38',''),(7,1,'Rocky McLaughlin MD','0','75180 Erdman Street\nCraigside, WY 46995','844-695-8789','Kuphal Group','2019-07-26 03:54:38',NULL,'2019-07-26 03:54:38',''),(8,2,'Mrs. Cynthia Beahan','0','14379 Mohr Branch Apt. 768\nThompsonfort, MD 84947','888.587.0719','McClure PLC','2019-07-26 03:54:38',NULL,'2019-07-26 03:54:38',''),(9,1,'Josefa Marks','0','49740 Sonny Rue Apt. 164\nBartellmouth, ME 48153','(888) 209-8204','Breitenberg-Bergnaum','2019-07-26 03:54:38',NULL,'2019-07-26 03:54:38',''),(10,2,'Penelope Schimmel','0','55554 McClure Lights\nEloiseberg, AL 41629-9786','877.882.3680','Boyle and Sons','2019-07-26 03:54:38',NULL,'2019-07-26 03:54:38',''),(11,1,'Jasen Yundt V','0','1120 Armstrong Highway Suite 451\nNew Blanca, WV 11110','1-877-321-7704','Hintz Inc','2019-07-26 03:54:38',NULL,'2019-07-26 03:54:38',''),(12,2,'Norberto Lang','0','64235 Franecki Freeway Apt. 938\nStrackeland, SD 36073-6616','844-837-7803','Harris, Gibson and Wolf','2019-07-26 03:54:38',NULL,'2019-07-26 03:54:38',''),(13,1,'Sebastian Dach','0','5261 Laura Ford Suite 245\nNatshire, TN 75548','877-882-0020','Cummerata LLC','2019-07-26 03:54:38',NULL,'2019-07-26 03:54:38',''),(14,2,'Macey Wisozk','0','364 Larkin Shores\nBergnaumberg, NY 90072-3617','1-800-412-2750','Will, Hahn and Weissnat','2019-07-26 03:54:38',NULL,'2019-07-26 03:54:38',''),(15,1,'Ernestina Koepp Jr.','0','227 Mara Bypass Suite 224\nNorth Aracelibury, IA 67172','888.597.2962','White, Okuneva and Rodriguez','2019-07-26 03:54:38',NULL,'2019-07-26 03:54:38',''),(16,2,'Lina McGlynn','0','30991 Annette Street\nWest Hettie, FL 62458-6679','866-772-0024','Zemlak-Kerluke','2019-07-26 03:54:38',NULL,'2019-07-26 03:54:38',''),(17,1,'Rossie Prohaska','0','1439 Veronica Union Suite 998\nNorth Omariview, KS 47563-0444','866.266.4730','Stracke and Sons','2019-07-26 03:54:38',NULL,'2019-07-26 03:54:38',''),(18,2,'Larissa Witting','0','48018 Sincere Center\nWest Hilario, CA 61032','877.690.7380','Schultz, Koepp and Lubowitz','2019-07-26 03:54:38',NULL,'2019-07-26 03:54:38',''),(19,1,'Prof. Brannon Olson DVM','0','24120 Nona Corner\nThompsonbury, KY 85335','866-837-2971','Klocko-Beer','2019-07-26 03:54:38',NULL,'2019-07-26 03:54:38',''),(20,2,'Devonte Cartwright','0','11856 Dare Mountain\nRowlandmouth, IN 40179-8478','(800) 765-6657','Reynolds Ltd','2019-07-26 03:54:38',NULL,'2019-07-26 03:54:38',''),(21,1,'Prof. Darwin Reilly','0','2302 Schiller Motorway\nPort Luluside, NE 32901','877-495-5226','Schultz LLC','2019-07-26 03:54:38',NULL,'2019-07-26 03:54:38',''),(22,2,'Jewell Aufderhar','0','600 Kohler Bridge Suite 571\nGermanshire, LA 13932-2667','800.588.7332','Abernathy-Lehner','2019-07-26 03:54:38',NULL,'2019-07-26 03:54:38',''),(23,1,'Dr. Teagan Pouros','0','61720 Rowe Brooks Apt. 479\nLake Mervin, ME 38522','800.501.7520','Glover, Luettgen and Nicolas','2019-07-26 03:54:38',NULL,'2019-07-26 03:54:38',''),(24,2,'Mrs. Elisa Armstrong','0','833 Bartoletti Spur Suite 178\nLake Emilia, MN 05293-5356','866.632.0701','Beatty Group','2019-07-26 03:54:38',NULL,'2019-07-26 03:54:38',''),(25,1,'Talia Jones','0','44890 Klocko Ridge Suite 055\nSouth Marty, MT 72148','866-715-3013','Donnelly Ltd','2019-07-26 03:54:38',NULL,'2019-07-26 03:54:38',''),(26,2,'Kevin Buckridge','0','5243 Hansen Cape Suite 950\nNew Kirstin, CA 44724','888.263.8541','Wisoky Group','2019-07-26 03:54:38',NULL,'2019-07-26 03:54:38',''),(27,1,'Selena Will','0','325 Don Course Suite 244\nStrackefurt, MD 39722-4069','844.892.8368','Ritchie LLC','2019-07-26 03:54:38',NULL,'2019-07-26 03:54:38',''),(28,2,'Nakia Russel','0','97449 Dejuan Well Apt. 508\nJazminchester, MO 25157-3672','(844) 512-5351','Morar-Padberg','2019-07-26 03:54:38',NULL,'2019-07-26 03:54:38',''),(29,1,'Ottilie Reynolds','0','18483 Smith Canyon\nNorth Jazmin, AL 54308-8507','1-800-947-5329','Dare, Jerde and Kassulke','2019-07-26 03:54:38',NULL,'2019-07-26 03:54:38',''),(30,2,'Braden Koelpin','0','7285 Faustino Shoals Suite 907\nLake Brenna, ME 87113-5720','855-395-8005','Kirlin Ltd','2019-07-26 03:54:38',NULL,'2019-07-26 03:54:38',''),(33,1,'Agung Fajar Permana','0','Alam Sutera','081911094709','PT. Centro Links','2019-07-28 10:50:46',NULL,'2019-10-18 04:42:47','Admin Tester'),(34,1,'Aulia Rachmat Yusdion','0','Pasar Minggu','628128355022','testtest','2019-08-24 09:54:47',NULL,'2019-09-16 18:16:29','Admin Tester');
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment`
--

DROP TABLE IF EXISTS `payment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_number` int(11) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `bank_account` varchar(255) DEFAULT NULL,
  `number_account` varchar(255) NOT NULL,
  `amount_paid` int(11) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '1 = Active; 2 = Inactive',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(255) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment`
--

LOCK TABLES `payment` WRITE;
/*!40000 ALTER TABLE `payment` DISABLE KEYS */;
INSERT INTO `payment` VALUES (2,8022803,'Transfer','BNI','11111',30000,1,'2019-09-16 14:20:33','Admin Tester','2019-10-17 09:16:33',NULL),(3,8022803,'Tunai','','',7400,1,'2019-09-16 17:21:21','Admin Tester','2019-09-16 17:23:25',NULL),(4,4234204,'Transfer','BNI','11111',50000,1,'2019-09-16 18:17:18','Admin Tester','2019-10-17 09:16:37',NULL),(5,8156208,'Transfer','BNI','11111',664400,1,'2019-10-17 04:23:05','Admin Tester','2019-10-17 09:16:40',NULL),(6,6285235,'Tunai',NULL,'',77667,1,'2019-10-17 04:25:39','Admin Tester','2019-10-17 04:25:39',NULL),(7,3536217,'Transfer','BNI','11111',10000,1,'2019-10-17 06:08:34','Admin Tester','2019-10-17 09:16:43',NULL),(8,3536217,'Transfer','BNI','11111',100,1,'2019-10-17 06:49:41','Admin Tester','2019-10-17 09:16:45',NULL),(9,3536217,'Transfer','BNI','11111',100,1,'2019-10-17 08:07:43','Admin Tester','2019-10-17 09:16:50',NULL),(10,3536217,'Transfer','BNI','11111',100,1,'2019-10-17 08:17:24','Admin Tester','2019-10-17 09:16:52',NULL),(11,3536217,'Transfer','Mandiri','767868768',100,1,'2019-10-17 09:27:41','Admin Tester','2019-10-17 09:27:41',NULL),(12,3536217,'Transfer','BNI','123456789',204400,1,'2019-10-17 09:47:58','Admin Tester','2019-10-17 09:47:58',NULL);
/*!40000 ALTER TABLE `payment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `sales` int(11) NOT NULL DEFAULT '0',
  `branch_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '1 = Active; 2 = Inactive',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` VALUES (1,'CIS DE-20',7000,10,0,1,2,'1567798837_5d72b6351b5e5.jpg',1,'2019-08-27 08:50:26','Admin Tester','2019-09-06 12:40:37','Admin Tester'),(2,'Tutup Botol',10000,10,0,1,2,'1567967158_5d7547b65af53.jpg',1,'2019-09-08 18:25:59','Admin Tester','2019-09-08 18:25:59',NULL);
/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_category`
--

DROP TABLE IF EXISTS `product_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) NOT NULL,
  `description` longtext,
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '1 = Active; 2 = Inactive',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(255) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_category`
--

LOCK TABLES `product_category` WRITE;
/*!40000 ALTER TABLE `product_category` DISABLE KEYS */;
INSERT INTO `product_category` VALUES (1,'Tinta Printer','#',1,'2019-08-25 14:20:42','Admin Tester','2019-08-25 14:21:41','Admin Tester'),(2,'Tutup Botol','#',1,'2019-08-25 14:21:26','Admin Tester','2019-08-25 14:21:26',NULL);
/*!40000 ALTER TABLE `product_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transaction`
--

DROP TABLE IF EXISTS `transaction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_number` varchar(255) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `item_qty` int(11) NOT NULL,
  `total_discount` int(11) NOT NULL,
  `total_ppn` int(11) NOT NULL,
  `total_price` int(11) NOT NULL,
  `total_amount_paid` int(11) NOT NULL DEFAULT '0',
  `is_delivered` int(1) NOT NULL DEFAULT '2' COMMENT '1 = Delivered; 2 = Not Delivered',
  `time_of_payment` date DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '2' COMMENT '1 = Paid; 2 = Not Paid',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaction`
--

LOCK TABLES `transaction` WRITE;
/*!40000 ALTER TABLE `transaction` DISABLE KEYS */;
INSERT INTO `transaction` VALUES (3,'7195690',34,1,3,0,2700,29700,0,2,'2019-09-30',3,'2019-09-16 13:36:17','Admin Tester','2019-09-16 17:54:57','Admin Tester'),(4,'8022803',34,1,4,0,3400,37400,37400,1,'2019-09-30',1,'2019-09-16 14:11:52','Admin Tester','2019-09-16 17:54:55','Admin Tester'),(5,'4234204',34,1,6,0,4800,52800,50000,2,'2019-09-30',2,'2019-09-16 16:12:52','Admin Tester','2019-09-16 18:17:18','Admin Tester'),(6,'6285235',34,1,9,0,7500,82500,77667,2,'2019-09-30',2,'2019-09-16 17:48:52','Admin Tester','2019-10-17 04:25:39','Admin Tester'),(7,'4991306',34,1,5,0,4100,45100,0,1,'2019-10-04',2,'2019-09-16 18:16:29','Admin Tester','2019-10-01 10:51:43','Admin Tester'),(8,'3536217',1,1,2,0,1700,18700,214800,2,'2019-10-08',1,'2019-10-01 10:51:00','Admin Tester','2019-10-17 09:47:58','Admin Tester'),(9,'8156208',33,1,82,0,60400,664400,664400,2,'2019-11-14',1,'2019-10-14 08:47:37','Admin Tester','2019-10-17 04:23:05','Admin Tester'),(10,'4083259',33,1,9,0,7500,82500,0,2,'2019-11-18',2,'2019-10-18 04:42:12','Admin Tester','2019-10-18 04:42:12',NULL),(11,'12707810',33,1,8,0,6800,74800,0,2,'2019-11-18',2,'2019-10-18 04:42:47','Admin Tester','2019-10-18 04:42:47',NULL);
/*!40000 ALTER TABLE `transaction` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transaction_detail`
--

DROP TABLE IF EXISTS `transaction_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transaction_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `unit_price` int(11) NOT NULL,
  `ppn` int(11) NOT NULL,
  `total_price` int(11) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '1 = Valid; 2 = Cancel',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(255) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaction_detail`
--

LOCK TABLES `transaction_detail` WRITE;
/*!40000 ALTER TABLE `transaction_detail` DISABLE KEYS */;
INSERT INTO `transaction_detail` VALUES (1,3,1,1,7000,700,7700,1,'2019-09-16 13:36:17','Admin Tester','2019-09-16 13:36:17',NULL),(2,3,2,2,20000,2000,22000,1,'2019-09-16 13:36:17','Admin Tester','2019-09-16 13:36:17',NULL),(3,4,1,2,14000,1400,15400,1,'2019-09-16 14:11:52','Admin Tester','2019-09-16 14:11:52',NULL),(4,4,2,2,20000,2000,22000,1,'2019-09-16 14:11:52','Admin Tester','2019-09-16 14:11:52',NULL),(5,5,1,4,28000,2800,30800,1,'2019-09-16 16:12:52','Admin Tester','2019-09-16 16:12:52',NULL),(6,5,2,2,20000,2000,22000,1,'2019-09-16 16:12:52','Admin Tester','2019-09-16 16:12:52',NULL),(7,6,1,5,35000,3500,38500,1,'2019-09-16 17:48:52','Admin Tester','2019-09-16 17:48:52',NULL),(8,6,2,4,40000,4000,44000,1,'2019-09-16 17:48:52','Admin Tester','2019-09-16 17:48:52',NULL),(9,7,1,3,21000,2100,23100,1,'2019-09-16 18:16:29','Admin Tester','2019-09-16 18:16:29',NULL),(10,7,2,2,20000,2000,22000,1,'2019-09-16 18:16:29','Admin Tester','2019-09-16 18:16:29',NULL),(11,8,1,1,7000,700,7700,1,'2019-10-01 10:51:00','Admin Tester','2019-10-01 10:51:00',NULL),(12,8,2,1,10000,1000,11000,1,'2019-10-01 10:51:00','Admin Tester','2019-10-01 10:51:00',NULL),(13,9,1,72,504000,50400,554400,1,'2019-10-14 08:47:37','Admin Tester','2019-10-14 08:47:37',NULL),(14,9,2,10,100000,10000,110000,1,'2019-10-14 08:47:37','Admin Tester','2019-10-14 08:47:37',NULL),(15,10,1,5,35000,3500,38500,1,'2019-10-18 04:42:12','Admin Tester','2019-10-18 04:42:12',NULL),(16,10,2,4,40000,4000,44000,1,'2019-10-18 04:42:12','Admin Tester','2019-10-18 04:42:12',NULL),(17,11,1,4,28000,2800,30800,1,'2019-10-18 04:42:47','Admin Tester','2019-10-18 04:42:47',NULL),(18,11,2,4,40000,4000,44000,1,'2019-10-18 04:42:47','Admin Tester','2019-10-18 04:42:47',NULL);
/*!40000 ALTER TABLE `transaction_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` int(1) NOT NULL DEFAULT '1' COMMENT '1 = Admin; 2 = User;',
  `branch_id` int(11) DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (3,'Admin Tester','admin@gmail.com',NULL,'$2y$10$N917SMVrmnuDIPx1Xi4Xfef5Fnvk.661A9xvCEBA0xUIL95t0RIBC',NULL,1,0,1,'2019-08-25 11:56:21','','2019-09-07 20:34:37','Admin Tester'),(4,'Cashier Tester','cashier@gmail.com',NULL,'$2y$10$npJO73BDxsAPUcQLfWcNzu7fKky3PbL1ypAFehJHJPsWScaozAQce',NULL,2,1,1,'2019-08-25 11:56:50','','2019-10-17 11:50:31','Admin Tester'),(5,'Cashier Branch 2','cashier2@gmail.com',NULL,'$2y$10$GZW0cIS8EdFIX9tHxwJXJ.QqULjJ3xDU6kBVYelkbxAa7JLJ4kftm',NULL,2,2,2,'2019-09-07 20:12:01','Admin Tester','2019-09-13 10:39:19',NULL);
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

-- Dump completed on 2020-04-28  9:08:50
