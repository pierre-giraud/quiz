-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 26 déc. 2019 à 00:23
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
-- Base de données :  `quiz_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `questions`
--

DROP TABLE IF EXISTS `questions`;
CREATE TABLE IF NOT EXISTS `questions` (
  `id_question` int(11) NOT NULL AUTO_INCREMENT,
  `texte_question` varchar(200) NOT NULL,
  `id_quiz` int(11) NOT NULL,
  PRIMARY KEY (`id_question`),
  KEY `quiz_fk` (`id_quiz`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `questions`
--

INSERT INTO `questions` (`id_question`, `texte_question`, `id_quiz`) VALUES
(8, 'Oui ?', 6);

--
-- Déclencheurs `questions`
--
DROP TRIGGER IF EXISTS `questions_delete`;
DELIMITER $$
CREATE TRIGGER `questions_delete` AFTER DELETE ON `questions` FOR EACH ROW DELETE FROM reponses WHERE reponses.id_question = OLD.id_question
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `quiz`
--

DROP TABLE IF EXISTS `quiz`;
CREATE TABLE IF NOT EXISTS `quiz` (
  `id_quiz` int(11) NOT NULL AUTO_INCREMENT,
  `titre_quiz` varchar(255) NOT NULL,
  `ispublic_quiz` tinyint(1) NOT NULL,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id_quiz`),
  KEY `user_fk` (`id_user`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `quiz`
--

INSERT INTO `quiz` (`id_quiz`, `titre_quiz`, `ispublic_quiz`, `id_user`) VALUES
(6, 'Un nouveau jaj', 0, 60);

--
-- Déclencheurs `quiz`
--
DROP TRIGGER IF EXISTS `quiz_delete`;
DELIMITER $$
CREATE TRIGGER `quiz_delete` AFTER DELETE ON `quiz` FOR EACH ROW DELETE FROM questions WHERE questions.id_quiz = OLD.id_quiz
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `reponses`
--

DROP TABLE IF EXISTS `reponses`;
CREATE TABLE IF NOT EXISTS `reponses` (
  `id_reponse` int(11) NOT NULL AUTO_INCREMENT,
  `texte_reponse` varchar(500) NOT NULL,
  `iscorrect_reponse` tinyint(1) NOT NULL,
  `id_question` int(11) NOT NULL,
  PRIMARY KEY (`id_reponse`),
  KEY `question_fk` (`id_question`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `reponses`
--

INSERT INTO `reponses` (`id_reponse`, `texte_reponse`, `iscorrect_reponse`, `id_question`) VALUES
(32, 'non', 0, 8),
(31, 'non', 0, 8),
(30, 'non', 0, 8),
(29, 'non', 0, 8);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `nom_user` varchar(50) NOT NULL,
  `mdp_user` varchar(100) NOT NULL,
  `type_user` varchar(10) NOT NULL,
  UNIQUE KEY `index_id` (`id_user`)
) ENGINE=MyISAM AUTO_INCREMENT=122 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id_user`, `nom_user`, `mdp_user`, `type_user`) VALUES
(60, 'Pierre Giraud', '$2y$10$uqSIR5nYAxKseb2RBFCKO.Aiohxgyw0zMqRd.ES7xi9.i70VwjHiy', 'admin'),
(61, 'Paul', '$2y$10$eluLCFrOQh3EwYlDzQ9CCOycP2IPojxSfv4wN4aieKxjXFbG/A5X6', 'user'),
(62, 'Diane', '$2y$10$aHS4pPJ70wJ41czfgNTLQ.cye4y.C.4Y6XYcc8u4IaWooH8WXbBvS', 'user');

--
-- Déclencheurs `users`
--
DROP TRIGGER IF EXISTS `user_delete`;
DELIMITER $$
CREATE TRIGGER `user_delete` AFTER DELETE ON `users` FOR EACH ROW DELETE FROM quiz WHERE quiz.id_user = OLD.id_user
$$
DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
