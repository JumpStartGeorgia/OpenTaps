-- phpMyAdmin SQL Dump
-- version 3.3.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 26, 2011 at 03:31 PM
-- Server version: 5.1.54
-- PHP Version: 5.3.5-1ubuntu7.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `opentaps`
--
CREATE DATABASE `opentaps` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `opentaps`;

-- --------------------------------------------------------

--
-- Table structure for table `donors`
--

CREATE TABLE IF NOT EXISTS `donors` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `don_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `don_desc` text CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `donors`
--

INSERT INTO `donors` (`id`, `don_name`, `don_desc`) VALUES
(2, '4545454', 'vaxaxaxa'),
(5, '44444444444444444444444444444444444444444', '444444444444444444444444444444444444444444124124521421351235 1235 2135 234 235 2352352 3'),
(6, 'adsdasdas', 'dasdsadasdasd'),
(7, 'sdasdasd', 'asdasda'),
(8, 'asdasdasd', 'dasdasdad'),
(9, 'asdasdasd', 'dasdasdad'),
(10, 'asdasdasd', 'dasdasdad');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unique` int(11) NOT NULL,
  `lang` varchar(50) NOT NULL,
  `parent_unique` int(11) NOT NULL,
  `name` varchar(35) NOT NULL,
  `short_name` varchar(15) NOT NULL,
  `title` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `hide` int(10) NOT NULL,
  `footer` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=56 ;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `unique`, `lang`, `parent_unique`, `name`, `short_name`, `title`, `text`, `hide`, `footer`) VALUES
