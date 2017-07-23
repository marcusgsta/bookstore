-- MySQL dump 10.16  Distrib 10.1.16-MariaDB, for osx10.6 (i386)
--
-- Host: localhost    Database: oophp
-- ------------------------------------------------------
-- Server version	10.1.16-MariaDB

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
-- Table structure for table `Cart`
--

DROP TABLE IF EXISTS `Cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer` int(11) DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `customer` (`customer`),
  CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`customer`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Cart`
--

LOCK TABLES `Cart` WRITE;
/*!40000 ALTER TABLE `Cart` DISABLE KEYS */;
INSERT INTO `Cart` VALUES (19,1,NULL);
/*!40000 ALTER TABLE `Cart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `CartRow`
--

DROP TABLE IF EXISTS `CartRow`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CartRow` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cart` int(11) DEFAULT NULL,
  `product` int(11) DEFAULT NULL,
  `items` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cart` (`cart`),
  KEY `product` (`product`),
  CONSTRAINT `cartrow_ibfk_1` FOREIGN KEY (`cart`) REFERENCES `Cart` (`id`),
  CONSTRAINT `cartrow_ibfk_2` FOREIGN KEY (`product`) REFERENCES `Product` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CartRow`
--

LOCK TABLES `CartRow` WRITE;
/*!40000 ALTER TABLE `CartRow` DISABLE KEYS */;
INSERT INTO `CartRow` VALUES (49,19,16,1),(50,19,9,1);
/*!40000 ALTER TABLE `CartRow` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Content`
--

DROP TABLE IF EXISTS `Content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `path` char(120) COLLATE utf8_swedish_ci DEFAULT NULL,
  `slug` char(120) COLLATE utf8_swedish_ci DEFAULT NULL,
  `title` varchar(120) COLLATE utf8_swedish_ci DEFAULT NULL,
  `data` text COLLATE utf8_swedish_ci,
  `type` char(20) COLLATE utf8_swedish_ci DEFAULT NULL,
  `filter` varchar(80) COLLATE utf8_swedish_ci DEFAULT NULL,
  `published` datetime DEFAULT CURRENT_TIMESTAMP,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `path` (`path`),
  UNIQUE KEY `slug` (`slug`),
  KEY `index_title` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Content`
--

LOCK TABLES `Content` WRITE;
/*!40000 ALTER TABLE `Content` DISABLE KEYS */;
INSERT INTO `Content` VALUES (1,'hem','hem','Hem','Detta är min hemsida. Den är skriven i [url=http://en.wikipedia.org/wiki/BBCode]bbcode[/url] vilket innebär att man kan formattera texten till [b]bold[/b] och [i]kursiv stil[/i] samt hantera länkar.\r\n\r\nDessutom finns ett filter \'nl2br\' som lägger in <br>-element istället för \\n, det är smidigt, man kan skriva texten precis som man tänker sig att den skall visas, med radbrytningar.','page','bbcode','2017-05-26 00:00:00','2017-05-26 08:26:58',NULL,NULL),(2,'om','om','Om','## Om Böcker Online\r\nVi är ett antikvariat som säljer böcker online. Böckerna är av flera olika genrer: roman, novell, sakprosa, och reselitteratur. Vi levererar snabbt hem till din brevlåda eller närmaste postkontor.\r\n\r\n## Om mig\r\nJag som har byggt webbshopen heter Marcus Gustafsson, och detta är slutprojektet för kursen Objektorienterad PHP-programmering, för Blekinge Tekniska Högskola.\r\n\r\nDenna webshop byggdes med HTML, CSS, PHP, LESS och MySQL.\r\n','page','markdown','2017-05-26 00:00:00','2017-05-26 08:26:58','2017-05-26 00:00:00',NULL),(3,'blogpost-1','valkommen-till-min-blogg','Välkommen till min blogg!','Detta är en bloggpost.\r\n\r\nNär det finns länkar till andra webbplatser så kommer de länkarna att bli klickbara.\r\n\r\nhttp://dbwebb.se är ett exempel på en länk som blir klickbar.','post','clickable,nl2br','2017-05-26 00:00:00','2017-05-26 08:26:58',NULL,'2017-07-14 10:40:31'),(4,'blogpost-2','nu-har-sommaren-kommit','Nu har sommaren kommit','Detta är en bloggpost som berättar att sommaren har kommit, ett budskap som kräver en bloggpost.','post','nl2br','2017-05-26 00:00:00','2017-05-26 08:26:58',NULL,'2017-07-14 10:40:41'),(21,'footer','footer','Footer','© Böcker bokhandel 2017','block','clickable,nl2br','2017-07-06 13:28:06','2017-07-06 11:28:06',NULL,NULL),(22,'nya-bocker','nya-bocker','Nya böcker','Snälla grannar kom med flera lådor böcker igår, som vi håller på att packa upp. Det är främst kriminalromaner, och också ett urval engelska novellsamlingar. De kommer snart upp på webbsidan. ','post','markdown','2017-07-13 15:55:53','2017-07-13 13:55:53',NULL,NULL),(23,'reportage-i-tidskrift','reportage-i-tidskrift','Reportage i tidskrift','Vi har blivit intervjuade i tidskriften Böcker, nr 4.\r\n\r\nKöp och läs!\r\n ','post','markdown','2017-07-14 10:23:28','2017-07-14 08:23:28',NULL,NULL),(24,'egna-kundkonton','egna-kundkonton','Egna kundkonton','Hoppas alla har en skön sommar!\r\n\r\nNu går det att skapa ett eget kundkonto på vår webbsida, och det har därför blivit mycket lättare att köpa våra böcker. Allt du behöver göra är att skapa användarnamn och lösenord, och så är du igång!','post','markdown','2017-07-14 10:27:16','2017-07-14 08:27:16',NULL,NULL),(25,'tarjei-vesaas-debutantpris','tarjei-vesaas-debutantpris','Tarjei Vesaas debutantpris','Vi gratulerar Jan Kristoffer Dale som har blivit tilldelad Tarjei Vesaas debutantpris för sin novellsamling Arbeidsnever.','post','markdown','2017-07-14 10:30:01','2017-07-14 08:30:01',NULL,NULL),(26,'upptack-london','upptack-london','Upptäck London','Med Gyldendals fickguide om London har du allt du behöver för en spännande resa. Köp den hos oss idag!','post','markdown','2017-07-14 10:33:01','2017-07-14 08:33:01',NULL,NULL),(27,'tipsa-oss','tipsa-oss','Tipsa oss','Tipsa oss om bra böcker som vi borde sälja. Skriv till oss på exempel@exempelmail.com.\r\n\r\nVi ser fram emot dina tips.','post','markdown','2017-07-14 10:34:39','2017-07-14 08:34:39',NULL,NULL),(28,'bokbussen','bokbussen','Bokbussen','Vi samarbetar med bokbussen, och lånar ut många av våra böcker hos dem.\r\n\r\nSe efter Böcker Onlines hylla på bokbussen.\r\n\r\nVälkommen!','post','markdown','2017-07-14 10:37:21','2017-07-14 08:37:21',NULL,NULL),(29,NULL,NULL,'Footer',NULL,NULL,NULL,'2017-07-14 10:46:49','2017-07-14 08:46:49',NULL,'2017-07-14 10:48:47');
/*!40000 ALTER TABLE `Content` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `InvenShelf`
--

DROP TABLE IF EXISTS `InvenShelf`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `InvenShelf` (
  `shelf` char(6) NOT NULL,
  `description` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`shelf`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `InvenShelf`
--

LOCK TABLES `InvenShelf` WRITE;
/*!40000 ALTER TABLE `InvenShelf` DISABLE KEYS */;
INSERT INTO `InvenShelf` VALUES ('AAA101','House A, aisle A, part A, shelf 101'),('AAA102','House A, aisle A, part A, shelf 102');
/*!40000 ALTER TABLE `InvenShelf` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Inventory`
--

DROP TABLE IF EXISTS `Inventory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `prod_id` int(11) DEFAULT NULL,
  `shelf_id` char(6) DEFAULT NULL,
  `items` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `prod_id` (`prod_id`),
  KEY `shelf_id` (`shelf_id`),
  KEY `index_items` (`items`),
  CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`prod_id`) REFERENCES `Product` (`id`),
  CONSTRAINT `inventory_ibfk_2` FOREIGN KEY (`shelf_id`) REFERENCES `InvenShelf` (`shelf`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Inventory`
--

LOCK TABLES `Inventory` WRITE;
/*!40000 ALTER TABLE `Inventory` DISABLE KEYS */;
INSERT INTO `Inventory` VALUES (11,8,NULL,6),(12,9,NULL,8),(13,10,NULL,6),(14,11,NULL,15),(15,12,NULL,12),(16,13,NULL,5),(17,14,NULL,3),(18,15,NULL,7),(19,16,NULL,13),(20,17,NULL,11);
/*!40000 ALTER TABLE `Inventory` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER LogInventoryUpdate
AFTER UPDATE
ON Inventory
	FOR EACH ROW
BEGIN
	IF NEW.items < 5 THEN
		INSERT INTO InventoryLog (`what`, `prod_id`, `old_amount`, `new_amount`)
        VALUES ("trigger", NEW.prod_id, OLD.items, NEW.items);
END IF;
	END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `InventoryLog`
--

DROP TABLE IF EXISTS `InventoryLog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `InventoryLog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `what` varchar(20) DEFAULT NULL,
  `when` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `prod_id` int(11) DEFAULT NULL,
  `old_amount` decimal(10,0) DEFAULT NULL,
  `new_amount` decimal(10,0) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `InventoryLog`
--

LOCK TABLES `InventoryLog` WRITE;
/*!40000 ALTER TABLE `InventoryLog` DISABLE KEYS */;
INSERT INTO `InventoryLog` VALUES (1,'trigger','2017-07-13 12:11:02',10,0,0),(2,'trigger','2017-07-13 12:29:33',14,0,3);
/*!40000 ALTER TABLE `InventoryLog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Invoice`
--

DROP TABLE IF EXISTS `Invoice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Invoice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order` int(11) DEFAULT NULL,
  `customer` int(11) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `order` (`order`),
  KEY `invoice_ibfk_2` (`customer`),
  CONSTRAINT `invoice_ibfk_1` FOREIGN KEY (`order`) REFERENCES `Order` (`id`),
  CONSTRAINT `invoice_ibfk_2` FOREIGN KEY (`customer`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Invoice`
--

LOCK TABLES `Invoice` WRITE;
/*!40000 ALTER TABLE `Invoice` DISABLE KEYS */;
/*!40000 ALTER TABLE `Invoice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `InvoiceRow`
--

DROP TABLE IF EXISTS `InvoiceRow`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `InvoiceRow` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice` int(11) DEFAULT NULL,
  `product` int(11) DEFAULT NULL,
  `items` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invoice` (`invoice`),
  KEY `product` (`product`),
  CONSTRAINT `invoicerow_ibfk_1` FOREIGN KEY (`invoice`) REFERENCES `Invoice` (`id`),
  CONSTRAINT `invoicerow_ibfk_2` FOREIGN KEY (`product`) REFERENCES `Product` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `InvoiceRow`
--

LOCK TABLES `InvoiceRow` WRITE;
/*!40000 ALTER TABLE `InvoiceRow` DISABLE KEYS */;
/*!40000 ALTER TABLE `InvoiceRow` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Offer`
--

DROP TABLE IF EXISTS `Offer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Offer` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `product` int(4) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `discount` decimal(10,0) DEFAULT NULL,
  `new_price` decimal(10,0) DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product` (`product`),
  CONSTRAINT `offer_ibfk_1` FOREIGN KEY (`product`) REFERENCES `Product` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Offer`
--

LOCK TABLES `Offer` WRITE;
/*!40000 ALTER TABLE `Offer` DISABLE KEYS */;
INSERT INTO `Offer` VALUES (9,'Web Usability',9,'Endast denna vecka!',50,NULL,'2017-07-17 18:16:28'),(10,'Hesteskamferingene 2004',8,'hej',5,NULL,'2017-07-20 08:59:21'),(11,'Mio, min Mio',13,'Endast denna vecka!',20,144,NULL);
/*!40000 ALTER TABLE `Offer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Order`
--

DROP TABLE IF EXISTS `Order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer` int(11) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  `delivery` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `customer` (`customer`),
  CONSTRAINT `order_ibfk_1` FOREIGN KEY (`customer`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Order`
--

LOCK TABLES `Order` WRITE;
/*!40000 ALTER TABLE `Order` DISABLE KEYS */;
INSERT INTO `Order` VALUES (23,1,'2017-07-13 17:32:44',NULL,NULL,NULL),(24,1,'2017-07-17 16:06:32',NULL,NULL,NULL),(25,1,'2017-07-17 16:06:47',NULL,NULL,NULL),(26,1,'2017-07-17 16:06:56',NULL,NULL,NULL),(27,1,'2017-07-17 16:07:40',NULL,NULL,NULL),(28,1,'2017-07-17 16:08:27',NULL,NULL,NULL),(29,1,'2017-07-17 16:17:37',NULL,NULL,NULL),(30,1,'2017-07-17 16:17:53',NULL,NULL,NULL),(31,1,'2017-07-23 11:50:30',NULL,NULL,NULL),(32,1,'2017-07-23 12:41:21',NULL,NULL,NULL);
/*!40000 ALTER TABLE `Order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `OrderRow`
--

DROP TABLE IF EXISTS `OrderRow`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `OrderRow` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order` int(11) DEFAULT NULL,
  `product` int(11) DEFAULT NULL,
  `items` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order` (`order`),
  KEY `product` (`product`),
  CONSTRAINT `orderrow_ibfk_1` FOREIGN KEY (`order`) REFERENCES `Order` (`id`),
  CONSTRAINT `orderrow_ibfk_2` FOREIGN KEY (`product`) REFERENCES `Product` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `OrderRow`
--

LOCK TABLES `OrderRow` WRITE;
/*!40000 ALTER TABLE `OrderRow` DISABLE KEYS */;
INSERT INTO `OrderRow` VALUES (56,23,17,1),(57,23,15,1),(58,23,10,1),(59,24,17,1),(60,24,15,1),(61,24,10,1),(62,25,17,1),(63,25,15,1),(64,25,10,1),(65,26,10,1),(66,27,9,1),(67,28,8,1),(68,29,8,2),(69,30,8,1),(70,31,16,1),(71,32,16,1),(72,32,9,1);
/*!40000 ALTER TABLE `OrderRow` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Prod2Cat`
--

DROP TABLE IF EXISTS `Prod2Cat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Prod2Cat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `prod_id` int(11) DEFAULT NULL,
  `cat_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `prod_id` (`prod_id`),
  KEY `cat_id` (`cat_id`),
  CONSTRAINT `prod2cat_ibfk_1` FOREIGN KEY (`prod_id`) REFERENCES `Product` (`id`),
  CONSTRAINT `prod2cat_ibfk_2` FOREIGN KEY (`cat_id`) REFERENCES `ProdCategory` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Prod2Cat`
--

LOCK TABLES `Prod2Cat` WRITE;
/*!40000 ALTER TABLE `Prod2Cat` DISABLE KEYS */;
INSERT INTO `Prod2Cat` VALUES (18,9,7),(25,8,9),(26,8,14),(31,10,15),(32,10,7),(33,11,7),(34,12,9),(35,12,14),(36,13,16),(37,14,7),(38,15,8),(39,15,14),(45,17,17),(46,17,7),(47,16,9),(48,16,14);
/*!40000 ALTER TABLE `Prod2Cat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ProdCategory`
--

DROP TABLE IF EXISTS `ProdCategory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ProdCategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ProdCategory`
--

LOCK TABLES `ProdCategory` WRITE;
/*!40000 ALTER TABLE `ProdCategory` DISABLE KEYS */;
INSERT INTO `ProdCategory` VALUES (7,'sakprosa'),(8,'noveller'),(9,'romaner'),(11,'kriminalromaner'),(12,'webbutveckling'),(14,'skönlitteratur'),(15,'reportage'),(16,'barnböcker'),(17,'reseguider');
/*!40000 ALTER TABLE `ProdCategory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Product`
--

DROP TABLE IF EXISTS `Product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `image` varchar(20) DEFAULT NULL,
  `recommended` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `index_description` (`description`(767))
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Product`
--

LOCK TABLES `Product` WRITE;
/*!40000 ALTER TABLE `Product` DISABLE KEYS */;
INSERT INTO `Product` VALUES (8,'Hesteskamferingene 2004','I 2004 blev der registreret 38 tilfælde af alvorlige skamferinger på heste i Danmark. Langt størstedelen af tilfældene var lokaliseret i Jylland. 10 heste døde af deres kvæstelser. Politiet oprettede en særlig efterforskningsenhed med hovedsæde i Århus. Efterforskningsheden fik navnet Tarok04. 80 personer blev afhørt over en periode på ni måneder. Der blev rejst én sigtelse.\r\n\r\nPå samme tid går den midaldrende Svend ture med hunden Betsy og drømmer om naboen Mona. For når alt kommer til alt, har han været en frustreret funktionær og ægtemand i de seneste tredive år. Men der kommer en ny dagsorden i hans liv, da kollegaen Niels spørger Svend, om han ikke vil passe hans heste, mens han er i Paris med sin nye kæreste.\r\n\r\nHesteskamferingerne 2004 er en roman om, hvor grænseoverskridende mennesker kan være over for hinanden, hvilken beruselse der kan ligge i at få en fælles fjende, og hvad man kan finde på at gøre i den gode sags tjeneste.\r\n\r\nMorten Holm Andersen debuterer med denne roman.',299.00,'hesteskam.jpg',1),(9,'Web Usability','DESIGN WITH THE USER IN MIND\r\nA Web site design that does not consider its user is a Web site that is destined to be a disappointing experience for the user. This new book by Jonathan Lazar provides readers with the concepts and tools needed to develop Web sites that maximize the user experience. It takes readers through the entire User-Centered Development Life Cycle, demonstrating practical skills and techniques that will help them for years to come.',59.00,'web_usability.png',1),(10,'Historien om Leila K','Historien om Leila K är på en och samma gång ett inträngande och kärleksfullt porträtt av en av Sveriges mest färgstarka och omtalade artister och ett undersökande reportage från Stockholms undre värld. Boken utforskar och slår hål på myter kring huvudpersonen och undersöker vad som är sant bakom allt som påståtts och sagts om Leila K.',89.00,'leila.jpg',NULL),(11,'Vad är konst','Konst är det som gör oss till människor, menar Ernst Billgren. I boken \"Vad är konst och 100 andra jätteviktiga frågor\" vänder han ut och in på konstbegreppet och leker med dess terminologi.',49.00,'vad_ar_konst.png',NULL),(12,'Indrivaren','Ett grymt drama om svek och skuld. Ronald är en enstöring som gör upp egna regler för vad som är rätt och fel och utdömer hårda straff för den som bryter mot dem. Men när han börjar driva in skulder från den egna familjen är det inte längre så enkelt.',89.00,'indrivaren.jpg',NULL),(13,'Mio, min Mio','Var det någon som hörde på radion den femtonde oktober förra året? Var det någon som hörde att de frågade efter en försvunnen pojke? Så här sa de: \"Polisen i Stockholm efterlyser 9-årige Bo Vilhelm Olsson som sedan i förrgår kväll varit försvunnen från sitt hem, Upplandsgatan 13. Bo Vilhelm Olsson har ljust hår och blå ögon och var vid försvinnandet klädd i korta bruna byxor, grå stickad tröja och liten röd luva. Meddelanden om den försvunne lämnas till polisens ordonnansavdelning.\" Ja, så sa de. Men det kom aldrig några meddelanden om Bo Vilhelm Olsson. Han var borta. Ingen fick någonsin veta vart han tog vägen ? Så börjar sagan om Mio. ',180.00,'mio_min_mio.jpg',NULL),(14,'Vår tids rädsla för allvar','»Boktiteln formulerar en mentalitet som genomsyrade det svenska samhället vid den tid då föredrag och bok blev till. Andra titlar hade också passat, t.ex. Fientlighet mot klart tänkande, Godtyckets herravälde eller Kitschens segertåg, formuleringar som inte hade kommit till utan kännedom om texter av tänkare som sociologen Loïc Wacquant, moralfilosofen Martin Buber och författaren Milan Kundera. Alla har de med enastående pregnans satt ord på och tydliggjort mänskliga beteenden som driver världen i elände. Föreliggande nyutgåva har fått behålla titeln Vår tids rädsla för allvar. Den äger sorgligt nog fortfarande sin giltighet. De förödande värdenormer och beteenden som beskrivs i boken har på intet sätt förändrats. Skärrade står vi återigen inför konsekvenserna av en ansvarslöshet, obildning och vulgaritet som trotsar all beskrivning. Fientligheten mot klart tänkande, godtycket och kitschen firar triumfer.«\r\n\r\nUr Roy Anderssons förord till den nya utgåvan.\r\n',150.00,'var_tids_radsla.png',NULL),(15,'Arbeidsnever','Tildelt Tarjei Vesaas\' debutantpris 2016! \r\n\r\nNovellene i Arbeidsnever handler om de som har falt utenfor; de som ikke fiksa skolen, og droppa ut. De ufaglærte. De som aldri flytta hjemmefra. De som aldri fant noen å slå seg ned sammen med, og de som har blitt forlatt.  Vi møter Trygve som snart skal bli far, og som har en usikker og tung lagerjobb, Frank som bor hjemme med sin mor og i det siste har fått et godt øye til den nye dama på kroa. I tillegg møter vi tre gamle venner som drar på hyttetur bare for å havne i ei grøft, og ungkaren Andrè som må ta en kikk på sitt eget liv.\r\n\r\nNovellene utspiller seg i samme miljø, og handler om vanlige menneskers liv og arbeid. Alle sliter de med sitt: usikkerheten, kjærligheten, økonomien og seg sjøl. Noen er fanget i situasjoner de ikke kommer seg ut av, mens andre må ta et valg om hvem de vil være, og hvordan de vil leve.',170.00,'arbeidsnever.jpg',NULL),(16,'Svinalängorna','Leena har två bästa vänner. Åse är nästan den enda hon känner som inte har en pappa som super, men hennes mamma brukar bli full så det jämnar ut sig. Riittas pappa är full nästan varje dag. \r\n    Leena och hennes finska föräldrar har tillsammans med andra invandrarfamiljer och låginkomsttagare flyttat in i ett nybyggt bostadsområde i 60-talets Ystad. För Leenas familj är den nya lägenheten höjden av lyx: tre rum, balkong, kakel och parkett. Av kommunen får kvarteret snart namnet Svinalängorna. \r\n    De brandgula trevåningshusen med lekplats på gården och havet runt knuten blir en samlande plats för Susanna Alakoskis myllrande och livfulla roman. Det är Leena själv som berättar, klarögt och fartfyllt, om sig själv, sina föräldrar och grannar och alla de dråpliga och drastiska händelser som utspelar sig runt henne. Ibland sitter hon i trapphuset, under trappen, och följer allt som händer. Eller gömmer sig under bordet och lyssnar på mammas och tant Helmis samtal om mens, om sina arbeten',130.00,'svinalangorna.jpg',NULL),(17,'London - lommeguide og kart','Omtale fra Den Norske Bokdatabasen\r\n\r\nLommeguiden inneholder en oversikt over de viktigste severdighetene, hvor du kan spise, drikke og shoppe i hvert område, samt et detaljert utbrettkart.\r\n\r\nOmtale fra forlaget\r\n\r\nReiseguideserie i lommerformat Alt du trenger for en perfekt dag! Gyldendals lommeguider . en guide og detaljert utbrettkart i lommeformat. Hver guide er på 96 sider og gir informasjon om severdigheter, butikker, restauranter og barer i byen du besøker.',99.00,'london.jpg',NULL);
/*!40000 ALTER TABLE `Product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(254) DEFAULT NULL,
  `pass` varchar(100) DEFAULT NULL,
  `gravatar` varchar(100) DEFAULT NULL,
  `role` varchar(2) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','marcusgu@hotmail.com','$2y$10$YDf2FG3riX9TytT.lKNXJu142M3l0oaZu1oO.A7MMZ1VAS74YIqtS','http://s.gravatar.com/avatar/63a61804b34024a097b950820e0dc955?s=80','1'),(2,'doe','example@email.com','$2y$10$FHCgtuatoNeMfXsv7mXhh.bF1aFbM8p/KrpKRvY3shB0U1oI04KIu','doe','0');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `vblog`
--

DROP TABLE IF EXISTS `vblog`;
/*!50001 DROP VIEW IF EXISTS `vblog`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vblog` (
  `path` tinyint NOT NULL,
  `slug` tinyint NOT NULL,
  `title` tinyint NOT NULL,
  `data` tinyint NOT NULL,
  `type` tinyint NOT NULL,
  `filter` tinyint NOT NULL,
  `published` tinyint NOT NULL,
  `created` tinyint NOT NULL,
  `updated` tinyint NOT NULL,
  `deleted` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vcartdetails`
--

DROP TABLE IF EXISTS `vcartdetails`;
/*!50001 DROP VIEW IF EXISTS `vcartdetails`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vcartdetails` (
  `CartNumber` tinyint NOT NULL,
  `CartRow` tinyint NOT NULL,
  `Description` tinyint NOT NULL,
  `Items` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vcartrows`
--

DROP TABLE IF EXISTS `vcartrows`;
/*!50001 DROP VIEW IF EXISTS `vcartrows`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vcartrows` (
  `id` tinyint NOT NULL,
  `cart` tinyint NOT NULL,
  `product` tinyint NOT NULL,
  `items` tinyint NOT NULL,
  `name` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vinventory`
--

DROP TABLE IF EXISTS `vinventory`;
/*!50001 DROP VIEW IF EXISTS `vinventory`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vinventory` (
  `shelf` tinyint NOT NULL,
  `location` tinyint NOT NULL,
  `items` tinyint NOT NULL,
  `name` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vinventorylog`
--

DROP TABLE IF EXISTS `vinventorylog`;
/*!50001 DROP VIEW IF EXISTS `vinventorylog`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vinventorylog` (
  `name` tinyint NOT NULL,
  `prod_id` tinyint NOT NULL,
  `when` tinyint NOT NULL,
  `old_amount` tinyint NOT NULL,
  `new_amount` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vorderdetails`
--

DROP TABLE IF EXISTS `vorderdetails`;
/*!50001 DROP VIEW IF EXISTS `vorderdetails`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vorderdetails` (
  `OrderNumber` tinyint NOT NULL,
  `OrderRow` tinyint NOT NULL,
  `Description` tinyint NOT NULL,
  `Items` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vplocklist`
--

DROP TABLE IF EXISTS `vplocklist`;
/*!50001 DROP VIEW IF EXISTS `vplocklist`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vplocklist` (
  `OrderNumber` tinyint NOT NULL,
  `OrderRow` tinyint NOT NULL,
  `Description` tinyint NOT NULL,
  `Items` tinyint NOT NULL,
  `Shelf` tinyint NOT NULL,
  `ShelfLocation` tinyint NOT NULL,
  `ItemsAvailable` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vproduct`
--

DROP TABLE IF EXISTS `vproduct`;
/*!50001 DROP VIEW IF EXISTS `vproduct`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vproduct` (
  `id` tinyint NOT NULL,
  `name` tinyint NOT NULL,
  `description` tinyint NOT NULL,
  `image` tinyint NOT NULL,
  `recommended` tinyint NOT NULL,
  `category` tinyint NOT NULL,
  `price` tinyint NOT NULL,
  `new_price` tinyint NOT NULL,
  `items` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Final view structure for view `vblog`
--

/*!50001 DROP TABLE IF EXISTS `vblog`*/;
/*!50001 DROP VIEW IF EXISTS `vblog`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vblog` AS select `C`.`path` AS `path`,`C`.`slug` AS `slug`,`C`.`title` AS `title`,`C`.`data` AS `data`,`C`.`type` AS `type`,`C`.`filter` AS `filter`,`C`.`published` AS `published`,`C`.`created` AS `created`,`C`.`updated` AS `updated`,`C`.`deleted` AS `deleted` from `content` `C` where (`C`.`type` = 'post') order by `C`.`published` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vcartdetails`
--

/*!50001 DROP TABLE IF EXISTS `vcartdetails`*/;
/*!50001 DROP VIEW IF EXISTS `vcartdetails`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vcartdetails` AS select `C`.`id` AS `CartNumber`,`R`.`id` AS `CartRow`,`P`.`description` AS `Description`,`R`.`items` AS `Items` from ((`cart` `C` left join `cartrow` `R` on((`C`.`id` = `R`.`cart`))) left join `product` `P` on((`R`.`product` = `P`.`id`))) order by `R`.`id` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vcartrows`
--

/*!50001 DROP TABLE IF EXISTS `vcartrows`*/;
/*!50001 DROP VIEW IF EXISTS `vcartrows`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vcartrows` AS select `CR`.`id` AS `id`,`CR`.`cart` AS `cart`,`CR`.`product` AS `product`,`CR`.`items` AS `items`,`P`.`name` AS `name` from ((`cartrow` `CR` left join `product` `P` on((`CR`.`product` = `P`.`id`))) left join `inventory` `I` on((`P`.`id` = `I`.`prod_id`))) order by `CR`.`cart` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vinventory`
--

/*!50001 DROP TABLE IF EXISTS `vinventory`*/;
/*!50001 DROP VIEW IF EXISTS `vinventory`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vinventory` AS select `S`.`shelf` AS `shelf`,`S`.`description` AS `location`,`I`.`items` AS `items`,`P`.`name` AS `name` from ((`inventory` `I` join `invenshelf` `S` on((`I`.`shelf_id` = `S`.`shelf`))) join `product` `P` on((`P`.`id` = `I`.`prod_id`))) order by `S`.`shelf` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vinventorylog`
--

/*!50001 DROP TABLE IF EXISTS `vinventorylog`*/;
/*!50001 DROP VIEW IF EXISTS `vinventorylog`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vinventorylog` AS select `product`.`name` AS `name`,`inventorylog`.`prod_id` AS `prod_id`,`inventorylog`.`when` AS `when`,`inventorylog`.`old_amount` AS `old_amount`,`inventorylog`.`new_amount` AS `new_amount` from (`inventorylog` join `product` on((`inventorylog`.`prod_id` = `product`.`id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vorderdetails`
--

/*!50001 DROP TABLE IF EXISTS `vorderdetails`*/;
/*!50001 DROP VIEW IF EXISTS `vorderdetails`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vorderdetails` AS select `O`.`id` AS `OrderNumber`,`R`.`id` AS `OrderRow`,`P`.`description` AS `Description`,`R`.`items` AS `Items` from ((`order` `O` join `orderrow` `R` on((`O`.`id` = `R`.`order`))) join `product` `P` on((`R`.`product` = `P`.`id`))) order by `R`.`id` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vplocklist`
--

/*!50001 DROP TABLE IF EXISTS `vplocklist`*/;
/*!50001 DROP VIEW IF EXISTS `vplocklist`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vplocklist` AS select `O`.`id` AS `OrderNumber`,`R`.`id` AS `OrderRow`,`P`.`description` AS `Description`,`R`.`items` AS `Items`,`S`.`shelf` AS `Shelf`,`S`.`description` AS `ShelfLocation`,`I`.`items` AS `ItemsAvailable` from ((((`order` `O` join `orderrow` `R` on((`O`.`id` = `R`.`order`))) join `product` `P` on((`R`.`product` = `P`.`id`))) join `inventory` `I` on((`P`.`id` = `I`.`prod_id`))) join `invenshelf` `S` on((`I`.`shelf_id` = `S`.`shelf`))) order by `R`.`id` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vproduct`
--

/*!50001 DROP TABLE IF EXISTS `vproduct`*/;
/*!50001 DROP VIEW IF EXISTS `vproduct`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vproduct` AS select `P`.`id` AS `id`,`P`.`name` AS `name`,`P`.`description` AS `description`,`P`.`image` AS `image`,`P`.`recommended` AS `recommended`,group_concat(distinct `PC`.`category` separator ',') AS `category`,`P`.`price` AS `price`,`offer`.`new_price` AS `new_price`,`I`.`items` AS `items` from ((((`product` `P` left join `prod2cat` `P2C` on((`P`.`id` = `P2C`.`prod_id`))) left join `prodcategory` `PC` on((`PC`.`id` = `P2C`.`cat_id`))) left join `offer` on((`P`.`id` = `offer`.`product`))) left join `inventory` `I` on((`P`.`id` = `I`.`prod_id`))) group by `P`.`id` order by `P`.`name` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-07-23 15:02:28
