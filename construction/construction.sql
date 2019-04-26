-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  ven. 26 avr. 2019 à 10:03
-- Version du serveur :  5.7.21
-- Version de PHP :  5.6.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `construction`
--

-- --------------------------------------------------------

--
-- Structure de la table `beton`
--

DROP TABLE IF EXISTS `beton`;
CREATE TABLE IF NOT EXISTS `beton` (
  `id_beton` int(3) NOT NULL AUTO_INCREMENT,
  `localisation_beton` varchar(100) NOT NULL,
  `qte_beton` int(11) NOT NULL,
  `cout_beton` int(11) NOT NULL,
  PRIMARY KEY (`id_beton`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ciment`
--

DROP TABLE IF EXISTS `ciment`;
CREATE TABLE IF NOT EXISTS `ciment` (
  `id_ciment` int(3) NOT NULL AUTO_INCREMENT,
  `nbre_ciment` int(11) NOT NULL,
  `cout_ciment` int(11) NOT NULL,
  `localisation_ciment` varchar(100) NOT NULL,
  PRIMARY KEY (`id_ciment`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ciment`
--

INSERT INTO `ciment` (`id_ciment`, `nbre_ciment`, `cout_ciment`, `localisation_ciment`) VALUES
(2, 10, 30000, 'marcory');

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `id_client` int(3) NOT NULL AUTO_INCREMENT,
  `nom_client` varchar(100) NOT NULL,
  `email_client` varchar(100) NOT NULL,
  `contact_client` varchar(100) NOT NULL,
  PRIMARY KEY (`id_client`)
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`id_client`, `nom_client`, `email_client`, `contact_client`) VALUES
(38, 'fono joel', 'joel@mail.com', '65737887'),
(39, 'toure sylla', 'toure@mail.com', '76655443');

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `id_commande` int(3) NOT NULL AUTO_INCREMENT,
  `type_commande` varchar(100) NOT NULL,
  `id_type_commande` int(3) NOT NULL,
  `id_client` int(3) NOT NULL,
  `id_user` int(3) NOT NULL,
  `date_commande` datetime NOT NULL,
  `etat_commande` int(1) NOT NULL,
  PRIMARY KEY (`id_commande`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`id_commande`, `type_commande`, `id_type_commande`, `id_client`, `id_user`, `date_commande`, `etat_commande`) VALUES
(26, 'vente de ciment', 2, 39, 1, '2019-04-26 09:51:58', 2),
(25, 'RÃ©alisation du projet', 13, 38, 10, '2019-04-26 09:47:29', 2);

-- --------------------------------------------------------

--
-- Structure de la table `etude`
--

DROP TABLE IF EXISTS `etude`;
CREATE TABLE IF NOT EXISTS `etude` (
  `id_etude` int(3) NOT NULL AUTO_INCREMENT,
  `emplacement_etude` varchar(100) NOT NULL,
  `dimension_etude` int(10) NOT NULL,
  `cout_etude` int(11) NOT NULL,
  PRIMARY KEY (`id_etude`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `projet`
--

DROP TABLE IF EXISTS `projet`;
CREATE TABLE IF NOT EXISTS `projet` (
  `id_projet` int(3) NOT NULL AUTO_INCREMENT,
  `type_projet` varchar(100) NOT NULL,
  PRIMARY KEY (`id_projet`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `projet`
--

INSERT INTO `projet` (`id_projet`, `type_projet`) VALUES
(13, 'maison_basse_3pcs');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int(3) NOT NULL AUTO_INCREMENT,
  `nom_user` varchar(100) NOT NULL,
  `email_user` varchar(50) NOT NULL,
  `mdp_user` varchar(50) NOT NULL,
  `privilege_user` varchar(30) NOT NULL,
  `etat_user` int(1) NOT NULL,
  `attribut_user` int(1) NOT NULL DEFAULT '0',
  `contact_user` varchar(12) NOT NULL,
  `photo_user` varchar(50) NOT NULL,
  `date_user` date NOT NULL DEFAULT '2019-01-01',
  PRIMARY KEY (`id_user`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id_user`, `nom_user`, `email_user`, `mdp_user`, `privilege_user`, `etat_user`, `attribut_user`, `contact_user`, `photo_user`, `date_user`) VALUES
(1, 'nick boy', 'a@mail.com', 'a', 'administrateur', 0, 0, '49025203', 'logo.png', '2019-01-01'),
(10, 'reza', 'reza@mail.com', '1234', 'architecte', 0, 0, '65534231', 'logo.png', '2019-04-26');

-- --------------------------------------------------------

--
-- Structure de la table `vente`
--

DROP TABLE IF EXISTS `vente`;
CREATE TABLE IF NOT EXISTS `vente` (
  `id_vente` int(3) NOT NULL AUTO_INCREMENT,
  `titre_vente` varchar(100) NOT NULL,
  `date_vente` date NOT NULL,
  `description_vente` text NOT NULL,
  `photo_vente` varchar(100) NOT NULL,
  PRIMARY KEY (`id_vente`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `vente`
--

INSERT INTO `vente` (`id_vente`, `titre_vente`, `date_vente`, `description_vente`, `photo_vente`) VALUES
(6, 'vente de terrain', '2019-04-26', 'terrain prÃ¨s de lagune', '3.jpg');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
