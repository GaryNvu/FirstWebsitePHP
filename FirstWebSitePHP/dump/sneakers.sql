-- phpMyAdmin SQL Dump
-- version 5.0.4deb2
-- https://www.phpmyadmin.net/
--
-- Hôte : mysql.info.unicaen.fr:3306
-- Généré le : lun. 28 nov. 2022 à 13:50
-- Version du serveur :  10.5.11-MariaDB-1
-- Version de PHP : 7.4.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `22001800_bd`
--

-- --------------------------------------------------------

--
-- Structure de la table `sneakers`
--

CREATE TABLE `sneakers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `price` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `sneakers`
--

INSERT INTO `sneakers` (`id`, `name`, `image`, `brand`, `price`) VALUES
(1134, 'Air Max 270', '6383a97a4ca9a.jpg', 'Nike', 170),
(1135, '550', '6383a989d7867.jpg', 'New Balance', 120),
(1136, 'Air Force 1', '6383a99cc3990.jpg', 'Nike', 120),
(1137, 'Stansmith', '6383a9c01c56b.jpg', 'Adidas', 90),
(1138, 'X-Ray', '6383a9d01e3b5.jpg', 'Puma', 110),
(1139, 'Ozweego', '6383a9e266968.jpg', 'Adidas', 140);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `sneakers`
--
ALTER TABLE `sneakers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `sneakers`
--
ALTER TABLE `sneakers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1141;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
