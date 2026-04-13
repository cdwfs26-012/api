-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 13 avr. 2026 à 15:57
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
-- Base de données : `api-test-partiel`
--

-- --------------------------------------------------------

--
-- Structure de la table `address`
--

CREATE TABLE `address` (
  `id` binary(16) NOT NULL,
  `street` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `zip_code` varchar(10) NOT NULL,
  `country` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `address`
--

INSERT INTO `address` (`id`, `street`, `city`, `zip_code`, `country`) VALUES
(0x019d86ea37a9734b94bb820e5dffae80, '12 rue de la Paix', 'Chartres', '28000', 'France'),
(0x019d86ea37a977fb94bb820e5ef05654, '45 Avenue de la République', 'Lucé', '28110', 'France'),
(0x019d86ea37a97c9b94bb820e5fc4fcab, '8 Impasse des Lilas', 'Mainvilliers', '28300', 'France');

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `id` binary(16) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`id`, `name`, `email`, `phone_number`) VALUES
(0x019d86ea3dd07b55b518e9ee00de321e, 'Boulangerie Centrale', 'contact@boulangerie.fr', NULL),
(0x019d86ea3dd07bb1b518e9ee012a8a59, 'Supermarché Express', 'manager@express.fr', NULL),
(0x019d86ea3dd07bd5b518e9ee015d71c9, 'Restaurant du Port', 'chef@duport.fr', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `delivery`
--

CREATE TABLE `delivery` (
  `id` binary(16) NOT NULL,
  `planned_at` datetime DEFAULT NULL,
  `status` varchar(50) NOT NULL,
  `tour_id` binary(16) DEFAULT NULL,
  `client_id` binary(16) DEFAULT NULL,
  `address_id` binary(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `delivery`
--

INSERT INTO `delivery` (`id`, `planned_at`, `status`, `tour_id`, `client_id`, `address_id`) VALUES
(0x019d86ea3de07a969724a4da4d69580e, '2026-04-14 00:00:00', 'DELIVERED', 0x019d86ea3dde7d3f80a27d5b1257e7cb, 0x019d86ea3dd07b55b518e9ee00de321e, 0x019d86ea37a9734b94bb820e5dffae80),
(0x019d86ea3de07ae29724a4da4e273b76, '2026-04-14 01:00:00', 'DELIVERED', 0x019d86ea3dde7d0f80a27d5b11a060b8, 0x019d86ea3dd07b55b518e9ee00de321e, 0x019d86ea37a977fb94bb820e5ef05654),
(0x019d86ea3de07b0a9724a4da4f124023, '2026-04-14 02:00:00', 'DELIVERED', 0x019d86ea3dde7d3f80a27d5b1257e7cb, 0x019d86ea3dd07bb1b518e9ee012a8a59, 0x019d86ea37a977fb94bb820e5ef05654),
(0x019d86ea3de07b2a9724a4da4f8d2c07, '2026-04-14 03:00:00', 'CANCELLED', 0x019d86ea3dde7c9380a27d5b1199458f, 0x019d86ea3dd07bd5b518e9ee015d71c9, 0x019d86ea37a977fb94bb820e5ef05654),
(0x019d86ea3de07b469724a4da4fc7e939, '2026-04-14 04:00:00', 'PENDING', 0x019d86ea3dde7d3f80a27d5b1257e7cb, 0x019d86ea3dd07b55b518e9ee00de321e, 0x019d86ea37a977fb94bb820e5ef05654),
(0x019d86ea3de07b729724a4da500a5879, '2026-04-14 05:00:00', 'CANCELLED', 0x019d86ea3dde7d3f80a27d5b1257e7cb, 0x019d86ea3dd07bd5b518e9ee015d71c9, 0x019d86ea37a977fb94bb820e5ef05654);

-- --------------------------------------------------------

--
-- Structure de la table `delivery_item`
--

CREATE TABLE `delivery_item` (
  `id` binary(16) NOT NULL,
  `quantity` int(11) NOT NULL,
  `delivery_id` binary(16) DEFAULT NULL,
  `product_id` binary(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20260413125212', '2026-04-13 12:52:17', 447),
('DoctrineMigrations\\Version20260413125622', '2026-04-13 12:56:26', 11);

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

CREATE TABLE `product` (
  `id` binary(16) NOT NULL,
  `name` varchar(255) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `weight` double DEFAULT NULL,
  `volume` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `product`
--

INSERT INTO `product` (`id`, `name`, `updated_at`, `weight`, `volume`) VALUES
(0x019d86ea3dd07c85b518e9ee01aeba00, 'Farine 25kg', NULL, 25, NULL),
(0x019d86ea3dd07cb1b518e9ee02868604, 'Palette d\'eau', NULL, 500, NULL),
(0x019d86ea3dd07cd9b518e9ee0309cb61, 'Carton Surgelés', NULL, 15, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tour`
--

CREATE TABLE `tour` (
  `id` binary(16) NOT NULL,
  `reference` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `driver_id` binary(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tour`
--

INSERT INTO `tour` (`id`, `reference`, `date`, `driver_id`) VALUES
(0x019d86ea3dde7c9380a27d5b1199458f, 'TOUR-2026-001', '2026-04-13', 0x019d86ea3a277033af6063932afd5896),
(0x019d86ea3dde7d0f80a27d5b11a060b8, 'TOUR-2026-002', '2026-04-13', 0x019d86ea3b5f7bcba5030a1291f46ce5),
(0x019d86ea3dde7d3f80a27d5b1257e7cb, 'TOUR-2026-003', '2026-04-13', 0x019d86ea3c977be3a7a8aa7538fdd64f);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` binary(16) NOT NULL,
  `email` varchar(180) NOT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`roles`)),
  `password` varchar(255) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `first_name`, `last_name`, `phone_number`) VALUES
(0x019d86ea38ed76c484c50492e2e77a5c, 'admin@legendre.fr', '[\"ROLE_ADMIN\"]', '$2y$13$A7ghY8o6tCDNITmB5feby.gb8EiPoOsYioTc7L4l44lqQRNF/scSC', NULL, NULL, NULL),
(0x019d86ea3a277033af6063932afd5896, 'jean@legendre.fr', '[\"ROLE_CHAUFFEUR\"]', '$2y$13$2mNXdMVayGMv8aLZLUj9ku3BY2xvtu4z4vCdnELwsMJuJvKGObMzW', 'Jean', 'Logistique', NULL),
(0x019d86ea3b5f7bcba5030a1291f46ce5, 'marc@legendre.fr', '[\"ROLE_CHAUFFEUR\"]', '$2y$13$jeFuHFM/2J0kJbaXVzeuxOXejNwxa2V7T2K/pHeJ7VQC22ZldcRFK', 'Marc', 'Express', NULL),
(0x019d86ea3c977be3a7a8aa7538fdd64f, 'lucie@legendre.fr', '[\"ROLE_CHAUFFEUR\"]', '$2y$13$vcfv5G4SJCFdomR8cerTMeDKqw9wDkhyMHgiXoZmisRJamT18UIH6', 'Lucie', 'Transport', NULL),
(0x019d86ea3dd07869b518e9ee00d38a17, 'client@legendre.fr', '[\"ROLE_CLIENT\"]', '$2y$13$qJE0KLNMYrJifLemK7ZZ3.TRDyfbKzZFViOJlL9xEICpgDXRiYvHy', NULL, NULL, NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `delivery`
--
ALTER TABLE `delivery`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_3781EC1015ED8D43` (`tour_id`),
  ADD KEY `IDX_3781EC1019EB6921` (`client_id`),
  ADD KEY `IDX_3781EC10F5B7AF75` (`address_id`);

--
-- Index pour la table `delivery_item`
--
ALTER TABLE `delivery_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_CE87ED8412136921` (`delivery_id`),
  ADD KEY `IDX_CE87ED844584665A` (`product_id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tour`
--
ALTER TABLE `tour`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_6AD1F969C3423909` (`driver_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `delivery`
--
ALTER TABLE `delivery`
  ADD CONSTRAINT `FK_3781EC1015ED8D43` FOREIGN KEY (`tour_id`) REFERENCES `tour` (`id`),
  ADD CONSTRAINT `FK_3781EC1019EB6921` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`),
  ADD CONSTRAINT `FK_3781EC10F5B7AF75` FOREIGN KEY (`address_id`) REFERENCES `address` (`id`);

--
-- Contraintes pour la table `delivery_item`
--
ALTER TABLE `delivery_item`
  ADD CONSTRAINT `FK_CE87ED8412136921` FOREIGN KEY (`delivery_id`) REFERENCES `delivery` (`id`),
  ADD CONSTRAINT `FK_CE87ED844584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Contraintes pour la table `tour`
--
ALTER TABLE `tour`
  ADD CONSTRAINT `FK_6AD1F969C3423909` FOREIGN KEY (`driver_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
