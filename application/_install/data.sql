-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 28, 2014 at 02:28 PM
-- Server version: 5.6.11
-- PHP Version: 5.5.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `login`
--

-- --------------------------------------------------------

--
-- Table structure for table `data`
--

CREATE TABLE IF NOT EXISTS `meta_data` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `client` varchar(100) NOT NULL,
  `articleid` int(11) NOT NULL,
  `publicationdate` date DEFAULT NULL,
  `mediatype` varchar(100) NOT NULL,
  `headline` varchar(100) DEFAULT NULL,
  `author` varchar(100) DEFAULT NULL,
  `circulation` int(11) DEFAULT NULL,
  `eav` int(11) DEFAULT NULL,
  `reach` varchar(100) DEFAULT NULL,
  `showname` varchar(100) DEFAULT NULL,
  `starttime` varchar(100) DEFAULT NULL,
  `duration` varchar(100) DEFAULT NULL,
  `articletext` text,
  `fileurl` varchar(200) NOT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `data`
--

INSERT INTO `meta_data` (`pid`, `client`, `articleid`, `publicationdate`, `mediatype`, `headline`, `author`, `circulation`, `eav`, `reach`, `showname`, `starttime`, `duration`, `articletext`, `fileurl`) VALUES
(1, 'fnb', 1, '2014-03-27', 'press', 'read line', 'me', 23, 253, 'everywhere', NULL, NULL, NULL, 'a long article', 'bla');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
