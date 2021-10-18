-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 20 mai 2021 à 04:06
-- Version du serveur :  10.4.17-MariaDB
-- Version de PHP : 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `biblio`
--

-- --------------------------------------------------------

--
-- Structure de la table `auteur`
--

create database LPABD_ALLAF_AMINE;
use LPABD_ALLAF_AMINE;

CREATE TABLE `auteur` (
  `codeAut` int(11) NOT NULL,
  `nomAut` varchar(50) NOT NULL,
  `prenomAut` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `auteur`
--

INSERT INTO `auteur` (`codeAut`, `nomAut`, `prenomAut`) VALUES
(5, '1', ''),
(6, 'Van vliet', 'hans'),
(7, 'Van vliet', 'hans'),
(8, 'Van vliet', 'hans'),
(9, 'Van vliet', 'hans'),
(10, 'Van vliet', 'hans'),
(11, 'Van vliet', 'hans'),
(12, 'Van vliet', 'hans'),
(13, 'Van vliet', 'hans'),
(14, 'Van vliet', 'hans'),
(15, 'Van vliet', 'hans'),
(16, 'Van vliet', 'hans'),
(17, 'Van vliet', 'hans'),
(18, 'Van vliet', 'hans'),
(19, 'Van vliet', 'hans'),
(20, 'Van vliet', 'hans'),
(21, 'Van vliet', 'hans'),
(22, 'Van vliet', 'hans'),
(23, 'Van vliet', 'hans'),
(24, 'Van vliet', 'hans'),
(25, 'Van vliet', 'hans'),
(26, 'Van vliet', 'hans'),
(27, 'Van vliet', 'hans'),
(28, 'Van vliet', 'hans'),
(29, 'davison ', 'gerald c'),
(30, 'davison ', 'Gerald'),
(31, 'davison ', 'gerald c'),
(32, 'davison ', 'gerald c'),
(33, 'davison ', 'gerald c'),
(34, 'davison ', 'gerald c'),
(35, 'davison ', 'gerald c'),
(36, 'davison ', 'gerald c'),
(37, 'davison ', 'gerald c'),
(38, 'davison ', 'gerald c'),
(39, 'davison ', 'gerald c'),
(40, 'davison ', 'gerald c'),
(41, 'davison ', 'gerald c'),
(42, '1', ''),
(43, 'davison ', 'gerald c'),
(44, 'davison ', 'gerald L'),
(45, 'Van vliet', 'hans'),
(46, 'hamzaoui', 'Hamza'),
(47, 'davison ', 'gerald c'),
(48, 'saqa', 'mohamed'),
(49, 'zefzaf', 'mohamed'),
(50, 'quen', 'khaterine'),
(51, 'rebiaa', 'zazo'),
(52, 'allaf', 'amine'),
(53, 'allaf', 'mohamed amine'),
(54, '', ''),
(55, 'Wilken', 'jeremy'),
(56, 'allaf', 'amine');

-- --------------------------------------------------------

--
-- Structure de la table `discipline`
--

CREATE TABLE `discipline` (
  `codeDis` int(11) NOT NULL,
  `libelleDis` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `discipline`
--

INSERT INTO `discipline` (`codeDis`, `libelleDis`) VALUES
(1, 'Informatique'),
(2, 'Mathématiques'),
(3, 'Géologie'),
(4, 'Physique'),
(5, 'Chimie');

-- --------------------------------------------------------

--
-- Structure de la table `edition`
--

CREATE TABLE `edition` (
  `codeEdi` int(11) NOT NULL,
  `anneeEdi` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `edition`
--

INSERT INTO `edition` (`codeEdi`, `anneeEdi`) VALUES
(1, 2020),
(2, 2019),
(3, 2018),
(4, 2017),
(5, 2016),
(6, 2015),
(7, 2014),
(8, 2013),
(9, 2012),
(10, 2011),
(11, 2010),
(12, 2009),
(13, 2008),
(14, 2005),
(15, 2001),
(16, 2005),
(17, 2005),
(18, 2003),
(19, 2009),
(20, 2009),
(21, 2009),
(22, 1999),
(23, 1999),
(24, 1999),
(25, 1999),
(26, 1996),
(27, 1996),
(28, 1996),
(29, 2003),
(30, 1997),
(31, 2001),
(32, 0),
(33, 1996),
(34, 2009),
(35, 2009),
(36, 2010),
(37, 2009),
(38, 2006),
(39, 2006),
(40, 2001),
(41, 2001),
(42, 2009),
(43, 2000);

-- --------------------------------------------------------

--
-- Structure de la table `emprunt`
--

CREATE TABLE `emprunt` (
  `codeEmprunt` int(11) NOT NULL,
  `dateDebut` datetime NOT NULL,
  `dateFin` datetime NOT NULL,
  `Etat` int(1) DEFAULT NULL,
  `codeBar` varchar(50) DEFAULT NULL,
  `CBGest` varchar(50) DEFAULT NULL,
  `CNE` varchar(50) NOT NULL,
  `termine` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `emprunt`
--

INSERT INTO `emprunt` (`codeEmprunt`, `dateDebut`, `dateFin`, `Etat`, `codeBar`, `CBGest`, `CNE`, `termine`) VALUES
(1, '2021-04-26 18:30:08', '2021-04-28 18:30:08', 1, 'A100000001', '115749', 'K131491460', '1'),
(2, '2021-04-26 18:59:27', '2021-04-26 19:24:59', 1, 'A100000001', '115749', 'p159845612', '1'),
(3, '2021-04-28 00:54:59', '2021-04-30 00:54:59', 1, 'C300000000001D', '115749', 'm026357489', '1'),
(4, '2021-05-06 01:58:25', '2021-05-08 01:58:25', 1, 'A100000001', '115749', 'm026357489', '1'),
(5, '2021-05-07 21:10:00', '2021-05-09 00:25:41', 1, 'A100000001', '115749', 'p159845612', '1'),
(6, '2021-05-08 17:49:38', '2021-05-17 21:26:44', 1, 'C300000000001D', '115749', 't123654789', '1'),
(7, '2021-05-08 17:53:18', '2021-05-10 17:53:18', 1, '15060715', '115749', 'F131385236', '1'),
(8, '2021-05-09 00:33:46', '2021-05-11 00:33:46', 1, 'A100000003', '115749', 'F131385236', '1'),
(9, '2021-05-09 00:35:49', '2021-05-11 00:35:49', 1, 'A100000003', '115749', 'F131385236', '1'),
(10, '2021-05-09 16:43:59', '2021-05-13 16:43:59', 1, 'A100000002', '115749', 't123654789', '1'),
(11, '2021-05-10 03:45:37', '2021-05-12 03:45:37', 1, 'A100000001', '115749', 'F131385236', '1'),
(12, '2021-05-11 02:48:10', '2021-05-11 02:50:04', 1, 'C300000000002D', '115749', 'f123459632', '1'),
(13, '2021-05-11 02:55:59', '2021-05-17 21:22:05', 1, 'C300000000005D', '115749', 'z159753692', '1'),
(14, '2021-05-11 23:47:20', '2021-05-13 23:47:20', 1, 'A100000005', '115749', 'f5645123698', '0'),
(15, '2021-05-12 00:12:30', '2021-05-19 17:20:26', 1, 'A100000003', '115749', 'g159784521', '1'),
(16, '2021-05-12 20:23:09', '2021-05-19 17:19:40', 1, 'A100000001', '115749', 'y165489325', '1'),
(17, '2021-05-17 22:16:46', '2021-05-19 17:19:01', 1, 'C300000000000D', NULL, 'v13131313', '1'),
(18, '2021-05-18 02:48:17', '2021-05-19 14:35:25', 1, 'A100000005', '115749', 'f125236458789', '1'),
(19, '2021-05-18 22:52:08', '2021-05-19 17:21:32', 1, 'A100000005', '115749', 'd123456', '1'),
(20, '2021-05-19 16:16:33', '2021-05-19 15:26:06', 1, '2147483647', '115749', 'f131385236', '1'),
(24, '2021-05-19 17:02:53', '2021-05-19 17:10:51', 1, '2147483647', '115749', 'f123459632', '1'),
(25, '2021-05-19 17:24:27', '2021-05-19 17:26:05', 1, '15060715', '115749', 'v13131313', '1'),
(26, '2021-05-19 18:21:33', '2021-05-21 18:21:33', 1, '15060715', '115749', 'm026357489', '0');

-- --------------------------------------------------------

--
-- Structure de la table `etudiant`
--

CREATE TABLE `etudiant` (
  `CNE` varchar(50) NOT NULL,
  `CNI` varchar(50) NOT NULL,
  `CBR` varchar(50) NOT NULL,
  `nomEtu` varchar(50) DEFAULT NULL,
  `prenomEtu` varchar(50) DEFAULT NULL,
  `telephone` varchar(50) DEFAULT NULL,
  `codeFi` int(11) DEFAULT NULL,
  `dateAjout` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `etudiant`
--

INSERT INTO `etudiant` (`CNE`, `CNI`, `CBR`, `nomEtu`, `prenomEtu`, `telephone`, `codeFi`, `dateAjout`) VALUES
('D123456', 'D123456', '100000000005', 'loukili', 'soufiane', '064512369', 3, '2021-05-18 22:48:47'),
('f123459632', 't123459', 'C1000007F', 'aboumaarouf', 'lina', '0659263418', 1, NULL),
('f125236458789', 'Z123654', '100000000000', 'zerouqi', 'hamza', '0645123652', 3, NULL),
('F131385236', 'Q348122', 'C1000000F', 'Allaf', 'mohamed amine', '0672940257', 2, NULL),
('f5645123698', 'Q569874', '100000000001', 'sousi', 'saad', '0623154876', 2, '2021-05-07 17:20:08'),
('g159784521', 'e1236987', '100000000003', 'souhami', 'sariz', '03214569', 1, '2021-05-07 17:30:51'),
('K131491460', 'K123694aaaaaa', 'C1000001F', 'laabouriaa', 'badr', '0612369874', 3, NULL),
('m026357489', 'n098456', 'C1000003F', 'mouhsine', 'hanaa', '0678945637', 3, NULL),
('p159845612', 'r159753', 'C1000006F', 'sabriaa', 'walid', '0615487526', 5, NULL),
('t123654789', 'z159753', '100000000002', 'jagrouny', 'hajar', '0214578874', 2, '2021-05-07 17:28:11'),
('v13131313', 'v894562315', '100000000004', 'taikaaa', 'kawtar', '0672940257', 5, '2021-05-07 17:54:01'),
('y165489325', 'b021536', 'C1000004F', 'regragui', 'anas', '0656234589', 4, NULL),
('z159753692', 'R145287', 'C1000002F', 'darif', 'marouane', '0610235648', 1, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `exemplaire`
--

CREATE TABLE `exemplaire` (
  `codeBar` varchar(50) NOT NULL,
  `etatEx` int(11) NOT NULL,
  `ISBN` varchar(50) DEFAULT NULL,
  `codeEdi` int(11) DEFAULT NULL,
  `inv` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `exemplaire`
--

INSERT INTO `exemplaire` (`codeBar`, `etatEx`, `ISBN`, `codeEdi`, `inv`) VALUES
('1234567890', 1, '9780470840726', 18, '12456'),
('15060715', 1, '9780470840726', 37, '20000'),
('2147483647', 1, '9780470840726', 17, '14000'),
('A100000001', 1, '9782216333806', 14, '15963'),
('A100000002', 1, '9789953683218', 33, '12369'),
('A100000003', 1, '6222011599500', 31, '12350'),
('A100000005', 1, '9782226101211', 34, '9856'),
('A100000008', 0, '9780470840726', 35, '25896'),
('A100000011', 1, '9780471975083', 42, '14001'),
('C300000000000D', 1, '9782226101211', 36, '12365'),
('C300000000001D', 1, '6222011599500', 37, '14789'),
('C300000000002D', 1, '9789953683218', 38, '123678'),
('C300000000005D', 1, '9782216333806', 39, '12054'),
('C300000000008D', 1, '9782216333806', 41, '123658');

-- --------------------------------------------------------

--
-- Structure de la table `filiere`
--

CREATE TABLE `filiere` (
  `codeFi` int(11) NOT NULL,
  `libelleFi` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `filiere`
--

INSERT INTO `filiere` (`codeFi`, `libelleFi`) VALUES
(1, 'SMI'),
(2, 'SMP'),
(3, 'LPABD'),
(4, 'BIBDA'),
(5, 'SMA');

-- --------------------------------------------------------

--
-- Structure de la table `gestionnaire`
--

CREATE TABLE `gestionnaire` (
  `CBGest` varchar(50) NOT NULL,
  `cinG` varchar(50) NOT NULL,
  `nomG` varchar(50) NOT NULL,
  `prenomG` varchar(50) NOT NULL,
  `emailG` varchar(50) NOT NULL,
  `telephoneG` varchar(50) NOT NULL,
  `mdpG` varchar(50) NOT NULL,
  `dateinscripG` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `gestionnaire`
--

INSERT INTO `gestionnaire` (`CBGest`, `cinG`, `nomG`, `prenomG`, `emailG`, `telephoneG`, `mdpG`, `dateinscripG`) VALUES
('115749', 'Q348122', 'allafoo', 'amine', 'Amine.allafi@gmail.com', '0672940257', '123456', '2021-05-17'),
('144833', 'Q312614', 'allali', 'salah-eddine', 'allali.salah@gmail.com', '0623568974', 'azsdcvbb', '2021-04-17'),
('384503', 'Q344841', 'hamzaoui', 'hajar', 'aeeae@gmail.com', '0672940257', 'azzazea', '2021-04-17'),
('70641', 'azdz', 'zadzd', 'zazda', 'zazad', 'zdazda', 'zadzda', '2021-04-17'),
('915116', 'Q595666', 'dodp', 'tot', 'amalal', 'adkdld', 'azert', '2021-05-17'),
('990617', 'Q323572', 'jagrouny', 'hajar', 'Amine.allafi@gmail.com', '0672940257', 'azd', '2021-04-17');

-- --------------------------------------------------------

--
-- Structure de la table `historique`
--

CREATE TABLE `historique` (
  `id_rech` int(11) NOT NULL,
  `date_recherche` datetime NOT NULL DEFAULT current_timestamp(),
  `CNE` varchar(50) DEFAULT NULL,
  `text` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `historique`
--

INSERT INTO `historique` (`id_rech`, `date_recherche`, `CNE`, `text`) VALUES
(1, '2021-05-12 01:14:07', 'g159784521', 'informatique'),
(2, '2021-05-12 01:14:19', 'g159784521', 'informatique');

-- --------------------------------------------------------

--
-- Structure de la table `livre`
--

CREATE TABLE `livre` (
  `ISBN` varchar(50) NOT NULL,
  `titreLiv` varchar(50) NOT NULL,
  `nbExemplaire` varchar(50) NOT NULL,
  `codeDis` int(11) DEFAULT NULL,
  `coteL` varchar(50) NOT NULL,
  `description` varchar(50) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `livre`
--

INSERT INTO `livre` (`ISBN`, `titreLiv`, `nbExemplaire`, `codeDis`, `coteL`, `description`, `type`) VALUES
('6222011599500', 'onions', '2', 3, '9995char', 'onions,onions', 'livre'),
('9780470840726', 'abnormal psychology', '5', 1, '4451lam', 'psychlogy,room', 'Mémoire'),
('9780471975083', 'Software engineering', '5', 1, '6951kol', 'programmation,design roror', 'livre'),
('9781617293313', 'Angular in action', '5', 1, '1123694', 'programmation,web', 'Livre'),
('9781617293856', 'React.js', '3', 1, '122000', 'javascript,programmation,informatique', 'livre'),
('9782011558114', 'alter algo', '3', 4, '236nom', 'français informatique', 'thèse'),
('9782216333806', 'Tables financières et statistiques', '5', 2, '5966lak', 'economie frnacais', 'brevet'),
('9782226101211', 'Lune de sang', '2', 1, '1263mp', 'js prog info', 'livre'),
('9789953683218', 'attempt', '3', 2, '1236rk', 'js prog info', 'livre');

-- --------------------------------------------------------

--
-- Structure de la table `punir`
--

CREATE TABLE `punir` (
  `CNE` varchar(50) DEFAULT NULL,
  `codePun` int(11) DEFAULT NULL,
  `codeEmprunt` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `punir`
--

INSERT INTO `punir` (`CNE`, `codePun`, `codeEmprunt`) VALUES
('p159845612', 1, 2),
('t123654789', 1, 6),
('y165489325', 1, 16),
('g159784521', 1, 15);

-- --------------------------------------------------------

--
-- Structure de la table `punition`
--

CREATE TABLE `punition` (
  `codePun` int(11) NOT NULL,
  `libellePun` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `punition`
--

INSERT INTO `punition` (`codePun`, `libellePun`) VALUES
(1, 'courte'),
(2, 'permanante');

-- --------------------------------------------------------

--
-- Structure de la table `rechercheparjour`
--

CREATE TABLE `rechercheparjour` (
  `id_rech` int(11) NOT NULL,
  `date_rech` datetime NOT NULL DEFAULT current_timestamp(),
  `CNE` varchar(50) DEFAULT NULL,
  `text` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `rechercheparjour`
--

INSERT INTO `rechercheparjour` (`id_rech`, `date_rech`, `CNE`, `text`) VALUES
(12, '2021-05-12 01:01:07', 'z159753692', 'aaaaaaa'),
(13, '2021-05-12 01:15:33', 'z159753692', 'aaa'),
(14, '2021-05-12 01:18:02', 'v13131313', 'aaa'),
(15, '2021-05-12 01:28:32', 'z159753692', 'lol'),
(16, '2021-05-12 01:37:12', 'g159784521', 'informatique'),
(17, '2021-05-12 01:37:26', 'g159784521', '9782011558114'),
(18, '2021-05-12 05:56:49', 'g159784521', 'physique'),
(19, '2021-05-17 21:16:16', 'v13131313', 'informatique'),
(20, '2021-05-19 15:40:02', NULL, NULL),
(21, '2021-05-19 16:24:08', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `rediger`
--

CREATE TABLE `rediger` (
  `ISBN` varchar(50) NOT NULL,
  `codeAut` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `rediger`
--

INSERT INTO `rediger` (`ISBN`, `codeAut`) VALUES
('9780471975083', 45),
('9782216333806', 46),
('9780470840726', 47),
('6222011599500', 48),
('9789953683218', 49),
('9782226101211', 50),
('9782011558114', 51),
('9781617293856', 53),
('9781617293313', 55);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `auteur`
--
ALTER TABLE `auteur`
  ADD PRIMARY KEY (`codeAut`);

--
-- Index pour la table `discipline`
--
ALTER TABLE `discipline`
  ADD PRIMARY KEY (`codeDis`);

--
-- Index pour la table `edition`
--
ALTER TABLE `edition`
  ADD PRIMARY KEY (`codeEdi`);

--
-- Index pour la table `emprunt`
--
ALTER TABLE `emprunt`
  ADD PRIMARY KEY (`codeEmprunt`),
  ADD KEY `codeBar` (`codeBar`),
  ADD KEY `CBGest` (`CBGest`),
  ADD KEY `CNE` (`CNE`);

--
-- Index pour la table `etudiant`
--
ALTER TABLE `etudiant`
  ADD PRIMARY KEY (`CNE`,`CNI`,`CBR`),
  ADD UNIQUE KEY `UC_etudiant` (`CBR`),
  ADD KEY `codeFi` (`codeFi`);

--
-- Index pour la table `exemplaire`
--
ALTER TABLE `exemplaire`
  ADD PRIMARY KEY (`codeBar`),
  ADD KEY `ISBN` (`ISBN`),
  ADD KEY `codeEdi` (`codeEdi`);

--
-- Index pour la table `filiere`
--
ALTER TABLE `filiere`
  ADD PRIMARY KEY (`codeFi`);

--
-- Index pour la table `gestionnaire`
--
ALTER TABLE `gestionnaire`
  ADD PRIMARY KEY (`CBGest`,`cinG`);

--
-- Index pour la table `historique`
--
ALTER TABLE `historique`
  ADD PRIMARY KEY (`id_rech`),
  ADD KEY `CNE` (`CNE`);

--
-- Index pour la table `livre`
--
ALTER TABLE `livre`
  ADD PRIMARY KEY (`ISBN`),
  ADD KEY `codeDis` (`codeDis`);

--
-- Index pour la table `punir`
--
ALTER TABLE `punir`
  ADD KEY `CNE` (`CNE`),
  ADD KEY `codePun` (`codePun`),
  ADD KEY `codeEmprunt` (`codeEmprunt`);

--
-- Index pour la table `punition`
--
ALTER TABLE `punition`
  ADD PRIMARY KEY (`codePun`);

--
-- Index pour la table `rechercheparjour`
--
ALTER TABLE `rechercheparjour`
  ADD PRIMARY KEY (`id_rech`),
  ADD KEY `CNE` (`CNE`);

--
-- Index pour la table `rediger`
--
ALTER TABLE `rediger`
  ADD KEY `ISBN` (`ISBN`),
  ADD KEY `codeAut` (`codeAut`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `auteur`
--
ALTER TABLE `auteur`
  MODIFY `codeAut` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT pour la table `discipline`
--
ALTER TABLE `discipline`
  MODIFY `codeDis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `edition`
--
ALTER TABLE `edition`
  MODIFY `codeEdi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT pour la table `emprunt`
--
ALTER TABLE `emprunt`
  MODIFY `codeEmprunt` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT pour la table `filiere`
--
ALTER TABLE `filiere`
  MODIFY `codeFi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `historique`
--
ALTER TABLE `historique`
  MODIFY `id_rech` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `punition`
--
ALTER TABLE `punition`
  MODIFY `codePun` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `rechercheparjour`
--
ALTER TABLE `rechercheparjour`
  MODIFY `id_rech` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `emprunt`
--
ALTER TABLE `emprunt`
  ADD CONSTRAINT `emprunt_ibfk_1` FOREIGN KEY (`codeBar`) REFERENCES `exemplaire` (`codeBar`),
  ADD CONSTRAINT `emprunt_ibfk_3` FOREIGN KEY (`CBGest`) REFERENCES `gestionnaire` (`CBGest`),
  ADD CONSTRAINT `emprunt_ibfk_4` FOREIGN KEY (`CNE`) REFERENCES `etudiant` (`CNE`);

--
-- Contraintes pour la table `etudiant`
--
ALTER TABLE `etudiant`
  ADD CONSTRAINT `etudiant_ibfk_1` FOREIGN KEY (`codeFi`) REFERENCES `filiere` (`codeFi`);

--
-- Contraintes pour la table `exemplaire`
--
ALTER TABLE `exemplaire`
  ADD CONSTRAINT `exemplaire_ibfk_1` FOREIGN KEY (`ISBN`) REFERENCES `livre` (`ISBN`),
  ADD CONSTRAINT `exemplaire_ibfk_2` FOREIGN KEY (`codeEdi`) REFERENCES `edition` (`codeEdi`);

--
-- Contraintes pour la table `historique`
--
ALTER TABLE `historique`
  ADD CONSTRAINT `historique_ibfk_1` FOREIGN KEY (`CNE`) REFERENCES `etudiant` (`CNE`);

--
-- Contraintes pour la table `livre`
--
ALTER TABLE `livre`
  ADD CONSTRAINT `livre_ibfk_2` FOREIGN KEY (`codeDis`) REFERENCES `discipline` (`codeDis`);

--
-- Contraintes pour la table `punir`
--
ALTER TABLE `punir`
  ADD CONSTRAINT `punir_ibfk_1` FOREIGN KEY (`CNE`) REFERENCES `etudiant` (`CNE`),
  ADD CONSTRAINT `punir_ibfk_2` FOREIGN KEY (`codePun`) REFERENCES `punition` (`codePun`),
  ADD CONSTRAINT `punir_ibfk_3` FOREIGN KEY (`codeEmprunt`) REFERENCES `emprunt` (`codeEmprunt`);

--
-- Contraintes pour la table `rediger`
--
ALTER TABLE `rediger`
  ADD CONSTRAINT `rediger_ibfk_1` FOREIGN KEY (`ISBN`) REFERENCES `livre` (`ISBN`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rediger_ibfk_2` FOREIGN KEY (`codeAut`) REFERENCES `auteur` (`codeAut`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
