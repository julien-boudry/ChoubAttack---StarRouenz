-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Dim 02 Mars 2014 à 14:38
-- Version du serveur: 5.6.12-log
-- Version de PHP: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `star-rouenz`
--
CREATE DATABASE IF NOT EXISTS `star-rouenz` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `star-rouenz`;

-- --------------------------------------------------------

--
-- Structure de la table `play`
--

CREATE TABLE IF NOT EXISTS `play` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `IP` char(39) COLLATE utf8_bin DEFAULT NULL,
  `DATE` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=828 ;

-- --------------------------------------------------------

--
-- Structure de la table `scores`
--

CREATE TABLE IF NOT EXISTS `scores` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `EMAIL` varchar(100) COLLATE utf8_bin NOT NULL,
  `SCORE` int(11) NOT NULL,
  `DATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `IP` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `ETAT` varchar(56) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `OPTI` (`ETAT`,`SCORE`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=11 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
