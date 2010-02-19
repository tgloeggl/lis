-- phpMyAdmin SQL Dump
-- version 3.2.2.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 19. Februar 2010 um 09:58
-- Server Version: 5.1.37
-- PHP-Version: 5.2.10-2ubuntu6.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Datenbank: `lis`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `lis_buildings`
--

CREATE TABLE IF NOT EXISTS `lis_buildings` (
  `building_id` int(11) NOT NULL AUTO_INCREMENT,
  `mod_energy` int(11) NOT NULL,
  `mod_carboxin` int(11) NOT NULL,
  `mod_detrogen` int(11) NOT NULL,
  `mod_radium` int(11) NOT NULL,
  `mod_credits` int(11) NOT NULL,
  `energy` int(11) NOT NULL,
  `carboxin` int(11) NOT NULL,
  `detrogen` int(11) NOT NULL,
  `radium` int(11) NOT NULL,
  `credits` int(11) NOT NULL,
  `max_level` int(11) NOT NULL,
  PRIMARY KEY (`building_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `lis_events`
--

CREATE TABLE IF NOT EXISTS `lis_events` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `type` enum('travel','build','research') NOT NULL,
  `range_id` int(11) NOT NULL,
  `start` int(11) NOT NULL,
  `end` int(11) NOT NULL,
  PRIMARY KEY (`event_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `lis_modules`
--

CREATE TABLE IF NOT EXISTS `lis_modules` (
  `module_id` int(11) NOT NULL AUTO_INCREMENT,
  `attack` int(11) NOT NULL,
  `shield` int(11) NOT NULL,
  `range` int(11) NOT NULL,
  `cargo` int(11) NOT NULL,
  `energy` int(11) NOT NULL,
  `carboxin` int(11) NOT NULL,
  `detrogen` int(11) NOT NULL,
  `radium` int(11) NOT NULL,
  `credits` int(11) NOT NULL,
  PRIMARY KEY (`module_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `lis_planets`
--

CREATE TABLE IF NOT EXISTS `lis_planets` (
  `planet_id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `energy` int(11) NOT NULL,
  `carboxin` int(11) NOT NULL,
  `detrogen` int(11) NOT NULL,
  `radium` int(11) NOT NULL,
  `credits` int(11) NOT NULL,
  PRIMARY KEY (`planet_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
-- Tabellenstruktur für Tabelle `lis_research_pre`
--

CREATE TABLE IF NOT EXISTS `lis_research_pre` (
  `research_id` int(11) NOT NULL,
  `pre_research_id` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  PRIMARY KEY (`research_id`,`pre_research_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `lis_shipdesign`
--

CREATE TABLE IF NOT EXISTS `lis_shipdesign` (
  `shipdesign_id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`shipdesign_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
-- Tabellenstruktur für Tabelle `lis_user`
--

CREATE TABLE IF NOT EXISTS `lis_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(32) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

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

