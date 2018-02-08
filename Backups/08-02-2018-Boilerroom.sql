/*
SQLyog Ultimate v12.09 (64 bit)
MySQL - 5.7.19 : Database - boilerroomapp
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`boilerroomapp` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `boilerroomapp`;

/*Table structure for table `bmc` */

DROP TABLE IF EXISTS `bmc`;

CREATE TABLE `bmc` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `bmc` */

/*Table structure for table `canvasentries` */

DROP TABLE IF EXISTS `canvasentries`;

CREATE TABLE `canvasentries` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `canvastype` varchar(255) DEFAULT NULL,
  `userID` int(11) DEFAULT NULL,
  `canvasID` int(11) DEFAULT NULL,
  `ideaID` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `canvasentries` */

/*Table structure for table `cardcollections` */

DROP TABLE IF EXISTS `cardcollections`;

CREATE TABLE `cardcollections` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `collectionName` varchar(255) NOT NULL,
  `ideaID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `creationDate` date NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `cardcollections` */

insert  into `cardcollections`(`ID`,`collectionName`,`ideaID`,`userID`,`creationDate`) values (6,'Another Collection',3,147,'2018-02-08'),(5,'First Collection',3,147,'2018-02-08');

/*Table structure for table `cards` */

DROP TABLE IF EXISTS `cards`;

CREATE TABLE `cards` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `cardName` varchar(255) NOT NULL,
  `ideaID` int(11) NOT NULL,
  `cardCollectionID` int(11) NOT NULL,
  `creationDate` date DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `cards` */

insert  into `cards`(`ID`,`cardName`,`ideaID`,`cardCollectionID`,`creationDate`) values (3,'first collectoin card',3,5,'2018-02-08'),(4,'Another collection card',3,6,'2018-02-08');

/*Table structure for table `ideaaccess` */

DROP TABLE IF EXISTS `ideaaccess`;

CREATE TABLE `ideaaccess` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ideaID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `ideaaccess` */

insert  into `ideaaccess`(`ID`,`ideaID`,`userID`) values (5,3,147);

/*Table structure for table `ideas` */

DROP TABLE IF EXISTS `ideas`;

CREATE TABLE `ideas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ideaName` varchar(255) NOT NULL,
  `ownerID` int(11) NOT NULL,
  `category` varchar(255) DEFAULT NULL,
  `creationDate` date NOT NULL,
  `shortDescription` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `ideas` */

insert  into `ideas`(`ID`,`ideaName`,`ownerID`,`category`,`creationDate`,`shortDescription`) values (3,'A new flowershop',147,'','2018-02-07','tes');

/*Table structure for table `teamaccess` */

DROP TABLE IF EXISTS `teamaccess`;

CREATE TABLE `teamaccess` (
  `ID` int(3) NOT NULL AUTO_INCREMENT,
  `teamID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `teamaccess` */

/*Table structure for table `teamideas` */

DROP TABLE IF EXISTS `teamideas`;

CREATE TABLE `teamideas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `teamID` int(11) NOT NULL,
  `ideaID` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `teamideas` */

insert  into `teamideas`(`ID`,`teamID`,`ideaID`) values (1,1,44),(2,3,41),(3,3,42),(4,4,38);

/*Table structure for table `teams` */

DROP TABLE IF EXISTS `teams`;

CREATE TABLE `teams` (
  `ID` int(3) NOT NULL AUTO_INCREMENT,
  `teamName` text NOT NULL,
  `teamOwnerID` int(11) NOT NULL,
  `creationDate` date NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

/*Data for the table `teams` */

insert  into `teams`(`ID`,`teamName`,`teamOwnerID`,`creationDate`) values (10,'new taem',147,'2018-02-08'),(9,'BLiS Digital',147,'2018-02-08');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `ID` int(3) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(320) NOT NULL,
  `password` varchar(255) NOT NULL,
  `isActivated` tinyint(1) NOT NULL,
  `hash` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=148 DEFAULT CHARSET=latin1;

/*Data for the table `users` */

insert  into `users`(`ID`,`firstName`,`lastName`,`username`,`email`,`password`,`isActivated`,`hash`) values (147,'Geert','van Drunen','GeertvanDrunen93','geert_van_drunen@live.nl','$2y$09$BYV8.wYPHWHTJlfF9d1kaugZYk44tMJWSfBFKBsvh4H2QzrWokda.',1,'42a0e188f5033bc65bf8d78622277c4e');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
