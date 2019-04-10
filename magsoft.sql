/*
SQLyog Community v13.0.1 (32 bit)
MySQL - 5.6.24 : Database - magsoft
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`magsoft` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `magsoft`;

/*Table structure for table `article` */

DROP TABLE IF EXISTS `article`;

CREATE TABLE `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `contenu` text NOT NULL,
  `date` datetime NOT NULL,
  `categorie_id` int(11) NOT NULL,
  `image1` varchar(200) NOT NULL,
  `image2` varchar(200) NOT NULL DEFAULT 'nada',
  `image3` varchar(200) NOT NULL DEFAULT 'nada',
  `image4` varchar(200) NOT NULL DEFAULT 'nada',
  `image5` varchar(200) NOT NULL DEFAULT 'nada',
  PRIMARY KEY (`id`),
  KEY `cat_art` (`categorie_id`),
  CONSTRAINT `cat_art` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `article` */

/*Table structure for table `categorie` */

DROP TABLE IF EXISTS `categorie`;

CREATE TABLE `categorie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(100) NOT NULL,
  `description` varchar(500) DEFAULT '-',
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `categorie` */

/*Table structure for table `country` */

DROP TABLE IF EXISTS `country`;

CREATE TABLE `country` (
  `code` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `population` int(11) NOT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `country` */

/*Table structure for table `menu` */

DROP TABLE IF EXISTS `menu`;

CREATE TABLE `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(100) NOT NULL,
  `lien` varchar(255) DEFAULT NULL,
  `description` text,
  `statut` int(2) DEFAULT '1',
  `date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

/*Data for the table `menu` */

insert  into `menu`(`id`,`libelle`,`lien`,`description`,`statut`,`date`) values 
(1,'Tableau de bord','statistique/index','Statistiques générale',1,'2019-03-30'),
(2,'Utilisateur','','Gestions des utilisateurs',1,'2019-03-31'),
(3,'Client','','Gestion des clients',1,NULL),
(4,'Niveau d\'accès','','Gestion des droits',1,NULL),
(9,'Personnel','','Gestion des personnels',1,NULL),
(10,'Produit','','Gestion des produits',1,NULL),
(11,'Stock','','Gestion du stock',1,NULL),
(12,'Charge','','Gestion des charges du magasin',1,NULL),
(13,'Statistiques','','Statistiques et bilan',1,NULL),
(14,'Menu','','Gestiion des menus',1,NULL),
(15,'Sous menu','','Gestion des sous menus',1,NULL),
(16,'Profile','','Gestion des profiles utilisateurs',1,NULL);

/*Table structure for table `migration` */

DROP TABLE IF EXISTS `migration`;

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `migration` */

/*Table structure for table `newsletter` */

DROP TABLE IF EXISTS `newsletter`;

CREATE TABLE `newsletter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `statut` int(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `newsletter` */

/*Table structure for table `profile` */

DROP TABLE IF EXISTS `profile`;

CREATE TABLE `profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `designation` varchar(255) NOT NULL,
  `droit` text,
  `date` date NOT NULL,
  `description` text,
  `userId` int(11) NOT NULL,
  `statut` int(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`),
  CONSTRAINT `profile_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `profile` */

insert  into `profile`(`id`,`designation`,`droit`,`date`,`description`,`userId`,`statut`) values 
(1,'Comptable',NULL,'0000-00-00','Doit sur les mouvements par rapport au finance ',1,1),
(2,'Direction',NULL,'0000-00-00','Droit général sur l\' application ',1,1),
(3,'Magasinier',NULL,'0000-00-00','Droit au mouvement des articles par rapport à la quantité',1,1),
(4,'commerciaux',NULL,'0000-00-00','Droit aux commerciaux',1,2);

/*Table structure for table `sous_menu` */

DROP TABLE IF EXISTS `sous_menu`;

CREATE TABLE `sous_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(200) NOT NULL,
  `lien` varchar(255) NOT NULL,
  `description` text,
  `menuId` int(11) NOT NULL,
  `visible` int(2) NOT NULL DEFAULT '0',
  `statut` int(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `menuId` (`menuId`),
  CONSTRAINT `sous_menu_ibfk_1` FOREIGN KEY (`menuId`) REFERENCES `menu` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

/*Data for the table `sous_menu` */

insert  into `sous_menu`(`id`,`libelle`,`lien`,`description`,`menuId`,`visible`,`statut`) values 
(1,'liste','user/index','liste des utilisateurs',2,1,1),
(2,'Ajouter','user/create','Création d\'un utilisateur',2,0,1),
(3,'Détail','user/view','Détail d\'un utilisateur',2,0,1),
(4,'Liste','menu/index','Liste des menus',4,1,1),
(5,'Liste','menu/index','Liste des menus',14,1,1),
(6,'Liste','sousmenu/index','Liste des sous menus',15,0,1),
(7,'Ajouter','menu/ajouter-menu','Enrégistrement d\'un menu',14,0,1),
(8,'Ajouter','sousmenu/ajouter-sousmenu','Enrégistrer un sous menu',15,0,1),
(9,'Liste','profile/index','Liste de tous les profiles utilisateurs',16,1,1),
(10,'Liste','article/index','Liste de tous les produits en stock',11,1,2);

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `auth_key` varchar(32) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `role` smallint(6) NOT NULL DEFAULT '10',
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `user` */

insert  into `user`(`id`,`username`,`auth_key`,`password_hash`,`password_reset_token`,`email`,`role`,`status`,`created_at`,`updated_at`) values 
(1,'well','?JI?قo???\Z???qb???͗?Z?Z??~','$2y$13$7sByo/QBZdxzRPiHRKtw4uIN2ujBj6AwSiTwwqto.mwQbhzotxuRS',NULL,'iwell@well.fr',10,10,1498678008,1498678008);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
