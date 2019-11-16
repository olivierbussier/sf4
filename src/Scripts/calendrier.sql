-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  sam. 16 nov. 2019 à 09:22
-- Version du serveur :  5.7.21
-- Version de PHP :  7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Déchargement des données de la table `preprod_calendrier`
--

INSERT INTO `calendrier` (`id`, `date`, `lieu`, `seance_materiel`, `resp_materiel`, `seance_bassin`, `resp_bassin`, `seance_gonflage`, `resp_gonflage`, `aide_gonf1`, `aide1validee`, `aide_gonf2`, `aide2validee`, `aide_gonf3`, `aide3validee`, `archive`) VALUES
(319, '2019-09-17', 'HE', 'O', 'COLOMBET Philippe', 'I', '', 'O', '', '', 'NA', '', 'NA', '', 'NA', 'NON'),
(320, '2019-09-24', 'HE', 'O', 'COLOMBET Philippe', 'O', 'DELONG Patrick', 'O', 'PAILLOTIN Jean-Francois', 'PAYNO Henri', 'NA', '', 'NA', '', 'NA', 'NON'),
(321, '2019-10-01', 'HE', 'O', 'DELONG Patrick', 'O', 'DELONG Patrick', 'O', 'CAPIOMONT Yves', '', 'NA', '', 'NA', '', 'NA', 'NON'),
(322, '2019-10-08', 'HE', 'O', 'DELONG Patrick', 'O', 'DELONG Patrick', 'O', 'POLLIN Guillaume', 'DECOSTER Olivier', 'O', 'PALERMO Morgan', 'O', 'CHAMBOLLE PACAUD Margot', 'O', 'NON'),
(323, '2019-10-15', 'HE', 'O', 'DELONG Patrick', 'O', 'DELONG Patrick', 'O', 'BUSSIER Olivier', 'PALERMO Morgan', 'NA', 'MAINDET Caroline', 'NA', 'DECOSTER Olivier', 'NA', 'NON'),
(324, '2019-10-22', 'HE', 'O', 'DELONG Patrick', 'O', 'DELONG Patrick', 'O', 'PAILLOTIN Jean-Francois', 'PERY Quentin', 'N', 'GARCIA Nathalie', 'O', 'DUMAS Lionel', 'O', 'NON'),
(325, '2019-10-29', 'HE', 'N', 'DELONG Patrick', 'N', '', 'N', '', '', 'NA', '', 'NA', '', 'NA', 'NON'),
(326, '2019-11-05', 'HE', 'O', 'COLOMBET Philippe', 'O', 'MORAND Serge', 'O', 'PAILLOTIN Jean-Francois', 'CHAMBOLLE PACAUD Margot', 'NA', 'LOUAAR Amar', 'NA', 'KHERKHACHE Imad', 'NA', 'NON'),
(327, '2019-11-12', 'HE', 'O', 'COLOMBET Philippe', 'O', 'MORAND Serge', 'O', 'BUSSIER Olivier', 'LOUAAR Amar', 'NA', 'KHERKHACHE Imad', 'NA', 'BUT Ludovic', 'NA', 'NON'),
(328, '2019-11-19', 'HE', 'O', 'PAILLOTIN Jean-Francois', 'O', 'DELONG Patrick', 'O', 'CAPIOMONT Yves', 'COSTE Marc', 'NA', 'SCHMUTZ Catherine', 'NA', 'DELAMARRE Olivier', 'NA', 'NON'),
(329, '2019-11-26', 'HE', 'O', 'POLLIN Guillaume', 'O', 'DELONG Patrick', 'O', 'POLLIN Guillaume', 'GARCIA Nathalie', 'NA', 'DUMAS Lionel', 'NA', 'MUR Stephanie', 'NA', 'NON'),
(330, '2019-12-03', 'HE', 'O', 'PAILLOTIN Jean-Francois', 'O', 'DELONG Patrick', 'O', 'PAILLOTIN Jean-Francois', 'PUECH Florent', 'NA', 'CERANA Sophie', 'NA', 'SCHMUTZ Catherine', 'NA', 'NON'),
(331, '2019-12-10', 'HE', 'O', '', 'O', 'DELONG Patrick', 'O', 'BUSSIER Olivier', 'BUT Ludovic', 'NA', 'DELAMARRE Olivier', 'NA', 'COURGOULET Guillaume', 'NA', 'NON'),
(332, '2019-12-17', 'HE', 'O', '', 'O', 'DELONG Patrick', 'O', 'CAPIOMONT Yves', 'MUR Stephanie', 'NA', 'DUVERT Gilles', 'NA', 'BROGUIERE Dominique', 'NA', 'NON'),
(333, '2019-12-24', 'HE', 'N', '', 'N', '', 'N', '', '', 'NA', '', 'NA', '', 'NA', 'NON'),
(334, '2019-12-31', 'HE', 'N', '', 'N', '', 'N', '', '', 'NA', '', 'NA', '', 'NA', 'NON'),
(335, '2020-01-07', 'HE', 'O', 'POLLIN Guillaume', 'O', '', 'O', 'POLLIN Guillaume', 'COSTE Marc', 'NA', 'NICHILO Franck', 'NA', '', 'NA', 'NON'),
(336, '2020-01-14', 'HE', 'O', '', 'O', '', 'O', '', 'NICHILO Franck', 'NA', 'HILAIRE Daniel', 'NA', '', 'NA', 'NON'),
(337, '2020-01-21', 'HE', 'O', '', 'O', '', 'O', '', 'PUECH Florent', 'NA', 'CERANA Sophie', 'NA', 'COURGOULET Guillaume', 'NA', 'NON'),
(338, '2020-01-28', 'HE', 'O', '', 'O', '', 'O', '', 'HILAIRE Daniel', 'NA', 'CARLU Joffrey', 'NA', '', 'NA', 'NON'),
(339, '2020-02-04', 'HE', 'O', '', 'O', '', 'O', '', 'CARLU Joffrey', 'NA', '', 'NA', '', 'NA', 'NON'),
(340, '2020-02-11', 'HE', 'O', '', 'O', '', 'O', '', 'FERNANDES Jeremy', 'NA', 'DE PREITER-BAISE Martin', 'NA', '', 'NA', 'NON'),
(341, '2020-02-18', 'HE', 'O', '', 'O', '', 'O', '', 'FERNANDES Jeremy', 'NA', 'DE PREITER-BAISE Martin', 'NA', '', 'NA', 'NON'),
(342, '2020-02-25', 'HE', 'N', '', 'N', '', 'N', '', '', 'NA', '', 'NA', '', 'NA', 'NON'),
(343, '2020-03-03', 'HE', 'O', '', 'O', '', 'O', '', 'BOMBARDIER Pascale', 'NA', 'BOMBARDIER Marc', 'NA', '', 'NA', 'NON'),
(344, '2020-03-10', 'HE', 'O', '', 'O', '', 'O', '', '', 'NA', '', 'NA', '', 'NA', 'NON'),
(345, '2020-03-17', 'HE', 'O', '', 'O', '', 'O', '', '', 'NA', '', 'NA', '', 'NA', 'NON'),
(346, '2020-03-24', 'HE', 'O', '', 'O', '', 'O', '', 'BOMBARDIER Pascale', 'NA', 'BOMBARDIER Marc', 'NA', '', 'NA', 'NON'),
(347, '2020-03-31', 'HE', 'O', '', 'O', '', 'O', '', '', 'NA', '', 'NA', '', 'NA', 'NON'),
(348, '2020-04-07', 'HE', 'O', '', 'O', '', 'O', '', '', 'NA', '', 'NA', '', 'NA', 'NON'),
(349, '2020-04-14', 'HE', 'O', '', 'O', '', 'O', '', '', 'NA', '', 'NA', '', 'NA', 'NON'),
(350, '2020-04-21', 'HE', 'N', '', 'N', '', 'N', '', '', 'NA', '', 'NA', '', 'NA', 'NON'),
(351, '2020-04-28', 'HE', 'O', '', 'O', '', 'O', '', 'FORTIER Marion', 'NA', '', 'NA', '', 'NA', 'NON'),
(352, '2020-05-05', 'HE', 'O', '', 'O', '', 'O', '', 'FORTIER Marion', 'NA', '', 'NA', '', 'NA', 'NON'),
(353, '2020-05-12', 'HE', 'O', '', 'O', '', 'O', '', '', 'NA', '', 'NA', '', 'NA', 'NON'),
(354, '2020-05-19', 'HE', 'O', '', 'O', '', 'O', '', '', 'NA', '', 'NA', '', 'NA', 'NON'),
(355, '2020-05-26', 'HE', 'O', '', 'O', '', 'O', '', '', 'NA', '', 'NA', '', 'NA', 'NON'),
(356, '2020-06-02', 'HE', 'O', '', 'O', '', 'O', '', '', 'NA', '', 'NA', '', 'NA', 'NON'),
(357, '2020-06-09', 'HE', 'O', '', 'O', '', 'O', '', '', 'NA', '', 'NA', '', 'NA', 'NON'),
(358, '2020-06-16', 'HE', 'O', '', 'O', '', 'O', '', '', 'NA', '', 'NA', '', 'NA', 'NON'),
(359, '2020-06-23', 'HE', 'O', '', 'O', '', 'O', '', '', 'NA', '', 'NA', '', 'NA', 'NON'),
(360, '2020-06-30', 'HE', 'O', '', 'O', '', 'O', '', '', 'NA', '', 'NA', '', 'NA', 'NON');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