(1, 1, 'en', 0, 'georgia profile', 'profile', '', '', -1, -1),
(2, 2, 'en', 0, 'water issues', 'issues', 'Vivamus vestibulum', 'Donec aliquet hendrerit lacinia. Curabitur iaculis orci vel ligula bibendum dapibus porttitor sit amet urna. Integer condimentum nunc a dui blandit accumsan. Phasellus vel mi nisl, eu commodo lacus. Sed euismod ultrices nunc a malesuada. Duis eleifend eleifend lorem at suscipit. Cras sem felis, vestibulum et vestibulum at, gravida nec nisl. Suspendisse ullamcorper massa id magna dictum quis porttitor justo viverra. Morbi viverra enim non dolor volutpat a dapibus erat faucibus. Duis vitae sem eu elit pellentesque venenatis. In hac habitasse platea dictumst. Sed laoreet rutrum est, commodo tristique nulla fermentum sit amet. Suspendisse at purus at diam vehicula tincidunt.', -1, -1),
(5, 3, 'en', 0, 'statistics', 'stat', '', '', -1, -1),
(6, 4, 'en', 0, 'data', 'data', '', '', -1, -1),
(11, 7, 'en', 0, 'about_us', '', '', '<b style=''font-weight:bold;''>JumpStart</b> Georgia was formed in Tbilisi, Georgia in October, 2009 with the purpose of creating open-source digital maps of Georgia using a network of Community Organizers and volunteers. JumpStart Georgia began with the funding, technical, administrative and financial management support of JumpStart International. JumpStart Georgia has built more than merely maps, however. It has evolved to embody the spirit of open information, improved communication, and increased citizen participation in the world around. We are defined by a set of core values, and we work hard to engage others in what we believe in.', 0, 0),
(28, 1, 'ka', 0, 'georgia profile', 'profile', '', '', -1, -1),
(29, 2, 'ka', 0, 'water issues', 'issues', 'Vivamus vestibulum', 'Donec aliquet hendrerit lacinia. Curabitur iaculis orci vel ligula bibendum dapibus porttitor sit amet urna. Integer condimentum nunc a dui blandit accumsan. Phasellus vel mi nisl, eu commodo lacus. Sed euismod ultrices nunc a malesuada. Duis eleifend eleifend lorem at suscipit. Cras sem felis, vestibulum et vestibulum at, gravida nec nisl. Suspendisse ullamcorper massa id magna dictum quis porttitor justo viverra. Morbi viverra enim non dolor volutpat a dapibus erat faucibus. Duis vitae sem eu elit pellentesque venenatis. In hac habitasse platea dictumst. Sed laoreet rutrum est, commodo tristique nulla fermentum sit amet. Suspendisse at purus at diam vehicula tincidunt.', -1, -1),
(30, 3, 'ka', 0, 'statistics', 'stat', '', '', -1, -1),
(31, 4, 'ka', 0, 'data', 'data', '', '', -1, -1),
(34, 7, 'ka', 0, 'about_us', '', '', '<b style=''font-weight:bold;''>JumpStart</b> Georgia was formed in Tbilisi, Georgia in October, 2009 with the purpose of creating open-source digital maps of Georgia using a network of Community Organizers and volunteers. JumpStart Georgia began with the funding, technical, administrative and financial management support of JumpStart International. JumpStart Georgia has built more than merely maps, however. It has evolved to embody the spirit of open information, improved communication, and increased citizen participation in the world around. We are defined by a set of core values, and we work hard to engage others in what we believe in.', 0, 0),
(55, 8, 'ka', 2, 'submenu1 (ka)', '', '', '', -1, -1),
(54, 8, 'en', 2, 'submenu1', '', '', '', -1, -1);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unique` int(11) NOT NULL,
  `lang` varchar(50) NOT NULL,
  `title` varchar(60) NOT NULL,
  `image` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `published_at` varchar(20) NOT NULL,
  `category` varchar(255) NOT NULL,
  `place_unique` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=89 ;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `unique`, `lang`, `title`, `image`, `body`, `published_at`, `category`, `place_unique`) VALUES
(59, 1, 'en', 'Water Supply 2010', '', 'In 2010 about 84% of the global population (6.74 billion people) had access to piped water supply through house connections or to an improved water source through other means than house, including standpipes, "water kiosks", protected springs and protected wells. However, about 14% (884 million people) did not have access to an improved water source and had to use unprotected wells or springs, canals, lakes or rivers for their water needs.[1]\r\nA clean water supply, especially so with regard to sewage, is the single most important determinant of public health. Destruction of water supply and/or sewage disposal infrastructure after major catastrophes (earthquakes, f loods, war, etc.) poses the immediate threat of severe epidemics of waterborne diseases, several of which can be life-threatening.', '2011-09-13 14:43', 'text', 70),
(60, 2, 'en', 'Water pollution', '', 'Water pollution is a major global problem which requires ongoing evaluation and revision of water resource policy at all levels (international down to individual aquifers and wells). It has been suggested that it is the leading worldwide cause of deaths and diseases,[1][2] and that it accounts for the deaths of more than 14,000 people daily.[2] An estimated 700 million Indians have no access to a proper toilet, and 1,000 Indian children die of diarrheal sickness every day.[3] Some 90% of China''s cities suffer from some degree of water pollution,[4] and nearly 500 million people lack access to safe drinking water.[5] In addition to the acute problems of water pollution in developing countries, industrialized countries continue to struggle with pollution problems as well. In the most recent national report on water quality in the United States, 45 percent of assessed stream miles, 47 percent of assessed lake acres, and 32 percent of assessed bay and estuarine square miles were classified as polluted.[6]\r\nWater is typically referred to as polluted when it is impaired by anthropogenic contaminants and either does not support a human use, such as drinking water, and/or undergoes a marked shift in its ability to support its constituent biotic communities, such as fish. Natural phenomena such as volcanoes, algae blooms, storms, and earthquakes also cause major changes in water quality and the ecological status of water.', '2011-09-13 14:47', 'text', 71),
(61, 3, 'en', 'world and water', 'uploads/541water.jpg', 'Water is a chemical substance with the chemical formula H2O. Its molecule contains one oxygen and two hydrogen atoms connected by covalent bonds. Water is a liquid at ambient conditions, but it often co-exists on Earth with its solid state, ice, and gaseous state (water vapor or steam). Water also exists in a liquid crystal state near hydrophilic surfaces.[1][2]\r\nWater covers 70.9% of the Earth''s surface,[3] and is vital for all known forms of life.[4] On Earth, it is found mostly in oceans and other large water bodies, with 1.6% of water below ground in aquifers and 0.001% in the air as vapor, clouds (formed of solid and liquid water particles suspended in air), and precipitation.[5] Oceans hold 97% of surface water, glaciers and polar ice caps 2.4%, and other land surface water such as rivers, lakes and ponds 0.6%. A very small amount of the Earth''s water is contained within biological bodies and manufactured products.\r\nWater on Earth moves continually through a cycle of evaporation or transpiration (evapotranspiration), precipitation, and runoff, usually reaching the sea. Over land, evaporation and transpiration contribute to the precipitation over land.', '2011-09-13 15:46', 'photo', 64),
(62, 1, 'ka', 'Water Supply 2010', '', 'In 2010 about 84% of the global population (6.74 billion people) had access to piped water supply through house connections or to an improved water source through other means than house, including standpipes, "water kiosks", protected springs and protected wells. However, about 14% (884 million people) did not have access to an improved water source and had to use unprotected wells or springs, canals, lakes or rivers for their water needs.[1]\r\nA clean water supply, especially so with regard to sewage, is the single most important determinant of public health. Destruction of water supply and/or sewage disposal infrastructure after major catastrophes (earthquakes, f loods, war, etc.) poses the immediate threat of severe epidemics of waterborne diseases, several of which can be life-threatening.', '2011-09-13 14:43', 'text', 70),
(63, 2, 'ka', 'Water pollution', '', 'Water pollution is a major global problem which requires ongoing evaluation and revision of water resource policy at all levels (international down to individual aquifers and wells). It has been suggested that it is the leading worldwide cause of deaths and diseases,[1][2] and that it accounts for the deaths of more than 14,000 people daily.[2] An estimated 700 million Indians have no access to a proper toilet, and 1,000 Indian children die of diarrheal sickness every day.[3] Some 90% of China''s cities suffer from some degree of water pollution,[4] and nearly 500 million people lack access to safe drinking water.[5] In addition to the acute problems of water pollution in developing countries, industrialized countries continue to struggle with pollution problems as well. In the most recent national report on water quality in the United States, 45 percent of assessed stream miles, 47 percent of assessed lake acres, and 32 percent of assessed bay and estuarine square miles were classified as polluted.[6]\r\nWater is typically referred to as polluted when it is impaired by anthropogenic contaminants and either does not support a human use, such as drinking water, and/or undergoes a marked shift in its ability to support its constituent biotic communities, such as fish. Natural phenomena such as volcanoes, algae blooms, storms, and earthquakes also cause major changes in water quality and the ecological status of water.', '2011-09-13 14:47', 'text', 71),
(64, 3, 'ka', 'world and water', 'uploads/541water.jpg', 'Water is a chemical substance with the chemical formula H2O. Its molecule contains one oxygen and two hydrogen atoms connected by covalent bonds. Water is a liquid at ambient conditions, but it often co-exists on Earth with its solid state, ice, and gaseous state (water vapor or steam). Water also exists in a liquid crystal state near hydrophilic surfaces.[1][2]\r\nWater covers 70.9% of the Earth''s surface,[3] and is vital for all known forms of life.[4] On Earth, it is found mostly in oceans and other large water bodies, with 1.6% of water below ground in aquifers and 0.001% in the air as vapor, clouds (formed of solid and liquid water particles suspended in air), and precipitation.[5] Oceans hold 97% of surface water, glaciers and polar ice caps 2.4%, and other land surface water such as rivers, lakes and ponds 0.6%. A very small amount of the Earth''s water is contained within biological bodies and manufactured products.\r\nWater on Earth moves continually through a cycle of evaporation or transpiration (evapotranspiration), precipitation, and runoff, usually reaching the sea. Over land, evaporation and transpiration contribute to the precipitation over land.', '2011-09-13 15:46', 'photo', 64),
(79, 7, 'en', 'vaxaxaxaxaxa (en)', '', '<p>vavaxaxaxaxa</p>', '2011-09-16 19:30', 'text', -1),
(80, 7, 'ka', 'vaxaxaxaxaxa', '', '<p>vavaxaxaxaxa</p>', '2011-09-16 19:30', 'text', -1),
(77, 6, 'en', 'ssasda (en)', '', '<p>ssasdassasdassasda</p>', '2011-09-16 19:10', 'text', -1),
(78, 6, 'ka', 'shine on', '', '<p>ssasdassasdassasda</p>', '2011-09-16 19:10', 'text', -1);

-- --------------------------------------------------------

--
-- Table structure for table `organizations`
--

CREATE TABLE IF NOT EXISTS `organizations` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `unique` int(11) NOT NULL,
  `lang` varchar(50) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  `district` text NOT NULL,
  `city_town` varchar(255) NOT NULL,
  `grante` varchar(255) NOT NULL,
  `sector` varchar(255) NOT NULL,
  `projects_info` text NOT NULL,
  `logo` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=64 ;

--
-- Dumping data for table `organizations`
--

INSERT INTO `organizations` (`id`, `unique`, `lang`, `name`, `description`, `district`, `city_town`, `grante`, `sector`, `projects_info`, `logo`) VALUES
(40, 1, 'ka', 'Vazha Organization', '<p>sdfsdfSociology can be defined as the science of the institutions of modernity; specific institutions serve a function, akin to the individual organs of a coherent body. In the social and political sciences in general, an "organization" may be more loosely understood as the planned, coordinated and purposeful action of human beings working through collective action to reach a common goal or construct a tangible product. This action is usually framed by formal membership and form (institutional rules). Sociology distinguishes the term organization into planned formal and unplanned informal (i.e. spontaneously formed) organizations. Sociology analyzes organizations in the first line from an institutional perspective. In this sense, organization is a permanent arrangement of elements. These elements and their actions are determined by rules so that a certain task can be fulfilled through a system of coordinated division of labor. An organization is defined by the elements that are part of it (who belongs to the organization and who does not?), its communication (which elements communicate and how do they communicate?), its autonomy (which changes are executed autonomously by the organization or its elements?), and its rules of action compared to outside events (what causes an organization to act as a collective actor?).</p>', 'sdfsdf', 'sdfsdfsdfsdfsdf', 'sdfsdfsdfsdfsdsd', 'fsdfsdfsdfsdfsdf', '<p>These structures are formed on the basis that there are enough people under the leader to give him support. Just as one would imagine a real pyramid, if there are not enough stone blocks to hold up the higher ones, gravity would irrevocably bring down the monumental structure. So one can imagine that if the leader does not have the support of his subordinates, the entire structure will collapse. Hierarchies were satirized in The Peter Principle (1969), a book that introduced hierarchiology and the saying that "in a hierarchy every employee tends to rise to his level of incompetence.""</p>', ''),
(41, 2, 'ka', 'Irakli Organization', '<p>This organizational type assigns each worker two bosses in two different hierarchies. One hierarchy is "functional" and assures that each type of expert in the organization is well-trained, and measured by a boss who is super-expert in the same field. The other direction is "executive" and tries to get projects completed using the experts. Projects might be organized by products, regions, customer types, or some other schema. As an example,(this is not reliable) a company might have separate individuals with overall responsibility for Product X and Product Y, and different individuals with overall responsibility for Engineering, Quality Control, etc. Individuals responsible for quality control of project X with therefore have two reporting lines.</p>', 'sdfsdf', 'Telavi', 'sdfsdfsdfsdfsdfsd', 'fsdfsdfsdfsdfsdfsdfsd', '<p>These consist of a group of peers who decide as a group, perhaps by voting. The difference between a jury and a committee is that the members of the committee are usually assigned to perform or lead further actions after the group comes to a decision, whereas members of a jury come to a decision. In common law countries, legal juries render decisions of guilt, liability and quantify damages; juries are also used in athletic contests, book awards and similar activities. Sometimes a selection committee functions like a jury. In the Middle Ages, juries in continental Europe were used to determine the law according to consensus amongst local notables. Committees are often the most reliable way to make decisions. Condorcet''s jury theorem proved that if the average member votes better than a roll of dice, then adding more members increases the number of majorities that can come to a correct vote (however correctness is defined). The problem is that if the average member is subsequently worse than a roll of dice, the committee''s decisions grow worse, not better: Staffing is crucial.</p>', '/var/www/OpenTaps/uploads/organization_photos/191014581313579390Firefox_wallpaper.png'),
(43, 1, 'en', 'Vazha Organization', 'sdfsdfSociology can be defined as the science of the institutions of modernity; specific institutions serve a function, akin to the individual organs of a coherent body. In the social and political sciences in general, an "organization" may be more loosely understood as the planned, coordinated and purposeful action of human beings working through collective action to reach a common goal or construct a tangible product. This action is usually framed by formal membership and form (institutional rules). Sociology distinguishes the term organization into planned formal and unplanned informal (i.e. spontaneously formed) organizations. Sociology analyzes organizations in the first line from an institutional perspective. In this sense, organization is a permanent arrangement of elements. These elements and their actions are determined by rules so that a certain task can be fulfilled through a system of coordinated division of labor.\r\nAn organization is defined by the elements that are part of it (who belongs to the organization and who does not?), its communication (which elements communicate and how do they communicate?), its autonomy (which changes are executed autonomously by the organization or its elements?), and its rules of action compared to outside events (what causes an organization to act as a collective actor?).', 'sdfsdf', 'sdfsdfsdfsdfsdf', 'sdfsdfsdfsdfsdsd', 'fsdfsdfsdfsdfsdf', 'These structures are formed on the basis that there are enough people under the leader to give him support. Just as one would imagine a real pyramid, if there are not enough stone blocks to hold up the higher ones, gravity would irrevocably bring down the monumental structure. So one can imagine that if the leader does not have the support of his subordinates, the entire structure will collapse. Hierarchies were satirized in The Peter Principle (1969), a book that introduced hierarchiology and the saying that "in a hierarchy every employee tends to rise to his level of incompetence.""', ''),
(44, 2, 'en', 'Irakli Organization', 'This organizational type assigns each worker two bosses in two different hierarchies. One hierarchy is "functional" and assures that each type of expert in the organization is well-trained, and measured by a boss who is super-expert in the same field. The other direction is "executive" and tries to get projects completed using the experts. Projects might be organized by products, regions, customer types, or some other schema.\r\nAs an example,(this is not reliable) a company might have separate individuals with overall responsibility for Product X and Product Y, and different individuals with overall responsibility for Engineering, Quality Control, etc. Individuals responsible for quality control of project X with therefore have two reporting lines.', 'sdfsdf', 'Telavi', 'sdfsdfsdfsdfsdfsd', 'fsdfsdfsdfsdfsdfsdfsd', 'These consist of a group of peers who decide as a group, perhaps by voting. The difference between a jury and a committee is that the members of the committee are usually assigned to perform or lead further actions after the group comes to a decision, whereas members of a jury come to a decision. In common law countries, legal juries render decisions of guilt, liability and quantify damages; juries are also used in athletic contests, book awards and similar activities. Sometimes a selection committee functions like a jury. In the Middle Ages, juries in continental Europe were used to determine the law according to consensus amongst local notables.\r\nCommittees are often the most reliable way to make decisions. Condorcet''s jury theorem proved that if the average member votes better than a roll of dice, then adding more members increases the number of majorities that can come to a correct vote (however correctness is defined). The problem is that if the average member is subsequently worse than a roll of dice, the committee''s decisions grow worse, not better: Staffing is crucial.', '/var/www/OpenTaps/uploads/organization_photos/191014581313579390Firefox_wallpaper.png'),
(53, 3, 'en', 'way i (en)', '<div>\r\n<div>\r\n<div>\r\n<p>way i&nbsp;</p>\r\n<div>\r\n<div>\r\n<p>way i&nbsp;</p>\r\n<div>\r\n<div>\r\n<p>way i&nbsp;</p>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>', 'way i ', 'way i ', 'way i ', 'way i ', '<div>\r\n<div>\r\n<p>way i&nbsp;</p>\r\n<div>\r\n<div>\r\n<p>way i&nbsp;</p>\r\n<div>\r\n<div>\r\n<p>way i&nbsp;</p>\r\n<div>\r\n<div>\r\n<p>way i&nbsp;</p>\r\n<div>\r\n<div>\r\n<p>way i&nbsp;</p>\r\n<div>\r\n<div>\r\n<p>way i&nbsp;</p>\r\n<div>\r\n<div>\r\n<p>way i&nbsp;</p>\r\n<div>\r\n<div>\r\n<p>way i&nbsp;</p>\r\n<div>\r\n<div>\r\n<p>way i&nbsp;</p>\r\n<div>\r\n<div>\r\n<p>way i&nbsp;</p>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>', ''),
(54, 3, 'ka', 'way i', '<div>\r\n<div>\r\n<div>\r\n<p>way i&nbsp;</p>\r\n<div>\r\n<div>\r\n<p>way i&nbsp;</p>\r\n<div>\r\n<div>\r\n<p>way i&nbsp;</p>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>', 'way i ', 'way i ', 'way i ', 'way i ', '<div>\r\n<div>\r\n<p>way i&nbsp;</p>\r\n<div>\r\n<div>\r\n<p>way i&nbsp;</p>\r\n<div>\r\n<div>\r\n<p>way i&nbsp;</p>\r\n<div>\r\n<div>\r\n<p>way i&nbsp;</p>\r\n<div>\r\n<div>\r\n<p>way i&nbsp;</p>\r\n<div>\r\n<div>\r\n<p>way i&nbsp;</p>\r\n<div>\r\n<div>\r\n<p>way i&nbsp;</p>\r\n<div>\r\n<div>\r\n<p>way i&nbsp;</p>\r\n<div>\r\n<div>\r\n<p>way i&nbsp;</p>\r\n<div>\r\n<div>\r\n<p>way i&nbsp;</p>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>', '');

-- --------------------------------------------------------

--
-- Table structure for table `places`
--

CREATE TABLE IF NOT EXISTS `places` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `unique` int(11) NOT NULL,
  `lang` varchar(50) NOT NULL,
  `longitude` decimal(20,5) NOT NULL,
  `latitude` decimal(20,5) NOT NULL,
  `name` varchar(255) NOT NULL,
  `region_unique` int(10) NOT NULL,
  `raion_unique` int(10) NOT NULL,
  `project_unique` int(10) NOT NULL,
  `pollution_unique` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=90 ;

--
-- Dumping data for table `places`
--

INSERT INTO `places` (`id`, `unique`, `lang`, `longitude`, `latitude`, `name`, `region_unique`, `raion_unique`, `project_unique`, `pollution_unique`) VALUES
(66, 1, 'en', '234.23423', '324234.23423', 'Batumi', 7, 0, 0, 0),
(60, 4, 'en', '4897809.19086', '5231598.57487', 'Oni', 6, 0, 0, 0),
(61, 5, 'en', '4980666.92951', '5128102.83859', 'Kobuleti', 7, 0, 0, 0),
(70, 2, 'en', '234523423423423.23432', '234324.23426', 'Khulo', 7, 0, 0, 0),
(71, 3, 'en', '4857450.43993', '5169837.45602', 'Barakoni', 6, 0, 0, 0),
(73, 4, 'ka', '4897809.19086', '5231598.57487', 'Oni', 6, 0, 0, 0),
(74, 5, 'ka', '4980666.92951', '5128102.83859', 'Kobuleti', 7, 0, 0, 0),
(75, 1, 'ka', '234.23423', '324234.23423', 'Batumi', 7, 0, 0, 0),
(76, 2, 'ka', '234523423423423.23432', '234324.23426', 'Khulo', 7, 0, 0, 0),
(77, 3, 'ka', '4857450.43993', '5169837.45602', 'Barakoni', 6, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `project_organizations`
--

CREATE TABLE IF NOT EXISTS `project_organizations` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `project_unique` int(10) NOT NULL,
  `organization_unique` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `project_organizations`
--

INSERT INTO `project_organizations` (`id`, `project_unique`, `organization_unique`) VALUES
(4, 4, 3),
(3, 4, 2),
(5, 4, 3),
(6, 4, 3);

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unique` int(11) NOT NULL,
  `lang` varchar(50) NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `budget` int(10) NOT NULL,
  `region_unique` int(10) NOT NULL,
  `city` varchar(100) NOT NULL,
  `grantee` varchar(255) NOT NULL,
  `sector` varchar(255) NOT NULL,
  `start_at` date NOT NULL,
  `end_at` date NOT NULL,
  `info` text NOT NULL,
  `type` varchar(255) NOT NULL,
  `place_unique` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=40 ;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `unique`, `lang`, `title`, `description`, `budget`, `region_unique`, `city`, `grantee`, `sector`, `start_at`, `end_at`, `info`, `type`, `place_unique`) VALUES
