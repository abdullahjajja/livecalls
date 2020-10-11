-- MySQL dump 10.13  Distrib 5.5.31, for Linux (x86_64)
--
-- Host: localhost    Database: livecalls
-- ------------------------------------------------------
-- Server version	5.5.31-log

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
-- Table structure for table `TestNumbers`
--

DROP TABLE IF EXISTS `TestNumbers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TestNumbers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `NumberRange` varchar(255) DEFAULT NULL,
  `TestNumber` varchar(255) DEFAULT NULL,
  `Country` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `access_network`
--

DROP TABLE IF EXISTS `access_network`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `access_network` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `country` varchar(200) CHARACTER SET latin1 DEFAULT NULL,
  `number` varchar(200) CHARACTER SET latin1 DEFAULT NULL,
  `network` varchar(200) CHARACTER SET latin1 DEFAULT NULL,
  `operator` varchar(200) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=351037 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `account_user_invoices`
--

DROP TABLE IF EXISTS `account_user_invoices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `account_user_invoices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `beneficiary_name` varchar(100) DEFAULT NULL,
  `beneficiary_address` varchar(300) DEFAULT NULL,
  `bank_name` varchar(200) DEFAULT NULL,
  `bank_address` varchar(300) DEFAULT NULL,
  `swift_code` char(50) DEFAULT NULL,
  `iban` char(50) DEFAULT NULL,
  `account_number` char(50) DEFAULT NULL,
  `currency_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `city_name` varchar(255) DEFAULT NULL,
  `state_name` varchar(255) DEFAULT NULL,
  `country_name` varchar(255) DEFAULT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `accounts_users`
--

DROP TABLE IF EXISTS `accounts_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `beneficiary_name` varchar(100) NOT NULL,
  `country_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `beneficiary_address` varchar(300) DEFAULT 'Your''s Adress',
  `bank_name` varchar(200) NOT NULL DEFAULT 'Your''s Bank Name',
  `bank_address` varchar(300) DEFAULT 'Yours Bank Address',
  `swift_code` char(50) DEFAULT 'Your''s SWIFT Code',
  `iban` char(50) NOT NULL DEFAULT 'Yours IBAN number',
  `account_number` char(50) DEFAULT 'Your''s Account Number',
  `comment` varbinary(300) DEFAULT NULL,
  `currency_id` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `state_id` int(11) NOT NULL,
  `status` int(1) DEFAULT '0',
  `city_name` varchar(255) DEFAULT 'Your''s City Name',
  `state_name` varchar(255) DEFAULT 'Your''s State Name',
  `country_name` varchar(255) DEFAULT 'Your''s Country Name',
  `key` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9063 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `aliases`
--

