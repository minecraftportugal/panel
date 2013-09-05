-- MySQL dump 10.13  Distrib 5.5.31, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: minecraft_auth
-- ------------------------------------------------------
-- Server version	5.5.31-0+wheezy1

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
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `playername` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `pwtype` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `email` varchar(100) DEFAULT NULL,
  `registerdate` datetime DEFAULT NULL,
  `registerip` char(45) DEFAULT NULL,
  `lastlogindate` datetime DEFAULT NULL,
  `lastloginip` char(45) DEFAULT NULL,
  `active` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `admin` int(11) DEFAULT '0',
  `ircnickname` varchar(32) DEFAULT NULL,
  `ircpassword` varchar(255) DEFAULT NULL,
  `ircauto` tinyint(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=356 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accounts`
--

LOCK TABLES `accounts` WRITE;
/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;
INSERT INTO `accounts` VALUES (351,'wikipeixoto','b64c648c4708307cd32685e1113011819ed9947effa0507b6250c9b132507c5a33c6a20e3e876bfa3492db08ee7364b1251d3b28231bfbfc65eb29af343578b7f19a2f49ad7d',0,'hugo.peixoto@gmail.com','2013-09-05 21:34:11','192.168.1.82',NULL,NULL,1,0,NULL,NULL,0),(352,'Deevian','b62348970d375ddeff5d75ae87c23f5e7c083b61d55f7538304a6d6fb3fa42cc77cc650b3019f99ba0d148de811842fe0513db0d22573ee1edc4be226f186c9fb1bb820a74b5',0,'jpmcabreu@gmail.com','2013-09-05 21:34:31','192.168.1.82',NULL,NULL,1,0,NULL,NULL,0),(353,'ticklemynausea','d05fd2ec6705c4d254772c66998c445c05dcd91dc67d2baef9b00dacb500c4e4e36916ff0ee508663b0288e62b10e231005b3e883d6f8005c7e8c8dcc128c3b82ee08789fd64',0,'emailoftheyear@gmail.com','2013-09-05 21:34:49','192.168.1.82',NULL,NULL,1,0,NULL,NULL,0),(354,'punsha','e03e37167ae96ed5c87ab448787ef5a770cb3c26cb892399203e857ddbef5e78f2885177699135929a567dee3d3211ae57e928a7d36a45447d69fcd73f6341310cc13a1464bc',0,'spam@pedrocoelho.pt','2013-09-05 21:35:32','192.168.1.82',NULL,NULL,1,0,NULL,NULL,0),(355,'dubaiss','a8ed1e113ff0c8bbb0330211e9a556d24d5d674a1c6366b73a97cd5c6ebe6572511361ee021c8591cb9f074d67eb2ca34b46b8f7c46cce93b0168fd4f860ed409f914c813310',0,'spam.me.slowly@gmail.com','2013-09-05 21:35:43','192.168.1.82',NULL,NULL,1,0,NULL,NULL,0),(350,'administrator','e32c8a1375f0262a6bed408aa368293fc5b368878abbac9bd88c1b8fa3439b2aa4abd34637713c57cebd26b704b1ca8e88c467ce93b6a442a5844e0389028756a4011ef57dc9',0,'mail@minecraftia.pt','2013-09-05 21:12:09','192.168.1.82',NULL,NULL,1,1,'testeeee','',0);
/*!40000 ALTER TABLE `accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `locations`
--

DROP TABLE IF EXISTS `locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `locations` (
  `uid` varchar(36) NOT NULL,
  `x` double NOT NULL,
  `y` double NOT NULL,
  `z` double NOT NULL,
  `yaw` float NOT NULL,
  `pitch` float NOT NULL,
  `global` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `locations`
--

LOCK TABLES `locations` WRITE;
/*!40000 ALTER TABLE `locations` DISABLE KEYS */;
/*!40000 ALTER TABLE `locations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lockouts`
--

DROP TABLE IF EXISTS `lockouts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lockouts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ipaddress` varchar(45) NOT NULL,
  `playername` varchar(255) NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lockouts`
--

LOCK TABLES `lockouts` WRITE;
/*!40000 ALTER TABLE `lockouts` DISABLE KEYS */;
/*!40000 ALTER TABLE `lockouts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `title` text,
  `body` text,
  `created_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news`
--

LOCK TABLES `news` WRITE;
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
INSERT INTO `news` VALUES (3,'2013-02-28 13:19:12','News Section','This post inaugurates the news session. News about server updates and changes will be posted here.',6),(4,'2013-04-05 11:20:30','New World!','In keeping up with our good tradition of ditching the map whenever there\'s a major craftbukkit update, Minecraftia v4 has just been inaugurated.',6),(5,'2013-05-15 11:20:52','Multiverse Portal','Now a Portal on top of the spawn tower will warp you between Minecraftia v2 and Minecraftia v4. Minecraftia v1 remains lost and Minecraftia v3 has nothing of interest in it.',6),(6,'2013-05-24 11:21:39','Website Login','Now logging in to this website will also log you win in to the Minecraft server. Refreshing the website will also refresh your minecraft session.',6),(7,'2013-04-26 11:22:21','Webchat','Now the webchat client takes the form of a resizable and moveable overlaying widget. Yay!',6),(8,'2013-05-28 20:06:33','RSS feed!','The news section now has an RSS feed available at <a href=\"https://minecraft.ticklemynausea.net/rss\" target=\"_blank\">minecraft.ticklemynausea.net/rss</a>. Stay tuned!',6);
/*!40000 ALTER TABLE `news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `playerdata`
--

DROP TABLE IF EXISTS `playerdata`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `playerdata` (
  `playername` varchar(255) NOT NULL,
  `items` text,
  `armor` text,
  `location` text,
  `potioneffects` text,
  `fireticks` smallint(6) NOT NULL DEFAULT '0',
  `remainingair` smallint(6) NOT NULL DEFAULT '300',
  PRIMARY KEY (`playername`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `playerdata`
--

LOCK TABLES `playerdata` WRITE;
/*!40000 ALTER TABLE `playerdata` DISABLE KEYS */;
/*!40000 ALTER TABLE `playerdata` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `accountid` int(10) unsigned NOT NULL,
  `ipaddress` char(45) NOT NULL,
  `logintime` datetime NOT NULL,
  PRIMARY KEY (`accountid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES (350,'','2013-09-05 21:40:43'),(340,'','2013-08-30 23:21:31');
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-09-05 21:53:18
