-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  lun. 23 déc. 2019 à 22:29
-- Version du serveur :  8.0.18
-- Version de PHP :  7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `quiz_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `questions`
--

DROP TABLE IF EXISTS `questions`;
CREATE TABLE IF NOT EXISTS `questions` (
  `id_question` int(11) NOT NULL AUTO_INCREMENT,
  `texte_question` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `id_quiz` int(11) NOT NULL,
  KEY `index_questions` (`id_question`),
  KEY `id_quiz` (`id_quiz`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `quiz`
--

DROP TABLE IF EXISTS `quiz`;
CREATE TABLE IF NOT EXISTS `quiz` (
  `id_quiz` int(11) NOT NULL AUTO_INCREMENT,
  `titre_quiz` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `ispublic_quiz` tinyint(1) NOT NULL DEFAULT '0',
  `id_user` int(11) NOT NULL,
  KEY `index_quiz` (`id_quiz`),
  KEY `id_user` (`id_user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reponses`
--

DROP TABLE IF EXISTS `reponses`;
CREATE TABLE IF NOT EXISTS `reponses` (
  `id_reponse` int(11) NOT NULL,
  `texte_reponse` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `iscorrect_reponse` tinyint(1) NOT NULL,
  `id_question` int(11) NOT NULL,
  KEY `index_reponse` (`id_reponse`),
  KEY `id_question` (`id_question`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `nom_user` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `mdp_user` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `type_user` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  UNIQUE KEY `index_id` (`id_user`)
) ENGINE=MyISAM AUTO_INCREMENT=118 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id_user`, `nom_user`, `mdp_user`, `type_user`) VALUES
(60, 'Pierre Giraud', '$2y$10$uqSIR5nYAxKseb2RBFCKO.Aiohxgyw0zMqRd.ES7xi9.i70VwjHiy', 'admin'),
(61, 'Paul', '$2y$10$eluLCFrOQh3EwYlDzQ9CCOycP2IPojxSfv4wN4aieKxjXFbG/A5X6', 'user'),
(62, 'Diane', '$2y$10$aHS4pPJ70wJ41czfgNTLQ.cye4y.C.4Y6XYcc8u4IaWooH8WXbBvS', 'user');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
