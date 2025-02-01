-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 31 jan. 2025 à 10:03
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `qcm`
--

-- --------------------------------------------------------

--
-- Structure de la table `log`
--

CREATE TABLE `log` (
  `idc` int(11) NOT NULL,
  `idu` int(11) DEFAULT NULL,
  `datedeb` datetime DEFAULT NULL,
  `datefin` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `log`
--

INSERT INTO `log` (`idc`, `idu`, `datedeb`, `datefin`) VALUES
(1, 1, '2025-01-29 17:20:21', '2025-01-29 19:22:44'),
(2, 8, '2025-01-29 17:21:07', '2025-01-29 18:52:44'),
(3, 10, '2025-01-29 17:28:35', '2025-01-29 18:52:44'),
(4, 12, '2025-01-29 17:35:11', '2025-01-29 18:52:44'),
(5, 1, '2025-01-29 18:43:42', '2025-01-29 19:22:44'),
(6, 12, '2025-01-29 18:48:13', '2025-01-29 18:52:44'),
(7, 1, '2025-01-29 18:54:42', '2025-01-29 19:22:44'),
(8, 1, '2025-01-29 19:29:00', '2025-01-29 19:29:00'),
(14, 1, '2025-01-29 20:13:27', '2025-01-29 20:13:36'),
(15, 10, '2025-01-29 20:15:38', '2025-01-29 20:16:39'),
(16, 1, '2025-01-29 20:42:52', '2025-01-29 20:42:56'),
(17, 16, '2025-01-30 13:39:21', '2025-01-30 13:45:29'),
(19, 10, '2025-01-30 14:00:56', '2025-01-30 14:12:16'),
(22, 1, '2025-01-30 14:27:22', '2025-01-30 14:27:26'),
(24, 1, '2025-01-30 14:31:10', '2025-01-30 14:31:15'),
(30, 14, '2025-01-30 18:36:51', '2025-01-30 18:37:55'),
(31, 12, '2025-01-30 18:48:58', '2025-01-30 19:03:08'),
(32, 1, '2025-01-30 19:04:16', '2025-01-30 19:04:20'),
(33, 16, '2025-01-30 19:09:07', '2025-01-30 19:10:12'),
(34, 16, '2025-01-31 09:16:04', NULL),
(35, 16, '2025-01-31 09:16:15', '2025-01-31 09:16:33');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`idc`),
  ADD KEY `idu` (`idu`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `log`
--
ALTER TABLE `log`
  MODIFY `idc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `log`
--
ALTER TABLE `log`
  ADD CONSTRAINT `log_ibfk_1` FOREIGN KEY (`idu`) REFERENCES `user` (`idu`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
