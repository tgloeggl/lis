-- phpMyAdmin SQL Dump
-- version 3.2.2.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 26. Februar 2010 um 14:26
-- Server Version: 5.1.37
-- PHP-Version: 5.2.10-2ubuntu6.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `lis`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `lis_buildings`
--

CREATE TABLE IF NOT EXISTS `lis_buildings` (
  `building_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` mediumtext NOT NULL,
  `defense` int(11) NOT NULL DEFAULT '0',
  `mod_energy` int(11) NOT NULL DEFAULT '0',
  `mod_carboxin` int(11) NOT NULL DEFAULT '0',
  `mod_detrogen` int(11) NOT NULL DEFAULT '0',
  `mod_radium` int(11) NOT NULL DEFAULT '0',
  `mod_credits` int(11) NOT NULL DEFAULT '0',
  `mod_storage` int(11) NOT NULL DEFAULT '0',
  `carboxin` int(11) NOT NULL DEFAULT '0',
  `detrogen` int(11) NOT NULL DEFAULT '0',
  `radium` int(11) NOT NULL DEFAULT '0',
  `credits` int(11) NOT NULL DEFAULT '0',
  `max_level` int(11) NOT NULL DEFAULT '0',
  `completion` int(11) NOT NULL DEFAULT '0' COMMENT 'time to completion',
  `research_id` int(11) NOT NULL DEFAULT '0' COMMENT 'enabled by this research',
  `position` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`building_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `lis_drives`
--

CREATE TABLE IF NOT EXISTS `lis_drives` (
  `drive_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `speed` float NOT NULL COMMENT 'times the speed of light',
  `detrogen` float NOT NULL,
  `radium` float NOT NULL,
  `carboxin` float NOT NULL,
  PRIMARY KEY (`drive_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `lis_events`
--

CREATE TABLE IF NOT EXISTS `lis_events` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `type` enum('travel','build','research','tick') NOT NULL,
  `range_id` int(11) NOT NULL,
  `sec_range_id` int(11) NOT NULL,
  `start` int(11) NOT NULL,
  `end` int(11) NOT NULL,
  PRIMARY KEY (`event_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1500 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `lis_modules`
--

CREATE TABLE IF NOT EXISTS `lis_modules` (
  `module_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `attack` int(11) NOT NULL DEFAULT '0',
  `armor` int(11) NOT NULL DEFAULT '0',
  `range` int(11) NOT NULL DEFAULT '0',
  `cargo` int(11) NOT NULL DEFAULT '0',
  `carboxin` int(11) NOT NULL DEFAULT '0',
  `detrogen` int(11) NOT NULL DEFAULT '0',
  `radium` int(11) NOT NULL DEFAULT '0',
  `credits` int(11) NOT NULL DEFAULT '0',
  `weight` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`module_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `lis_planets`
--

CREATE TABLE IF NOT EXISTS `lis_planets` (
  `planet_id` int(11) NOT NULL AUTO_INCREMENT,
  `x` int(11) NOT NULL,
  `y` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '0',
  `carboxin` int(11) NOT NULL DEFAULT '0',
  `detrogen` int(11) NOT NULL DEFAULT '0',
  `radium` int(11) NOT NULL DEFAULT '0',
  `credits` int(11) NOT NULL DEFAULT '0',
  `size` int(11) NOT NULL DEFAULT '0',
  `temp` int(11) NOT NULL DEFAULT '0',
  `type` enum('poor','few','casual','normal','gaia') NOT NULL DEFAULT 'casual',
  PRIMARY KEY (`planet_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=64 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `lis_planets_buildings`
--

CREATE TABLE IF NOT EXISTS `lis_planets_buildings` (
  `planet_id` int(11) NOT NULL,
  `building_id` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`planet_id`,`building_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `lis_research`
--

CREATE TABLE IF NOT EXISTS `lis_research` (
  `research_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `energy` int(11) NOT NULL,
  `carboxin` int(11) NOT NULL,
  `detrogen` int(11) NOT NULL,
  `radium` int(11) NOT NULL,
  `credits` int(11) NOT NULL,
  PRIMARY KEY (`research_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `lis_research_sets`
--

CREATE TABLE IF NOT EXISTS `lis_research_sets` (
  `research_id` int(11) NOT NULL,
  `element_id` int(11) NOT NULL COMMENT 'module, building, drive, shipsize, research',
  `type` enum('module','building','drive','shipsize','research') NOT NULL DEFAULT 'research',
  `level` int(11) NOT NULL DEFAULT '0',
  `status` enum('enabled','disabled') NOT NULL DEFAULT 'enabled',
  PRIMARY KEY (`research_id`,`element_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='info about enabled modules, buildings...';

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `lis_shipdesign`
--

CREATE TABLE IF NOT EXISTS `lis_shipdesign` (
  `shipdesign_id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `shipsize_id` int(11) NOT NULL DEFAULT '1',
  `drive_id` int(11) NOT NULL DEFAULT '1',
  `armor` int(11) NOT NULL,
  `cargo` int(11) NOT NULL DEFAULT '0',
  `carboxin` int(11) NOT NULL DEFAULT '0',
  `detrogen` int(11) NOT NULL DEFAULT '0',
  `radium` int(11) NOT NULL DEFAULT '0',
  `credits` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`shipdesign_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `lis_shipdesign_modules`
--

CREATE TABLE IF NOT EXISTS `lis_shipdesign_modules` (
  `shipdesign_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  PRIMARY KEY (`shipdesign_id`,`module_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `lis_shipsizes`
--

CREATE TABLE IF NOT EXISTS `lis_shipsizes` (
  `shipsize_id` int(11) NOT NULL AUTO_INCREMENT,
  `tonnage` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `weight` int(11) NOT NULL,
  `armor` int(11) NOT NULL,
  `carboxin` int(11) NOT NULL DEFAULT '0',
  `detrogen` int(11) NOT NULL DEFAULT '0',
  `radium` int(11) NOT NULL DEFAULT '0',
  `credits` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`shipsize_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `lis_tickets`
--

CREATE TABLE IF NOT EXISTS `lis_tickets` (
  `ticket_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `content` mediumtext NOT NULL,
  PRIMARY KEY (`ticket_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `lis_user`
--

CREATE TABLE IF NOT EXISTS `lis_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(32) NOT NULL,
  `lifesign` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `lis_user_fleets`
--

CREATE TABLE IF NOT EXISTS `lis_user_fleets` (
  `fleet_id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `x` int(11) NOT NULL,
  `y` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `carboxin` int(11) NOT NULL,
  `detrogen` int(11) NOT NULL,
  `radium` int(11) NOT NULL,
  `credits` int(11) NOT NULL,
  PRIMARY KEY (`fleet_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `lis_user_research`
--

CREATE TABLE IF NOT EXISTS `lis_user_research` (
  `research_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  PRIMARY KEY (`research_id`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `lis_user_ships`
--

CREATE TABLE IF NOT EXISTS `lis_user_ships` (
  `fleet_id` int(11) NOT NULL,
  `shipdesign_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  PRIMARY KEY (`fleet_id`,`shipdesign_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
