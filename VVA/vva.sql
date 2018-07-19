-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Lun 21 Mai 2018 à 23:26
-- Version du serveur :  10.1.21-MariaDB
-- Version de PHP :  5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `vva`
--

-- --------------------------------------------------------

--
-- Structure de la table `compte`
--

CREATE TABLE `compte` (
  `USER` char(8) NOT NULL,
  `MDP` char(10) DEFAULT NULL,
  `NOMCPTE` char(40) DEFAULT NULL,
  `PRENOMCPTE` char(30) DEFAULT NULL,
  `DATEINSCRIP` date DEFAULT NULL,
  `DATEFERME` date DEFAULT NULL,
  `TYPECOMPTE` char(3) DEFAULT NULL,
  `ADRMAILCPTE` char(60) DEFAULT NULL,
  `NOTELCPTE` char(15) DEFAULT NULL,
  `NOPORTCPTE` char(15) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `compte`
--

INSERT INTO `compte` (`USER`, `MDP`, `NOMCPTE`, `PRENOMCPTE`, `DATEINSCRIP`, `DATEFERME`, `TYPECOMPTE`, `ADRMAILCPTE`, `NOTELCPTE`, `NOPORTCPTE`) VALUES
('MDurand', '123abc', 'DURAND', 'Marc', '2017-09-30', NULL, 'vac', 'durang.marc@email.com', '0651821763', '0651821764'),
('admin', '123abc', 'RAVELOSON', 'Fanilo', '2017-09-30', NULL, 'loc', 'raveloson.fanilo@test.com', '0651821761', '095082465'),
('GMoreau', '123abc', 'MOREAU', 'Geoffrey', '2018-05-13', NULL, 'vac', 'g.moreau@outlook.fr', '0651821754', '0651821754');

-- --------------------------------------------------------

--
-- Structure de la table `etat_resa`
--

CREATE TABLE `etat_resa` (
  `CODEETATRESA` char(2) NOT NULL,
  `NOMETATRESA` char(15) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `etat_resa`
--

INSERT INTO `etat_resa` (`CODEETATRESA`, `NOMETATRESA`) VALUES
('0', 'Bloquée'),
('1', 'Arrhes versées'),
('2', 'Solde'),
('3', 'Clés retirées'),
('4', 'Annulée'),
('5', 'Terminée');

-- --------------------------------------------------------

--
-- Structure de la table `hebergement`
--

CREATE TABLE `hebergement` (
  `NOHEB` int(11) NOT NULL,
  `CODETYPEHEB` char(5) NOT NULL,
  `NOMHEB` char(40) DEFAULT NULL,
  `NBPLACEHEB` int(11) DEFAULT NULL,
  `SURFACEHEB` int(11) DEFAULT NULL,
  `INTERNET` int(11) DEFAULT NULL,
  `ANNEEHEB` int(11) DEFAULT NULL,
  `SECTEURHEB` char(15) DEFAULT NULL,
  `ORIENTATIONHEB` char(5) DEFAULT NULL,
  `ETATHEB` char(32) DEFAULT NULL,
  `DESCRIHEB` char(200) DEFAULT NULL,
  `PHOTOHEB` char(100) DEFAULT NULL,
  `TARIFSEMHEB` decimal(7,2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `hebergement`
--

INSERT INTO `hebergement` (`NOHEB`, `CODETYPEHEB`, `NOMHEB`, `NBPLACEHEB`, `SURFACEHEB`, `INTERNET`, `ANNEEHEB`, `SECTEURHEB`, `ORIENTATIONHEB`, `ETATHEB`, `DESCRIHEB`, `PHOTOHEB`, `TARIFSEMHEB`) VALUES
(16, '1', 'Appartement - 4 personnes', 4, 50, 1, 1969, 'Alpes', 'Nord', 'Rénové', 'Un appartement pouvant accueillir 4 personnes au plus.', 'photo', '150.00'),
(10, '4', 'Les Balcons de la Vanoise', 6, 50, 1, 1995, 'Alpes', 'Nord', 'En rénovation', 'Résidence de tourisme 4* - Au cœur de la station - Piscine couverte chauffée - Sauna - Hammam - Bain à remous - Aire de jeux - Services inclus', 'http://image.noelshack.com/fichiers/2018/21/1/1526922981-residence-le-pic-de-l-ours8.jpg', '319.00'),
(9, '4', 'Chalet', 10, 1000, 1, 1950, 'Alpes', 'Est', 'Rénové', 'Un grand chalet pour 10 personnes, le service est offert.', 'a', '750.00'),
(15, '2', 'Bungalow - 3 Personnes', 3, 20, 1, 1950, 'Alpes', 'Sud', 'Rénové', 'Un bungalow pour 6 personnes, le service est offert.', 'photo', '50.00');

-- --------------------------------------------------------

--
-- Structure de la table `resa`
--

CREATE TABLE `resa` (
  `NOHEB` int(11) NOT NULL,
  `DATEDEBSEM` date NOT NULL,
  `USER` char(8) NOT NULL,
  `CODEETATRESA` char(2) NOT NULL,
  `DATERESA` date DEFAULT NULL,
  `DATEARRHES` date DEFAULT NULL,
  `MONTANTARRHES` decimal(7,2) DEFAULT NULL,
  `NBOCCUPANT` int(11) DEFAULT NULL,
  `TARIFSEMRESA` decimal(7,2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `resa`
--

INSERT INTO `resa` (`NOHEB`, `DATEDEBSEM`, `USER`, `CODEETATRESA`, `DATERESA`, `DATEARRHES`, `MONTANTARRHES`, `NBOCCUPANT`, `TARIFSEMRESA`) VALUES
(4, '2019-01-05', 'fravel', '3', '2018-05-21', NULL, NULL, 1, '100.00'),
(3, '2018-01-06', 'fravel', '0', '2018-01-03', NULL, NULL, 1, '100.00'),
(4, '2018-01-06', 'fravel', '1', '2018-01-03', NULL, NULL, 1, '100.00'),
(4, '2017-12-30', 'fravel', '1', '2017-11-25', NULL, NULL, 1, '100.00'),
(4, '2017-12-02', 'fravel', '1', '2017-11-25', NULL, NULL, 1, '100.00');

-- --------------------------------------------------------

--
-- Structure de la table `semaine`
--

CREATE TABLE `semaine` (
  `DATEDEBSEM` date NOT NULL,
  `DATEFINSEM` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `semaine`
--

INSERT INTO `semaine` (`DATEDEBSEM`, `DATEFINSEM`) VALUES
('2018-03-17', '2018-03-24'),
('2018-02-03', '2018-02-10'),
('2018-01-06', '2018-01-13'),
('2018-03-03', '2018-03-10'),
('2018-01-13', '2018-01-20'),
('2018-02-10', '2018-02-17'),
('2019-01-05', '2019-01-12'),
('2018-05-26', '2018-06-02'),
('2018-05-02', '2018-06-09'),
('2018-06-16', '2018-06-23'),
('0000-00-00', NULL),
('2018-07-07', '2018-07-14'),
('2018-08-04', '2018-08-11'),
('2018-09-01', '2018-09-08'),
('2019-02-02', '2019-02-09'),
('2018-10-06', '2018-10-13'),
('2018-10-13', '2018-10-20'),
('2018-10-20', '2018-10-27'),
('2018-11-03', '2018-11-10'),
('2018-11-10', '2018-11-17'),
('2018-11-17', '2018-11-24'),
('2018-12-01', '2018-12-08'),
('2018-12-08', '2018-12-15'),
('2018-12-15', '2018-12-21'),
('2018-12-21', '2018-12-28'),
('2019-01-12', '2019-01-19'),
('2019-01-19', '2019-01-26'),
('2019-02-09', '2019-02-16'),
('2019-02-16', '2019-02-23'),
('2019-02-23', '2019-02-20'),
('2019-03-02', '2019-03-13'),
('2019-03-09', '2019-03-13'),
('2019-03-16', '2019-03-13'),
('2019-03-23', '2019-03-13'),
('2019-04-06', '2019-04-13'),
('2019-04-13', '2019-04-20'),
('2019-04-20', '2019-04-27');

-- --------------------------------------------------------

--
-- Structure de la table `type_heb`
--

CREATE TABLE `type_heb` (
  `CODETYPEHEB` char(5) NOT NULL,
  `NOMTYPEHEB` char(30) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `type_heb`
--

INSERT INTO `type_heb` (`CODETYPEHEB`, `NOMTYPEHEB`) VALUES
('1', 'Appartement'),
('2', 'Bungalow'),
('3', 'Mobil home'),
('4', 'Chalet');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `compte`
--
ALTER TABLE `compte`
  ADD PRIMARY KEY (`USER`);

--
-- Index pour la table `etat_resa`
--
ALTER TABLE `etat_resa`
  ADD PRIMARY KEY (`CODEETATRESA`);

--
-- Index pour la table `hebergement`
--
ALTER TABLE `hebergement`
  ADD PRIMARY KEY (`NOHEB`),
  ADD KEY `FK_HEBERGEMENT_TYPE_HEB` (`CODETYPEHEB`);

--
-- Index pour la table `resa`
--
ALTER TABLE `resa`
  ADD PRIMARY KEY (`NOHEB`,`DATEDEBSEM`),
  ADD KEY `FK_RESA_COMPTE` (`USER`),
  ADD KEY `FK_RESA_SEMAINE` (`DATEDEBSEM`),
  ADD KEY `FK_RESA_ETAT_RESA` (`CODEETATRESA`);

--
-- Index pour la table `semaine`
--
ALTER TABLE `semaine`
  ADD PRIMARY KEY (`DATEDEBSEM`);

--
-- Index pour la table `type_heb`
--
ALTER TABLE `type_heb`
  ADD PRIMARY KEY (`CODETYPEHEB`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `hebergement`
--
ALTER TABLE `hebergement`
  MODIFY `NOHEB` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
