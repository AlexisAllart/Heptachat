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
-- Structure de la table `chat`
--

DROP TABLE IF EXISTS `chat`;
CREATE TABLE IF NOT EXISTS `chat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `msg` text NOT NULL,
  `date` timestamp NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=73 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `chat`
--

INSERT INTO `chat` (`id`, `name`, `msg`, `date`, `image`) VALUES
(57, 'Tata', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Mauris pellentesque pulvinar pellentesque habitant morbi tristique senectus.', '2019-05-30 12:38:03', 'ProfilePics/6.jpg'),
(58, 'Babylon', 'Tincidunt dui ut ornare lectus sit amet. Sed faucibus turpis in eu mi bibendum neque egestas. Purus gravida quis blandit turpis cursus in hac. Adipiscing enim eu turpis egestas pretium aenean. Leo in vitae turpis massa sed.', '2019-05-30 12:38:31', 'ProfilePics/1.jpg'),
(59, 'Jupiter', 'Nunc sed id semper risus in hendrerit gravida. Risus commodo viverra maecenas accumsan lacus. Nunc consequat interdum varius sit amet mattis.', '2019-05-30 12:41:52', 'ProfilePics/2.jpg'),
(60, 'Loulou', 'Placerat duis ultricies lacus sed. Dictum fusce ut placerat orci. Condimentum mattis pellentesque id nibh tortor id aliquet lectus proin. Est ullamcorper eget nulla facilisi etiam dignissim diam.', '2019-05-30 12:42:15', 'ProfilePics/4.jpg'),
(61, 'Mimi', 'Adipiscing elit ut aliquam purus sit amet luctus venenatis lectus. Donec adipiscing tristique risus nec feugiat in fermentum posuere.', '2019-05-30 12:42:32', 'ProfilePics/5.jpg'),
(62, 'Loulou', 'Tellus elementum sagittis vitae et. Vitae congue mauris rhoncus aenean vel elit scelerisque. Nunc sed id semper risus in hendrerit gravida rutrum quisque. Pellentesque nec nam aliquam sem et tortor consequat id.', '2019-05-30 12:42:49', 'ProfilePics/4.jpg'),
(63, 'Tata', 'Elit pellentesque habitant morbi tristique senectus et netus et malesuada. Quis hendrerit dolor magna eget est lorem. Justo laoreet sit amet cursus sit amet dictum sit amet.', '2019-05-30 13:13:34', 'ProfilePics/6.jpg');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
