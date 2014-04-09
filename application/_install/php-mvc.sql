-- phpMyAdmin SQL Dump
-- version 4.1.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 09, 2014 at 05:14 PM
-- Server version: 5.5.35-0ubuntu0.12.04.2
-- PHP Version: 5.3.10-1ubuntu3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `php-mvc`
--

-- --------------------------------------------------------

--
-- Table structure for table `active_guests`
--

CREATE TABLE IF NOT EXISTS `active_guests` (
  `ip` varchar(15) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ip`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `active_users`
--

CREATE TABLE IF NOT EXISTS `active_users` (
  `username` varchar(30) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `banned_users`
--

CREATE TABLE IF NOT EXISTS `banned_users` (
  `buid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(32) NOT NULL,
  `userid` varchar(32) NOT NULL,
  `userlevel` tinyint(1) NOT NULL,
  `email` varchar(50) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `parent_directory` varchar(30) NOT NULL,
  PRIMARY KEY (`buid`),
  UNIQUE KEY `uid` (`uid`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `banned_users`
--

INSERT INTO `banned_users` (`buid`, `uid`, `username`, `password`, `userid`, `userlevel`, `email`, `timestamp`, `parent_directory`) VALUES
(16, 6, 'master1agent2member1', 'c7764cfed23c5ca3bb393308a0da2306', '0', 1, 'master1agent2member1@3g.com', '2014-04-02 07:01:18', 'Member');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `meta_data`
--

CREATE TABLE IF NOT EXISTS `meta_data` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `client` varchar(100) NOT NULL,
  `articleid` int(11) NOT NULL,
  `publicationdate` date DEFAULT NULL,
  `mediatype` varchar(100) NOT NULL,
  `medianame` varchar(100) DEFAULT NULL,
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `meta_data`
--

INSERT INTO `meta_data` (`pid`, `client`, `articleid`, `publicationdate`, `mediatype`, `medianame`, `headline`, `author`, `circulation`, `eav`, `reach`, `showname`, `starttime`, `duration`, `articletext`, `fileurl`) VALUES
(1, 'fnb', 1, '2014-03-27', 'press', '', 'read line', 'me', 23, 253, 'everywhere', NULL, NULL, NULL, 'a long article', 'bla'),
(4, 'mello', 45, '2014-02-14', 'Press', '', 'headline', 'author', 876, 87, '687', '', '', '', 'oscar p', '/var/www/kwanda/public/clientuploads/print/invoice-001.docx');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `actor_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `object_id` int(11) DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1126 ;

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE IF NOT EXISTS `status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `status` text NOT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(32) DEFAULT NULL,
  `userid` varchar(32) DEFAULT NULL,
  `userlevel` tinyint(1) unsigned NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `parent_directory` varchar(30) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `username`, `password`, `userid`, `userlevel`, `email`, `timestamp`, `parent_directory`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', '1664b4f2e910d4aff260666613758e5f', 9, 'arman@3g.com', '0000-00-00 00:00:00', 'Admin'),
(2, 'simba', '21232f297a57a5a743894a0e4a801fc3', '0f766d2e851f64ed0ee90e2caf443016', 8, 'mp.mello5@gmail.com', '0000-00-00 00:00:00', 'Employee'),
(9, 'mello', '3a15c7d0bbe60300a39f76f8a5ba6896', 'd008535580f0187e43b72b1666597dc4', 1, 'mp.mello5@gmail.com', '0000-00-00 00:00:00', 'Client'),
(10, 'potego', '1731670480f28db506ccca447471b95d', '16e494a957154a48a7a0557a06c57510', 1, 'mp.mello5@gmail.com', '2014-04-06 10:04:20', 'Client');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
