-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 17, 2019 at 02:10 AM
-- Server version: 5.7.23
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `biohomie`
--

-- --------------------------------------------------------

--
-- Table structure for table `aliase`
--

DROP TABLE IF EXISTS `aliase`;
CREATE TABLE IF NOT EXISTS `aliase` (
  `aliase_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_ID` int(10) UNSIGNED NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`aliase_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `user_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(60) NOT NULL,
  `user_confirmed` varchar(10) NOT NULL,
  `user_level` int(10) UNSIGNED NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_ID`, `first_name`, `last_name`, `email`, `password`, `user_confirmed`, `user_level`, `date_created`) VALUES
(13, 'Erich', 'Tefft', 'erich.tefft@gmail.com', '$2y$10$5tD0H/wm4ZQ8i8MsK8rP1OveLwG6U3ttzV0mpjgXPh13/kPMlIqbO', 'no', 1, '2019-10-15 16:14:02'),
(14, 'Erich', 'Tefft', 'erich.teft@gmail.com', '$2y$10$DxChr.ARzmIuhttrP0LcMuoXfv98/TRZ8iF1qPHzYfGBeDgTNH0Qm', 'no', 1, '2019-10-15 16:21:22'),
(15, 'Erich', 'Tefft', 'eric.tefft@gmail.com', '$2y$10$Cz.YXBSQRdd9.l.6B5MuzeVuFWUnYYwib2vH25R6XifYvpYydE6Zy', 'no', 1, '2019-10-15 16:23:40'),
(16, 'Erich', 'Tefft', 'tefft@gmail.com', '$2y$10$ddK1aiP/HtinTz46k5JeKO86wjc9KQmQFSJx61z6DJeJPmN5GmqPO', 'no', 1, '2019-10-15 16:24:54'),
(17, 'Tim', 'Tefft', 'tim@gmail.com', '$2y$10$zUjJ5DPWVw5YYx/ITwHZjOprwqVYJh5dG7kmmo9MEldkuLxKyVpHa', 'no', 1, '2019-10-15 18:28:07');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
