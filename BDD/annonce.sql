/*
SQLyog Community v12.16 (32 bit)
MySQL - 5.7.26 : Database - annonces
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`annonces` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `annonces`;

/*Table structure for table `annonce` */

DROP TABLE IF EXISTS `annonce`;

CREATE TABLE `annonce` (
  `ID_ANNONCE` int(11) NOT NULL AUTO_INCREMENT,
  `ID_RUBRIQUE` int(11) NOT NULL,
  `ID_UTILISATEUR` int(11) NOT NULL,
  `ENTETE` varchar(128) NOT NULL,
  `CORPS` text,
  `DATE_DEPOT` date NOT NULL,
  `DATE_VALIDITE` date DEFAULT NULL,
  PRIMARY KEY (`ID_ANNONCE`),
  KEY `I_FK_ANNONCE_RUBRIQUE` (`ID_RUBRIQUE`),
  KEY `I_FK_ANNONCE_UTILISATEUR` (`ID_UTILISATEUR`),
  CONSTRAINT `annonce_ibfk_1` FOREIGN KEY (`ID_RUBRIQUE`) REFERENCES `rubrique` (`ID_RUBRIQUE`),
  CONSTRAINT `annonce_ibfk_2` FOREIGN KEY (`ID_UTILISATEUR`) REFERENCES `utilisateur` (`ID_UTILISATEUR`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Table structure for table `image` */

DROP TABLE IF EXISTS `image`;

CREATE TABLE `image` (
  `ID_IMAGE` int(11) NOT NULL AUTO_INCREMENT,
  `ID_ANNONCE` int(11) NOT NULL,
  `CHEMIN` varchar(128) NOT NULL,
  PRIMARY KEY (`ID_IMAGE`),
  KEY `I_FK_IMAGE_ANNONCE` (`ID_ANNONCE`),
  CONSTRAINT `image_ibfk_1` FOREIGN KEY (`ID_ANNONCE`) REFERENCES `annonce` (`ID_ANNONCE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `parametre` */

DROP TABLE IF EXISTS `parametre`;

CREATE TABLE `parametre` (
  `DUREE_VALIDITE` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `rubrique` */

DROP TABLE IF EXISTS `rubrique`;

CREATE TABLE `rubrique` (
  `ID_RUBRIQUE` int(11) NOT NULL AUTO_INCREMENT,
  `LIBELLE` varchar(128) NOT NULL,
  PRIMARY KEY (`ID_RUBRIQUE`),
  UNIQUE KEY `LIBELLE` (`LIBELLE`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Table structure for table `utilisateur` */

DROP TABLE IF EXISTS `utilisateur`;

CREATE TABLE `utilisateur` (
  `ID_UTILISATEUR` int(11) NOT NULL AUTO_INCREMENT,
  `NOM` char(32) NOT NULL,
  `PRENOM` char(32) NOT NULL,
  `EMAIL` varchar(128) NOT NULL,
  `USERNAME` char(32) NOT NULL,
  `MDP` varchar(128) NOT NULL,
  `ADMIN` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID_UTILISATEUR`),
  UNIQUE KEY `EMAIL` (`EMAIL`),
  UNIQUE KEY `USERNAME` (`USERNAME`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/* Trigger structure for table `annonce` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `default_date_depot` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `default_date_depot` BEFORE INSERT ON `annonce` FOR EACH ROW BEGIN
	SET new.DATE_DEPOT = CURDATE();
END */$$


DELIMITER ;

/* Trigger structure for table `annonce` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `default_date_validite` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `default_date_validite` BEFORE INSERT ON `annonce` FOR EACH ROW BEGIN
	IF new.DATE_VALIDITE <  new.DATE_DEPOT OR new.DATE_VALIDITE IS NULL THEN
		SET new.DATE_VALIDITE = DATE_ADD(CURDATE(),INTERVAL 4 WEEK);
	END IF;
END */$$


DELIMITER ;

/* Trigger structure for table `utilisateur` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `password_hash` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `password_hash` BEFORE INSERT ON `utilisateur` FOR EACH ROW BEGIN
	SET new.MDP = SHA1(new.MDP);
END */$$


DELIMITER ;

/* Procedure structure for procedure `insert_annonce` */

/*!50003 DROP PROCEDURE IF EXISTS  `insert_annonce` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_annonce`(id_rubrique INT,id_utilisateur INT,entete VARCHAR(128),corps TEXT,date_validite DATE)
BEGIN
	INSERT INTO ANNONCE(ANNONCE.ID_RUBRIQUE,ANNONCE.ID_UTILISATEUR,ANNONCE.ENTETE,ANNONCE.CORPS,ANNONCE.DATE_VALIDITE)
	VALUES (id_rubrique,id_utilisateur,entete,corps,date_validite);
END */$$
DELIMITER ;

/* Procedure structure for procedure `insert_rubrique` */

/*!50003 DROP PROCEDURE IF EXISTS  `insert_rubrique` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_rubrique`(libelle VARCHAR(128))
BEGIN
	INSERT INTO RUBRIQUE(RUBRIQUE.LIBELLE)
	VALUES (libelle);
END */$$
DELIMITER ;

/* Procedure structure for procedure `insert_utilisateur` */

/*!50003 DROP PROCEDURE IF EXISTS  `insert_utilisateur` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_utilisateur`(nom CHAR(32),prenom CHAR(32),email VARCHAR(128),username CHAR(32),mdp VARCHAR(128),admin TINYINT(1))
BEGIN
	INSERT INTO UTILISATEUR(UTILISATEUR.NOM,UTILISATEUR.PRENOM,UTILISATEUR.EMAIL,UTILISATEUR.USERNAME,UTILISATEUR.MDP,UTILISATEUR.ADMIN)
	VALUES (nom,prenom,email,username,mdp,admin);
END */$$
DELIMITER ;

/*Table structure for table `annonce_simple` */

DROP TABLE IF EXISTS `annonce_simple`;

/*!50001 DROP VIEW IF EXISTS `annonce_simple` */;
/*!50001 DROP TABLE IF EXISTS `annonce_simple` */;

/*!50001 CREATE TABLE  `annonce_simple`(
 `USERNAME` char(32) ,
 `ENTETE` varchar(128) ,
 `DATE_VALIDITE` date 
)*/;

/*View structure for view annonce_simple */

/*!50001 DROP TABLE IF EXISTS `annonce_simple` */;
/*!50001 DROP VIEW IF EXISTS `annonce_simple` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `annonce_simple` AS select `utilisateur`.`USERNAME` AS `USERNAME`,`annonce`.`ENTETE` AS `ENTETE`,`annonce`.`DATE_VALIDITE` AS `DATE_VALIDITE` from (`annonce` join `utilisateur` on((`annonce`.`ID_UTILISATEUR` = `utilisateur`.`ID_UTILISATEUR`))) */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
