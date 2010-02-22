-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 21. Februar 2010 um 21:53
-- Server Version: 5.1.41
-- PHP-Version: 5.3.1

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
  `mod_energy` int(11) NOT NULL DEFAULT '0',
  `mod_carboxin` int(11) NOT NULL DEFAULT '0',
  `mod_detrogen` int(11) NOT NULL DEFAULT '0',
  `mod_radium` int(11) NOT NULL DEFAULT '0',
  `mod_credits` int(11) NOT NULL DEFAULT '0',
  `mod_storage` int(11) NOT NULL DEFAULT '0',
  `energy` int(11) NOT NULL DEFAULT '0',
  `carboxin` int(11) NOT NULL DEFAULT '0',
  `detrogen` int(11) NOT NULL DEFAULT '0',
  `radium` int(11) NOT NULL DEFAULT '0',
  `credits` int(11) NOT NULL DEFAULT '0',
  `max_level` int(11) NOT NULL DEFAULT '0',
  `completion` int(11) NOT NULL DEFAULT '0' COMMENT 'time to completion',
  `research_id` int(11) NOT NULL DEFAULT '0' COMMENT 'enabled by this research',
  `position` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`building_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Daten für Tabelle `lis_buildings`
--

INSERT INTO `lis_buildings` (`building_id`, `name`, `description`, `mod_energy`, `mod_carboxin`, `mod_detrogen`, `mod_radium`, `mod_credits`, `mod_storage`, `energy`, `carboxin`, `detrogen`, `radium`, `credits`, `max_level`, `completion`, `research_id`, `position`) VALUES
(2, 'Solarkraftwerk', 'Ein Solarkraftwerk mit einer durchschnittlichen Leistung von 1300 MWh. Außerdem verbraucht es nichts außer Wartungskosten und ist gut für die Umwelt.', 1300, -100, 0, 0, 0, 0, 0, 20000, 0, 0, 1500000, 10, 4200, 0, 2),
(1, 'Atomkraftwerk', 'Ein Atomkraftwerk der 1000 MWh-Klasse. Dieses Kraftwerk reicht für den Anfang.', 1000, -100, 0, -10, 0, 0, 0, 20000, 0, 0, 1000000, 10, 3600, 0, 1),
(3, 'Carboxin-Mine', 'Eine Carboxin-Mine, die die natürlichen Ressourcen des Planeten ausbeutet. Je besser der Planet, umso reicher die Ausbeute.', -100, 500, 0, 0, 0, 0, 0, 0, 0, 0, 100000, 50, 600, 0, 10),
(4, 'Detrogen-Extraktor', '', -150, 0, 300, 0, 0, 0, 0, 20000, 0, 0, 100000, 50, 600, 0, 11),
(5, 'Radium-Mine', '', 0, 0, 0, 50, 0, 0, 0, 0, 0, 0, 50000, 50, 3600, 0, 12);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Daten für Tabelle `lis_events`
--

INSERT INTO `lis_events` (`event_id`, `user_id`, `type`, `range_id`, `sec_range_id`, `start`, `end`) VALUES
(7, 1, 'build', 11, 5, 1266783617, 1266787217),
(11, 0, 'tick', 0, 0, 0, 0),
(12, 1, 'build', 50, 5, 1266784798, 1266788398);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `lis_modules`
--

CREATE TABLE IF NOT EXISTS `lis_modules` (
  `module_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `attack` int(11) NOT NULL DEFAULT '0',
  `shield` int(11) NOT NULL DEFAULT '0',
  `range` int(11) NOT NULL DEFAULT '0',
  `cargo` int(11) NOT NULL DEFAULT '0',
  `carboxin` int(11) NOT NULL DEFAULT '0',
  `detrogen` int(11) NOT NULL DEFAULT '0',
  `radium` int(11) NOT NULL DEFAULT '0',
  `credits` int(11) NOT NULL DEFAULT '0',
  `troops` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`module_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `lis_modules`
--

INSERT INTO `lis_modules` (`module_id`, `name`, `attack`, `shield`, `range`, `cargo`, `carboxin`, `detrogen`, `radium`, `credits`, `troops`) VALUES
(1, 'Laser', 5, 0, 5, 0, 10, 0, 0, 100, 0);

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

--
-- Daten für Tabelle `lis_planets`
--

INSERT INTO `lis_planets` (`planet_id`, `x`, `y`, `owner_id`, `name`, `carboxin`, `detrogen`, `radium`, `credits`, `size`, `temp`, `type`) VALUES
(1, 0, 0, 0, 'Zahadum', 0, 0, 0, 0, 94, 306, 'casual'),
(2, -2, 0, 0, 'Delta Kos', 0, 0, 0, 0, 86, 481, 'casual'),
(3, 1, 3, 0, 'Thuban al Raschi', 0, 0, 0, 0, 47, 743, 'casual'),
(4, -5, 5, 0, 'Beteigeuze Electra', 0, 0, 0, 0, 78, 529, 'casual'),
(5, 9, 0, 0, 'Kynosura Electra', 0, 0, 0, 0, 51, 673, 'casual'),
(6, 3, -3, 0, 'Gamma Al Giedi', 0, 0, 0, 0, 19, 31, 'casual'),
(7, 6, 8, 0, 'Spika Multi', 0, 0, 0, 0, 40, 395, 'casual'),
(8, -8, 0, 0, 'Herkules Sirius', 0, 0, 0, 0, 46, 137, 'casual'),
(9, 5, 10, 0, 'Mizar Menkar', 0, 0, 0, 0, 9, -243, 'casual'),
(10, 7, 5, 0, 'Alioth del Sorion', 0, 0, 0, 0, 6, 627, 'casual'),
(11, -4, 12, 1, 'Benetnasch Kos', 0, 5000, 0, 40000, 100, 123, 'normal'),
(12, 6, -1, 0, 'Hamal Ras Alhague', 0, 0, 0, 0, 99, -11, 'casual'),
(13, 12, 2, 0, 'Aldebaran el Dschenubi', 0, 0, 0, 0, 84, -167, 'casual'),
(14, 11, -11, 0, 'Pegasus del Sorion', 0, 0, 0, 0, 22, 455, 'casual'),
(15, -12, 13, 0, 'Hamal Al Giedi', 0, 0, 0, 0, 61, 31, 'casual'),
(16, 0, -10, 0, 'Alderamin Nodus', 0, 0, 0, 0, 38, 48, 'casual'),
(17, -13, -5, 0, 'Hamal Centauri', 0, 0, 0, 0, 6, 400, 'casual'),
(18, 8, 10, 0, 'Kassiopeia Ras Alhague', 0, 0, 0, 0, 16, 114, 'casual'),
(19, -2, -12, 0, 'Mizar Nodus', 0, 0, 0, 0, 64, 623, 'casual'),
(20, 13, 10, 0, 'Alphecca al Raschi', 0, 0, 0, 0, 71, 31, 'casual'),
(21, -6, -10, 0, 'Markab Sirius', 0, 0, 0, 0, 64, 544, 'casual'),
(22, 12, -14, 0, 'Lundubar Menki', 0, 0, 0, 0, 7, -119, 'casual'),
(23, 1, 0, 0, 'Geheime Sternenbasis', 0, 0, 0, 0, 43, 29, 'casual'),
(24, -2, -5, 0, 'Alioth Kos', 0, 0, 0, 0, 93, -244, 'casual'),
(25, 10, -7, 0, 'Sagatarius Castor', 0, 0, 0, 0, 37, -48, 'casual'),
(26, -13, 2, 0, 'Theta Secundus', 0, 0, 0, 0, 6, -254, 'casual'),
(27, 15, -12, 0, 'Arneb Serafim', 0, 0, 0, 0, 20, 129, 'casual'),
(28, 17, 11, 0, 'Sadalmelek Sirius', 0, 0, 0, 0, 81, 664, 'casual'),
(29, -15, -9, 0, 'Alhajoth Serafim', 0, 0, 0, 0, 44, 187, 'casual'),
(30, -7, 9, 0, 'Ras Algehti Castor', 0, 0, 0, 0, 76, 202, 'casual'),
(31, 18, 14, 0, 'Herkules Al Giedi', 0, 0, 0, 0, 51, 702, 'casual'),
(32, 11, -16, 0, 'Mizar Electra', 0, 0, 0, 0, 27, 162, 'casual'),
(33, 16, 0, 0, 'Canopus Plasmid', 0, 0, 0, 0, 80, -41, 'casual'),
(34, -5, -18, 0, 'Landa Al Giedi', 0, 0, 0, 0, 18, 564, 'casual'),
(35, -16, -16, 0, 'Zeus Ras Alhague', 0, 0, 0, 0, 52, 202, 'casual'),
(36, -18, -3, 0, 'Mintaka Ras Alhague', 0, 0, 0, 0, 4, 571, 'casual'),
(37, -9, -18, 0, 'Hamal Plasmid', 0, 0, 0, 0, 64, 505, 'casual'),
(38, -19, 10, 0, 'Kaitos Multi', 0, 0, 0, 0, 9, 69, 'casual'),
(39, -19, 6, 0, 'Alderamin al Raschi', 0, 0, 0, 0, 52, 87, 'casual'),
(40, -19, -10, 0, 'Bellatrix Multi', 0, 0, 0, 0, 32, 482, 'casual'),
(41, -19, 9, 0, 'Regulus Plasmid', 0, 0, 0, 0, 4, 406, 'casual'),
(42, 19, 17, 0, 'Pegasus Sirius', 0, 0, 0, 0, 23, -159, 'casual'),
(43, 17, 15, 0, 'Capella Al Giedi', 0, 0, 0, 0, 5, 240, 'casual'),
(44, 20, 21, 0, 'Kynosura Ras Alhague', 0, 0, 0, 0, 56, -65, 'casual'),
(45, 4, 22, 0, 'Andromeda Menkar', 0, 0, 0, 0, 63, 213, 'casual'),
(46, -11, -19, 0, 'Menkalinan Menkar', 0, 0, 0, 0, 47, 513, 'casual'),
(47, -22, -5, 0, 'Alderamin Kos', 0, 0, 0, 0, 46, 181, 'casual'),
(48, 1, 22, 0, 'Kepheus Castor', 0, 0, 0, 0, 91, 625, 'casual'),
(49, -22, -2, 0, 'Azimech Sirius', 0, 0, 0, 0, 15, -161, 'casual'),
(50, -8, 23, 1, 'Pegasus al Raschi', 0, 0, 0, 0, 80, 25, 'gaia'),
(51, 14, -22, 0, 'Arkturus Deran', 0, 0, 0, 0, 62, 606, 'casual'),
(52, 5, -21, 0, 'Apollo Centauri', 0, 0, 0, 0, 7, 565, 'casual'),
(53, -20, 17, 0, 'Algieba Ras Alhague', 0, 0, 0, 0, 49, 262, 'casual'),
(54, -21, 23, 0, 'Andromeda al Raschi', 0, 0, 0, 0, 22, -126, 'casual'),
(55, -18, 13, 0, 'Herkules Kos', 0, 0, 0, 0, 66, -160, 'casual'),
(56, -21, 22, 0, 'Orion Nebula', 0, 0, 0, 0, 64, -166, 'casual'),
(57, 18, 12, 0, 'Perseus Electra', 0, 0, 0, 0, 19, -96, 'casual'),
(58, 22, 24, 0, 'Andromeda Centauri', 0, 0, 0, 0, 6, 274, 'casual'),
(59, 16, -24, 0, 'Canopus Secundus', 0, 0, 0, 0, 71, -85, 'casual'),
(60, 24, 3, 0, 'Delta Secundus', 0, 0, 0, 0, 39, 9, 'casual'),
(61, -22, -16, 0, 'Pi Plasmid', 0, 0, 0, 0, 81, 557, 'casual'),
(62, 17, 24, 0, 'Arkturus Centauri', 0, 0, 0, 0, 89, 13, 'casual'),
(63, -21, 5, 0, 'Deneb Serafim', 0, 0, 0, 0, 3, 651, 'casual');

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

--
-- Daten für Tabelle `lis_planets_buildings`
--

INSERT INTO `lis_planets_buildings` (`planet_id`, `building_id`, `level`, `active`) VALUES
(11, 1, 5, 0),
(11, 4, 3, 0),
(11, 2, 1, 0);

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

--
-- Daten für Tabelle `lis_research`
--


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

--
-- Daten für Tabelle `lis_research_pre`
--


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

--
-- Daten für Tabelle `lis_shipdesign`
--


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

--
-- Daten für Tabelle `lis_shipdesign_modules`
--


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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `lis_user`
--

INSERT INTO `lis_user` (`user_id`, `username`, `password`, `lifesign`) VALUES
(1, 'datenpunk', '81dc9bdb52d04dc20036dbd8313ed055', 1266785366),
(2, 'admin', '81dc9bdb52d04dc20036dbd8313ed055', 0);

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

--
-- Daten für Tabelle `lis_user_fleets`
--


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

--
-- Daten für Tabelle `lis_user_research`
--


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

--
-- Daten für Tabelle `lis_user_ships`
--


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
