-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 21, 2020 at 02:35 AM
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
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `comment_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_ID` int(11) NOT NULL,
  `discussion_ID` int(11) NOT NULL,
  `comments` text NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `comment_edited` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`comment_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `discussion`
--

DROP TABLE IF EXISTS `discussion`;
CREATE TABLE IF NOT EXISTS `discussion` (
  `discussion_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_ID` int(11) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `post` mediumtext NOT NULL,
  `comment_ID` int(11) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `discussion_edited` timestamp NULL DEFAULT NULL,
  `images` tinyint(1) NOT NULL,
  PRIMARY KEY (`discussion_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=89 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

DROP TABLE IF EXISTS `image`;
CREATE TABLE IF NOT EXISTS `image` (
  `image_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_ID` int(11) NOT NULL,
  `discussion_ID` int(11) NOT NULL,
  `image_url` varchar(100) NOT NULL,
  `profile` tinyint(1) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`image_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

DROP TABLE IF EXISTS `tag`;
CREATE TABLE IF NOT EXISTS `tag` (
  `tag_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tag_word` varchar(20) NOT NULL,
  `discussion_ID` int(11) NOT NULL,
  PRIMARY KEY (`tag_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=45 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `user_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(60) NOT NULL,
  `user_confirmed` varchar(10) NOT NULL,
  `user_level` int(10) UNSIGNED NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_ID`),
  UNIQUE KEY `username` (`username`,`email`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `vote`
--

DROP TABLE IF EXISTS `vote`;
CREATE TABLE IF NOT EXISTS `vote` (
  `vote_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_ID` int(11) NOT NULL,
  PRIMARY KEY (`vote_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