(15, 1, 'ka', 'Water Pollution Fixing in Rustavi', 'Legal systems elaborate rights and responsibilities in a variety of ways. A general distinction can be made between civil law jurisdictions, which codify their laws, and common law systems, where judge made law is not consolidated. In some countries, religion informs the law. Law provides a rich source of scholarly inquiry, into legal history, philosophy, economic analysis or sociology. Law also raises important and complex issues concerning equality, fairness and justice. "In its majestic equality", said the author Anatole France in 1894, "the law forbids rich and poor alike to sleep under bridges, beg in the streets and steal loaves of bread."[5] In a typical democracy, the central institutions for interpreting and creating law are the three main branches of government, namely an impartial judiciary, a democratic legislature, and an accountable executive.', 6230000, 0, 'Rustavi', 'Ministry of Pain', '42nd international battle station', '2012-12-05', '2013-04-03', 'Criminal law, also known as penal law, pertains to crimes and punishment.[21] It thus regulates the definition of and penalties for offences found to have a sufficiently deleterious social impact but, in itself, makes no moral judgment on an offender nor imposes restrictions on society that physically prevents people from committing a crime in the first place.[22] Investigating, apprehending, charging, and trying suspected offenders is regulated by the law of criminal procedure.[23] The paradigm case of a crime lies in the proof, beyond reasonable doubt, that a person is guilty of two things. First, the accused must commit an act which is deemed by society to be criminal, or actus reus (guilty act).[24] Second, the accused must have the requisite malicious intent to do a criminal act, or mens rea (guilty mind). However for so called "strict liability" crimes, an actus reus is enough.[25] Criminal systems of the civil law tradition distinguish between intention in the broad sense (dolus directus and dolus eventualis), and negligence. Negligence does not carry criminal responsibility unless a particular crime provides for its punishment.', 'Water Pollution', 61),
(16, 2, 'ka', 'Sewage in Batumi', '<p>Criminal law, also known as penal law, pertains to crimes and punishment.[21] It thus regulates the definition of and penalties for offences found to have a sufficiently deleterious social impact but, in itself, makes no moral judgment on an offender nor imposes restrictions on society that physically prevents people from committing a crime in the first place.[22] Investigating, apprehending, charging, and trying suspected offenders is regulated by the law of criminal procedure.[23] The paradigm case of a crime lies in the proof, beyond reasonable doubt, that a person is guilty of two things. First, the accused must commit an act which is deemed by society to be criminal, or actus reus (guilty act).[24] Second, the accused must have the requisite malicious intent to do a criminal act, or mens rea (guilty mind). However for so called "strict liability" crimes, an actus reus is enough.[25] Criminal systems of the civil law tradition distinguish between intention in the broad sense (dolus directus and dolus eventualis), and negligence. Negligence does not carry criminal responsibility unless a particular crime provides for its punishment.</p>', 13235000, 0, 'Batumi', 'Random grantee', 'Random sector', '2005-10-10', '2010-07-08', '<p>Legal systems elaborate rights and responsibilities in a variety of ways. A general distinction can be made between civil law jurisdictions, which codify their laws, and common law systems, where judge made law is not consolidated. In some countries, religion informs the law. Law provides a rich source of scholarly inquiry, into legal history, philosophy, economic analysis or sociology. Law also raises important and complex issues concerning equality, fairness and justice. "In its majestic equality", said the author Anatole France in 1894, "the law forbids rich and poor alike to sleep under bridges, beg in the streets and steal loaves of bread."[5] In a typical democracy, the central institutions for interpreting and creating law are the three main branches of government, namely an impartial judiciary, a democratic legislature, and an accountable executive.</p>', 'Sewage', 73),
(17, 3, 'ka', 'Sewage in Batumi', 'Criminal law, also known as penal law, pertains to crimes and punishment.[21] It thus regulates the definition of and penalties for offences found to have a sufficiently deleterious social impact but, in itself, makes no moral judgment on an offender nor imposes restrictions on society that physically prevents people from committing a crime in the first place.[22] Investigating, apprehending, charging, and trying suspected offenders is regulated by the law of criminal procedure.[23] The paradigm case of a crime lies in the proof, beyond reasonable doubt, that a person is guilty of two things. First, the accused must commit an act which is deemed by society to be criminal, or actus reus (guilty act).[24] Second, the accused must have the requisite malicious intent to do a criminal act, or mens rea (guilty mind). However for so called "strict liability" crimes, an actus reus is enough.[25] Criminal systems of the civil law tradition distinguish between intention in the broad sense (dolus directus and dolus eventualis), and negligence. Negligence does not carry criminal responsibility unless a particular crime provides for its punishment.', 13235000, 0, 'Batumi', 'Random grantee', 'Random sector', '2005-10-10', '2010-07-08', 'Legal systems elaborate rights and responsibilities in a variety of ways. A general distinction can be made between civil law jurisdictions, which codify their laws, and common law systems, where judge made law is not consolidated. In some countries, religion informs the law. Law provides a rich source of scholarly inquiry, into legal history, philosophy, economic analysis or sociology. Law also raises important and complex issues concerning equality, fairness and justice. "In its majestic equality", said the author Anatole France in 1894, "the law forbids rich and poor alike to sleep under bridges, beg in the streets and steal loaves of bread."[5] In a typical democracy, the central institutions for interpreting and creating law are the three main branches of government, namely an impartial judiciary, a democratic legislature, and an accountable executive.', 'Sewage', 71),
(18, 1, 'en', 'Water Pollution Fixing in Rustavi (en)', 'Legal systems elaborate rights and responsibilities in a variety of ways. A general distinction can be made between civil law jurisdictions, which codify their laws, and common law systems, where judge made law is not consolidated. In some countries, religion informs the law. Law provides a rich source of scholarly inquiry, into legal history, philosophy, economic analysis or sociology. Law also raises important and complex issues concerning equality, fairness and justice. "In its majestic equality", said the author Anatole France in 1894, "the law forbids rich and poor alike to sleep under bridges, beg in the streets and steal loaves of bread."[5] In a typical democracy, the central institutions for interpreting and creating law are the three main branches of government, namely an impartial judiciary, a democratic legislature, and an accountable executive.', 6230000, 0, 'Rustavi', 'Ministry of Pain', '42nd international battle station', '2012-12-05', '2013-04-03', 'Criminal law, also known as penal law, pertains to crimes and punishment.[21] It thus regulates the definition of and penalties for offences found to have a sufficiently deleterious social impact but, in itself, makes no moral judgment on an offender nor imposes restrictions on society that physically prevents people from committing a crime in the first place.[22] Investigating, apprehending, charging, and trying suspected offenders is regulated by the law of criminal procedure.[23] The paradigm case of a crime lies in the proof, beyond reasonable doubt, that a person is guilty of two things. First, the accused must commit an act which is deemed by society to be criminal, or actus reus (guilty act).[24] Second, the accused must have the requisite malicious intent to do a criminal act, or mens rea (guilty mind). However for so called "strict liability" crimes, an actus reus is enough.[25] Criminal systems of the civil law tradition distinguish between intention in the broad sense (dolus directus and dolus eventualis), and negligence. Negligence does not carry criminal responsibility unless a particular crime provides for its punishment.', 'Water Pollution', 61),
(19, 2, 'en', 'Sewage in Batumi', 'Criminal law, also known as penal law, pertains to crimes and punishment.[21] It thus regulates the definition of and penalties for offences found to have a sufficiently deleterious social impact but, in itself, makes no moral judgment on an offender nor imposes restrictions on society that physically prevents people from committing a crime in the first place.[22] Investigating, apprehending, charging, and trying suspected offenders is regulated by the law of criminal procedure.[23] The paradigm case of a crime lies in the proof, beyond reasonable doubt, that a person is guilty of two things. First, the accused must commit an act which is deemed by society to be criminal, or actus reus (guilty act).[24] Second, the accused must have the requisite malicious intent to do a criminal act, or mens rea (guilty mind). However for so called "strict liability" crimes, an actus reus is enough.[25] Criminal systems of the civil law tradition distinguish between intention in the broad sense (dolus directus and dolus eventualis), and negligence. Negligence does not carry criminal responsibility unless a particular crime provides for its punishment.', 13235000, 0, 'Batumi', 'Random grantee', 'Random sector', '2005-10-10', '2010-07-08', 'Legal systems elaborate rights and responsibilities in a variety of ways. A general distinction can be made between civil law jurisdictions, which codify their laws, and common law systems, where judge made law is not consolidated. In some countries, religion informs the law. Law provides a rich source of scholarly inquiry, into legal history, philosophy, economic analysis or sociology. Law also raises important and complex issues concerning equality, fairness and justice. "In its majestic equality", said the author Anatole France in 1894, "the law forbids rich and poor alike to sleep under bridges, beg in the streets and steal loaves of bread."[5] In a typical democracy, the central institutions for interpreting and creating law are the three main branches of government, namely an impartial judiciary, a democratic legislature, and an accountable executive.', 'Sewage', 64),
(20, 3, 'en', 'Sewage in Batumi', 'Criminal law, also known as penal law, pertains to crimes and punishment.[21] It thus regulates the definition of and penalties for offences found to have a sufficiently deleterious social impact but, in itself, makes no moral judgment on an offender nor imposes restrictions on society that physically prevents people from committing a crime in the first place.[22] Investigating, apprehending, charging, and trying suspected offenders is regulated by the law of criminal procedure.[23] The paradigm case of a crime lies in the proof, beyond reasonable doubt, that a person is guilty of two things. First, the accused must commit an act which is deemed by society to be criminal, or actus reus (guilty act).[24] Second, the accused must have the requisite malicious intent to do a criminal act, or mens rea (guilty mind). However for so called "strict liability" crimes, an actus reus is enough.[25] Criminal systems of the civil law tradition distinguish between intention in the broad sense (dolus directus and dolus eventualis), and negligence. Negligence does not carry criminal responsibility unless a particular crime provides for its punishment.', 13235000, 0, 'Batumi', 'Random grantee', 'Random sector', '2005-10-10', '2010-07-08', 'Legal systems elaborate rights and responsibilities in a variety of ways. A general distinction can be made between civil law jurisdictions, which codify their laws, and common law systems, where judge made law is not consolidated. In some countries, religion informs the law. Law provides a rich source of scholarly inquiry, into legal history, philosophy, economic analysis or sociology. Law also raises important and complex issues concerning equality, fairness and justice. "In its majestic equality", said the author Anatole France in 1894, "the law forbids rich and poor alike to sleep under bridges, beg in the streets and steal loaves of bread."[5] In a typical democracy, the central institutions for interpreting and creating law are the three main branches of government, namely an impartial judiciary, a democratic legislature, and an accountable executive.', 'Sewage', 71),
(38, 6, 'en', '33333333', '<p>33333333</p>', 33333333, 0, '33333333', '33333333', '33333333', '1000-10-10', '1994-06-10', '<p>33333333</p>', 'Sewage', 4),
(36, 5, 'en', '33333333', '<p>33333333333333333333333</p>', 2147483647, 0, '333333333333333', '3333333333333333', '33333', '3333-11-11', '3333-12-11', '<p>333333333333333333333333333</p>', 'Sewage', 4),
(37, 5, 'ka', '33333333', '<p>33333333333333333333333</p>', 2147483647, 0, '333333333333333', '3333333333333333', '33333', '3333-11-11', '3333-12-11', '<p>333333333333333333333333333</p>', 'Sewage', 4),
(32, 4, 'en', 'lockdown ', '<p>lockdown&nbsp;lockdown&nbsp;lockdown&nbsp;lockdown&nbsp;lockdown&nbsp;lockdown&nbsp;lockdown&nbsp;lockdown v</p>', 43673373, 0, 'lockdown ', 'lockdown ', 'lockdown 3', '3333-11-11', '1000-10-10', '<p>lockdown&nbsp;lockdown&nbsp;lockdown&nbsp;lockdown&nbsp;lockdown&nbsp;lockdown&nbsp;lockdown&nbsp;lockdown&nbsp;</p>', 'Sewage', 73),
(33, 4, 'ka', 'lockdown ', '<p>lockdown&nbsp;lockdown&nbsp;lockdown&nbsp;lockdown&nbsp;lockdown&nbsp;lockdown&nbsp;lockdown&nbsp;lockdown v</p>', 43673373, 0, 'lockdown ', 'lockdown ', 'lockdown 3', '3333-11-11', '1000-10-10', '<p>lockdown&nbsp;lockdown&nbsp;lockdown&nbsp;lockdown&nbsp;lockdown&nbsp;lockdown&nbsp;lockdown&nbsp;lockdown&nbsp;</p>', 'Sewage', 73),
(39, 6, 'ka', '33333333', '<p>33333333</p>', 33333333, 0, '33333333', '33333333', '33333333', '1000-10-10', '1994-06-10', '<p>33333333</p>', 'Sewage', 4);

