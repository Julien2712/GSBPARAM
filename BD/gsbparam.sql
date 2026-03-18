-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3307
-- Généré le : mer. 18 mars 2026 à 13:31
-- Version du serveur : 11.5.2-MariaDB
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gsbparam`
--

-- --------------------------------------------------------

--
-- Structure de la table `administrateur`
--

DROP TABLE IF EXISTS `administrateur`;
CREATE TABLE IF NOT EXISTS `administrateur` (
  `id` char(3) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `mdp` char(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Déchargement des données de la table `administrateur`
--

INSERT INTO `administrateur` (`id`, `nom`, `mdp`) VALUES
('1', 'LeBoss', 'TheBest$147#'),
('2', 'LeChefProjet', 'NearlyTheBest$280@');

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `id` char(3) NOT NULL,
  `libelle` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id`, `libelle`) VALUES
('CH', 'Cheveux'),
('FO', 'Forme'),
('PS', 'Protection Solaire');

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `id` varchar(32) NOT NULL,
  `dateCommande` datetime DEFAULT NULL,
  `idClient` int(10) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `I_FK_commande_utilisateur` (`idClient`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`id`, `dateCommande`, `idClient`) VALUES
('1101461660', '2024-09-01 00:00:00', 0),
('1101461665', '2024-09-01 00:00:00', 0),
('1101461666', '2025-10-02 00:00:00', 0),
('1101461667', '2025-10-09 00:00:00', 0),
('1101461668', '2025-10-09 00:00:00', 0),
('1101461669', '2025-10-09 00:00:00', 0),
('1101461670', '2025-10-09 00:00:00', 0),
('1101461671', '2025-10-09 00:00:00', 0),
('1101461672', '2025-10-09 00:00:00', 0),
('1101461673', '2025-10-09 00:00:00', 0),
('1101461674', '2025-10-09 00:00:00', 0);

-- --------------------------------------------------------

--
-- Structure de la table `contenir`
--