DROP TABLE IF EXISTS `aliases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aliases` (
  `sticky` int(11) DEFAULT NULL,
  `alias` varchar(128) DEFAULT NULL,
  `command` varchar(4096) DEFAULT NULL,
  `hostname` varchar(256) DEFAULT NULL,
  KEY `alias1` (`alias`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Temporary table structure for view `basic_calls`
--

DROP TABLE IF EXISTS `basic_calls`;
/*!50001 DROP VIEW IF EXISTS `basic_calls`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `basic_calls` (
  `uuid` tinyint NOT NULL,
  `direction` tinyint NOT NULL,
  `created` tinyint NOT NULL,
  `created_epoch` tinyint NOT NULL,
  `name` tinyint NOT NULL,
  `state` tinyint NOT NULL,
  `cid_name` tinyint NOT NULL,
  `cid_num` tinyint NOT NULL,
  `ip_addr` tinyint NOT NULL,
  `dest` tinyint NOT NULL,
  `presence_id` tinyint NOT NULL,
  `presence_data` tinyint NOT NULL,
  `callstate` tinyint NOT NULL,
  `callee_name` tinyint NOT NULL,
  `callee_num` tinyint NOT NULL,
  `callee_direction` tinyint NOT NULL,
  `call_uuid` tinyint NOT NULL,
  `hostname` tinyint NOT NULL,
  `sent_callee_name` tinyint NOT NULL,
  `sent_callee_num` tinyint NOT NULL,
  `b_uuid` tinyint NOT NULL,
  `b_direction` tinyint NOT NULL,
  `b_created` tinyint NOT NULL,
  `b_created_epoch` tinyint NOT NULL,
  `b_name` tinyint NOT NULL,
  `b_state` tinyint NOT NULL,
  `b_cid_name` tinyint NOT NULL,
  `b_cid_num` tinyint NOT NULL,
  `b_ip_addr` tinyint NOT NULL,
  `b_dest` tinyint NOT NULL,
  `b_presence_id` tinyint NOT NULL,
  `b_presence_data` tinyint NOT NULL,
  `b_callstate` tinyint NOT NULL,
  `b_callee_name` tinyint NOT NULL,
  `b_callee_num` tinyint NOT NULL,
  `b_callee_direction` tinyint NOT NULL,
  `b_sent_callee_name` tinyint NOT NULL,
  `b_sent_callee_num` tinyint NOT NULL,
  `call_created_epoch` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `billingterms`
--

DROP TABLE IF EXISTS `billingterms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `billingterms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `billing_term` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `call_permission_control`
--

DROP TABLE IF EXISTS `call_permission_control`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `call_permission_control` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `destination` varchar(20) NOT NULL,
  `numberrange_name` varchar(100) NOT NULL,
  `billsec` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`,`date`,`destination`,`numberrange_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `calls`
--

DROP TABLE IF EXISTS `calls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `calls` (
  `call_uuid` varchar(255) DEFAULT NULL,
  `call_created` varchar(128) DEFAULT NULL,
  `call_created_epoch` int(11) DEFAULT NULL,
  `caller_uuid` varchar(256) DEFAULT NULL,
  `callee_uuid` varchar(256) DEFAULT NULL,
  `hostname` varchar(256) DEFAULT NULL,
  KEY `calls1` (`hostname`),
  KEY `callsidx1` (`hostname`),
  KEY `eruuindex` (`caller_uuid`),
  KEY `eeuuindex` (`callee_uuid`),
  KEY `eeuuindex2` (`call_uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cdrs`
--

DROP TABLE IF EXISTS `cdrs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cdrs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `caller_id_name` varchar(30) DEFAULT NULL,
  `caller_id_number` varchar(30) DEFAULT NULL,
  `destination_number` varchar(30) DEFAULT NULL,
  `context` varchar(20) DEFAULT NULL,
  `start_stamp` datetime DEFAULT NULL,
  `answer_stamp` datetime DEFAULT NULL,
  `end_stamp` datetime DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `billsec` int(11) DEFAULT NULL,
  `hangup_cause` varchar(50) DEFAULT NULL,
  `uuid` varchar(100) DEFAULT NULL,
  `bleg_uuid` varchar(100) DEFAULT NULL,
  `accountcode` varchar(10) DEFAULT NULL,
  `superresseler_id` int(11) DEFAULT '0',
  `resseller_id` int(11) DEFAULT '0',
  `subresseller_id` int(11) DEFAULT '0',
  `numberrange_name` varchar(150) DEFAULT NULL,
  `Addon` int(11) DEFAULT '0',
  `superresrate` float DEFAULT NULL,
  `ressellerrate` float DEFAULT NULL,
  `subresrate` float DEFAULT NULL,
  `currency_id` int(5) DEFAULT NULL,
  `admin_currency` int(5) DEFAULT NULL,
  `supres_currency` int(5) DEFAULT NULL,
  `reseller_currency` int(5) DEFAULT NULL,
  `subres_currency` int(5) DEFAULT NULL,
  `isdaily` int(2) DEFAULT NULL,
  `operator_name` varchar(25) DEFAULT NULL,
  `payment_term` varchar(15) DEFAULT NULL,
  `operator_ip` varchar(16) DEFAULT NULL,
  `adminbuyrate` float DEFAULT NULL,
  `sip_local_network_addr` char(60) DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `index_superresseler_id` (`superresseler_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25584305 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`%`*/ /*!50003 TRIGGER `did_last_used` AFTER INSERT ON `cdrs` 
    FOR EACH ROW BEGIN
	update dids set dids.last_used=New.end_stamp where did=New.destination_number;
    END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `cdrs_archive`
--

DROP TABLE IF EXISTS `cdrs_archive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cdrs_archive` (
  `caller_id_name` varchar(30) DEFAULT NULL,
  `caller_id_number` varchar(30) DEFAULT NULL,
  `destination_number` varchar(30) DEFAULT NULL,
  `context` varchar(20) DEFAULT NULL,
  `start_stamp` datetime DEFAULT NULL,
  `answer_stamp` datetime DEFAULT NULL,
  `end_stamp` datetime DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `billsec` int(11) DEFAULT NULL,
  `hangup_cause` varchar(50) DEFAULT NULL,
  `uuid` varchar(100) DEFAULT NULL,
  `bleg_uuid` varchar(100) DEFAULT NULL,
  `accountcode` varchar(10) DEFAULT NULL,
  `superresseler_id` int(11) DEFAULT '0',
  `resseller_id` int(11) DEFAULT '0',
  `subresseller_id` int(11) DEFAULT '0',
  `numberrange_name` varchar(150) DEFAULT NULL,
  `Addon` int(11) DEFAULT '0',
  `superresrate` float DEFAULT NULL,
  `ressellerrate` float DEFAULT NULL,
  `subresrate` float DEFAULT NULL,
  `currency_id` int(5) DEFAULT NULL,
  `admin_currency` int(5) DEFAULT NULL,
  `supres_currency` int(5) DEFAULT NULL,
  `reseller_currency` int(5) DEFAULT NULL,
  `subres_currency` int(5) DEFAULT NULL,
  `isdaily` int(2) DEFAULT NULL,
  `operator_name` varchar(25) DEFAULT NULL,
  `payment_term` varchar(15) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=60128552 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `channels`
--

DROP TABLE IF EXISTS `channels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `channels` (
  `uuid` varchar(256) DEFAULT NULL,
  `direction` varchar(32) DEFAULT NULL,
  `created` varchar(128) DEFAULT NULL,
  `created_epoch` int(11) DEFAULT NULL,
  `name` varchar(1024) DEFAULT NULL,
  `state` varchar(64) DEFAULT NULL,
  `cid_name` varchar(1024) DEFAULT NULL,
  `cid_num` varchar(256) DEFAULT NULL,
  `ip_addr` varchar(256) DEFAULT NULL,
  `dest` varchar(1024) DEFAULT NULL,
  `application` varchar(128) DEFAULT NULL,
  `application_data` varchar(4096) DEFAULT NULL,
  `dialplan` varchar(128) DEFAULT NULL,
  `context` varchar(128) DEFAULT NULL,
  `read_codec` varchar(128) DEFAULT NULL,
  `read_rate` varchar(32) DEFAULT NULL,
  `read_bit_rate` varchar(32) DEFAULT NULL,
  `write_codec` varchar(128) DEFAULT NULL,
  `write_rate` varchar(32) DEFAULT NULL,
  `write_bit_rate` varchar(32) DEFAULT NULL,
  `secure` varchar(64) DEFAULT NULL,
  `hostname` varchar(256) DEFAULT NULL,
  `presence_id` varchar(4096) DEFAULT NULL,
  `presence_data` varchar(4096) DEFAULT NULL,
  `accountcode` varchar(256) DEFAULT NULL,
  `callstate` varchar(64) DEFAULT NULL,
  `callee_name` varchar(1024) DEFAULT NULL,
  `callee_num` varchar(256) DEFAULT NULL,
  `callee_direction` varchar(5) DEFAULT NULL,
  `call_uuid` varchar(256) DEFAULT NULL,
  `sent_callee_name` varchar(1024) DEFAULT NULL,
  `sent_callee_num` varchar(256) DEFAULT NULL,
  `initial_cid_name` varchar(1024) DEFAULT NULL,
  `initial_cid_num` varchar(256) DEFAULT NULL,
  `initial_ip_addr` varchar(256) DEFAULT NULL,
  `initial_dest` varchar(1024) DEFAULT NULL,
  `initial_dialplan` varchar(128) DEFAULT NULL,
  `initial_context` varchar(128) DEFAULT NULL,
  KEY `channels1` (`hostname`),
  KEY `chidx1` (`hostname`),
  KEY `uuindex` (`uuid`,`hostname`),
  KEY `uuindex2` (`call_uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cities`
--

DROP TABLE IF EXISTS `cities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cities` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `state_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=29744 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `complete`
--

DROP TABLE IF EXISTS `complete`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `complete` (
  `sticky` int(11) DEFAULT NULL,
  `a1` varchar(128) DEFAULT NULL,
  `a2` varchar(128) DEFAULT NULL,
  `a3` varchar(128) DEFAULT NULL,
  `a4` varchar(128) DEFAULT NULL,
  `a5` varchar(128) DEFAULT NULL,
  `a6` varchar(128) DEFAULT NULL,
  `a7` varchar(128) DEFAULT NULL,
  `a8` varchar(128) DEFAULT NULL,
  `a9` varchar(128) DEFAULT NULL,
  `a10` varchar(128) DEFAULT NULL,
  `hostname` varchar(256) DEFAULT NULL,
  KEY `complete1` (`a1`,`hostname`),
  KEY `complete2` (`a2`,`hostname`),
  KEY `complete3` (`a3`,`hostname`),
  KEY `complete4` (`a4`,`hostname`),
  KEY `complete5` (`a5`,`hostname`),
  KEY `complete6` (`a6`,`hostname`),
  KEY `complete7` (`a7`,`hostname`),
  KEY `complete8` (`a8`,`hostname`),
  KEY `complete9` (`a9`,`hostname`),
  KEY `complete10` (`a10`,`hostname`),
  KEY `complete11` (`a1`,`a2`,`a3`,`a4`,`a5`,`a6`,`a7`,`a8`,`a9`,`a10`,`hostname`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `conferencepins`
--

DROP TABLE IF EXISTS `conferencepins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `conferencepins` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `pin` int(4) DEFAULT NULL,
  `tpin` int(4) DEFAULT '4499',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `countries` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `currencies`
--

DROP TABLE IF EXISTS `currencies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `currencies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `currency_name` varchar(50) NOT NULL,
  `symbol` varchar(50) DEFAULT NULL,
  `rate` float DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `db_data`
--

DROP TABLE IF EXISTS `db_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_data` (
  `hostname` varchar(255) DEFAULT NULL,
  `realm` varchar(255) DEFAULT NULL,
  `data_key` varchar(255) DEFAULT NULL,
  `data` varchar(255) DEFAULT NULL,
  UNIQUE KEY `dd_data_key_realm` (`data_key`,`realm`),
  KEY `dd_realm` (`realm`),
  KEY `dd_data_key` (`data_key`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Temporary table structure for view `detailed_calls`
--

DROP TABLE IF EXISTS `detailed_calls`;
/*!50001 DROP VIEW IF EXISTS `detailed_calls`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `detailed_calls` (
  `uuid` tinyint NOT NULL,
  `direction` tinyint NOT NULL,
  `created` tinyint NOT NULL,
  `created_epoch` tinyint NOT NULL,
  `name` tinyint NOT NULL,
  `state` tinyint NOT NULL,
  `cid_name` tinyint NOT NULL,
  `cid_num` tinyint NOT NULL,
  `ip_addr` tinyint NOT NULL,
  `dest` tinyint NOT NULL,
  `application` tinyint NOT NULL,
  `application_data` tinyint NOT NULL,
  `dialplan` tinyint NOT NULL,
  `context` tinyint NOT NULL,
  `read_codec` tinyint NOT NULL,
  `read_rate` tinyint NOT NULL,
  `read_bit_rate` tinyint NOT NULL,
  `write_codec` tinyint NOT NULL,
  `write_rate` tinyint NOT NULL,
  `write_bit_rate` tinyint NOT NULL,
  `secure` tinyint NOT NULL,
  `hostname` tinyint NOT NULL,
  `presence_id` tinyint NOT NULL,
  `presence_data` tinyint NOT NULL,
  `callstate` tinyint NOT NULL,
  `callee_name` tinyint NOT NULL,
  `callee_num` tinyint NOT NULL,
  `callee_direction` tinyint NOT NULL,
  `call_uuid` tinyint NOT NULL,
  `sent_callee_name` tinyint NOT NULL,
  `sent_callee_num` tinyint NOT NULL,
  `b_uuid` tinyint NOT NULL,
  `b_direction` tinyint NOT NULL,
  `b_created` tinyint NOT NULL,
  `b_created_epoch` tinyint NOT NULL,
  `b_name` tinyint NOT NULL,
  `b_state` tinyint NOT NULL,
  `b_cid_name` tinyint NOT NULL,
  `b_cid_num` tinyint NOT NULL,
  `b_ip_addr` tinyint NOT NULL,
  `b_dest` tinyint NOT NULL,
  `b_application` tinyint NOT NULL,
  `b_application_data` tinyint NOT NULL,
  `b_dialplan` tinyint NOT NULL,
  `b_context` tinyint NOT NULL,
  `b_read_codec` tinyint NOT NULL,
  `b_read_rate` tinyint NOT NULL,
  `b_read_bit_rate` tinyint NOT NULL,
  `b_write_codec` tinyint NOT NULL,
  `b_write_rate` tinyint NOT NULL,
  `b_write_bit_rate` tinyint NOT NULL,
  `b_secure` tinyint NOT NULL,
  `b_hostname` tinyint NOT NULL,
  `b_presence_id` tinyint NOT NULL,
  `b_presence_data` tinyint NOT NULL,
  `b_callstate` tinyint NOT NULL,
  `b_callee_name` tinyint NOT NULL,
  `b_callee_num` tinyint NOT NULL,
  `b_callee_direction` tinyint NOT NULL,
  `b_call_uuid` tinyint NOT NULL,
  `b_sent_callee_name` tinyint NOT NULL,
  `b_sent_callee_num` tinyint NOT NULL,
  `call_created_epoch` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `didrates`
--

DROP TABLE IF EXISTS `didrates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `didrates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `did_id` int(11) DEFAULT NULL,
  `adminbuyrate` decimal(10,5) DEFAULT NULL,
  `admin_currency` int(11) DEFAULT '1',
  `superresrate` decimal(10,5) DEFAULT NULL,
  `supres_currency` int(11) DEFAULT '1',
  `ressellerrate` decimal(10,5) DEFAULT NULL,
  `reseller_currency` int(11) DEFAULT '1',
  `subresrate` decimal(10,5) DEFAULT NULL,
  `subres_currency` int(11) DEFAULT '1',
  `assignedBy` int(11) DEFAULT NULL,
  `currency_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `did_id` (`did_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13774855 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dids`
--

DROP TABLE IF EXISTS `dids`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dids` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numberrange_id` int(11) DEFAULT NULL,
  `did` varchar(20) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `IsTestNumber` tinyint(1) DEFAULT '0',
  `mincallduration` int(11) DEFAULT NULL,
  `perclilimit` int(11) DEFAULT '0',
  `maxdailyminutes` int(11) DEFAULT NULL,
  `ivr_id` varchar(500) DEFAULT 'TeachYourselfEnglishINTHECITY.wav',
  `last_used` datetime DEFAULT NULL,
  `routing` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id`,`did`),
  KEY `dids` (`did`),
  KEY `numberrange_id` (`numberrange_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5101541 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dids_users`
--

DROP TABLE IF EXISTS `dids_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dids_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `did_id` int(11) NOT NULL,
  `superresseler_id` int(11) DEFAULT NULL,
  `resseller_id` int(11) DEFAULT NULL,
  `subresseller_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `isdaily` int(11) NOT NULL,
  `payment_term` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `did_id` (`did_id`),
  KEY `assign_user` (`superresseler_id`,`resseller_id`,`subresseller_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10378105 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `group_data`
--

DROP TABLE IF EXISTS `group_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `group_data` (
  `hostname` varchar(255) DEFAULT NULL,
  `groupname` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  KEY `gd_groupname` (`groupname`),
  KEY `gd_url` (`url`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `interfaces`
--

DROP TABLE IF EXISTS `interfaces`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `interfaces` (
  `type` varchar(128) DEFAULT NULL,
  `name` varchar(1024) DEFAULT NULL,
  `description` varchar(4096) DEFAULT NULL,
  `ikey` varchar(1024) DEFAULT NULL,
  `filename` varchar(4096) DEFAULT NULL,
  `syntax` varchar(4096) DEFAULT NULL,
  `hostname` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `invoice_details`
--

DROP TABLE IF EXISTS `invoice_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoice_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numberrange_id` int(11) DEFAULT NULL,
  `currency_id` int(11) DEFAULT NULL,
  `invoice_id` int(11) NOT NULL DEFAULT '1',
  `minutes` float DEFAULT NULL,
  `rate` float DEFAULT NULL,
  `invoice_total` float DEFAULT NULL,
  `numberrange_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=323535 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `invoice_reports`
--

DROP TABLE IF EXISTS `invoice_reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoice_reports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) DEFAULT NULL,
  `total_usd` double DEFAULT '0',
  `total_gbp` double DEFAULT '0',
  `total_euro` double DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21995 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `invoice_statuses`
--

DROP TABLE IF EXISTS `invoice_statuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoice_statuses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `invoices`
--

DROP TABLE IF EXISTS `invoices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_status_id` int(11) DEFAULT '1',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) DEFAULT NULL,
  `isdaily` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22035 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ips`
--

DROP TABLE IF EXISTS `ips`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ips` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_name` varchar(100) NOT NULL,
  `ip_address` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ivrs`
--

DROP TABLE IF EXISTS `ivrs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ivrs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ivr_name` varchar(1000) DEFAULT NULL,
  `ivr_uploaded_name` varchar(1000) NOT NULL DEFAULT 'TeachYourselfEnglishINTHECITY.wav',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=118 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `limit_data`
--

DROP TABLE IF EXISTS `limit_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `limit_data` (
  `hostname` varchar(255) DEFAULT NULL,
  `realm` varchar(255) DEFAULT NULL,
  `id` varchar(255) DEFAULT NULL,
  `uuid` varchar(255) DEFAULT NULL,
  KEY `ld_hostname` (`hostname`),
  KEY `ld_uuid` (`uuid`),
  KEY `ld_realm` (`realm`),
  KEY `ld_id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mivrs`
--

DROP TABLE IF EXISTS `mivrs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mivrs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `0` varchar(100) DEFAULT NULL,
  `1` varchar(100) DEFAULT NULL,
  `2` varchar(100) DEFAULT NULL,
  `3` varchar(100) DEFAULT NULL,
  `4` varchar(100) DEFAULT NULL,
  `5` varchar(100) DEFAULT NULL,
  `6` varchar(100) DEFAULT NULL,
  `7` varchar(100) DEFAULT NULL,
  `8` varchar(100) DEFAULT NULL,
  `9` varchar(100) DEFAULT NULL,
  `10` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `nat`
--

DROP TABLE IF EXISTS `nat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nat` (
  `sticky` int(11) DEFAULT NULL,
  `port` int(11) DEFAULT NULL,
  `proto` int(11) DEFAULT NULL,
  `hostname` varchar(256) DEFAULT NULL,
  KEY `nat_map_port_proto` (`port`,`proto`,`hostname`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(80) NOT NULL,
  `detail` text NOT NULL,
  `status` tinyint(1) DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=401 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `numberrange_id` int(11) DEFAULT NULL,
  `statusid` tinyint(1) DEFAULT '1' COMMENT 'Notification Status 1 for new ,2 for approve ,3 for reject',
  `assign_total` int(11) DEFAULT NULL,
  `isdaily` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33733 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `numberrange_rate_list`
--

DROP TABLE IF EXISTS `numberrange_rate_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `numberrange_rate_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `buyinrate` decimal(10,4) DEFAULT NULL,
  `monthly` decimal(10,4) DEFAULT NULL,
  `weekly` decimal(10,4) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=180 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `numberranges`
--

DROP TABLE IF EXISTS `numberranges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `numberranges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `operator_id` int(11) DEFAULT NULL,
  `route` varchar(50) DEFAULT NULL,
  `routetype_id` int(11) DEFAULT NULL,
  `ivrpath` varchar(500) DEFAULT NULL,
  `currency_id` int(11) NOT NULL DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `clilimit` int(11) DEFAULT NULL,
  `buyingrate` decimal(10,5) DEFAULT NULL,
  `sellingrate` decimal(10,5) NOT NULL DEFAULT '0.00000',
  `minduraction` int(11) DEFAULT NULL,
  `maxduration` int(11) DEFAULT NULL,
  `calllimit` int(11) DEFAULT NULL,
  `maxdailyminutes` int(11) DEFAULT NULL,
  `dailyrate` decimal(10,5) NOT NULL DEFAULT '0.00000',
  `monthlyrate` decimal(10,5) NOT NULL DEFAULT '0.00000',
  `daily_title` varchar(100) DEFAULT NULL,
  `weekly_title` varchar(100) DEFAULT NULL,
  `monthly_title` varchar(100) DEFAULT NULL,
  `isringing` tinyint(4) DEFAULT NULL,
  `isfixed` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`,`name`)
) ENGINE=InnoDB AUTO_INCREMENT=99477 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `numberranges_log`
--

DROP TABLE IF EXISTS `numberranges_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `numberranges_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  `log_text` text,
  `created` varchar(60) DEFAULT NULL,
  `monthly_rate` varchar(50) DEFAULT NULL,
  `weekly_rate` varchar(50) DEFAULT NULL,
  `daily_rate` varchar(50) DEFAULT NULL,
  `range_name` varchar(50) DEFAULT NULL,
  `operatorid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30943 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `operator_invoice_details`
--

DROP TABLE IF EXISTS `operator_invoice_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `operator_invoice_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numberrange_id` int(11) DEFAULT NULL,
  `currency_id` int(11) DEFAULT NULL,
  `operator_invoice_id` int(11) NOT NULL DEFAULT '1',
  `minutes` float DEFAULT NULL,
  `rate` float DEFAULT NULL,
  `invoice_total` float DEFAULT NULL,
  `numberrange_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=127211 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `operator_invoices`
--

DROP TABLE IF EXISTS `operator_invoices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `operator_invoices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_status_id` int(11) DEFAULT '1',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `operator_id` int(11) DEFAULT NULL,
  `isweekly` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1677 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `operator_ips`
--

DROP TABLE IF EXISTS `operator_ips`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `operator_ips` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `ip` varchar(20) DEFAULT NULL,
  `operator_id` int(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `isprimary` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=511 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `operators`
--

DROP TABLE IF EXISTS `operators`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `operators` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `isweekly` int(1) NOT NULL DEFAULT '0',
  `euro_account` varchar(550) NOT NULL,
  `gbp_account` varchar(550) NOT NULL,
  `usd_account` varchar(550) NOT NULL,
  `alphabet` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `payment_terms`
--

DROP TABLE IF EXISTS `payment_terms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment_terms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) DEFAULT NULL,
  `title` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `payoneer_user_invoices`
--

DROP TABLE IF EXISTS `payoneer_user_invoices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payoneer_user_invoices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(50) DEFAULT NULL,
  `card_number` char(20) DEFAULT NULL,
  `date_expiry` date DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `payoneer_users`
--

DROP TABLE IF EXISTS `payoneer_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payoneer_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(50) DEFAULT 'Your Name On Card',
  `card_number` char(20) DEFAULT 'Your Card Number',
  `date_expiry` date DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `status` int(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2935 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `profit_details`
--

DROP TABLE IF EXISTS `profit_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `profit_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `currency_id` int(11) DEFAULT NULL,
  `profit_id` int(11) DEFAULT NULL,
  `minutes` float DEFAULT NULL,
  `sellingrate` float DEFAULT NULL,
  `selling_total` float DEFAULT NULL,
  `buyingrate` float DEFAULT NULL,
  `buying_total` float DEFAULT NULL,
  `profit` float DEFAULT NULL,
  `operator_name` varchar(255) DEFAULT NULL,
  `numberrange_name` varchar(255) DEFAULT NULL,
  `payable_minutes` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46325 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `profits`
--

DROP TABLE IF EXISTS `profits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `profits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `operator_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=141 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `randomdid_log`
--

DROP TABLE IF EXISTS `randomdid_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `randomdid_log` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `start_did` varchar(20) DEFAULT NULL,
  `end_did` varchar(20) DEFAULT NULL,
  `qty` varchar(20) DEFAULT NULL,
  `inserted_log` varchar(1000) DEFAULT NULL,
  `duplicate_log` varchar(1000) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11249 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ratecard_log`
--

DROP TABLE IF EXISTS `ratecard_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ratecard_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  `assigned_dids` text,
  `log_text` text,
  `created` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=145920 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `recovery`
--

DROP TABLE IF EXISTS `recovery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recovery` (
  `runtime_uuid` varchar(255) DEFAULT NULL,
  `technology` varchar(255) DEFAULT NULL,
  `profile_name` varchar(255) DEFAULT NULL,
  `hostname` varchar(255) DEFAULT NULL,
  `uuid` varchar(255) DEFAULT NULL,
  `metadata` text,
  KEY `recovery1` (`technology`),
  KEY `recovery2` (`profile_name`),
  KEY `recovery3` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `registration_ids`
--

DROP TABLE IF EXISTS `registration_ids`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `registration_ids` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `deviceid` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `registrations`
--

DROP TABLE IF EXISTS `registrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `registrations` (
  `reg_user` varchar(256) DEFAULT NULL,
  `realm` varchar(256) DEFAULT NULL,
  `token` varchar(256) DEFAULT NULL,
  `url` text,
  `expires` int(11) DEFAULT NULL,
  `network_ip` varchar(256) DEFAULT NULL,
  `network_port` varchar(256) DEFAULT NULL,
  `network_proto` varchar(256) DEFAULT NULL,
  `hostname` varchar(256) DEFAULT NULL,
  `metadata` varchar(256) DEFAULT NULL,
  KEY `regindex1` (`reg_user`,`realm`,`hostname`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `routetypes`
--

DROP TABLE IF EXISTS `routetypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `routetypes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sip_authentication`
--

DROP TABLE IF EXISTS `sip_authentication`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sip_authentication` (
  `nonce` varchar(255) DEFAULT NULL,
  `expires` int(11) DEFAULT NULL,
  `profile_name` varchar(255) DEFAULT NULL,
  `hostname` varchar(255) DEFAULT NULL,
  `last_nc` int(11) DEFAULT NULL,
  KEY `sa_nonce` (`nonce`),
  KEY `sa_hostname` (`hostname`),
  KEY `sa_expires` (`expires`),
  KEY `sa_last_nc` (`last_nc`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sip_dialogs`
--

DROP TABLE IF EXISTS `sip_dialogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sip_dialogs` (
  `call_id` varchar(255) DEFAULT NULL,
  `uuid` varchar(255) DEFAULT NULL,
  `sip_to_user` varchar(255) DEFAULT NULL,
  `sip_to_host` varchar(255) DEFAULT NULL,
  `sip_from_user` varchar(255) DEFAULT NULL,
  `sip_from_host` varchar(255) DEFAULT NULL,
  `contact_user` varchar(255) DEFAULT NULL,
  `contact_host` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `direction` varchar(255) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `profile_name` varchar(255) DEFAULT NULL,
  `hostname` varchar(255) DEFAULT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `presence_id` varchar(255) DEFAULT NULL,
  `presence_data` varchar(255) DEFAULT NULL,
  `call_info` varchar(255) DEFAULT NULL,
  `call_info_state` varchar(255) DEFAULT '',
  `expires` int(11) DEFAULT '0',
  `status` varchar(255) DEFAULT NULL,
  `rpid` varchar(255) DEFAULT NULL,
  `sip_to_tag` varchar(255) DEFAULT NULL,
  `sip_from_tag` varchar(255) DEFAULT NULL,
  `rcd` int(11) NOT NULL DEFAULT '0',
  KEY `sd_uuid` (`uuid`),
  KEY `sd_hostname` (`hostname`),
  KEY `sd_presence_data` (`presence_data`),
  KEY `sd_call_info` (`call_info`),
  KEY `sd_call_info_state` (`call_info_state`),
  KEY `sd_expires` (`expires`),
  KEY `sd_rcd` (`rcd`),
  KEY `sd_sip_to_tag` (`sip_to_tag`),
  KEY `sd_sip_from_user` (`sip_from_user`),
  KEY `sd_sip_from_host` (`sip_from_host`),
  KEY `sd_sip_to_host` (`sip_to_host`),
  KEY `sd_presence_id` (`presence_id`),
  KEY `sd_call_id` (`call_id`),
  KEY `sd_sip_from_tag` (`sip_from_tag`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sip_presence`
--

DROP TABLE IF EXISTS `sip_presence`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sip_presence` (
  `sip_user` varchar(255) DEFAULT NULL,
  `sip_host` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `rpid` varchar(255) DEFAULT NULL,
  `expires` int(11) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `profile_name` varchar(255) DEFAULT NULL,
  `hostname` varchar(255) DEFAULT NULL,
  `network_ip` varchar(255) DEFAULT NULL,
  `network_port` varchar(6) DEFAULT NULL,
  `open_closed` varchar(255) DEFAULT NULL,
  KEY `sp_hostname` (`hostname`),
  KEY `sp_open_closed` (`open_closed`),
  KEY `sp_sip_user` (`sip_user`),
  KEY `sp_sip_host` (`sip_host`),
  KEY `sp_profile_name` (`profile_name`),
  KEY `sp_expires` (`expires`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sip_registrations`
--

DROP TABLE IF EXISTS `sip_registrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sip_registrations` (
  `call_id` varchar(255) DEFAULT NULL,
  `sip_user` varchar(255) DEFAULT NULL,
  `sip_host` varchar(255) DEFAULT NULL,
  `presence_hosts` varchar(255) DEFAULT NULL,
  `contact` varchar(1024) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `rpid` varchar(255) DEFAULT NULL,
  `expires` int(11) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `server_user` varchar(255) DEFAULT NULL,
  `server_host` varchar(255) DEFAULT NULL,
  `profile_name` varchar(255) DEFAULT NULL,
  `hostname` varchar(255) DEFAULT NULL,
  `network_ip` varchar(255) DEFAULT NULL,
  `network_port` varchar(6) DEFAULT NULL,
  `sip_username` varchar(255) DEFAULT NULL,
  `sip_realm` varchar(255) DEFAULT NULL,
  `mwi_user` varchar(255) DEFAULT NULL,
  `mwi_host` varchar(255) DEFAULT NULL,
  `orig_server_host` varchar(255) DEFAULT NULL,
  `orig_hostname` varchar(255) DEFAULT NULL,
  `sub_host` varchar(255) DEFAULT NULL,
  KEY `sr_call_id` (`call_id`),
  KEY `sr_sip_user` (`sip_user`),
  KEY `sr_sip_host` (`sip_host`),
  KEY `sr_sub_host` (`sub_host`),
  KEY `sr_mwi_user` (`mwi_user`),
  KEY `sr_mwi_host` (`mwi_host`),
  KEY `sr_profile_name` (`profile_name`),
  KEY `sr_presence_hosts` (`presence_hosts`),
  KEY `sr_contact` (`contact`(767)),
  KEY `sr_expires` (`expires`),
  KEY `sr_hostname` (`hostname`),
  KEY `sr_status` (`status`),
  KEY `sr_network_ip` (`network_ip`),
  KEY `sr_network_port` (`network_port`),
  KEY `sr_sip_username` (`sip_username`),
  KEY `sr_sip_realm` (`sip_realm`),
  KEY `sr_orig_server_host` (`orig_server_host`),
  KEY `sr_orig_hostname` (`orig_hostname`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sip_shared_appearance_dialogs`
--

DROP TABLE IF EXISTS `sip_shared_appearance_dialogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sip_shared_appearance_dialogs` (
  `profile_name` varchar(255) DEFAULT NULL,
  `hostname` varchar(255) DEFAULT NULL,
  `contact_str` varchar(255) DEFAULT NULL,
  `call_id` varchar(255) DEFAULT NULL,
  `network_ip` varchar(255) DEFAULT NULL,
  `expires` int(11) DEFAULT NULL,
  KEY `ssd_profile_name` (`profile_name`),
  KEY `ssd_hostname` (`hostname`),
  KEY `ssd_contact_str` (`contact_str`),
  KEY `ssd_call_id` (`call_id`),
  KEY `ssd_expires` (`expires`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sip_shared_appearance_subscriptions`
--

DROP TABLE IF EXISTS `sip_shared_appearance_subscriptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sip_shared_appearance_subscriptions` (
  `subscriber` varchar(255) DEFAULT NULL,
  `call_id` varchar(255) DEFAULT NULL,
  `aor` varchar(255) DEFAULT NULL,
  `profile_name` varchar(255) DEFAULT NULL,
  `hostname` varchar(255) DEFAULT NULL,
  `contact_str` varchar(255) DEFAULT NULL,
  `network_ip` varchar(255) DEFAULT NULL,
  KEY `ssa_hostname` (`hostname`),
  KEY `ssa_network_ip` (`network_ip`),
  KEY `ssa_subscriber` (`subscriber`),
  KEY `ssa_profile_name` (`profile_name`),
  KEY `ssa_aor` (`aor`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sip_subscriptions`
--

DROP TABLE IF EXISTS `sip_subscriptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sip_subscriptions` (
  `proto` varchar(255) DEFAULT NULL,
  `sip_user` varchar(255) DEFAULT NULL,
  `sip_host` varchar(255) DEFAULT NULL,
  `sub_to_user` varchar(255) DEFAULT NULL,
  `sub_to_host` varchar(255) DEFAULT NULL,
  `presence_hosts` varchar(255) DEFAULT NULL,
  `event` varchar(255) DEFAULT NULL,
  `contact` varchar(1024) DEFAULT NULL,
  `call_id` varchar(255) DEFAULT NULL,
  `full_from` varchar(255) DEFAULT NULL,
  `full_via` varchar(255) DEFAULT NULL,
  `expires` int(11) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `accept` varchar(255) DEFAULT NULL,
  `profile_name` varchar(255) DEFAULT NULL,
  `hostname` varchar(255) DEFAULT NULL,
  `network_port` varchar(6) DEFAULT NULL,
  `network_ip` varchar(255) DEFAULT NULL,
  `version` int(11) NOT NULL DEFAULT '0',
  `orig_proto` varchar(255) DEFAULT NULL,
  `full_to` varchar(255) DEFAULT NULL,
  KEY `ss_call_id` (`call_id`),
  KEY `ss_hostname` (`hostname`),
  KEY `ss_network_ip` (`network_ip`),
  KEY `ss_sip_user` (`sip_user`),
  KEY `ss_sip_host` (`sip_host`),
  KEY `ss_presence_hosts` (`presence_hosts`),
  KEY `ss_event` (`event`),
  KEY `ss_proto` (`proto`),
  KEY `ss_sub_to_user` (`sub_to_user`),
  KEY `ss_sub_to_host` (`sub_to_host`),
  KEY `ss_expires` (`expires`),
  KEY `ss_orig_proto` (`orig_proto`),
  KEY `ss_network_port` (`network_port`),
  KEY `ss_profile_name` (`profile_name`),
  KEY `ss_version` (`version`),
  KEY `ss_full_from` (`full_from`),
  KEY `ss_contact` (`contact`(767))
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `states`
--

DROP TABLE IF EXISTS `states`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `states` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `country_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=112 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tasks`
--

DROP TABLE IF EXISTS `tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tasks` (
  `task_id` int(11) DEFAULT NULL,
  `task_desc` varchar(4096) DEFAULT NULL,
  `task_group` varchar(1024) DEFAULT NULL,
  `task_runtime` bigint(20) DEFAULT NULL,
  `task_sql_manager` int(11) DEFAULT NULL,
  `hostname` varchar(256) DEFAULT NULL,
  KEY `tasks1` (`hostname`,`task_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `unmatch_did_cdrs`
--

DROP TABLE IF EXISTS `unmatch_did_cdrs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `unmatch_did_cdrs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `caller_id_name` varchar(30) DEFAULT NULL,
  `caller_id_number` varchar(30) DEFAULT NULL,
  `destination_number` varchar(30) DEFAULT NULL,
  `context` varchar(20) DEFAULT NULL,
  `start_stamp` datetime DEFAULT NULL,
  `answer_stamp` datetime DEFAULT NULL,
  `end_stamp` datetime DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `billsec` int(11) DEFAULT NULL,
  `hangup_cause` varchar(50) DEFAULT NULL,
  `custom_hangup_cause` varchar(50) DEFAULT NULL,
  `uuid` varchar(100) DEFAULT NULL,
  `bleg_uuid` varchar(100) DEFAULT NULL,
  `accountcode` varchar(10) DEFAULT NULL,
  `superresseler_id` int(11) DEFAULT '0',
  `resseller_id` int(11) DEFAULT '0',
  `subresseller_id` int(11) DEFAULT '0',
  `numberrange_name` varchar(150) DEFAULT NULL,
  `Addon` int(11) DEFAULT '0',
  `superresrate` float DEFAULT NULL,
  `ressellerrate` float DEFAULT NULL,
  `subresrate` float DEFAULT NULL,
  `currency_id` int(5) DEFAULT NULL,
  `admin_currency` int(5) DEFAULT NULL,
  `supres_currency` int(5) DEFAULT NULL,
  `reseller_currency` int(5) DEFAULT NULL,
  `subres_currency` int(5) DEFAULT NULL,
  `isdaily` int(2) DEFAULT NULL,
  `operator_name` varchar(25) DEFAULT NULL,
  `payment_term` varchar(15) DEFAULT NULL,
  `operator_ip` varchar(16) DEFAULT NULL,
  `adminbuyrate` float DEFAULT NULL,
  `writecodec` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_notifications`
--

DROP TABLE IF EXISTS `user_notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `detail` text,
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=169402 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_types`
--

DROP TABLE IF EXISTS `user_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varbinary(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` double NOT NULL AUTO_INCREMENT,
  `login` varchar(150) DEFAULT NULL,
  `password` varchar(900) DEFAULT NULL,
  `first_name` varchar(600) DEFAULT NULL,
  `last_name` varchar(600) DEFAULT NULL,
  `email` varchar(900) DEFAULT NULL,
  `phone` varchar(150) DEFAULT NULL,
  `address` varchar(1500) DEFAULT NULL,
  `country_id` double DEFAULT NULL,
  `state_id` double DEFAULT NULL,
  `city_id` double DEFAULT NULL,
  `role_id` double DEFAULT NULL,
  `add_on` float DEFAULT NULL,
  `created_by` double DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `preference` varchar(600) DEFAULT NULL,
  `user_type_id` double DEFAULT NULL,
  `isdeleted` tinyint(1) DEFAULT NULL,
  `skype` varchar(150) DEFAULT NULL,
  KEY `user_Id_index` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21505 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wire_user_invoices`
--

DROP TABLE IF EXISTS `wire_user_invoices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wire_user_invoices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(50) DEFAULT NULL,
  `mobile_number` char(25) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `country_name` varchar(255) DEFAULT NULL,
  `state_name` varchar(255) DEFAULT NULL,
  `city_name` varchar(255) DEFAULT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wire_users`
--

DROP TABLE IF EXISTS `wire_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wire_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(50) DEFAULT 'Yours'' Name',
  `mobile_number` char(25) DEFAULT 'your Mobile Number',
  `country_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `country_name` varchar(255) DEFAULT 'Your Country Name',
  `state_name` varchar(255) DEFAULT 'Your State Name',
  `city_name` varchar(255) DEFAULT 'Your City Name',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2935 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping routines for database 'livecalls'
--
/*!50003 DROP PROCEDURE IF EXISTS `insert_users_accounts` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`%` PROCEDURE `insert_users_accounts`()
BEGIN
TRUNCATE accounts_users;
	INSERT INTO accounts_users (`user_id`,`currency_id`)
SELECT users.`id`,4 FROM users
WHERE role_id=2 ;
INSERT INTO accounts_users (`user_id`,`currency_id`)
SELECT users.`id`,1 FROM users
WHERE role_id=2 ;
INSERT INTO accounts_users (`user_id`,`currency_id`)
SELECT users.`id`,2 FROM users
WHERE role_id=2 ;
TRUNCATE wire_users;
INSERT INTO wire_users(`user_id`)
SELECT users.`id` FROM users
WHERE role_id=2 ;
TRUNCATE payoneer_users;
INSERT INTO payoneer_users(`user_id`)
SELECT users.`id` FROM users
WHERE role_id=2 ;
    END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Final view structure for view `basic_calls`
--

/*!50001 DROP TABLE IF EXISTS `basic_calls`*/;
/*!50001 DROP VIEW IF EXISTS `basic_calls`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = latin1 */;
/*!50001 SET character_set_results     = latin1 */;
/*!50001 SET collation_connection      = latin1_swedish_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `basic_calls` AS select `a`.`uuid` AS `uuid`,`a`.`direction` AS `direction`,`a`.`created` AS `created`,`a`.`created_epoch` AS `created_epoch`,`a`.`name` AS `name`,`a`.`state` AS `state`,`a`.`cid_name` AS `cid_name`,`a`.`cid_num` AS `cid_num`,`a`.`ip_addr` AS `ip_addr`,`a`.`dest` AS `dest`,`a`.`presence_id` AS `presence_id`,`a`.`presence_data` AS `presence_data`,`a`.`callstate` AS `callstate`,`a`.`callee_name` AS `callee_name`,`a`.`callee_num` AS `callee_num`,`a`.`callee_direction` AS `callee_direction`,`a`.`call_uuid` AS `call_uuid`,`a`.`hostname` AS `hostname`,`a`.`sent_callee_name` AS `sent_callee_name`,`a`.`sent_callee_num` AS `sent_callee_num`,`b`.`uuid` AS `b_uuid`,`b`.`direction` AS `b_direction`,`b`.`created` AS `b_created`,`b`.`created_epoch` AS `b_created_epoch`,`b`.`name` AS `b_name`,`b`.`state` AS `b_state`,`b`.`cid_name` AS `b_cid_name`,`b`.`cid_num` AS `b_cid_num`,`b`.`ip_addr` AS `b_ip_addr`,`b`.`dest` AS `b_dest`,`b`.`presence_id` AS `b_presence_id`,`b`.`presence_data` AS `b_presence_data`,`b`.`callstate` AS `b_callstate`,`b`.`callee_name` AS `b_callee_name`,`b`.`callee_num` AS `b_callee_num`,`b`.`callee_direction` AS `b_callee_direction`,`b`.`sent_callee_name` AS `b_sent_callee_name`,`b`.`sent_callee_num` AS `b_sent_callee_num`,`c`.`call_created_epoch` AS `call_created_epoch` from ((`channels` `a` left join `calls` `c` on(((`a`.`uuid` = `c`.`caller_uuid`) and (`a`.`hostname` = `c`.`hostname`)))) left join `channels` `b` on(((`b`.`uuid` = `c`.`callee_uuid`) and (`b`.`hostname` = `c`.`hostname`)))) where ((`a`.`uuid` = `c`.`caller_uuid`) or (not(`a`.`uuid` in (select `calls`.`callee_uuid` from `calls`)))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `detailed_calls`
--

/*!50001 DROP TABLE IF EXISTS `detailed_calls`*/;
/*!50001 DROP VIEW IF EXISTS `detailed_calls`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = latin1 */;
/*!50001 SET character_set_results     = latin1 */;
/*!50001 SET collation_connection      = latin1_swedish_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `detailed_calls` AS select `a`.`uuid` AS `uuid`,`a`.`direction` AS `direction`,`a`.`created` AS `created`,`a`.`created_epoch` AS `created_epoch`,`a`.`name` AS `name`,`a`.`state` AS `state`,`a`.`cid_name` AS `cid_name`,`a`.`cid_num` AS `cid_num`,`a`.`ip_addr` AS `ip_addr`,`a`.`dest` AS `dest`,`a`.`application` AS `application`,`a`.`application_data` AS `application_data`,`a`.`dialplan` AS `dialplan`,`a`.`context` AS `context`,`a`.`read_codec` AS `read_codec`,`a`.`read_rate` AS `read_rate`,`a`.`read_bit_rate` AS `read_bit_rate`,`a`.`write_codec` AS `write_codec`,`a`.`write_rate` AS `write_rate`,`a`.`write_bit_rate` AS `write_bit_rate`,`a`.`secure` AS `secure`,`a`.`hostname` AS `hostname`,`a`.`presence_id` AS `presence_id`,`a`.`presence_data` AS `presence_data`,`a`.`callstate` AS `callstate`,`a`.`callee_name` AS `callee_name`,`a`.`callee_num` AS `callee_num`,`a`.`callee_direction` AS `callee_direction`,`a`.`call_uuid` AS `call_uuid`,`a`.`sent_callee_name` AS `sent_callee_name`,`a`.`sent_callee_num` AS `sent_callee_num`,`b`.`uuid` AS `b_uuid`,`b`.`direction` AS `b_direction`,`b`.`created` AS `b_created`,`b`.`created_epoch` AS `b_created_epoch`,`b`.`name` AS `b_name`,`b`.`state` AS `b_state`,`b`.`cid_name` AS `b_cid_name`,`b`.`cid_num` AS `b_cid_num`,`b`.`ip_addr` AS `b_ip_addr`,`b`.`dest` AS `b_dest`,`b`.`application` AS `b_application`,`b`.`application_data` AS `b_application_data`,`b`.`dialplan` AS `b_dialplan`,`b`.`context` AS `b_context`,`b`.`read_codec` AS `b_read_codec`,`b`.`read_rate` AS `b_read_rate`,`b`.`read_bit_rate` AS `b_read_bit_rate`,`b`.`write_codec` AS `b_write_codec`,`b`.`write_rate` AS `b_write_rate`,`b`.`write_bit_rate` AS `b_write_bit_rate`,`b`.`secure` AS `b_secure`,`b`.`hostname` AS `b_hostname`,`b`.`presence_id` AS `b_presence_id`,`b`.`presence_data` AS `b_presence_data`,`b`.`callstate` AS `b_callstate`,`b`.`callee_name` AS `b_callee_name`,`b`.`callee_num` AS `b_callee_num`,`b`.`callee_direction` AS `b_callee_direction`,`b`.`call_uuid` AS `b_call_uuid`,`b`.`sent_callee_name` AS `b_sent_callee_name`,`b`.`sent_callee_num` AS `b_sent_callee_num`,`c`.`call_created_epoch` AS `call_created_epoch` from ((`channels` `a` left join `calls` `c` on(((`a`.`uuid` = `c`.`caller_uuid`) and (`a`.`hostname` = `c`.`hostname`)))) left join `channels` `b` on(((`b`.`uuid` = `c`.`callee_uuid`) and (`b`.`hostname` = `c`.`hostname`)))) where ((`a`.`uuid` = `c`.`caller_uuid`) or (not(`a`.`uuid` in (select `calls`.`callee_uuid` from `calls`)))) */;
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

-- Dump completed on 2020-10-11 23:23:50