-- --------------------------------------------------------

--
-- Table structure for table `projects_data`
--

CREATE TABLE IF NOT EXISTS `projects_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unique` int(11) NOT NULL,
  `lang` varchar(50) NOT NULL,
  `key` varchar(255) NOT NULL,
  `sort` int(11) NOT NULL,
  `sidebar` int(11) NOT NULL,
  `value` text NOT NULL,
  `project_unique` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=100 ;

--
-- Dumping data for table `projects_data`
--

INSERT INTO `projects_data` (`id`, `unique`, `lang`, `key`, `sort`, `sidebar`, `value`, `project_unique`) VALUES
(13, 3, 'ka', 'asda first', 3, 1, '<p>sdasda</p>', 2),
(14, 4, 'en', ' 	delete_project_data($id); (en)', 2, 1, '<p><br /> delete_project_data($id);</p>', 2),
(3, 2, 'en', 'lockdown  (en)', 0, 1, '<p>lockdown&nbsp;lockdown&nbsp;lockdown&nbsp;lockdown&nbsp;lockdown&nbsp;lockdown&nbsp;lockdown&nbsp;lockdown&nbsp;</p>', 1),
(4, 2, 'ka', 'lockdown ', 0, 1, '<p>lockdown&nbsp;lockdown&nbsp;lockdown&nbsp;lockdown&nbsp;lockdown&nbsp;lockdown&nbsp;lockdown&nbsp;lockdown&nbsp;</p>', 1),
(15, 4, 'ka', ' 	delete_project_data($id);', 2, 1, '<p><br /> delete_project_data($id);</p>', 2),
(12, 3, 'en', 'asda first (en)', 3, 1, '<p>sdasda</p>', 2),
(99, 8, 'ka', '452', 234, 0, '<p>23434234</p>', 6),
(98, 8, 'en', '452 (en)', 234, 0, '<p>23434234</p>', 6),
(97, 7, 'ka', 'raara', 34, 0, '<p>asdada</p>', 6),
(96, 7, 'en', 'raara (en)', 34, 0, '<p>asdada</p>', 6),
(95, 6, 'ka', 'asdasd', 3, 1, '<p>asdads</p>', 6),
(94, 6, 'en', 'asdasd (en)', 3, 1, '<p>asdads</p>', 6),
(93, 5, 'ka', 'assdasda', 3, 1, '<p>adasad</p>', 6),
(92, 5, 'en', 'assdasda (en)', 3, 1, '<p>adasad</p>', 6);

