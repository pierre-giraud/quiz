-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  ven. 27 déc. 2019 à 21:52
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
  `texte_question` varchar(200) NOT NULL,
  `id_quiz` int(11) NOT NULL,
  PRIMARY KEY (`id_question`),
  KEY `quiz_fk` (`id_quiz`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `questions`
--

INSERT INTO `questions` (`id_question`, `texte_question`, `id_quiz`) VALUES
(15, 'az', 13),
(16, 'zoz', 14),
(17, 'La question 1 ?', 15),
(18, 'La question 2 ?', 15),
(20, 'Une question 3 ?', 15);

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
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `quiz`
--

INSERT INTO `quiz` (`id_quiz`, `titre_quiz`, `ispublic_quiz`, `id_user`) VALUES
(13, 'Un nouveau quiz', 1, 60),
(14, 'Un nouveau jaj', 0, 60),
(15, 'Un nouveau KEK', 1, 60);

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
) ENGINE=MyISAM AUTO_INCREMENT=92 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `reponses`
--

INSERT INTO `reponses` (`id_reponse`, `texte_reponse`, `iscorrect_reponse`, `id_question`) VALUES
(60, '', 0, 15),
(59, '', 0, 15),
(58, 'dz', 0, 15),
(57, 'azd', 0, 15),
(61, 'oui', 0, 16),
(62, 'on', 0, 16),
(63, 'kek', 0, 16),
(64, '', 0, 16),
(65, 'J\'avoue', 0, 17),
(66, 'Grave', 0, 17),
(76, 'Oui', 0, 18),
(69, 'peut etre', 0, 18),
(70, 'oui', 0, 18),
(79, 'De ouf !', 0, 20),
(80, 'Ouais !', 0, 20),
(81, 'Non !', 0, 20),
(82, 'ZOZ', 0, 20);

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
) ENGINE=MyISAM AUTO_INCREMENT=125 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
