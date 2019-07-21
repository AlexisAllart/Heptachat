-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 30 mai 2019 à 22:42
-- Version du serveur :  5.7.24
-- Version de PHP :  7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `heptachat`
--

-- --------------------------------------------------------

--
-- Structure de la table `formulaire`
--

DROP TABLE IF EXISTS `formulaire`;
CREATE TABLE IF NOT EXISTS `formulaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(255) NOT NULL,
  `mdp` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `online` tinyint(1) NOT NULL,
  `image` varchar(255) NOT NULL DEFAULT 'ProfilePics/0.jpg',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `formulaire`
--

INSERT INTO `formulaire` (`id`, `pseudo`, `mdp`, `email`, `online`, `image`) VALUES
(1, 'Babylon', '356a192b7913b04c54574d18c28d46e6395428ab', 'Babylon@heptachat.com', 1, 'ProfilePics/1.jpg'),
(2, 'Jupiter', '356a192b7913b04c54574d18c28d46e6395428ab', 'Jupiter@heptachat.com', 1, 'ProfilePics/2.jpg'),
(3, 'Martin', '356a192b7913b04c54574d18c28d46e6395428ab', 'Martin@heptachat.com', 1, 'ProfilePics/3.jpg'),
(4, 'Loulou', '356a192b7913b04c54574d18c28d46e6395428ab', 'Loulou@heptachat.com', 1, 'ProfilePics/4.jpg'),
(5, 'Mimi', '356a192b7913b04c54574d18c28d46e6395428ab', 'Mimi@heptachat.com', 1, 'ProfilePics/5.jpg'),
(7, 'Testeur', '356a192b7913b04c54574d18c28d46e6395428ab', 'Testuser@Testuser.com', 1, 'ProfilePics/7.jpg'),
(8, 'HeptaChat', '356a192b7913b04c54574d18c28d46e6395428ab', 'HeptaChat@HeptaChat.com', 1, 'ProfilePics/0.jpg'),
(9, 'Felix', '356a192b7913b04c54574d18c28d46e6395428ab', 'Felix@heptachat.com', 1, 'ProfilePics/9.jpg');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