-- --------------------------------------------------------

--
-- Table structure for table `raions`
--

CREATE TABLE IF NOT EXISTS `raions` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `unique` int(11) NOT NULL,
  `lang` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `region_unique` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `raions`
--

INSERT INTO `raions` (`id`, `unique`, `lang`, `name`, `region_unique`) VALUES
(1, 1, 'en', 'dsfsdfsdf', 1),
(2, 2, 'en', 'dfsfsdfsdfsdgffgdfgdfg', 2),
(3, 1, 'ka', 'dsfsdfsdf', 1),
(4, 2, 'ka', 'dfsfsdfsdfsdgffgdfgdfg', 2);

-- --------------------------------------------------------

--
-- Table structure for table `region_cordinates`
--

CREATE TABLE IF NOT EXISTS `region_cordinates` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `longitude` decimal(20,5) NOT NULL,
  `latitude` decimal(20,5) NOT NULL,
  `region_unique` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `region_cordinates`
--

INSERT INTO `region_cordinates` (`id`, `longitude`, `latitude`, `region_unique`) VALUES
(1, '4636700.30229', '5109299.32963', 5);

-- --------------------------------------------------------

--
-- Table structure for table `regions`
--

CREATE TABLE IF NOT EXISTS `regions` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `unique` int(11) NOT NULL,
  `lang` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `region_info` text NOT NULL,
  `projects_info` text NOT NULL,
  `city` varchar(255) NOT NULL,
  `population` int(10) NOT NULL,
  `square_meters` int(10) NOT NULL,
  `settlement` varchar(255) NOT NULL,
  `villages` int(10) NOT NULL,
  `districts` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `regions`
