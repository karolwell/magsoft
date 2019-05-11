-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Sam 27 Avril 2019 à 21:39
-- Version du serveur :  5.6.24
-- Version de PHP :  5.5.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `magsoft`
--

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE IF NOT EXISTS `categorie` (
  `id` int(11) NOT NULL,
  `designation` varchar(225) NOT NULL,
  `description` text,
  `statut` int(2) NOT NULL DEFAULT '1',
  `date_create` datetime NOT NULL,
  `date_update` datetime DEFAULT NULL,
  `create_by` int(11) NOT NULL,
  `update_by` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `categorie`
--

INSERT INTO `categorie` (`id`, `designation`, `description`, `statut`, `date_create`, `date_update`, `create_by`, `update_by`) VALUES
(1, 'Tomate', 'Tous les produits tomate', 1, '2019-04-24 13:32:30', NULL, 1, NULL),
(2, 'Riz', 'Tous les produits riz', 1, '2019-04-24 14:16:33', NULL, 1, NULL),
(3, 'Pate alimentaire', 'Tous les produits pate alimentaire', 1, '2019-04-24 14:17:44', NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `charge`
--

CREATE TABLE IF NOT EXISTS `charge` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) DEFAULT NULL,
  `fichiers` text,
  `cout` double DEFAULT NULL,
  `statut` int(2) NOT NULL DEFAULT '1',
  `date_create` datetime NOT NULL,
  `date_update` datetime DEFAULT NULL,
  `create_by` int(11) NOT NULL,
  `update_by` int(11) DEFAULT NULL,
  `id_users` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE IF NOT EXISTS `client` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `tel` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `statut` int(2) NOT NULL DEFAULT '1',
  `date_create` datetime NOT NULL,
  `date_update` datetime DEFAULT NULL,
  `create_by` int(11) NOT NULL,
  `update_by` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `client`
--

INSERT INTO `client` (`id`, `nom`, `tel`, `email`, `adresse`, `statut`, `date_create`, `date_update`, `create_by`, `update_by`) VALUES
(1, 'CFK CONCEPT', '22890414158', 'cfkconcept@cfkconcept.tg', 'CFK CONCEPT Agoè Assiyéyé ...', 1, '2019-04-27 12:43:24', '2019-04-27 19:10:55', 1, 1),
(2, 'Well', '22890810456', 'well@well.tg', 'Well 77 Agoè', 1, '2019-04-27 12:46:35', NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `entree_stock`
--

CREATE TABLE IF NOT EXISTS `entree_stock` (
  `id` int(11) NOT NULL,
  `reference` varchar(32) NOT NULL,
  `quantite` double NOT NULL,
  `statut` int(11) NOT NULL DEFAULT '1',
  `date_create` datetime NOT NULL,
  `date_update` datetime DEFAULT NULL,
  `create_by` int(11) NOT NULL,
  `update_by` int(11) DEFAULT NULL,
  `id_produit` int(11) NOT NULL,
  `id_fournisseur` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `fiche`
--

CREATE TABLE IF NOT EXISTS `fiche` (
  `id` int(11) NOT NULL,
  `reference` varchar(255) NOT NULL,
  `libelle` varchar(255) DEFAULT NULL,
  `fichiers` text,
  `statut` int(2) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `fournisseur`
--

CREATE TABLE IF NOT EXISTS `fournisseur` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `tel` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `statut` int(2) NOT NULL DEFAULT '1',
  `date_create` datetime NOT NULL,
  `date_update` datetime DEFAULT NULL,
  `create_by` int(11) NOT NULL,
  `update_by` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `fournisseur`
--

INSERT INTO `fournisseur` (`id`, `nom`, `tel`, `email`, `adresse`, `statut`, `date_create`, `date_update`, `create_by`, `update_by`) VALUES
(1, 'Dangote tomate', '0033125252525', 'dangote_tomate@gmail.com', 'Dangote street 70 lagos Nigeria', 1, '2019-04-27 14:35:55', '2019-04-27 14:38:11', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) NOT NULL,
  `libelle` varchar(100) NOT NULL,
  `lien` varchar(255) DEFAULT NULL,
  `description` text,
  `position` int(2) DEFAULT NULL,
  `statut` int(2) DEFAULT '1',
  `date` date DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `menu`
--

INSERT INTO `menu` (`id`, `libelle`, `lien`, `description`, `position`, `statut`, `date`) VALUES
(1, 'Tableau de bord', 'statistique/index', 'Statistiques générale', 1, 1, '2019-03-30'),
(2, 'Utilisateur', '', 'Gestions des utilisateurs', 2, 1, '2019-03-31'),
(3, 'Client', '', 'Gestion des clients', 7, 1, NULL),
(4, 'Niveau d''accès', '', 'Gestion des droits', 8, 1, NULL),
(9, 'Personnel', '', 'Gestion des personnels', 13, 1, NULL),
(10, 'Produit', '', 'Gestion des produits', 10, 1, NULL),
(12, 'Charge', '', 'Gestion des charges du magasin', 12, 1, NULL),
(13, 'Statistiques', '', 'Statistiques et bilan', 14, 1, NULL),
(14, 'Menu', '', 'Gestiion des menus', 4, 1, NULL),
(15, 'Sous menu', '', 'Gestion des sous menus', 5, 1, NULL),
(16, 'Profile', '', 'Gestion des profiles utilisateurs', 3, 1, NULL),
(17, 'Categorie', '', 'Menu catégorie', 9, 1, NULL),
(18, 'Mouvement', '', 'Gestion des ravitaillements et ventes des produits', 11, 1, NULL),
(19, 'Fournisseur', '', 'Menu fournisseur', 6, 1, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE IF NOT EXISTS `produit` (
  `id` int(11) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `prix` float NOT NULL,
  `description` text,
  `quantite_min` double DEFAULT '0',
  `quantite_max` double DEFAULT '0',
  `quantite` double DEFAULT '0',
  `statut` int(2) DEFAULT '1',
  `date_create` datetime NOT NULL,
  `date_update` datetime DEFAULT NULL,
  `create_by` int(11) NOT NULL,
  `update_by` int(11) DEFAULT NULL,
  `id_categorie` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `produit`
--

INSERT INTO `produit` (`id`, `designation`, `prix`, `description`, `quantite_min`, `quantite_max`, `quantite`, `statut`, `date_create`, `date_update`, `create_by`, `update_by`, `id_categorie`) VALUES
(1, 'Carton Rocco', 10000, 'Carton de tomate Rocco', 100, 2000, 0, 1, '2019-04-24 17:35:56', NULL, 1, NULL, 1),
(2, '5 kilo Riz alizé', 6000, '5 kilo Riz alize', 100, 3000, 0, 1, '2019-04-24 17:49:25', NULL, 1, NULL, 2),
(3, '1 carton Spaguetti maman', 6000, 'maccaronni maman', 50, 500, 0, 1, '2019-04-27 16:41:44', NULL, 4, NULL, 3);

-- --------------------------------------------------------

--
-- Structure de la table `profile`
--

CREATE TABLE IF NOT EXISTS `profile` (
  `id` int(11) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `droit` text,
  `date` date NOT NULL,
  `description` text,
  `userId` int(11) NOT NULL,
  `statut` int(2) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `profile`
--

INSERT INTO `profile` (`id`, `designation`, `droit`, `date`, `description`, `userId`, `statut`) VALUES
(1, 'Comptable', '{"9":"","12":"","13":"","":0}', '0000-00-00', 'Doit sur les mouvements par rapport au finance ', 1, 1),
(2, 'Administrateur', '{"1":"","2":"1,2,3","3":"20,21,22,23,24","10":"14,15,16,17,18","14":"5,7","15":"6,8","16":"9,11","17":"12,13","18":"19,30","19":"25,26,27,28,29","":0}', '0000-00-00', 'Droit général sur l'' application ', 1, 1),
(3, 'Magasinier', '{"11":"10","":0}', '0000-00-00', 'Droit au mouvement des articles par rapport à la quantité', 1, 1),
(4, 'commerciaux', NULL, '0000-00-00', 'Droit aux commerciaux', 1, 2),
(5, 'Direction', '{"1":"","2":"1,2,3","10":"14,15,16,17,18","16":"9,11","17":"12,13","18":"19","":0}', '0000-00-00', 'Profile directement lié à la direction droit à tous les menus', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `sortie_stock`
--

CREATE TABLE IF NOT EXISTS `sortie_stock` (
  `id` int(11) NOT NULL,
  `reference` varchar(32) NOT NULL,
  `quantite` double NOT NULL,
  `statut` int(11) NOT NULL DEFAULT '1',
  `date_create` datetime NOT NULL,
  `date_update` datetime DEFAULT NULL,
  `create_by` int(11) NOT NULL,
  `update_by` int(11) DEFAULT NULL,
  `id_produit` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_client` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `sous_menu`
--

CREATE TABLE IF NOT EXISTS `sous_menu` (
  `id` int(11) NOT NULL,
  `libelle` varchar(200) NOT NULL,
  `lien` varchar(255) NOT NULL,
  `description` text,
  `menuId` int(11) NOT NULL,
  `visible` int(2) NOT NULL DEFAULT '0',
  `statut` int(2) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `sous_menu`
--

INSERT INTO `sous_menu` (`id`, `libelle`, `lien`, `description`, `menuId`, `visible`, `statut`) VALUES
(1, 'liste', 'user/index', 'liste des utilisateurs', 2, 1, 1),
(2, 'Ajouter', 'user/create', 'Création d''un utilisateur', 2, 0, 1),
(3, 'Détail', 'user/view', 'Détail d''un utilisateur', 2, 0, 1),
(4, 'Liste', 'menu/index', 'Liste des menus', 4, 1, 1),
(5, 'Liste', 'menu/index', 'Liste des menus', 14, 1, 1),
(6, 'Liste', 'sousmenu/index', 'Liste des sous menus', 15, 1, 1),
(7, 'Ajouter', 'menu/ajouter-menu', 'Enrégistrement d''un menu', 14, 0, 1),
(8, 'Ajouter', 'sousmenu/ajouter-sousmenu', 'Enrégistrer un sous menu', 15, 0, 1),
(9, 'Liste', 'profile/index', 'Liste de tous les profiles utilisateurs', 16, 1, 1),
(11, 'Droit', 'profile/droit', 'Attribution des niveaux d''accès aux profiles', 16, 1, 1),
(12, 'Liste', 'categorie/index', 'Liste de toutes les catégories', 17, 1, 1),
(13, 'Ajouter', 'categorie/ajouter-categorie', 'Enrégistrement des catégories', 17, 0, 1),
(14, 'Liste', 'produit/index', 'Liste de tous les produits', 10, 1, 1),
(15, 'Ajouter', 'produit/ajouter-produit', 'Enrégistrement de nouveaux produits', 10, 0, 1),
(16, 'Activation', 'produit/activer-desactiver', 'Activation et désactivation d''un produit', 10, 0, 1),
(17, 'Supprimer', 'produit/supprimer', 'Suppression d''un produit', 10, 0, 1),
(18, 'mouvements', 'produit/mouvements', 'Tous les mouments d''entrées et de sorties des produits', 10, 0, 1),
(19, 'Ravitaillement', 'entreestock/index', 'Ravillement du stock de nouveaux produits', 18, 1, 1),
(20, 'Liste', 'client/index', 'Liste de tous les clients', 3, 1, 1),
(21, 'Ajouter', 'client/ajouter-client', 'Enrégistrement d''un nouveau client', 3, 0, 1),
(22, 'Activation', 'client/activer-desactiver', 'Activation et désactivation des clients', 3, 0, 1),
(23, 'Details', 'client/details', 'Suivre les achats effectués par le client', 3, 0, 1),
(24, 'Supprimer', 'client/supprimer', 'Suppression d''un client', 3, 0, 1),
(25, 'Liste', 'fournisseur/index', 'Liste de tous les fournisseurs', 19, 1, 1),
(26, 'Ajouter', 'fournisseur/ajouter-fournisseur', 'Enrégistrement d''un fourniseur', 19, 0, 1),
(27, 'Activation', 'fournisseur/activer-desactiver', 'Activation et désactivation d''un fournisseur', 19, 0, 1),
(28, 'Détails', 'fournisseur/details', 'Détails des ravitaillements du fournisseur', 19, 0, 1),
(29, 'Supprimer', 'fournisseur/supprimer', 'Suppression d''un fournisseur', 19, 0, 1),
(30, 'Vente', 'sortiestock/index', 'Liste des ventes', 18, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `stock`
--

CREATE TABLE IF NOT EXISTS `stock` (
  `id` int(11) NOT NULL,
  `quantite` double DEFAULT NULL,
  `quantite_max` double DEFAULT NULL,
  `statut` int(11) NOT NULL DEFAULT '1',
  `date_create` datetime NOT NULL,
  `date_update` datetime DEFAULT NULL,
  `create_by` int(11) NOT NULL,
  `update_by` int(11) DEFAULT NULL,
  `id_produit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `auth_key` varchar(32) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL,
  `profileId` int(11) DEFAULT NULL,
  `role` smallint(6) NOT NULL DEFAULT '10',
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id`, `username`, `telephone`, `email`, `auth_key`, `password_hash`, `password_reset_token`, `profileId`, `role`, `status`, `created_at`, `updated_at`) VALUES
(1, 'well', '90414158', 'iwell@well.fr', 'F-i8vrvPwKtRh-J4_S2kCfKOlz0nh7ip', '$2y$13$7sByo/QBZdxzRPiHRKtw4uIN2ujBj6AwSiTwwqto.mwQbhzotxuRS', NULL, 2, 10, 10, 1498678008, 1498678008),
(2, 'intime', '90414158', 'intime@well.fr', 'Ix750anxw1YuvZKpwX4WX1Om_gmkgBJU', '$2y$13$7sByo/QBZdxzRPiHRKtw4uIN2ujBj6AwSiTwwqto.mwQbhzotxuRS', NULL, 5, 10, 10, 1554578554, 1554578554),
(3, 'elwin', '90810456', 'elwin@well.fr', 'F-i8vrvPwKtRh-J4_S2kCfKOlz0nh7qS', '$2y$13$RuM4T2/.7TXsFupxhzwn3..be3fcAkhbE.VA87eTAjR3LUJYaHNcK', NULL, NULL, 10, 10, 1554580206, 1554580206),
(4, 'ruthy', '90810456', 'smile@gmail.com', 'MwL9ZSZKtrMMKR2nfQVVMTo7wb7t6VZQ', '$2y$13$7sByo/QBZdxzRPiHRKtw4uIN2ujBj6AwSiTwwqto.mwQbhzotxuRS', NULL, 5, 10, 10, 1556382672, 1556382672);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id` (`id`), ADD KEY `create_by` (`create_by`), ADD KEY `update_by` (`update_by`);

--
-- Index pour la table `charge`
--
ALTER TABLE `charge`
  ADD PRIMARY KEY (`id`), ADD KEY `create_by` (`create_by`), ADD KEY `update_by` (`update_by`);

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id`), ADD KEY `create_by` (`create_by`), ADD KEY `update_by` (`update_by`);

--
-- Index pour la table `entree_stock`
--
ALTER TABLE `entree_stock`
  ADD PRIMARY KEY (`id`), ADD KEY `create_by` (`create_by`), ADD KEY `update_by` (`update_by`), ADD KEY `id_produit` (`id_produit`), ADD KEY `id_fournisseur` (`id_fournisseur`);

--
-- Index pour la table `fiche`
--
ALTER TABLE `fiche`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `fournisseur`
--
ALTER TABLE `fournisseur`
  ADD PRIMARY KEY (`id`), ADD KEY `create_by` (`create_by`), ADD KEY `update_by` (`update_by`);

--
-- Index pour la table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`id`), ADD KEY `create_by` (`create_by`), ADD KEY `update_by` (`update_by`), ADD KEY `id_categorie` (`id_categorie`), ADD KEY `id_categorie_2` (`id_categorie`);

--
-- Index pour la table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`id`), ADD KEY `userId` (`userId`);

--
-- Index pour la table `sortie_stock`
--
ALTER TABLE `sortie_stock`
  ADD PRIMARY KEY (`id`), ADD KEY `create_by` (`create_by`), ADD KEY `update_by` (`update_by`), ADD KEY `id_user` (`id_user`), ADD KEY `id_produit` (`id_produit`), ADD KEY `id_client` (`id_client`);

--
-- Index pour la table `sous_menu`
--
ALTER TABLE `sous_menu`
  ADD PRIMARY KEY (`id`), ADD KEY `menuId` (`menuId`);

--
-- Index pour la table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id`), ADD KEY `create_by` (`create_by`), ADD KEY `update_by` (`update_by`), ADD KEY `id_produit` (`id_produit`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`), ADD KEY `profileId` (`profileId`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `charge`
--
ALTER TABLE `charge`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `client`
--
ALTER TABLE `client`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `entree_stock`
--
ALTER TABLE `entree_stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `fiche`
--
ALTER TABLE `fiche`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `fournisseur`
--
ALTER TABLE `fournisseur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT pour la table `produit`
--
ALTER TABLE `produit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `profile`
--
ALTER TABLE `profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `sortie_stock`
--
ALTER TABLE `sortie_stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `sous_menu`
--
ALTER TABLE `sous_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT pour la table `stock`
--
ALTER TABLE `stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `categorie`
--
ALTER TABLE `categorie`
ADD CONSTRAINT `categorie_ibfk_1` FOREIGN KEY (`create_by`) REFERENCES `user` (`id`),
ADD CONSTRAINT `categorie_ibfk_2` FOREIGN KEY (`update_by`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `charge`
--
ALTER TABLE `charge`
ADD CONSTRAINT `charge_ibfk_1` FOREIGN KEY (`create_by`) REFERENCES `user` (`id`),
ADD CONSTRAINT `charge_ibfk_2` FOREIGN KEY (`update_by`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `client`
--
ALTER TABLE `client`
ADD CONSTRAINT `client_ibfk_1` FOREIGN KEY (`create_by`) REFERENCES `user` (`id`),
ADD CONSTRAINT `client_ibfk_2` FOREIGN KEY (`update_by`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `entree_stock`
--
ALTER TABLE `entree_stock`
ADD CONSTRAINT `entree_stock_ibfk_1` FOREIGN KEY (`create_by`) REFERENCES `user` (`id`),
ADD CONSTRAINT `entree_stock_ibfk_2` FOREIGN KEY (`update_by`) REFERENCES `user` (`id`),
ADD CONSTRAINT `entree_stock_ibfk_4` FOREIGN KEY (`id_produit`) REFERENCES `produit` (`id`),
ADD CONSTRAINT `entree_stock_ibfk_5` FOREIGN KEY (`id_fournisseur`) REFERENCES `fournisseur` (`id`);

--
-- Contraintes pour la table `fournisseur`
--
ALTER TABLE `fournisseur`
ADD CONSTRAINT `fournisseur_ibfk_1` FOREIGN KEY (`create_by`) REFERENCES `user` (`id`),
ADD CONSTRAINT `fournisseur_ibfk_2` FOREIGN KEY (`update_by`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `produit`
--
ALTER TABLE `produit`
ADD CONSTRAINT `produit_ibfk_1` FOREIGN KEY (`create_by`) REFERENCES `user` (`id`),
ADD CONSTRAINT `produit_ibfk_2` FOREIGN KEY (`update_by`) REFERENCES `user` (`id`),
ADD CONSTRAINT `produit_ibfk_3` FOREIGN KEY (`id_categorie`) REFERENCES `categorie` (`id`);

--
-- Contraintes pour la table `profile`
--
ALTER TABLE `profile`
ADD CONSTRAINT `profile_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `sortie_stock`
--
ALTER TABLE `sortie_stock`
ADD CONSTRAINT `sortie_stock_ibfk_1` FOREIGN KEY (`create_by`) REFERENCES `user` (`id`),
ADD CONSTRAINT `sortie_stock_ibfk_2` FOREIGN KEY (`update_by`) REFERENCES `user` (`id`),
ADD CONSTRAINT `sortie_stock_ibfk_3` FOREIGN KEY (`id_produit`) REFERENCES `produit` (`id`),
ADD CONSTRAINT `sortie_stock_ibfk_4` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`),
ADD CONSTRAINT `sortie_stock_ibfk_5` FOREIGN KEY (`id_client`) REFERENCES `client` (`id`);

--
-- Contraintes pour la table `sous_menu`
--
ALTER TABLE `sous_menu`
ADD CONSTRAINT `sous_menu_ibfk_1` FOREIGN KEY (`menuId`) REFERENCES `menu` (`id`);

--
-- Contraintes pour la table `stock`
--
ALTER TABLE `stock`
ADD CONSTRAINT `stock_ibfk_1` FOREIGN KEY (`create_by`) REFERENCES `user` (`id`),
ADD CONSTRAINT `stock_ibfk_2` FOREIGN KEY (`update_by`) REFERENCES `user` (`id`),
ADD CONSTRAINT `stock_ibfk_3` FOREIGN KEY (`id_produit`) REFERENCES `produit` (`id`);

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`profileId`) REFERENCES `profile` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
