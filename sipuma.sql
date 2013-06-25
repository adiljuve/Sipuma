-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 20, 2012 at 07:13 AM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sipuma`
--

-- --------------------------------------------------------

--
-- Table structure for table `discussion`
--

CREATE TABLE IF NOT EXISTS `discussion` (
  `discussion_id` int(6) NOT NULL,
  `paper_id` int(6) NOT NULL,
  `user_id` varchar(25) NOT NULL,
  `comment` tinytext NOT NULL,
  `comment_date` date NOT NULL,
  `parent_id` int(6) NOT NULL,
  PRIMARY KEY (`discussion_id`),
  KEY `paper_id` (`paper_id`),
  KEY `user_id` (`user_id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `discussion`
--


-- --------------------------------------------------------

--
-- Table structure for table `file_revision`
--

CREATE TABLE IF NOT EXISTS `file_revision` (
  `file_id` int(6) NOT NULL AUTO_INCREMENT,
  `paper_id` int(6) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_directory` varchar(255) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`file_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `file_revision`
--


-- --------------------------------------------------------

--
-- Table structure for table `free_user_paper`
--

CREATE TABLE IF NOT EXISTS `free_user_paper` (
  `user_id` int(6) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(50) NOT NULL,
  `paper_id` int(6) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

--
-- Dumping data for table `free_user_paper`
--


-- --------------------------------------------------------

--
-- Table structure for table `journal`
--

CREATE TABLE IF NOT EXISTS `journal` (
  `journal_id` int(6) NOT NULL,
  `journal_name` varchar(100) NOT NULL,
  `path` varchar(25) NOT NULL,
  `info` text NOT NULL,
  PRIMARY KEY (`journal_id`),
  KEY `url` (`path`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

--
-- Dumping data for table `journal`
--


-- --------------------------------------------------------

--
-- Table structure for table `journal_member`
--

CREATE TABLE IF NOT EXISTS `journal_member` (
  `journal_id` int(6) NOT NULL,
  `user_id` varchar(25) NOT NULL,
  KEY `journal_id` (`journal_id`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `journal_member`
--


-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `message_id` int(6) NOT NULL,
  `sender_id` varchar(25) NOT NULL,
  `subject` varchar(25) NOT NULL,
  `message` tinytext NOT NULL,
  `message_date` date NOT NULL,
  PRIMARY KEY (`message_id`),
  KEY `sender_id` (`sender_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `message`
--


-- --------------------------------------------------------

--
-- Table structure for table `message_recipient`
--

CREATE TABLE IF NOT EXISTS `message_recipient` (
  `message_id` int(6) NOT NULL,
  `recipient_id` varchar(25) NOT NULL,
  `message_status` enum('0','1') NOT NULL,
  KEY `recipient_id` (`recipient_id`),
  KEY `message_id` (`message_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `message_recipient`
--


-- --------------------------------------------------------

--
-- Table structure for table `paper`
--

CREATE TABLE IF NOT EXISTS `paper` (
  `paper_id` int(6) NOT NULL,
  `title` varchar(100) NOT NULL,
  `abstraction` text NOT NULL,
  `date_created` date NOT NULL,
  `date_published` date DEFAULT NULL,
  `journal_id` int(6) NOT NULL,
  `paper_status` enum('0','1','2','3') NOT NULL,
  `revision_count` int(2) NOT NULL,
  `latest_revision` date DEFAULT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_directory` varchar(255) NOT NULL,
  PRIMARY KEY (`paper_id`),
  KEY `date_published` (`date_published`,`journal_id`,`paper_status`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `paper`
--


-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE IF NOT EXISTS `review` (
  `review_id` int(6) NOT NULL AUTO_INCREMENT,
  `paper_id` int(6) NOT NULL,
  `reviewer_id` varchar(25) NOT NULL,
  `review_message` tinytext,
  `review_status` enum('0','1','2','3') NOT NULL,
  `active` enum('Y','N') NOT NULL,
  `review_date` date NOT NULL,
  PRIMARY KEY (`review_id`),
  KEY `paper_id` (`paper_id`,`reviewer_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=69 ;

--
-- Dumping data for table `review`
--


-- --------------------------------------------------------

--
-- Table structure for table `site_info`
--

CREATE TABLE IF NOT EXISTS `site_info` (
  `title` varchar(100) NOT NULL,
  `owner` varchar(100) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `fax` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `address` varchar(100) NOT NULL,
  `info` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `site_info`
--

INSERT INTO `site_info` (`title`, `owner`, `phone_number`, `fax`, `email`, `address`, `info`) VALUES
('Sistem Informasi Publikasi Karya Ilmiah Mahasiswa', 'Fakultas Teknologi Industri Universitas Islam Indonesia', '', '', '', '', '<p>Penelitian pegembangan sistem informasi ini memiliki beberapa manfaat, yaitu:</p>\r\n<ol>\r\n<li>Mempermudah pengelolaan hasil penelitian mahasiswa.</li>\r\n<li>Mempermudah pencarian hasil penelitian mahasiswa yang telah ada sebelumnya.</li>\r\n<li>Sebagai salah satu wadah bagi mahasiswa untuk saling berbagi hasil penelitian.</li>\r\n</ol>');

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE IF NOT EXISTS `subject` (
  `subject_id` int(6) NOT NULL AUTO_INCREMENT,
  `subject_name` varchar(50) NOT NULL,
  PRIMARY KEY (`subject_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=50 ;

--
-- Dumping data for table `subject`
--


-- --------------------------------------------------------

--
-- Table structure for table `subject_journal`
--

CREATE TABLE IF NOT EXISTS `subject_journal` (
  `subject_id` int(6) NOT NULL,
  `journal_id` int(6) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subject_journal`
--


-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` varchar(25) NOT NULL,
  `password` varchar(50) NOT NULL,
  `full_name` varchar(50) NOT NULL,
  `gender` enum('L','P') NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `website` varchar(50) DEFAULT NULL,
  `date_registered` date NOT NULL,
  `info` text,
  `user_type` enum('A','D','M') NOT NULL,
  `user_status` enum('0','1') NOT NULL,
  PRIMARY KEY (`user_id`),
  KEY `username` (`gender`,`user_type`,`user_status`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `password`, `full_name`, `gender`, `email`, `phone_number`, `website`, `date_registered`, `info`, `user_type`, `user_status`) VALUES
('admin', '21232f297a57a5a743894a0e4a801fc3', 'Imadirrizki', 'L', 'admin@admin.com', '08130000008', NULL, '2012-12-20', NULL, 'A', '1');

-- --------------------------------------------------------

--
-- Table structure for table `user_paper`
--

CREATE TABLE IF NOT EXISTS `user_paper` (
  `user_id` varchar(25) NOT NULL,
  `paper_id` int(6) NOT NULL,
  KEY `user_id` (`user_id`,`paper_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_paper`
--