--

INSERT INTO `regions` (`id`, `unique`, `lang`, `name`, `region_info`, `projects_info`, `city`, `population`, `square_meters`, `settlement`, `villages`, `districts`) VALUES
(7, 1, 'ka', 'Achara', 'Adjara has been part of Colchis and Caucasian Iberia since ancient times. Colonized by Greeks in the 5th century BC, the region fell under Rome in the 2nd century BC. It became part of the region of Egrisi before being incorporated into the unified Georgian Kingdom in the 9th century AD. The Ottomans conquered the area in 1614. The people of Adjara converted to Islam in this period. The Ottomans were forced to cede Adjara to the expanding Russian Empire in 1878.\r\nAfter a temporary occupation by Turkish and British troops in 1918â€“1920, Adjara became part of the Democratic Republic of Georgia in 1920. After a brief military conflict in March 1921, Ankara''s government ceded the territory to Georgia due to Article VI of Treaty of Kars on condition that autonomy is provided for the muslim population. The Soviet Union established the Adjar \r\nAdjara is well-known for its humid climate (especially along the coastal regions) and prolonged rainy weather, although there is plentiful sunshine during the Spring and Summer months. Adjara receives the highest amounts of precipitation both in Georgia and in the Caucasus. It is also one of the wettest temperate regions in the northern hemisphere. No region along Adjara''s coast receives less than 2,200 mm (86.6 in) of precipitation per year. The west-facing (windward) slopes of the Meskheti Range receive upwards of 4,500 mm (177.2 in) of precipitation per year. The coastal lowlands receive most of the precipitation in the form of rain (due to the area''s subtropical climate). September and October are usually the wettest months. Batumi''s average monthly rainfall for the month of September is 410 mm (16.14 in). The interior parts of Adjara are considerably drier than the coastal mountains and lowlands. Winter usually brings significant snowfall to the higher regions of Adjara, where snowfall often reaches several meters. Average summer temperatures are between 22â€“24 degrees Celsius in the lowland areas and 17â€“21 degrees Celsius in the highlands. The highest areas of Adjara have lower temperatures. Average winter temperatures are between 4â€“6 degrees Celsius along the coast while the interior areas and mountains average around -3â€“2 degrees Celsius. Some of the highest mountains of Adjara have average winter temperatures of -8â€“(-7) degrees Celsius.', 'Autonomous Soviet Socialist Republic in 1921 in accord with this clause. Thus, Adjara was still a component part of Georgia, but with considerable local autonomy.', 'Batumi', 2234000, 5434000, 'adjara', 32, 11),
(6, 2, 'ka', 'Racha', 'Racha had been part of Colchis and Caucasian Iberia since ancient times and its main town Oni was said to have been founded by King Parnajom of Iberia in the 2nd century BC. Upon creation of the unified Georgian kingdom in the 11th century, Racha became one of the duchies (saeristavo) within it. Rati of the Baghvashi family was the first duke (eristavi) appointed by King Bagrat III. Descendants of Rati and his son Kakhaber, eponymous father of Rachaâ€™s ruling dynasty of Kakhaberisdze, governed the province until 1278. In 1278 King David VI Narin abolished the duchy during his war against the Mongols. In the mid-14th century, the duchy was restored under the rule of the Tcharelidze family.', 'The next dynasty of Chkhetidze governed Racha from 1465 to 1769. Vassals of the King of Imereti, they revolted several times against the royal power. The 1678-1679 civil war resulted in the most serious consequences. In this war, Duke Shoshita II of Racha (1661-1684) supported Prince Archil, a rival of the pro-Ottoman Imeretian king Bagrat IV. On the defeat of Archil, Racha was overrun and plundered by an Ottoman punitive force. Under Rostom (1749-1769), the duchy became virtually independent from Imereti. However, towards the end of 1769, King Solomon I of Imereti managed to arrest Rostom and to abolish the duchy. In 1784, King David of Imereti revived the duchy and gave it to his nephew Anton. Local opposition attempted to use an Ottoman force to take control of Racha, but the victory of King David at Skhvava (January 26, 1786) temporarily secured his dominance in the area. In 1789, the next Imeretian king Solomon II finally abolished the duchy and subordinated the province directly to the royal administration.', 'Ambrolauri', 15000, 20515100, 'Krikhi', 50, 13),
(8, 1, 'en', 'Achara (en)', 'Adjara has been part of Colchis and Caucasian Iberia since ancient times. Colonized by Greeks in the 5th century BC, the region fell under Rome in the 2nd century BC. It became part of the region of Egrisi before being incorporated into the unified Georgian Kingdom in the 9th century AD. The Ottomans conquered the area in 1614. The people of Adjara converted to Islam in this period. The Ottomans were forced to cede Adjara to the expanding Russian Empire in 1878.\r\nAfter a temporary occupation by Turkish and British troops in 1918â€“1920, Adjara became part of the Democratic Republic of Georgia in 1920. After a brief military conflict in March 1921, Ankara''s government ceded the territory to Georgia due to Article VI of Treaty of Kars on condition that autonomy is provided for the muslim population. The Soviet Union established the Adjar \r\nAdjara is well-known for its humid climate (especially along the coastal regions) and prolonged rainy weather, although there is plentiful sunshine during the Spring and Summer months. Adjara receives the highest amounts of precipitation both in Georgia and in the Caucasus. It is also one of the wettest temperate regions in the northern hemisphere. No region along Adjara''s coast receives less than 2,200 mm (86.6 in) of precipitation per year. The west-facing (windward) slopes of the Meskheti Range receive upwards of 4,500 mm (177.2 in) of precipitation per year. The coastal lowlands receive most of the precipitation in the form of rain (due to the area''s subtropical climate). September and October are usually the wettest months. Batumi''s average monthly rainfall for the month of September is 410 mm (16.14 in). The interior parts of Adjara are considerably drier than the coastal mountains and lowlands. Winter usually brings significant snowfall to the higher regions of Adjara, where snowfall often reaches several meters. Average summer temperatures are between 22â€“24 degrees Celsius in the lowland areas and 17â€“21 degrees Celsius in the highlands. The highest areas of Adjara have lower temperatures. Average winter temperatures are between 4â€“6 degrees Celsius along the coast while the interior areas and mountains average around -3â€“2 degrees Celsius. Some of the highest mountains of Adjara have average winter temperatures of -8â€“(-7) degrees Celsius.', 'Autonomous Soviet Socialist Republic in 1921 in accord with this clause. Thus, Adjara was still a component part of Georgia, but with considerable local autonomy.', 'Batumi', 2234000, 5434000, 'adjara', 32, 11),
(9, 2, 'en', 'Racha (en)', 'Racha had been part of Colchis and Caucasian Iberia since ancient times and its main town Oni was said to have been founded by King Parnajom of Iberia in the 2nd century BC. Upon creation of the unified Georgian kingdom in the 11th century, Racha became one of the duchies (saeristavo) within it. Rati of the Baghvashi family was the first duke (eristavi) appointed by King Bagrat III. Descendants of Rati and his son Kakhaber, eponymous father of Rachaâ€™s ruling dynasty of Kakhaberisdze, governed the province until 1278. In 1278 King David VI Narin abolished the duchy during his war against the Mongols. In the mid-14th century, the duchy was restored under the rule of the Tcharelidze family.', 'The next dynasty of Chkhetidze governed Racha from 1465 to 1769. Vassals of the King of Imereti, they revolted several times against the royal power. The 1678-1679 civil war resulted in the most serious consequences. In this war, Duke Shoshita II of Racha (1661-1684) supported Prince Archil, a rival of the pro-Ottoman Imeretian king Bagrat IV. On the defeat of Archil, Racha was overrun and plundered by an Ottoman punitive force. Under Rostom (1749-1769), the duchy became virtually independent from Imereti. However, towards the end of 1769, King Solomon I of Imereti managed to arrest Rostom and to abolish the duchy. In 1784, King David of Imereti revived the duchy and gave it to his nephew Anton. Local opposition attempted to use an Ottoman force to take control of Racha, but the victory of King David at Skhvava (January 26, 1786) temporarily secured his dominance in the area. In 1789, the next Imeretian king Solomon II finally abolished the duchy and subordinated the province directly to the royal administration.', 'Ambrolauri', 15000, 20515100, 'Krikhi', 50, 13);

