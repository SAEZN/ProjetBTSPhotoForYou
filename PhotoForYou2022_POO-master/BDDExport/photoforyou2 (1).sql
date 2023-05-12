-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 12 mai 2023 à 19:44
-- Version du serveur : 5.7.36
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `photoforyou2`
--

-- --------------------------------------------------------

--
-- Structure de la table `menu`
--

DROP TABLE IF EXISTS `menu`;
CREATE TABLE IF NOT EXISTS `menu` (
  `idMenu` int(3) NOT NULL,
  `nomMenu` varchar(45) NOT NULL,
  `Lien` varchar(45) DEFAULT NULL,
  `Habilitation` char(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idMenu`),
  UNIQUE KEY `nomMenu_UNIQUE` (`nomMenu`),
  UNIQUE KEY `Lien_UNIQUE` (`Lien`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `photos`
--

DROP TABLE IF EXISTS `photos`;
CREATE TABLE IF NOT EXISTS `photos` (
  `id` int(11) NOT NULL,
  `title` varchar(30) NOT NULL,
  `description` varchar(30) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `file` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `photos`
--

INSERT INTO `photos` (`id`, `title`, `description`, `filename`, `date`, `file`) VALUES
(1, 'RiviÃ¨re', '', '645e9565db902_jetee-au-bord-lac-hallstatt-autriche_181624-44201.avif', '2023-05-11 22:00:00', 'Array'),
(1, 'Montagne', '', '645e9579d19db_tÃ©lÃ©chargement.jfif', '2023-05-11 22:00:00', 'Array'),
(1, 'MontgoliÃ¨re', '', '645e95885be40_tÃ©lÃ©chargement (2).jfif', '2023-05-11 22:00:00', 'Array'),
(1, 'Rivage', '', '645e95b2bc10e_AnneJutras_PhotoTrend_0_photo-intro-770x512.jpg', '2023-05-11 22:00:00', 'Array'),
(1, 'Rivage 2', '', '645e95c9a576d_tÃ©lÃ©chargement (1).jfif', '2023-05-11 22:00:00', 'Array');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_utilisateur` varchar(30) NOT NULL,
  `adresse_email` varchar(50) NOT NULL,
  `mot_de_passe` varchar(32) NOT NULL,
  `credits` int(11) NOT NULL DEFAULT '0',
  `Photo` varchar(145) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mail_UNIQUE` (`adresse_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
