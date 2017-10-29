-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 19, 2017 at 08:48 AM
-- Server version: 5.6.37
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `taiki_sirius`
--

-- --------------------------------------------------------

--
-- Table structure for table `chatbox`
--

CREATE TABLE `chatbox` (
  `messageID` bigint(20) UNSIGNED NOT NULL,
  `messageText` text NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `userName` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `genre`
--

CREATE TABLE `genre` (
  `genreID` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `highScore`
--

CREATE TABLE `highScore` (
  `userName` text NOT NULL,
  `score` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `music`
--

CREATE TABLE `music` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `genreID` bigint(20) NOT NULL,
  `filename` text NOT NULL,
  `trackName` text NOT NULL,
  `artistName` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chatbox`
--

--
-- Indexes for table `chatbox`
--
ALTER TABLE `chatbox`
  ADD PRIMARY KEY (`messageID`),
  ADD UNIQUE KEY `messageID` (`messageID`);

--
-- Indexes for table `genre`
--
ALTER TABLE `genre`
  ADD UNIQUE KEY `genreID` (`genreID`),
  ADD UNIQUE KEY `name` (`name`(64));

--
-- Indexes for table `music`
--
ALTER TABLE `music`
  ADD UNIQUE KEY `ID` (`ID`),
  ADD UNIQUE KEY `searchSimilar` (`ID`,`genreID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chatbox`
--
ALTER TABLE `chatbox`
  MODIFY `messageID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `genre`
--
ALTER TABLE `genre`
  MODIFY `genreID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `music`
--
ALTER TABLE `music`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_1.mp3', "The Walking Dead", "The Walking Dead");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_2.mp3', "Le diner de con", "Le diner de con");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_3.mp3', "Borderland 2", "Borderland 2");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_4.mp3', "Fame", "Fame");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_5.mp3', "Les mysterieuses citées d'Or", "Les mysterieuses citées d'Or");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_6.mp3', "James Bond", "James Bond");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_7.mp3', "For a few dollars more", "For a few dollars more");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_8.mp3', "Gladiator", "Gladiator");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_9.mp3', "Inception", "Inception");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_10.mp3', "How I met your Mother", "How I met your Mother");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_11.mp3', "Jurassic Park", "Jurassic Park");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_12.mp3', "Kill Bill", "Kill Bill");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_13.mp3', "Ghostbuster", "Ghostbuster");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_14.mp3', "Pearl Harbor", "Pearl Harbor");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_15.mp3', "Pulp Fiction", "Pulp Fiction");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_16.mp3', "Reservoir Dogs", "Reservoir Dogs");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_17.mp3', "Retour vers le futur", "Retour vers le futur");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_18.mp3', "Le bon la brute et le truand", "Le bon la brute et le truand");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_19.mp3', "Panthère rose", "Panthère rose");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_20.mp3', "Le flic de Beverly Hills", "Le flic de Beverly Hills");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_21.mp3', "Avenger", "Avenger");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_22.mp3', "James bond", "James bond");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_23.mp3', "Harry potter", "Harry potter");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_24.mp3', "transformers", "transformers");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_25.mp3', "Star wars", "Star wars");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_26.mp3', "Mission impossible", "Mission impossible");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_27.mp3', "Les bronzés font du ski", "Les bronzés font du ski");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_28.mp3', "Legend", "Legend");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_29.mp3', "Les aventures de Tintin", "Les aventures de Tintin");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_30.mp3', "TED", "TED");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_31.mp3', "Lone ranger", "Lone ranger");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_32.mp3', "Games of Thrones", "Games of Thrones");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_33.mp3', "Toy story", "Toy story");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_34.mp3', "Le noël de scrooge", "Le noël de scrooge");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_35.mp3', "Batman", "Batman");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_36.mp3', "Edge of tomorrow", "Edge of tomorrow");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_37.mp3', "Le seigneur des anneaux", "Le seigneur des anneaux");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_38.mp3', "Inception", "Inception");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_39.mp3', "Intouchable", "Intouchable");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_40.mp3', "Inssaisissable", "Inssaisissable");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_41.mp3', "Pirates des caraïbes", "Pirates des caraïbes");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_42.mp3', "Les visiteurs", "Les visiteurs");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_43.mp3', "Gatsby", "Gatsby");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_44.mp3', "Fast and Furious", "Fast and Furious");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_45.mp3', "La reine des neiges", "La reine des neiges");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_46.mp3', "Godzilla", "Godzilla");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_47.mp3', "Interstellar", "Interstellar");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_48.mp3', "Spider man ", "Spider man ");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_49.mp3', "Le roi lion ", "Le roi lion ");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_50.mp3', "Saw", "Saw");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_51.mp3', "Aladin (Kev adams)", "Aladin (Kev adams)");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_52.mp3', "Mad max fury road", "Mad max fury road");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_53.mp3', "Cars", "Cars");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_54.mp3', "Tarzan", "Tarzan");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_55.mp3', "Man of steel ", "Man of steel ");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_56.mp3', "Le labyrinthe", "Le labyrinthe");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_57.mp3', "Kingsman", "Kingsman");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_58.mp3', "L'aprenti sorcier", "L'aprenti sorcier");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_59.mp3', "Tortue ninja", "Tortue ninja");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_60.mp3', "Narnia", "Narnia");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_61.mp3', "Men in black", "Men in black");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_62.mp3', "Rocky", "Rocky");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_63.mp3', "Titanic", "Titanic");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_64.mp3', "terminator", "terminator");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_65.mp3', "Deadpool", "Deadpool");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_66.mp3', "L'exorciste", "L'exorciste");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_67.mp3', "LOL", "LOL");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_68.mp3', "Pacific Rim", "Pacific Rim");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_69.mp3', "Friend", "Friend");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_70.mp3', "Slumdog millionnaire", "Slumdog millionnaire");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_71.mp3', "X men", "X men");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_72.mp3', "Wall-e", "Wall-e");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_73.mp3', "Avatar", "Avatar");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_74.mp3', "Je suis une legende ", "Je suis une legende ");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_75.mp3', "Noé", "Noé");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_76.mp3', "Indiana jones", "Indiana jones");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_77.mp3', "Le hobbit", "Le hobbit");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_78.mp3', "Gladiator", "Gladiator");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_79.mp3', "Furry", "Furry");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_80.mp3', "Hansel et Gretel", "Hansel et Gretel");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_81.mp3', "Star Trek", "Star Trek");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_82.mp3', "Benjamin Button", "Benjamin Button");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_83.mp3', "Hunger games", "Hunger games");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_84.mp3', "Alice au pays des merveilles", "Alice au pays des merveilles");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_85.mp3', "Jupiter", "Jupiter");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_86.mp3', "Jurassic World", "Jurassic World");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_87.mp3', "Hercule", "Hercule");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_88.mp3', "GI joe", "GI joe");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_89.mp3', "Ant-man", "Ant-man");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_90.mp3', "Kick ass", "Kick ass");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_91.mp3', "Brice de nice", "Brice de nice");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_92.mp3', "Simpson", "Simpson");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_93.mp3', "Matrix", "Matrix");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_94.mp3', "Arrow", "Arrow");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_95.mp3', "Les 4 fantastiques ", "Les 4 fantastiques ");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_96.mp3', "Sin city", "Sin city");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_97.mp3', "Taken 2", "Taken 2");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_98.mp3', "Mr & Ms Smith", "Mr & Ms Smith");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_99.mp3', "Némo", "Némo");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_100.mp3', "the flash", "the flash");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_101.mp3', "Bad boys", "Bad boys");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_102.mp3', "Babysitting", "Babysitting");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_103.mp3', "Les profs", "Les profs");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_104.mp3', "Amercian pie", "Amercian pie");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_105.mp3', "Madagascar", "Madagascar");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_106.mp3', "Dardevil", "Dardevil");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_107.mp3', "Le parrain", "Le parrain");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_108.mp3', "La liste de shindler", "La liste de shindler");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_109.mp3', "Twilight", "Twilight");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_110.mp3', "La nuit au musée", "La nuit au musée");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_111.mp3', "Frère des ours", "Frère des ours");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_112.mp3', "Astérix et obélix mission Cléopatre ", "Astérix et obélix mission Cléopatre ");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_113.mp3', "Prison break", "Prison break");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_114.mp3', "Le dictateur ", "Le dictateur ");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_115.mp3', "Step up", "Step up");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_116.mp3', "One Tree Hill", "One Tree Hill");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_117.mp3', "Pearl Harbor", "Pearl Harbor");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_118.mp3', "Hercule ", "Hercule ");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_119.mp3', "Amélie Poulain", "Amélie Poulain");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_120.mp3', "Doctor Who", "Doctor Who");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_121.mp3', "MacGyver", "MacGyver");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_122.mp3', "WestWorld", "WestWorld");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_123.mp3', "OSS 117", "OSS 117");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_124.mp3', "Penny Dreadful", "Penny Dreadful");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_125.mp3', "Fight Club", "Fight Club");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_126.mp3', "Portal", "Portal");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_127.mp3', "Space Jam", "Space Jam");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_128.mp3', "Tintin", "Tintin");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_129.mp3', "Men in black", "Men in black");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_130.mp3', "Les dents de la mer", "Les dents de la mer");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_131.mp3', "Psychose", "Psychose");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_132.mp3', "2001 Odyssée de l'espace", "2001 Odyssée de l'espace");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_133.mp3', "Capitaine Flam", "Capitaine Flam");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_134.mp3', "Code Lyoko", "Code Lyoko");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_135.mp3', "Dallas", "Dallas");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_136.mp3', "Le laboratoire de Dexter", "Le laboratoire de Dexter");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_137.mp3', "Le prince de Bel-Air", "Le prince de Bel-Air");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_138.mp3', "Orange Mecanique", "Orange Mecanique");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_139.mp3', "Les zinzins de l'espace", "Les zinzins de l'espace");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_140.mp3', "Oggy et les cafards", "Oggy et les cafards");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_141.mp3', "Hawaï five-O", "Hawaï five-O");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_142.mp3', "Hercules", "Hercules");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_143.mp3', "Drive", "Drive");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_144.mp3', "Les choristes", "Les choristes");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_145.mp3', "NCIS", "NCIS");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_146.mp3', "L'age de glace", "L'age de glace");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_147.mp3', "Shining", "Shining");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_148.mp3', "Walker Texas Ranger", "Walker Texas Ranger");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_149.mp3', "Xena la guerrière", "Xena la guerrière");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_150.mp3', "Yu-gi-oh", "Yu-gi-oh");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_151.mp3', "Kiki la petite sorcière", "Kiki la petite sorcière");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_152.mp3', "Les Gardiens de la galaxie 1", "Les Gardiens de la galaxie 1");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_153.mp3', "American Beauty", "American Beauty");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_154.mp3', "Taxi Driver", "Taxi Driver");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_155.mp3', "E.T", "E.T");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_156.mp3', "Vendredi 13", "Vendredi 13");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_157.mp3', "Full Metal Jacket", "Full Metal Jacket");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_158.mp3', "Halloween", "Halloween");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_159.mp3', "Jason Bourne", "Jason Bourne");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_160.mp3', "Total Recall", "Total Recall");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_161.mp3', "Kingsman", "Kingsman");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_162.mp3', "Starship troopers", "Starship troopers");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_163.mp3', "Asterix mission Cléopatre", "Asterix mission Cléopatre");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_164.mp3', "Le voyage de Chihiro", "Le voyage de Chihiro");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_165.mp3', "Predator", "Predator");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_166.mp3', "Prometheus", "Prometheus");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_167.mp3', "Robocop", "Robocop");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_168.mp3', "Seven", "Seven");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_169.mp3', "Stuart Little", "Stuart Little");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_170.mp3', "James Bond: Spectre", "James Bond: Spectre");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_171.mp3', "The 100", "The 100");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_172.mp3', "La ligne Verte", "La ligne Verte");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_173.mp3', "Les Evadés", "Les Evadés");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_174.mp3', "Kill Bill", "Kill Bill");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_175.mp3', "X-men Le commencement", "X-men Le commencement");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_176.mp3', "Gremlins", "Gremlins");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_177.mp3', "Madagascar 2", "Madagascar 2");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_178.mp3', "Iron Man", "Iron Man");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_179.mp3', "La Planéte au Trésor", "La Planéte au Trésor");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_180.mp3', "L'odyssée de Pi", "L'odyssée de Pi");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_181.mp3', "Slumdog Millionaire", "Slumdog Millionaire");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_182.mp3', "Pokemon", "Pokemon");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_183.mp3', "Shrek", "Shrek");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_184.mp3', "The Big Bang Theory", "The Big Bang Theory");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_185.mp3', "World War Z", "World War Z");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_186.mp3', "Kung Fu Panda", "Kung Fu Panda");
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', 'extract_187.mp3', "Dexter", "Dexter");
INSERT INTO `genre` (`genreID`, `name`) VALUES ('1', 'Série/Film');
INSERT INTO `genre` (`genreID`, `name`) VALUES ('2', 'Musique');

INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, 2, 'extract_4.mp3', 'Fame', 'Irene Cara');
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, 2, 'extract_170.mp3', 'Writing\'s on the Wall', 'Sam Smith');
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, 2, 'extract_181.mp3', 'Paper Planes', 'MIA');
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, 2, 'extract_183.mp3', 'I\'m a Believer', 'Smash Mouth');
INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, 2, 'extract_186.mp3', 'Hero', 'Hans Zimmer');

INSERT INTO `highScore` (`userName`, `score`) VALUES ('CapsHil', '10000');
INSERT INTO `highScore` (`userName`, `score`) VALUES ('Gillesse', '8250');
INSERT INTO `highScore` (`userName`, `score`) VALUES ('Taiki', '7000');
INSERT INTO `highScore` (`userName`, `score`) VALUES ('Bougaincity', '4300');
INSERT INTO `highScore` (`userName`, `score`) VALUES ('Falempin', '50');
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