DROP TABLE IF EXISTS `contenir`;
CREATE TABLE IF NOT EXISTS `contenir` (
  `idCommande` varchar(32) NOT NULL,
  `idProduit` varchar(5) NOT NULL,
  `qte` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`idCommande`,`idProduit`),
  KEY `I_FK_CONTENIR_COMMANDE` (`idCommande`),
  KEY `I_FK_CONTENIR_Produit` (`idProduit`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Déchargement des données de la table `contenir`
--

INSERT INTO `contenir` (`idCommande`, `idProduit`, `qte`) VALUES
('1101461660', 'f03', 1),
('1101461660', 'p01', 1),
('1101461665', 'f05', 1),
('1101461665', 'p06', 1),
('1101461666', 'c02', 1),
('1101461666', 'c04', 1),
('1101461669', 'c03', 1),
('1101461669', 'c04', 1),
('1101461670', 'c03', 1),
('1101461670', 'c04', 1),
('1101461671', 'c02', 1),
('1101461673', 'c02', 1),
('1101461673', 'c03', 1),
('1101461674', 'c02', 1),
('1101461674', 'c03', 1);

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

DROP TABLE IF EXISTS `produit`;
CREATE TABLE IF NOT EXISTS `produit` (
  `id` varchar(5) NOT NULL,
  `description` char(50) DEFAULT NULL,
  `prix` decimal(10,2) DEFAULT NULL,
  `image` char(100) DEFAULT NULL,
  `idCategorie` char(3) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `I_FK_Produit_CATEGORIE` (`idCategorie`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`id`, `description`, `prix`, `image`, `idCategorie`) VALUES
('c01', 'Laino Shampooing Douche au Thé Vert BIO', 4.00, 'assets/images/laino-shampooing-douche-au-the-vert-bio-200ml.png', 'CH'),
('c02', 'Klorane fibres de lin baume après shampooing', 10.80, 'assets/images/klorane-fibres-de-lin-baume-apres-shampooing-150-ml.jpg', 'CH'),
('c03', 'Weleda Kids 2in1 Shower & Shampoo Orange fruitée', 4.00, 'assets/images/weleda-kids-2in1-shower-shampoo-orange-fruitee-150-ml.jpg', 'CH'),
('c04', 'Weleda Kids 2in1 Shower & Shampoo vanille douce', 4.00, 'assets/images/weleda-kids-2in1-shower-shampoo-vanille-douce-150-ml.jpg', 'CH'),
('c05', 'Klorane Shampooing sec à l\'extrait d\'ortie', 6.10, 'assets/images/klorane-shampooing-sec-a-l-extrait-d-ortie-spray-150ml.png', 'CH'),
('c06', 'Phytopulp mousse volume intense', 18.00, 'assets/images/phytopulp-mousse-volume-intense-200ml.jpg', 'CH'),
('c07', 'Bio Beaute by Nuxe Shampooing nutritif', 8.00, 'assets/images/bio-beaute-by-nuxe-shampooing-nutritif-200ml.png', 'CH'),
('f01', 'Nuxe Men Contour des Yeux Multi-Fonctions', 12.05, 'assets/images/nuxe-men-contour-des-yeux-multi-fonctions-15ml.png', 'FO'),
('f02', 'Tisane romon nature sommirel bio sachet 20', 5.50, 'assets/images/tisane-romon-nature-sommirel-bio-sachet-20.jpg', 'FO'),
('f03', 'La Roche Posay Cicaplast crème pansement', 11.00, 'assets/images/la-roche-posay-cicaplast-creme-pansement-40ml.jpg', 'FO'),
('f04', 'Futuro sport stabilisateur pour cheville', 26.50, 'assets/images/futuro-sport-stabilisateur-pour-cheville-deluxe-attelle-cheville.png', 'FO'),
('f05', 'Microlife pèse-personne électronique weegschaal', 63.00, 'assets/images/microlife-pese-personne-electronique-weegschaal-ws80.jpg', 'FO'),
('f06', 'Melapi Miel Thym Liquide 500g', 6.50, 'assets/images/melapi-miel-thym-liquide-500g.jpg', 'FO'),
('f07', 'Meli Meliflor Pollen 200g', 8.60, 'assets/images/melapi-pollen-250g.jpg', 'FO'),
('p01', 'Avène solaire Spray très haute protection', 22.00, 'assets/images/avene-solaire-spray-tres-haute-protection-spf50200ml.png', 'PS'),
('p02', 'Mustela Solaire Lait très haute Protection', 17.50, 'assets/images/mustela-solaire-lait-tres-haute-protection-spf50-100ml.jpg', 'PS'),
('p03', 'Isdin Eryfotona aAK fluid', 29.00, 'assets/images/isdin-eryfotona-aak-fluid-100-50ml.jpg', 'PS'),
('p04', 'La Roche Posay Anthélios 50+ Brume Visage', 8.75, 'assets/images/la-roche-posay-anthelios-50-brume-visage-toucher-sec-75ml.png', 'PS'),
('p05', 'Nuxe Sun Huile Lactée Capillaire Protectrice', 15.00, 'assets/images/nuxe-sun-huile-lactee-capillaire-protectrice-100ml.png', 'PS'),
('p06', 'Uriage Bariésun stick lèvres SPF30 4g', 5.65, 'assets/images/uriage-bariesun-stick-levres-spf30-4g.jpg', 'PS'),
('p07', 'Bioderma Cicabio creme SPF50+ 30ml', 13.70, 'assets/images/bioderma-cicabio-creme-spf50-30ml.png', 'PS');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `login` varchar(100) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) DEFAULT NULL,
  `mail` varchar(255) NOT NULL,
  `motdepasse` varchar(255) NOT NULL,
  `rue` varchar(255) DEFAULT NULL,
  `cp` varchar(10) DEFAULT NULL,
  `ville` varchar(100) DEFAULT NULL,
  `panier` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mail` (`mail`),
  UNIQUE KEY `login` (`login`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `login`, `nom`, `prenom`, `mail`, `motdepasse`, `rue`, `cp`, `ville`, `panier`) VALUES
(4, 'test', 'test', 'test', 'test@gmail.com', '$2y$10$pNNmjNFFDE8kwYFaXSDrluH55Kswjel.ZokS7YHn3f/W/slloFzWm', 'test', '45000', 'test', '{\"c02\":1}');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `FK_commande_utilisateur` FOREIGN KEY (`idClient`) REFERENCES `utilisateur` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `contenir`
--
ALTER TABLE `contenir`
  ADD CONSTRAINT `contenir_ibfk_1` FOREIGN KEY (`idCommande`) REFERENCES `commande` (`id`),
  ADD CONSTRAINT `contenir_ibfk_2` FOREIGN KEY (`idProduit`) REFERENCES `produit` (`id`);

--
-- Contraintes pour la table `produit`
--
ALTER TABLE `produit`
  ADD CONSTRAINT `produit_ibfk_1` FOREIGN KEY (`idCategorie`) REFERENCES `categorie` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
