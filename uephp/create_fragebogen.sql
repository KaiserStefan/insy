-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 29, 2014 at 01:48 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `fragebogen`
--

-- --------------------------------------------------------

--
-- Table structure for table `antworten`
--

create database if not exists fragebogen;
use fragebogen;

drop table if exists is_richtig;
drop table if exists antworten;
drop table if exists fragen;
drop table if exists kategorien;


CREATE TABLE IF NOT EXISTS `antworten` (
  `AntwortID` int(11) NOT NULL AUTO_INCREMENT,
  `FK_FragenID` int(10) unsigned NOT NULL,
  `Text` varchar(255) NOT NULL,
	`richtig` boolean not null,
  PRIMARY KEY (`AntwortID`),
  KEY `FK_FragenID` (`FK_FragenID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `fragen`
--

CREATE TABLE IF NOT EXISTS `fragen` (
  `FragenID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `FK_Kategorie` int(10) unsigned NOT NULL,
  `Frage` varchar(255) NOT NULL,
  PRIMARY KEY (`FragenID`),
  KEY `FK_Kategorie` (`FK_Kategorie`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `kategorien`
--

CREATE TABLE IF NOT EXISTS `kategorien` (
  `KategorieID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Bezeichnung` varchar(255) NOT NULL,
  PRIMARY KEY (`KategorieID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `kategorien`
--

create table if not exists `is_richtig` (
`is_richtig_id` int(10) not null auto_increment,
`FK_anworten` int(11) NOT NULL,
`richtig` boolean not null,
primary key (`is_richtig_id`),
key `FK_anworten` (`FK_anworten`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `antworten`
--
ALTER TABLE `antworten`
ADD CONSTRAINT `antworten_ibfk_1` 
FOREIGN KEY (`FK_FragenID`) 
REFERENCES `fragen` (`FragenID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `fragen`
--
ALTER TABLE `fragen`
  ADD CONSTRAINT `fragen_ibfk_1` FOREIGN KEY (`FK_Kategorie`) REFERENCES `kategorien` (`KategorieID`) ON DELETE CASCADE ON UPDATE CASCADE;


alter table `is_richtig`
add constraint `fk_con` 
foreign key (`FK_anworten`) 
references `antworten` (`AntwortID`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
