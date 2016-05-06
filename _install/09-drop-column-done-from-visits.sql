-- phpMyAdmin SQL Dump
-- version 4.5.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 06, 2016 at 09:08 PM
-- Server version: 5.5.49-0ubuntu0.14.04.1
-- PHP Version: 7.0.6-1+donate.sury.org~trusty+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `demot`
--

-- --------------------------------------------------------

--
-- Table structure for table `visits`
--

DROP TABLE IF EXISTS `visits`;
CREATE TABLE `visits` (
  `Id` int(5) NOT NULL,
  `AppointmentId` int(5) NOT NULL,
  `SecondVisitor` varchar(32) DEFAULT NULL,
  `ThirdVisitor` varchar(32) DEFAULT NULL,
  `GivenObjects` varchar(100) NOT NULL,
  `ReceivedObjects` varchar(100) NOT NULL,
  `Relationship` varchar(50) NOT NULL,
  `Motive` text NOT NULL,
  `Comments` text NOT NULL,
  `Duration` int(11) NOT NULL,
  `InmatePhisicalState` varchar(100) NOT NULL,
  `InmateEmotionalState` varchar(100) NOT NULL,
  `GuardId` varchar(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `visits`
--

INSERT INTO `visits` (`Id`, `AppointmentId`, `SecondVisitor`, `ThirdVisitor`, `GivenObjects`, `ReceivedObjects`, `Relationship`, `Motive`, `Comments`, `Duration`, `InmatePhisicalState`, `InmateEmotionalState`, `GuardId`) VALUES
(16, 5, '1', NULL, 'Topor', 'Cutit', 'Tata', 'Evadare', 'E ok', 1000, '1', '1', ''),
(21, 14, 'd743069b47060a609a12221398001fee', '8441bfa1c3f1ff04c1de42f800af3337', 'test pentru id ', 'test pentru id', 'prieteni', 'test', 'sa vad daca reusesc', 70, '5', '5', ''),
(20, 13, 'd743069b47060a609a12221398001fee', 'absent', 'Nimic', 'Nimic', 'PRienteni', 'Degeaba', 'Nici macar un comment', 30, '5', '5', ''),
(22, 10, 'ad046e0d2300b73ecb78007966a30872', '2f78a4f190161bbb1672fdcaec789ff7', 'k', 'k', 'ok', 'k', 'kkkk', 60, '3', '3', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `visits`
--
ALTER TABLE `visits`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Id` (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `visits`
--
ALTER TABLE `visits`
  MODIFY `Id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
