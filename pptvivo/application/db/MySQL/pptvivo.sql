-- MySQL dump 10.13  Distrib 5.1.37, for Win32 (ia32)
--
-- Host: localhost    Database: pptvivo
-- ------------------------------------------------------
-- Server version	5.1.37

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
-- Current Database: `pptvivo`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `pptvivo` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `pptvivo`;

--
-- Table structure for table `exposition`
--

DROP TABLE IF EXISTS `exposition`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `exposition` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `presentationid` int(11) NOT NULL,
  `exposuredate` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_exposition_presentation` (`presentationid`),
  CONSTRAINT `FK_exposition_presentation` FOREIGN KEY (`presentationid`) REFERENCES `presentation` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exposition`
--

LOCK TABLES `exposition` WRITE;
/*!40000 ALTER TABLE `exposition` DISABLE KEYS */;
INSERT INTO `exposition` VALUES (1,1,'2013-04-06'),(2,1,'2013-04-07'),(3,1,'2013-04-14');
/*!40000 ALTER TABLE `exposition` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `expositionattendant`
--

DROP TABLE IF EXISTS `expositionattendant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `expositionattendant` (
  `userid` int(10) NOT NULL,
  `expositionid` int(10) NOT NULL,
  PRIMARY KEY (`userid`,`expositionid`),
  UNIQUE KEY `userid_expositionid` (`userid`,`expositionid`),
  KEY `FK_exposition_attendant_exposition` (`expositionid`),
  CONSTRAINT `FK_exposition_attendant_exposition` FOREIGN KEY (`expositionid`) REFERENCES `exposition` (`id`),
  CONSTRAINT `FK_exposition_attendant_systemuser` FOREIGN KEY (`userid`) REFERENCES `systemuser` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expositionattendant`
--

LOCK TABLES `expositionattendant` WRITE;
/*!40000 ALTER TABLE `expositionattendant` DISABLE KEYS */;
INSERT INTO `expositionattendant` VALUES (81,1),(1,2),(81,2);
/*!40000 ALTER TABLE `expositionattendant` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `expositionnote`
--

DROP TABLE IF EXISTS `expositionnote`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `expositionnote` (
  `expositionid` int(11) NOT NULL,
  `note` text NOT NULL,
  `slide` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  KEY `FK_expositionnote_exposition` (`expositionid`),
  KEY `FK_expositionnote_systemuser` (`userid`),
  CONSTRAINT `FK_expositionnote_exposition` FOREIGN KEY (`expositionid`) REFERENCES `exposition` (`id`),
  CONSTRAINT `FK_expositionnote_systemuser` FOREIGN KEY (`userid`) REFERENCES `systemuser` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expositionnote`
--

LOCK TABLES `expositionnote` WRITE;
/*!40000 ALTER TABLE `expositionnote` DISABLE KEYS */;
INSERT INTO `expositionnote` VALUES (1,'aaaaaa',1,81),(1,'sdasdsdasd',1,81),(1,'dfasfasfasfasf',1,81),(1,'&lt;sfasfasfasfasfasfas',1,81),(1,'asdasdasdasd',1,81),(1,'asdasdasdasd',1,81),(1,'asdasdasdasdasdasd',1,81),(1,'adasdasdasdsdasdasd',1,81),(1,'sdfsdfsdfsdfsdfsdfsd',1,81),(1,'dsaasddasd',1,81),(1,'asdasdasdsd',1,81),(1,'asdasdasdasdas',1,81),(1,'sdasdasdasdasdsdasd',1,81);
/*!40000 ALTER TABLE `expositionnote` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `expositionquestion`
--

DROP TABLE IF EXISTS `expositionquestion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `expositionquestion` (
  `expositionid` int(11) NOT NULL,
  `question` text NOT NULL,
  `slide` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `questiondate` datetime NOT NULL,
  KEY `FK_expositionquestion_exposition` (`expositionid`),
  KEY `FK_expositionquestion_systemuser` (`userid`),
  CONSTRAINT `FK_expositionquestion_exposition` FOREIGN KEY (`expositionid`) REFERENCES `exposition` (`id`),
  CONSTRAINT `FK_expositionquestion_systemuser` FOREIGN KEY (`userid`) REFERENCES `systemuser` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expositionquestion`
--

LOCK TABLES `expositionquestion` WRITE;
/*!40000 ALTER TABLE `expositionquestion` DISABLE KEYS */;
INSERT INTO `expositionquestion` VALUES (1,'test',1,81,'2013-04-06 18:18:41'),(1,'asdasdasda',1,81,'2013-04-06 18:20:16');
/*!40000 ALTER TABLE `expositionquestion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `expositionslide`
--

DROP TABLE IF EXISTS `expositionslide`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `expositionslide` (
  `expositionid` int(10) NOT NULL DEFAULT '0',
  `slideid` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`expositionid`,`slideid`),
  CONSTRAINT `FK__exposition` FOREIGN KEY (`expositionid`) REFERENCES `exposition` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expositionslide`
--

LOCK TABLES `expositionslide` WRITE;
/*!40000 ALTER TABLE `expositionslide` DISABLE KEYS */;
INSERT INTO `expositionslide` VALUES (1,1),(2,1),(3,1);
/*!40000 ALTER TABLE `expositionslide` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `language`
--

DROP TABLE IF EXISTS `language`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lang_name` varchar(50) NOT NULL,
  `lang_iso` varchar(2) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UQ_language_lang_name` (`lang_name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `language`
--

LOCK TABLES `language` WRITE;
/*!40000 ALTER TABLE `language` DISABLE KEYS */;
INSERT INTO `language` VALUES (1,'Español','es'),(2,'English','en');
/*!40000 ALTER TABLE `language` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `literal`
--

DROP TABLE IF EXISTS `literal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `literal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lit_key` varchar(50) NOT NULL,
  `lit_text` text NOT NULL,
  `lit_lang` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lit_key_lit_lang` (`lit_key`,`lit_lang`),
  KEY `FK_literal_language` (`lit_lang`),
  CONSTRAINT `FK_literal_language` FOREIGN KEY (`lit_lang`) REFERENCES `language` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=192 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `literal`
--

LOCK TABLES `literal` WRITE;
/*!40000 ALTER TABLE `literal` DISABLE KEYS */;
INSERT INTO `literal` VALUES (37,'user','Usuario',1),(38,'password','Contraseña',1),(39,'login','Ingresar',1),(40,'locale_code','es',1),(41,'date_format_long','%d de %B de %Y',1),(42,'site_header_title','PPT Vivo!',1),(43,'site_header_motto','Presentaciones On Line',1),(44,'document','Documento',1),(45,'upload','Subir',1),(46,'maxuploadfilesize','Tamaño máximo de archivo',1),(47,'complete_mandatory_fields','Complete los campos obligatorios',1),(48,'error','Error',1),(49,'back','Volver',1),(50,'import','Importar',1),(51,'no_results_found','No se encontraron resultados',1),(52,'filters','Filtros',1),(53,'filter_apply','Aplicar',1),(54,'clear','Limpiar',1),(55,'date_format','d/m/Y',1),(56,'next','Siguente',1),(57,'previous','Anterior',1),(58,'export','Exportar',1),(59,'date_between','Fecha entre',1),(60,'date_format_js','dd/mm/yy',1),(61,'state','Estado',1),(62,'select_an_option','Seleccione una opción',1),(63,'pending','Pendiente',1),(64,'closed','Cerrado',1),(65,'cancelled','Baja',1),(66,'error_field_max_length','El valor del campo excede el máximo de caracteres permitidos',1),(67,'error_numeric_length','Debe ingresar sólo números',1),(68,'error_mail_format','Formato de e-mail incorrecto',1),(69,'phone_wrong_format','Formato de teléfono incorrecto',1),(70,'passwords_match_error','Las contraseñas no coinciden',1),(71,'logout','Salir',1),(73,'user','User',2),(74,'password','Password',2),(75,'login','Login',2),(76,'locale_code','en',2),(77,'date_format_long','%B, the %d of %Y',2),(78,'site_header_title','PPT Vivo!',2),(79,'site_header_motto','On-Line Presentations',2),(80,'document','Document',2),(81,'upload','Upload',2),(82,'maxuploadfilesize','Upload file max size',2),(83,'complete_mandatory_fields','Complete mandatory fields',2),(84,'error','Error',2),(85,'back','Back',2),(86,'import','Import',2),(87,'no_results_found','No results found',2),(88,'filters','Filters',2),(89,'filter_apply','Apply',2),(90,'clear','Clear',2),(91,'date_format','m/d/Y',2),(92,'next','Next',2),(93,'previous','Previous',2),(94,'export','Export',2),(95,'date_between','Date between',2),(96,'date_format_js','mm/dd/yy',2),(97,'state','State',2),(98,'select_an_option','Select an option',2),(99,'pending','Pending',2),(100,'closed','Closed',2),(101,'cancelled','Cancelled',2),(102,'error_field_max_length','Field value exceds the maximum length allowed',2),(103,'error_numeric_length','Only numbers allowed',2),(104,'error_mail_format','Wrong e-mail format',2),(105,'phone_wrong_format','Wrong phone format',2),(106,'passwords_match_error','Passwords doesn\'t match',2),(107,'logout','Logout',2),(108,'login_form_literal','PPT Vivo! Login',2),(109,'register','Sign up',2),(110,'name','Name',2),(111,'surname','Surname',2),(112,'email','E-mail',2),(113,'repeat_password','Repeat',2),(114,'plan','Plan',2),(115,'send','Send',2),(116,'register_user','Sign up',2),(117,'error_inserting_user','Error inserting user. Please, verify your data',2),(118,'error_updating_user','Error updating user. Please, verify your data',2),(119,'username_already_exists','Username already exists',2),(120,'user_activate_success','User has been successfully activated. You may now login.',2),(121,'user_activate_error','User has not been activated. Please contact system administrator',2),(122,'login_error_user_not_found','User not found or user hasn\'t been activated',2),(123,'login_error_password_incorrect','Password incorrect',2),(124,'register_user_success','You have been successfully registered. Now you will receive an e-mail with the account activation instructions.',2),(125,'email_already_exists','E-mail is already in use. Please select another',2),(126,'or_login_with','Login with',2),(127,'twitter_url_error','Error accesing the Twitter login site',2),(128,'facebook_login_error','There was an error getting user information',2),(129,'register_question','Doesn\'t have an account?',2),(130,'forgot_your_password','Forgot your password?',2),(131,'forgot_password_header','Enter your email address. A link will be sent to you in order to restore your password.',2),(132,'forgot_password_request_success','Mail has been sent.',2),(133,'email_nonexistent','Doesn\'t exist a user with the requested e-mail',2),(134,'reset_password_header','Use this form to reset your password',2),(135,'user_nonexistent','The user doesn\'t exist',2),(136,'error_reset_password','There was an error resetting user password. Please try again later.',2),(137,'success_reset_password','Password updated successfully',2),(138,'error_creating_user_folder','User folder couldn\'t be created',2),(139,'open','Open',2),(140,'delete','Delete',2),(141,'preview_not_available','Preview not available',2),(142,'error_deleting_presentation','Error deleting presentation',2),(143,'confirm_delete_presentation','Do you wish to delete the presentation?',2),(144,'error_deleting_exposition_notes','Error deleting exposition notes',2),(145,'error_deleting_exposition_questions','Error deleting exposition questions',2),(146,'error_deleting_exposition','Error deleting exposition',2),(147,'error_deleting_presentation_folder','Error removing presentation folder',2),(148,'error_deleting_file','Error deleting file',2),(149,'error_creating_presentation_folder','Error creating presentation folder',2),(150,'error_copying_file','Error copying file',2),(151,'upload_file_error','Error uploading file',2),(152,'error_inserting_presentation','Error inserting presentation',2),(153,'file_nonexistent','File doesn\'t exist',2),(154,'error_creating_presentation','Error al crear la presentacion. Verifique los datos enviados. Mensaje recibido:',2),(155,'add_presentation','Add presentation',2),(156,'title','Title',2),(157,'description','Description',2),(158,'file','File',2),(159,'created','Created',2),(160,'error_deleting_exposition_attendants','Error deleting exposition attendants',2),(161,'attendances','Attendances',2),(162,'attendance_comments','Attendance Comments',2),(163,'slide','Slide',2),(164,'note','Note',2),(165,'confirm_delete_attendance','Do you wish to delete the attendance?',2),(166,'detail','Detail',2),(167,'exposures_of','Exposures of',2),(168,'attendants','Attendants',2),(169,'no_attendants','No attendants',2),(170,'presentation_url','Presentation URL',2),(171,'create_exposition','Create exposition',2),(172,'error_inserting_exposition','Error inserting exposition',2),(173,'invalid_presentation_url','Invalid presentation URL',2),(174,'error_inserting_exposition_note','Error inserting exposition nore',2),(175,'add_note','Add note',2),(176,'error_inserting_exposition_attendance','Error inserting exposition attendance',2),(177,'error_inserting_exposition_question','Error inserting exposition note',2),(178,'add_question','Add question',2),(179,'question_successfully_sent','Question succesfully sent',2),(180,'questions','Questions',2),(181,'question','Question',2),(182,'no_questions','No questions',2),(183,'share','Share',2),(184,'see_public_presentation','No thanks, just take me to the presentation!',2),(185,'error_deleting_exposition_slide','Error deleting exposition slide',2),(186,'info','Information',2),(187,'join','Join',2),(188,'no_script_message','Your browser doesn\'t suport scripts',2),(189,'usertype','User type',2),(190,'update_account_success','User account data successfully updated',2),(191,'qr_code_text','Use this QR code to redirect to your presentation viewer.',2);
/*!40000 ALTER TABLE `literal` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `literalchange_insert` AFTER INSERT ON `literal` FOR EACH ROW BEGIN
INSERT INTO literalchanges SET languageid = NEW.lit_lang ;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `literalchange_update` AFTER UPDATE ON `literal` FOR EACH ROW BEGIN
INSERT INTO literalchanges SET languageid = NEW.lit_lang;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `literalchange_delete` BEFORE DELETE ON `literal` FOR EACH ROW BEGIN
INSERT INTO literalchanges SET languageid = OLD.lit_lang;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `literalchanges`
--

DROP TABLE IF EXISTS `literalchanges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `literalchanges` (
  `idliteralchanges` int(11) NOT NULL AUTO_INCREMENT,
  `languageid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idliteralchanges`),
  KEY `FK_literalchanges_language` (`languageid`),
  CONSTRAINT `FK_literalchanges_language` FOREIGN KEY (`languageid`) REFERENCES `language` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `literalchanges`
--

LOCK TABLES `literalchanges` WRITE;
/*!40000 ALTER TABLE `literalchanges` DISABLE KEYS */;
INSERT INTO `literalchanges` VALUES (1,2),(2,2),(3,2),(4,2),(5,2),(6,2),(7,2),(8,2),(9,2),(10,2),(11,2),(12,2),(13,2),(14,2),(15,2),(16,2),(17,2),(18,2),(19,2),(20,2),(21,2),(22,2),(23,2),(24,2),(25,2),(26,2),(27,2),(28,2),(29,2),(30,2),(31,2),(32,2),(33,2),(34,2),(35,2),(36,2),(37,2),(38,2),(39,2),(40,2),(41,2),(42,2),(43,2),(44,2),(45,2),(46,2),(47,2),(48,2),(49,2),(50,2),(51,2),(52,2),(53,2),(54,2),(55,2),(56,2),(57,2),(58,2);
/*!40000 ALTER TABLE `literalchanges` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `logintype`
--

DROP TABLE IF EXISTS `logintype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `logintype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logintype`
--

LOCK TABLES `logintype` WRITE;
/*!40000 ALTER TABLE `logintype` DISABLE KEYS */;
INSERT INTO `logintype` VALUES (1,'native'),(2,'facebook'),(3,'twitter');
/*!40000 ALTER TABLE `logintype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mailtemplate`
--

DROP TABLE IF EXISTS `mailtemplate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mailtemplate` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `template` varchar(100) NOT NULL,
  `subject` text NOT NULL,
  `body` text NOT NULL,
  `languageid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_mailtemplate_language` (`languageid`),
  CONSTRAINT `FK_mailtemplate_language` FOREIGN KEY (`languageid`) REFERENCES `language` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mailtemplate`
--

LOCK TABLES `mailtemplate` WRITE;
/*!40000 ALTER TABLE `mailtemplate` DISABLE KEYS */;
INSERT INTO `mailtemplate` VALUES (1,'activate_account','Activate your account in PPT Vivo!','<p>Dear %s,</p>\r\n\r\n<p>\r\nThanks for registering in PPT Vivo!. In order to activate your account, please click in the link below:\r\n<br />\r\n<a href=\"%s\">%s</a>\r\n<br /><br />\r\nYour user name is <strong>%s</strong>\r\n</p>\r\n\r\n<p>\r\nBest regards,\r\n<br />\r\nPPT Vivo! Team\r\n</p>',2),(2,'restore_password','Restore password link for PPT Vivo!','<p>Dear %s,</p>\r\n\r\n<p>\r\nClick in the link below to restore your password:\r\n<br />\r\n<a href=\"%s\">%s</a>\r\n</p>\r\n\r\n<p>\r\nBest regards,\r\n<br />\r\nPPT Vivo! Team\r\n</p>',2);
/*!40000 ALTER TABLE `mailtemplate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu`
--

DROP TABLE IF EXISTS `menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menukey` varchar(50) NOT NULL,
  `parentid` int(11) DEFAULT NULL,
  `menulevel` int(11) NOT NULL,
  `menuorder` int(11) NOT NULL,
  `moduleid` int(11) DEFAULT NULL,
  `visible` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UQ_menu_menukey` (`menukey`),
  KEY `FK_menu_menu` (`parentid`),
  KEY `FK_menu_module` (`moduleid`),
  CONSTRAINT `FK_menu_menu` FOREIGN KEY (`parentid`) REFERENCES `menu` (`id`),
  CONSTRAINT `FK_menu_module` FOREIGN KEY (`moduleid`) REFERENCES `module` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu`
--

LOCK TABLES `menu` WRITE;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
INSERT INTO `menu` VALUES (1,'home',NULL,0,0,NULL,0),(2,'404',NULL,0,0,NULL,0),(3,'401',NULL,0,0,NULL,0),(4,'users',NULL,0,0,1,0),(5,'presentations',NULL,0,30,2,1),(6,'attendances',NULL,0,40,2,1),(7,'create_presentation',NULL,0,0,2,0),(8,'account_options',NULL,0,20,1,1),(9,'presentation_options',NULL,0,60,1,1),(10,'account_analytics',NULL,0,50,1,1),(11,'account_detail',NULL,0,10,1,1);
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu_translation`
--

DROP TABLE IF EXISTS `menu_translation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu_translation` (
  `menuid` int(11) NOT NULL,
  `languageid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text,
  PRIMARY KEY (`menuid`,`languageid`),
  KEY `FK_menu_translation_language` (`languageid`),
  CONSTRAINT `FK_menu_translation_language` FOREIGN KEY (`languageid`) REFERENCES `language` (`id`),
  CONSTRAINT `FK_menu_translation_menu` FOREIGN KEY (`menuid`) REFERENCES `menu` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_translation`
--

LOCK TABLES `menu_translation` WRITE;
/*!40000 ALTER TABLE `menu_translation` DISABLE KEYS */;
INSERT INTO `menu_translation` VALUES (1,2,'Home',NULL),(2,2,'404',NULL),(3,2,'401',NULL),(4,2,'Users','Users management'),(5,2,'Presentations','Presentations Management'),(6,2,'My Attendances',NULL),(7,2,'Create Presentation',NULL),(8,2,'Account Options',NULL),(9,2,'Presentation Options',NULL),(10,2,'Analytics',NULL),(11,2,'User Profile',NULL);
/*!40000 ALTER TABLE `menu_translation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `module`
--

DROP TABLE IF EXISTS `module`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `modulename` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `module`
--

LOCK TABLES `module` WRITE;
/*!40000 ALTER TABLE `module` DISABLE KEYS */;
INSERT INTO `module` VALUES (1,'users'),(2,'presentations');
/*!40000 ALTER TABLE `module` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parameters`
--

DROP TABLE IF EXISTS `parameters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `parameters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `paramname` varchar(100) NOT NULL,
  `paramvalue` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UQ_parameters_paramname` (`paramname`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parameters`
--

LOCK TABLES `parameters` WRITE;
/*!40000 ALTER TABLE `parameters` DISABLE KEYS */;
INSERT INTO `parameters` VALUES (1,'site_title','PPT Vivo!'),(2,'menu_split_level_1','2'),(3,'page_size','4'),(4,'login_form_literal','login_form_literal'),(5,'mail_from','info@pptvivo.com.ar'),(6,'mail_from_name','PPT Vivo!'),(7,'facebook_login','1'),(8,'twitter_login','1'),(9,'social_networks_login','1'),(10,'pager_max_pages','10'),(11,'player_url','http://viewer-dev.pptvivo.com/');
/*!40000 ALTER TABLE `parameters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plan`
--

DROP TABLE IF EXISTS `plan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `plan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `filesize` varchar(10) NOT NULL,
  `diskquota` varchar(10) NOT NULL,
  `plugin` tinyint(1) NOT NULL DEFAULT '1',
  `privatesharing` tinyint(1) NOT NULL DEFAULT '1',
  `advertisings` tinyint(1) NOT NULL DEFAULT '0',
  `slidenavigation` tinyint(1) NOT NULL DEFAULT '1',
  `allowquestions` tinyint(1) NOT NULL DEFAULT '1',
  `allowdownloads` tinyint(1) NOT NULL DEFAULT '1',
  `socialnetworksharing` tinyint(1) NOT NULL DEFAULT '1',
  `feedback` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plan`
--

LOCK TABLES `plan` WRITE;
/*!40000 ALTER TABLE `plan` DISABLE KEYS */;
INSERT INTO `plan` VALUES (1,'Basic','20MB','2GB',1,1,1,0,0,0,0,0),(2,'Silver','100MB','50GB',1,1,0,1,1,1,1,1),(3,'Gold','300MB','100GB',1,1,0,1,1,1,1,1);
/*!40000 ALTER TABLE `plan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `presentation`
--

DROP TABLE IF EXISTS `presentation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `presentation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL,
  `description` text,
  `filename` varchar(255) NOT NULL,
  `userid` int(11) NOT NULL,
  `creationdate` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_presentation_systemuser` (`userid`),
  CONSTRAINT `FK_presentation_systemuser` FOREIGN KEY (`userid`) REFERENCES `systemuser` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `presentation`
--

LOCK TABLES `presentation` WRITE;
/*!40000 ALTER TABLE `presentation` DISABLE KEYS */;
INSERT INTO `presentation` VALUES (1,'Test','Test','INCREIBLE_LO_QUE_CURA.ppt',81,'2013-04-06');
/*!40000 ALTER TABLE `presentation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `systemuser`
--

DROP TABLE IF EXISTS `systemuser`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `systemuser` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userlogin` varchar(50) DEFAULT NULL,
  `userpassword` varchar(255) DEFAULT NULL,
  `usertypeid` int(11) DEFAULT NULL,
  `useremail` varchar(255) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `usersurname` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_systemuser_usertype` (`usertypeid`),
  CONSTRAINT `FK_systemuser_usertype` FOREIGN KEY (`usertypeid`) REFERENCES `usertype` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `systemuser`
--

LOCK TABLES `systemuser` WRITE;
/*!40000 ALTER TABLE `systemuser` DISABLE KEYS */;
INSERT INTO `systemuser` VALUES (1,'pptvivo_public_attendant','$1$Ro3.3p2.$FOtVlOYuifpfGxDu3vrYx0',2,NULL,'Public',NULL),(81,'gabo','$1$aE5.Qv4.$vIsf8qJk2PueFfrHSNgp1/',2,'gaboguzman@gmail.com','Gabriel2','Guzm&aacute;n2');
/*!40000 ALTER TABLE `systemuser` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `urlmapping`
--

DROP TABLE IF EXISTS `urlmapping`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `urlmapping` (
  `url` varchar(255) NOT NULL,
  `menuid` int(11) NOT NULL,
  `languageid` int(11) NOT NULL,
  PRIMARY KEY (`url`,`menuid`,`languageid`),
  UNIQUE KEY `UQ_urlmapping_url` (`url`),
  KEY `FK_urlmapping_menu` (`menuid`),
  KEY `FK_urlmapping_language` (`languageid`),
  CONSTRAINT `FK_urlmapping_language` FOREIGN KEY (`languageid`) REFERENCES `language` (`id`),
  CONSTRAINT `FK_urlmapping_menu` FOREIGN KEY (`menuid`) REFERENCES `menu` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `urlmapping`
--

LOCK TABLES `urlmapping` WRITE;
/*!40000 ALTER TABLE `urlmapping` DISABLE KEYS */;
INSERT INTO `urlmapping` VALUES ('home',1,2),('404',2,2),('401',3,2),('users',4,2),('presentations',5,2),('presentations?action=viewAttendances&loginRequired=1',6,2),('presentations?action=createPresentation&loginRequired=1',7,2),('users?action=accountOptions',8,2),('users?action=presentationOptions',9,2),('users?action=accountAnalytics',10,2),('users?action=accountDetail',11,2);
/*!40000 ALTER TABLE `urlmapping` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `userdata`
--

DROP TABLE IF EXISTS `userdata`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userdata` (
  `userid` int(11) NOT NULL,
  `planid` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  UNIQUE KEY `userid` (`userid`),
  KEY `FK_userdata_plan` (`planid`),
  CONSTRAINT `FK_userdata_plan` FOREIGN KEY (`planid`) REFERENCES `plan` (`id`),
  CONSTRAINT `FK_userdata_systemuser` FOREIGN KEY (`userid`) REFERENCES `systemuser` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userdata`
--

LOCK TABLES `userdata` WRITE;
/*!40000 ALTER TABLE `userdata` DISABLE KEYS */;
INSERT INTO `userdata` VALUES (1,3,1),(81,3,1);
/*!40000 ALTER TABLE `userdata` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `userlogintype`
--

DROP TABLE IF EXISTS `userlogintype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userlogintype` (
  `userid` int(11) NOT NULL,
  `logintypeid` int(11) NOT NULL,
  `oauthid` bigint(20) DEFAULT NULL,
  KEY `FK_userlogintype_systemuser` (`userid`),
  KEY `FK_userlogintype_logintype` (`logintypeid`),
  CONSTRAINT `FK_userlogintype_logintype` FOREIGN KEY (`logintypeid`) REFERENCES `logintype` (`id`),
  CONSTRAINT `FK_userlogintype_systemuser` FOREIGN KEY (`userid`) REFERENCES `systemuser` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userlogintype`
--

LOCK TABLES `userlogintype` WRITE;
/*!40000 ALTER TABLE `userlogintype` DISABLE KEYS */;
INSERT INTO `userlogintype` VALUES (1,1,NULL),(81,1,NULL);
/*!40000 ALTER TABLE `userlogintype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usertype`
--

DROP TABLE IF EXISTS `usertype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usertype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `typename` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UQ_usertype_typename` (`typename`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usertype`
--

LOCK TABLES `usertype` WRITE;
/*!40000 ALTER TABLE `usertype` DISABLE KEYS */;
INSERT INTO `usertype` VALUES (1,'Administrator'),(2,'User');
/*!40000 ALTER TABLE `usertype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usertypeaccess`
--

DROP TABLE IF EXISTS `usertypeaccess`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usertypeaccess` (
  `usertypeid` int(11) DEFAULT NULL,
  `menuid` int(11) NOT NULL,
  KEY `FK_usertypeaccess_usertype` (`usertypeid`),
  KEY `FK_usertypeaccess_menu` (`menuid`),
  CONSTRAINT `FK_usertypeaccess_menu` FOREIGN KEY (`menuid`) REFERENCES `menu` (`id`),
  CONSTRAINT `FK_usertypeaccess_usertype` FOREIGN KEY (`usertypeid`) REFERENCES `usertype` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usertypeaccess`
--

LOCK TABLES `usertypeaccess` WRITE;
/*!40000 ALTER TABLE `usertypeaccess` DISABLE KEYS */;
INSERT INTO `usertypeaccess` VALUES (1,1),(NULL,4),(NULL,2),(NULL,3),(2,1),(2,5),(1,5),(1,6),(2,6),(1,7),(2,7),(1,8),(2,8),(1,9),(2,9),(1,10),(2,10),(1,11),(2,11);
/*!40000 ALTER TABLE `usertypeaccess` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'pptvivo'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-04-14 21:17:39