-- --------------------------------------------------------

--
-- Table structure for table `tag_connector`
--

CREATE TABLE IF NOT EXISTS `tag_connector` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag_unique` int(11) NOT NULL,
  `org_unique` int(11) DEFAULT NULL,
  `proj_unique` int(11) DEFAULT NULL,
  `news_unique` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=564 ;

--
-- Dumping data for table `tag_connector`
--

INSERT INTO `tag_connector` (`id`, `tag_unique`, `org_unique`, `proj_unique`, `news_unique`) VALUES
(1, 1, NULL, NULL, 1),
(2, 1, NULL, NULL, 2),
(27, 9, NULL, NULL, 2),
(4, 2, NULL, NULL, 4),
(5, 3, NULL, NULL, 1),
(6, 3, NULL, NULL, 2),
(7, 4, NULL, NULL, 3),
(8, 4, NULL, NULL, 4),
(9, 5, NULL, NULL, 1),
(10, 5, NULL, NULL, 2),
(11, 6, NULL, NULL, 3),
(12, 6, NULL, NULL, 4),
(13, 7, NULL, NULL, 1),
(14, 7, NULL, NULL, 2),
(15, 8, NULL, NULL, 3),
(16, 8, NULL, NULL, 4),
(17, 9, NULL, NULL, 1),
(18, 9, NULL, NULL, 3),
(33, 3, NULL, NULL, 5),
(32, 2, NULL, NULL, 5),
(31, 1, NULL, NULL, 5),
(30, 3, NULL, NULL, 5),
(29, 2, NULL, NULL, 5),
(28, 1, NULL, NULL, 5),
(365, 8, NULL, NULL, 6),
(364, 5, NULL, NULL, 6),
(363, 2, NULL, NULL, 6),
(40, 1, NULL, NULL, 7),
(41, 2, NULL, NULL, 7),
(42, 1, NULL, NULL, 7),
(43, 2, NULL, NULL, 7),
(189, 9, 3, NULL, NULL),
(188, 7, 3, NULL, NULL),
(187, 6, 3, NULL, NULL),
(186, 5, 3, NULL, NULL),
(185, 4, 3, NULL, NULL),
(184, 3, 3, NULL, NULL),
(63, 6, 54, NULL, NULL),
(64, 7, 54, NULL, NULL),
(65, 8, 54, NULL, NULL),
(66, 6, 54, NULL, NULL),
(67, 8, 54, NULL, NULL),
(68, 9, 54, NULL, NULL),
(69, 2, 41, NULL, NULL),
(70, 3, 41, NULL, NULL),
(71, 3, 40, NULL, NULL),
(72, 5, 40, NULL, NULL),
(183, 2, 3, NULL, NULL),
(238, 3, 1, NULL, NULL),
(237, 2, 1, NULL, NULL),
(236, 1, 1, NULL, NULL),
(256, 8, NULL, 2, NULL),
(255, 7, NULL, 2, NULL),
(560, 24, NULL, 6, NULL),
(559, 12, NULL, 6, NULL),
(558, 11, NULL, 6, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unique` int(11) NOT NULL,
  `lang` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=59 ;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `unique`, `lang`, `name`) VALUES
