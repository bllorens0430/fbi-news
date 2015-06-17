-- phpMyAdmin SQL Dump
-- version 3.2.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 10, 2011 at 05:33 AM
-- Server version: 5.1.37
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `books`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE IF NOT EXISTS `books` (
  `BookID` int(11) NOT NULL AUTO_INCREMENT,
  `Title` varchar(150) NOT NULL,
  `Author` varchar(150) NOT NULL,
  `PublisherName` varchar(150) NOT NULL,
  `CopyrightYear` year(4) NOT NULL,
  PRIMARY KEY (`BookID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`BookID`, `Title`, `Author`, `PublisherName`, `CopyrightYear`) VALUES
(1, 'Algebra', 'Almel', 'Chun Sa', 2007),
(2, 'Algebra', 'Almel', 'Chun Sa', 2007),
(3, 'Algebra', 'Almel', 'Chun Sa', 2007),
(4, 'Algebra', 'Almel', 'Chun Sa', 2007),
(5, 'Algebra', 'Almel', 'Chun Sa', 2007),
(6, 'Algebra', 'Almel', 'Chun Sa', 2007),
(7, 'Algebra', 'Almel', 'Chun Sa', 2007),
(8, 'Algebra', 'Almel', 'Chun Sa', 2007);
