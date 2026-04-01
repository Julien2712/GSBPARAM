-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3307
-- Généré le : mer. 01 avr. 2026 à 12:58
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
-- Base de données : `test`
--

-- --------------------------------------------------------

--
-- Structure de la table `associer`
--

DROP TABLE IF EXISTS `associer`;
CREATE TABLE IF NOT EXISTS `associer` (
  `prodId` varchar(5) NOT NULL,
  `prodId_produit` varchar(5) NOT NULL,
  PRIMARY KEY (`prodId`,`prodId_produit`),
  KEY `associer_prodId_produit_FK` (`prodId_produit`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `avis`
--

DROP TABLE IF EXISTS `avis`;
CREATE TABLE IF NOT EXISTS `avis` (
  `utiId` int(11) NOT NULL,
  `prodId` varchar(5) NOT NULL,
  `note` int(11) NOT NULL,
  `date` date NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`utiId`,`prodId`),
  KEY `avis_prodId_FK` (`prodId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

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
-- Structure de la table `connexion`
--

DROP TABLE IF EXISTS `connexion`;
CREATE TABLE IF NOT EXISTS `connexion` (
  `conId` int(11) NOT NULL,
  `conMdp` varchar(255) NOT NULL,
  PRIMARY KEY (`conId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Déchargement des données de la table `connexion`
--

INSERT INTO `connexion` (`conId`, `conMdp`) VALUES
(1, '$2y$10$pNNmjNFFDE8kwYFaXSDrluH55Kswjel.ZokS7YHn3f/W/slloFzWm'),
(2, 'TheBest$147#'),
(3, 'NearlyTheBest$280@');

-- --------------------------------------------------------

--
-- Structure de la table `habilitation`
--

DROP TABLE IF EXISTS `habilitation`;
CREATE TABLE IF NOT EXISTS `habilitation` (
  `habId` int(11) NOT NULL,
  `habLibelle` varchar(255) NOT NULL,
  PRIMARY KEY (`habId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Déchargement des données de la table `habilitation`
--

INSERT INTO `habilitation` (`habId`, `habLibelle`) VALUES
(1, 'Client'),
(2, 'Administrateur');

-- --------------------------------------------------------

--
-- Structure de la table `lignecommande`
--

DROP TABLE IF EXISTS `lignecommande`;
CREATE TABLE IF NOT EXISTS `lignecommande` (
  `ligneID` int(11) NOT NULL AUTO_INCREMENT,
  `ligneQuantite` int(11) NOT NULL,
  `prodId` varchar(5) NOT NULL,
  `panierID` bigint(20) NOT NULL,
  PRIMARY KEY (`ligneID`),
  KEY `lignecommande_prodId_FK` (`prodId`),
  KEY `lignecommande_panierID_FK` (`panierID`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Déchargement des données de la table `lignecommande`
--

INSERT INTO `lignecommande` (`ligneID`, `ligneQuantite`, `prodId`, `panierID`) VALUES
(1, 1, 'f03', 1101461660),
(2, 1, 'p01', 1101461660),
(3, 1, 'f05', 1101461665),
(4, 1, 'p06', 1101461665),
(5, 1, 'c02', 1101461666),
(6, 1, 'c04', 1101461666),
(7, 1, 'c03', 1101461669),
(8, 1, 'c04', 1101461669),
(9, 1, 'c03', 1101461670),
(10, 1, 'c04', 1101461670),
(11, 1, 'c02', 1101461671),
(12, 1, 'c02', 1101461673),
(13, 1, 'c03', 1101461673),
(14, 1, 'c02', 1101461674),
(15, 1, 'c03', 1101461674);

-- --------------------------------------------------------

--
-- Structure de la table `marque`
--

DROP TABLE IF EXISTS `marque`;
CREATE TABLE IF NOT EXISTS `marque` (
  `marqueID` int(11) NOT NULL,
  `marqueLibelle` varchar(3) NOT NULL,
  PRIMARY KEY (`marqueID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Déchargement des données de la table `marque`
--

INSERT INTO `marque` (`marqueID`, `marqueLibelle`) VALUES
(1, 'GEN');

-- --------------------------------------------------------

--
-- Structure de la table `panier_commande`
--

DROP TABLE IF EXISTS `panier_commande`;
CREATE TABLE IF NOT EXISTS `panier_commande` (
  `panierID` bigint(20) NOT NULL,
  `panierDate` date NOT NULL,
  `dateCommande` date NOT NULL,
  `etatCommande` varchar(255) NOT NULL,
  `utiId` int(11) DEFAULT NULL,
  PRIMARY KEY (`panierID`),
  KEY `panier_commande_utiId_FK` (`utiId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Déchargement des données de la table `panier_commande`
--

INSERT INTO `panier_commande` (`panierID`, `panierDate`, `dateCommande`, `etatCommande`, `utiId`) VALUES
(1101461660, '2024-09-01', '2024-09-01', 'validée', NULL),
(1101461665, '2024-09-01', '2024-09-01', 'validée', NULL),
(1101461666, '2025-10-02', '2025-10-02', 'validée', NULL),
(1101461667, '2025-10-09', '2025-10-09', 'validée', NULL),
(1101461668, '2025-10-09', '2025-10-09', 'validée', NULL),
(1101461669, '2025-10-09', '2025-10-09', 'validée', NULL),
(1101461670, '2025-10-09', '2025-10-09', 'validée', NULL),
(1101461671, '2025-10-09', '2025-10-09', 'validée', NULL),
(1101461672, '2025-10-09', '2025-10-09', 'validée', NULL),
(1101461673, '2025-10-09', '2025-10-09', 'validée', NULL),
(1101461674, '2025-10-09', '2025-10-09', 'validée', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

DROP TABLE IF EXISTS `produit`;
CREATE TABLE IF NOT EXISTS `produit` (
  `prodId` varchar(5) NOT NULL,
  `prodDescription` char(50) DEFAULT NULL,
  `prodPrix` decimal(10,2) DEFAULT NULL,
  `prodImage` char(100) DEFAULT NULL,
  `prodDateAjout` date DEFAULT NULL,
  `prodStock` int(11) NOT NULL DEFAULT 0,
  `prodContenance` int(11) NOT NULL DEFAULT 0,
  `dateMiseEnAvantDebut` date DEFAULT NULL,
  `dateMiseEnAvantfin` date DEFAULT NULL,
  `idCategorie` char(3) DEFAULT NULL,
  `marqueID` int(11) NOT NULL,
  PRIMARY KEY (`prodId`),
  KEY `produit_idCategorie_FK` (`idCategorie`),
  KEY `produit_marqueID_FK` (`marqueID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`prodId`, `prodDescription`, `prodPrix`, `prodImage`, `prodDateAjout`, `prodStock`, `prodContenance`, `dateMiseEnAvantDebut`, `dateMiseEnAvantfin`, `idCategorie`, `marqueID`) VALUES
('c01', 'Laino Shampooing Douche Thé Vert BIO', 4.00, 'assets/images/laino-shampooing-douche-au-the-vert-bio-200ml.png', '2026-04-01', 0, 0, NULL, NULL, 'CH', 1),
('c02', 'Klorane fibres de lin baume shampooing', 10.80, 'assets/images/klorane-fibres-de-lin-baume-apres-shampooing-150-ml.jpg', '2026-04-01', 0, 0, NULL, NULL, 'CH', 1),
('c03', 'Weleda Kids 2in1 Orange fruitée', 4.00, 'assets/images/weleda-kids-2in1-shower-shampoo-orange-fruitee-150-ml.jpg', '2026-04-01', 0, 0, NULL, NULL, 'CH', 1),
('c04', 'Weleda Kids 2in1 vanille douce', 4.00, 'assets/images/weleda-kids-2in1-shower-shampoo-vanille-douce-150-ml.jpg', '2026-04-01', 0, 0, NULL, NULL, 'CH', 1),
('c05', 'Klorane Shampooing sec ortie', 6.10, 'assets/images/klorane-shampooing-sec-a-l-extrait-d-ortie-spray-150ml.png', '2026-04-01', 0, 0, NULL, NULL, 'CH', 1),
('c06', 'Phytopulp mousse volume intense', 18.00, 'assets/images/phytopulp-mousse-volume-intense-200ml.jpg', '2026-04-01', 0, 0, NULL, NULL, 'CH', 1),
('c07', 'Bio Beaute by Nuxe Shampooing nutritif', 8.00, 'assets/images/bio-beaute-by-nuxe-shampooing-nutritif-200ml.png', '2026-04-01', 0, 0, NULL, NULL, 'CH', 1),
('c08', 'TEST', 100.00, NULL, '2026-04-01', 0, 0, NULL, NULL, NULL, 1),
('f01', 'Nuxe Men Contour des Yeux', 12.05, 'assets/images/nuxe-men-contour-des-yeux-multi-fonctions-15ml.png', '2026-04-01', 0, 0, NULL, NULL, 'FO', 1),
('f02', 'Tisane romon nature sommirel bio', 5.50, 'assets/images/tisane-romon-nature-sommirel-bio-sachet-20.jpg', '2026-04-01', 0, 0, NULL, NULL, 'FO', 1),
('f03', 'La Roche Posay Cicaplast crème', 11.00, 'assets/images/la-roche-posay-cicaplast-creme-pansement-40ml.jpg', '2026-04-01', 0, 0, NULL, NULL, 'FO', 1),
('f04', 'Futuro sport stabilisateur cheville', 26.50, 'assets/images/futuro-sport-stabilisateur-pour-cheville-deluxe-attelle-cheville.png', '2026-04-01', 0, 0, NULL, NULL, 'FO', 1),
('f05', 'Microlife pèse-personne électronique', 63.00, 'assets/images/microlife-pese-personne-electronique-weegschaal-ws80.jpg', '2026-04-01', 0, 0, NULL, NULL, 'FO', 1),
('f06', 'Melapi Miel Thym Liquide 500g', 6.50, 'assets/images/melapi-miel-thym-liquide-500g.jpg', '2026-04-01', 0, 0, NULL, NULL, 'FO', 1),
('f07', 'Meli Meliflor Pollen 200g', 8.60, 'assets/images/melapi-pollen-250g.jpg', '2026-04-01', 0, 0, NULL, NULL, 'FO', 1),
('p01', 'Avène solaire Spray SPF50', 22.00, 'assets/images/avene-solaire-spray-tres-haute-protection-spf50200ml.png', '2026-04-01', 0, 0, NULL, NULL, 'PS', 1),
('p02', 'Mustela Solaire Lait SPF50', 17.50, 'assets/images/mustela-solaire-lait-tres-haute-protection-spf50-100ml.jpg', '2026-04-01', 0, 0, NULL, NULL, 'PS', 1),
('p03', 'Isdin Eryfotona aAK fluid', 29.00, 'assets/images/isdin-eryfotona-aak-fluid-100-50ml.jpg', '2026-04-01', 0, 0, NULL, NULL, 'PS', 1),
('p04', 'La Roche Posay Anthélios Brume', 8.75, 'assets/images/la-roche-posay-anthelios-50-brume-visage-toucher-sec-75ml.png', '2026-04-01', 0, 0, NULL, NULL, 'PS', 1),
('p05', 'Nuxe Sun Huile Lactée Capillaire', 15.00, 'assets/images/nuxe-sun-huile-lactee-capillaire-protectrice-100ml.png', '2026-04-01', 0, 0, NULL, NULL, 'PS', 1),
('p06', 'Uriage Bariésun stick lèvres SPF30', 5.65, 'assets/images/uriage-bariesun-stick-levres-spf30-4g.jpg', '2026-04-01', 0, 0, NULL, NULL, 'PS', 1),
('p07', 'Bioderma Cicabio creme SPF50+', 13.70, 'assets/images/bioderma-cicabio-creme-spf50-30ml.png', '2026-04-01', 0, 0, NULL, NULL, 'PS', 1);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `utiId` int(11) NOT NULL,
  `utiLogin` varchar(100) NOT NULL,
  `utiNom` varchar(255) DEFAULT NULL,
  `utiMail` varchar(255) DEFAULT NULL,
  `utiCp` char(5) DEFAULT NULL,
  `utiVille` varchar(255) DEFAULT NULL,
  `utiAdresse` varchar(255) DEFAULT NULL,
  `habId` int(11) NOT NULL,
  `conId` int(11) DEFAULT NULL,
  PRIMARY KEY (`utiId`),
  UNIQUE KEY `utiLogin_UNQ` (`utiLogin`),
  UNIQUE KEY `conId_UNQ` (`conId`),
  KEY `utilisateur_habId_FK` (`habId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`utiId`, `utiLogin`, `utiNom`, `utiMail`, `utiCp`, `utiVille`, `utiAdresse`, `habId`, `conId`) VALUES
(1, 'test', 'test', 'test@gmail.com', '45000', 'test', 'test', 1, 1),
(2, 'LeBoss', 'LeBoss', NULL, NULL, NULL, NULL, 2, 2),
(3, 'LeChefProjet', 'LeChefProjet', NULL, NULL, NULL, NULL, 2, 3);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `associer`
--
ALTER TABLE `associer`
  ADD CONSTRAINT `associer_prodId_FK` FOREIGN KEY (`prodId`) REFERENCES `produit` (`prodId`),
  ADD CONSTRAINT `associer_prodId_produit_FK` FOREIGN KEY (`prodId_produit`) REFERENCES `produit` (`prodId`);

--
-- Contraintes pour la table `avis`
--
ALTER TABLE `avis`
  ADD CONSTRAINT `avis_prodId_FK` FOREIGN KEY (`prodId`) REFERENCES `produit` (`prodId`),
  ADD CONSTRAINT `avis_utiId_FK` FOREIGN KEY (`utiId`) REFERENCES `utilisateur` (`utiId`);

--
-- Contraintes pour la table `lignecommande`
--
ALTER TABLE `lignecommande`
  ADD CONSTRAINT `lignecommande_panierID_FK` FOREIGN KEY (`panierID`) REFERENCES `panier_commande` (`panierID`),
  ADD CONSTRAINT `lignecommande_prodId_FK` FOREIGN KEY (`prodId`) REFERENCES `produit` (`prodId`);

--
-- Contraintes pour la table `panier_commande`
--
ALTER TABLE `panier_commande`
  ADD CONSTRAINT `panier_commande_utiId_FK` FOREIGN KEY (`utiId`) REFERENCES `utilisateur` (`utiId`);

--
-- Contraintes pour la table `produit`
--
ALTER TABLE `produit`
  ADD CONSTRAINT `produit_idCategorie_FK` FOREIGN KEY (`idCategorie`) REFERENCES `categorie` (`id`),
  ADD CONSTRAINT `produit_marqueID_FK` FOREIGN KEY (`marqueID`) REFERENCES `marque` (`marqueID`);

--
-- Contraintes pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD CONSTRAINT `utilisateur_conId_FK` FOREIGN KEY (`conId`) REFERENCES `connexion` (`conId`),
  ADD CONSTRAINT `utilisateur_habId_FK` FOREIGN KEY (`habId`) REFERENCES `habilitation` (`habId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