(1, 1, 'ka', 'lorem'),
(2, 2, 'ka', 'ipsum'),
(3, 3, 'ka', 'dolor'),
(4, 4, 'ka', 'sit'),
(5, 5, 'ka', 'amet'),
(6, 6, 'ka', 'consectetur'),
(9, 7, 'ka', 'vaxaxa3'),
(10, 8, 'ka', 'tag#'),
(12, 1, 'en', 'lorem (en)'),
(13, 2, 'en', 'ipsum (en)'),
(14, 3, 'en', 'dolor (en)'),
(15, 4, 'en', 'sit (en)'),
(16, 5, 'en', 'amet (en)'),
(17, 6, 'en', 'consectetur (en)'),
(18, 7, 'en', 'vaxaxa3 (en)'),
(19, 8, 'en', 'tag# (en)'),
(22, 9, 'en', 'sad (en)'),
(23, 9, 'ka', 'sad'),
(27, 10, 'en', 'vaxaaxa (en)'),
(28, 10, 'ka', 'vaxaaxa'),
(29, 11, 'en', 'shini (en)'),
(30, 11, 'ka', 'shini'),
(31, 12, 'en', 'kaieg (en)'),
(32, 12, 'ka', 'kaieg'),
(33, 13, 'en', '33335252 (en)'),
(34, 13, 'ka', '33335252'),
(35, 14, 'en', '657856858 (en)'),
(36, 14, 'ka', '657856858'),
(37, 15, 'en', 'test (en)'),
(38, 15, 'ka', 'test'),
(39, 16, 'en', 'test2 (en)'),
(40, 16, 'ka', 'test2'),
(41, 17, 'en', 'adasddad (en)'),
(42, 17, 'ka', 'adasddad'),
(43, 18, 'en', 'test4 (en)'),
(44, 18, 'ka', 'test4'),
(45, 19, 'en', 'test5 (en)'),
(46, 19, 'ka', 'test5'),
(47, 20, 'en', 'test6 (en)'),
(48, 20, 'ka', 'test6'),
(49, 21, 'en', 'test7 (en)'),
(50, 21, 'ka', 'test7'),
(51, 22, 'en', 'kidermae (en)'),
(52, 22, 'ka', 'kidermae'),
(53, 23, 'en', 'dara (en)'),
(54, 23, 'ka', 'dara'),
(55, 24, 'en', 'atas (en)'),
(56, 24, 'ka', 'atas'),
(57, 25, 'en', 'dakidermae (en)'),
(58, 25, 'ka', 'dakidermae');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'vazha', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8'),
(2, 'client', '2736fab291f04e69b62d490c3c09361f5b82461a'),
(6, 'ika', 'e34a2da1437adaf97ada8a7b4c52f2555a9b26dc');

-- --------------------------------------------------------

--
-- Table structure for table `water_supply`
--

CREATE TABLE IF NOT EXISTS `water_supply` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `lang` varchar(25) NOT NULL,
  `text` varchar(255) NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `region_unique` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `water_supply`
--

INSERT INTO `water_supply` (`id`, `lang`, `text`, `last_updated`, `region_unique`) VALUES
(1, '', 'lorem ipsum sit amet', '0000-00-00 00:00:00', 6),
(2, '', 'iyo da ara iyo ra gvtis uketesi ra iqneboda', '0000-00-00 00:00:00', 7),
(3, '', 'water supply supply water', '2011-09-19 17:33:21', 11);
