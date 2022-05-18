-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 18, 2022 at 11:24 AM
-- Server version: 10.1.48-MariaDB-0ubuntu0.18.04.1
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ex85657`
--

-- --------------------------------------------------------

--
-- Table structure for table `Afbeeldingen`
--

CREATE TABLE `Afbeeldingen` (
  `ID` int(5) NOT NULL,
  `Naam` varchar(260) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Afbeeldingen`
--

INSERT INTO `Afbeeldingen` (`ID`, `Naam`) VALUES
(1, 'strand.jpg'),
(2, 'bergen.jpg'),
(3, 'rivier.jpg'),
(4, 'sneeuw.jpg'),
(5, 'platteland.jpg'),
(6, 'woestijn.jpg'),
(7, 'savana.jpg'),
(8, 'canyon.jpg'),
(9, 'stad.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `Docenten`
--

CREATE TABLE `Docenten` (
  `ID` int(5) NOT NULL,
  `Afkorting` varchar(3) NOT NULL,
  `Wachtwoord` varchar(200) NOT NULL,
  `Naam` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Docenten`
--

INSERT INTO `Docenten` (`ID`, `Afkorting`, `Wachtwoord`, `Naam`) VALUES
(2, 'BLS', '067acde581193ba318f9ea063b2604ae1bb5539a', 'Henk Bijlsma');

-- --------------------------------------------------------

--
-- Table structure for table `Inschrijvingen`
--

CREATE TABLE `Inschrijvingen` (
  `ID` int(5) NOT NULL,
  `StudentNummer` int(5) NOT NULL,
  `ReisID` int(5) NOT NULL,
  `Identiteitbewijs` int(9) NOT NULL,
  `Opmerkingen` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Inschrijvingen`
--

INSERT INTO `Inschrijvingen` (`ID`, `StudentNummer`, `ReisID`, `Identiteitbewijs`, `Opmerkingen`) VALUES
(5, 8, 3, 123123123, 'test'),
(6, 9, 2, 123123321, 'Heimwee'),
(12, 8, 2, 123123123, 'Heimwee'),
(13, 10, 2, 123123123, ''),
(14, 11, 2, 123123123, ''),
(15, 12, 2, 123123123, '');

-- --------------------------------------------------------

--
-- Table structure for table `Reizen`
--

CREATE TABLE `Reizen` (
  `ID` int(5) NOT NULL,
  `Titel` varchar(100) NOT NULL,
  `Bestemming` varchar(150) NOT NULL,
  `Omschrijving` varchar(1000) NOT NULL,
  `Begindatum` date NOT NULL,
  `Einddatum` date NOT NULL,
  `MaxInschrijvingen` int(3) NOT NULL,
  `Afbeelding` varchar(260) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Reizen`
--

INSERT INTO `Reizen` (`ID`, `Titel`, `Bestemming`, `Omschrijving`, `Begindatum`, `Einddatum`, `MaxInschrijvingen`, `Afbeelding`) VALUES
(2, '23 Daagse rondreis door Madagascar', 'Madagascar', 'Tijdens deze avontuurlijke rondreis door Madagascar beleven zowel cultuur- als natuurliefhebbers een geweldige reis. Het land herbergt een uniek planten- en dierenleven met lemuren (halfapen), kameleons en bizar stekelwoud. Door het canyonlandschap van Isalo en het tropische woud van Périnet is het prachtig wandelen. De weelderige Amberbergen zijn ook zeer de moeite van het verkennen waard. Een ontmoeting met de vriendelijke bevolking met hun bijzondere geschiedenis en voorouderverering bieden een goede afwisseling op al het natuurschoon. ', '2022-06-09', '2022-06-23', 6, 'rivier.jpg'),
(3, 'Florida Sunshine State', 'Florida', 'Florida, the ‘Sunshine State’ ligt in het zuidoosten van de Verenigde Staten heeft een subtropisch klimaat. De naam is afgeleid van de Spaanse naam La Florida, wat De Bloemrijke betekent. De hoofdstad is Tallahassee. Andere grote steden zijn Miami, Jacksonville, Fort Lauderdale, Tampa, St. Petersburg, Clearwater en Orlando. De staat telt 13 miljoen inwoners, 34 rivieren en meer dan 30.000 meren. Ontdek the Sunshine State en lees hieronder de reisinformatie over Florida.', '2022-05-25', '2022-05-31', 4, 'strand.jpg'),
(8, 'Miami Race', 'Miami', 'De welbekende pastelkleurige strandwachthuisjes op het witte South Beach en de fraaie Art Deco gebouwen aan Ocean Drive vormen het decor van een vakantie in Miami. In deze bruisende wereldstad in het zonnige zuiden van de Verenigde Staten kun je dansen tussen de celebrities in nachtclub LIV. Of woon een baseball game van de Miami Marlins bij. Bekijk hieronder meer Miami tips.', '2022-05-18', '2022-06-03', 42, 'strand.jpg'),
(11, 'Spanje', 'europa', 'spanje ligt in europa', '2022-05-20', '2022-05-26', 4, 'strand.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `Studenten`
--

CREATE TABLE `Studenten` (
  `StudentNummer` int(5) NOT NULL,
  `Wachtwoord` varchar(200) NOT NULL,
  `Naam` varchar(50) NOT NULL,
  `Achternaam` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Studenten`
--

INSERT INTO `Studenten` (`StudentNummer`, `Wachtwoord`, `Naam`, `Achternaam`) VALUES
(8, '7288edd0fc3ffcbe93a0cf06e3568e28521687bc', 'Anouk', 'van Abbe'),
(9, '7288edd0fc3ffcbe93a0cf06e3568e28521687bc', 'Henno', 'Passchier'),
(10, '7288edd0fc3ffcbe93a0cf06e3568e28521687bc', 'Jan', 'van Kooppen'),
(11, '7288edd0fc3ffcbe93a0cf06e3568e28521687bc', 'Pieter', 'Loon'),
(12, '7288edd0fc3ffcbe93a0cf06e3568e28521687bc', 'Roel', 'Knaap'),
(13, '7288edd0fc3ffcbe93a0cf06e3568e28521687bc', 'David', 'Koopmans');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Afbeeldingen`
--
ALTER TABLE `Afbeeldingen`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `Docenten`
--
ALTER TABLE `Docenten`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `Inschrijvingen`
--
ALTER TABLE `Inschrijvingen`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `Reizen`
--
ALTER TABLE `Reizen`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `Studenten`
--
ALTER TABLE `Studenten`
  ADD PRIMARY KEY (`StudentNummer`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Afbeeldingen`
--
ALTER TABLE `Afbeeldingen`
  MODIFY `ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `Docenten`
--
ALTER TABLE `Docenten`
  MODIFY `ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `Inschrijvingen`
--
ALTER TABLE `Inschrijvingen`
  MODIFY `ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `Reizen`
--
ALTER TABLE `Reizen`
  MODIFY `ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `Studenten`
--
ALTER TABLE `Studenten`
  MODIFY `StudentNummer` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
