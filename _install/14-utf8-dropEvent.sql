-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 19, 2016 at 11:15 AM
-- Server version: 5.7.9
-- PHP Version: 7.0.0

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
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `Id` varchar(32) NOT NULL,
  `InstId` int(2) DEFAULT NULL,
  `UserName` varchar(50) NOT NULL,
  `PwdHash` varchar(32) NOT NULL,
  `Rank` int(1) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `UserName` (`UserName`),
  KEY `InstId` (`InstId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`Id`, `InstId`, `UserName`, `PwdHash`, `Rank`) VALUES
('23bc3abe956f1737b197255bf17d5a9a', NULL, 'super admin', '202cb962ac59075b964b07152d234b70', 0),
('23bc3abe956f1737b197255bf17d5a9b', 1, 'admin', '202cb962ac59075b964b07152d234b70', 1),
('61b85da718e7e4f4a89fde1af1e239ae', 1, 'guard', '202cb962ac59075b964b07152d234b70', 2),
('61b85da718e7e4f4a89fde1af1e23932', 2, 'guard a', '202cb962ac59075b964b07152d234b70', 2);

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

DROP TABLE IF EXISTS `appointments`;
CREATE TABLE IF NOT EXISTS `appointments` (
  `Id` int(5) NOT NULL AUTO_INCREMENT,
  `VisitorId` varchar(32) NOT NULL,
  `DateOfAppointment` date NOT NULL,
  `TimeOfAppointment` time NOT NULL,
  `Visitor2FirstName` varchar(50) DEFAULT NULL,
  `Visitor2LastName` varchar(50) DEFAULT NULL,
  `Visitor2CNP` varchar(13) DEFAULT NULL,
  `Visitor2Id` varchar(32) DEFAULT NULL,
  `Visitor3FirstName` varchar(50) DEFAULT NULL,
  `Visitor3LastName` varchar(50) DEFAULT NULL,
  `Visitor3CNP` varchar(13) DEFAULT NULL,
  `Visitor3Id` varchar(32) DEFAULT NULL,
  `State` varchar(20) NOT NULL,
  `InmateId` varchar(32) NOT NULL,
  `GuardId` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=59 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`Id`, `VisitorId`, `DateOfAppointment`, `TimeOfAppointment`, `Visitor2FirstName`, `Visitor2LastName`, `Visitor2CNP`, `Visitor2Id`, `Visitor3FirstName`, `Visitor3LastName`, `Visitor3CNP`, `Visitor3Id`, `State`, `InmateId`, `GuardId`) VALUES
(1, '8995de07f10e6c9f6335bd0534d0d83e', '2016-04-29', '11:00:00', 'Alex', 'Alex', '12312312312', '', 'Andrei', 'Andrei', '12312312332', '', 'noshow', '3fdb1b0d3e6bb8114f9c59ed07c12e86', ''),
(2, '8995de07f10e6c9f6335bd0534d0d83e', '2016-04-29', '11:00:00', 'Alex', 'Alex', '12312312312', '', 'Andrei', 'Andrei', '12312312332', '340ddc288e7f2247616b43b416836fa7', 'done', '3fdb1b0d3e6bb8114f9c59ed07c12e86', ''),
(3, '8995de07f10e6c9f6335bd0534d0d83e', '2016-04-29', '11:00:00', 'Alex', 'Alex', '12312312312', '340ddc288e7f2247616b43b416836fa7', 'Andrei', 'Andrei', '12312312332', '', 'noshow', '3fdb1b0d3e6bb8114f9c59ed07c12e86', ''),
(4, '8995de07f10e6c9f6335bd0534d0d83e', '2016-04-29', '11:00:00', 'Alex', 'Alex', '12312312312', '340ddc288e7f2247616b43b416836fa7', 'Andrei', 'Andrei', '12312312332', '', 'rejected', '3fdb1b0d3e6bb8114f9c59ed07c12e86', ''),
(5, '340ddc288e7f2247616b43b416836fa7', '2016-05-10', '10:00:00', 'Ion', 'Ion', '1234512345123', '', '', '', '', '', 'done', '3fdb1b0d3e6bb8114f9c59ed07c12e86', ''),
(6, '340ddc288e7f2247616b43b416836fa7', '2016-05-11', '10:00:00', 'Ioana', 'Ioana', '2234512345123', '', '', '', '', '', 'rejected', '3fdb1b0d3e6bb8114f9c59ed07c12e86', ''),
(7, '340ddc288e7f2247616b43b416836fa7', '2016-05-12', '10:00:00', 'Paul', 'Paul', '3234512345123', '', '', '', '', '', 'done', '3fdb1b0d3e6bb8114f9c59ed07c12e86', ''),
(8, '340ddc288e7f2247616b43b416836fa7', '2016-05-10', '12:00:00', '', '', '', '', '', '', '', '', 'done', '3fdb1b0d3e6bb8114f9c59ed07c12e86', ''),
(11, '340ddc288e7f2247616b43b416836fa7', '1333-12-13', '00:00:13', 'Alex', 'z', '1910729374220', 'a61b5570c198b8f7c4d4c8b21316fcb4', 'Andrei', 'Chelaru', '1910729374519', 'a0cc807a03912b250b74eff11c2ae8d2', 'done', '3fdb1b0d3e6bb8114f9c59ed07c12e86', ''),
(10, '340ddc288e7f2247616b43b416836fa7', '1991-12-12', '00:00:13', 'Alexandru', 'zamfir', '1910729374510', 'ad046e0d2300b73ecb78007966a30872', 'Bogdan', 'olariu', '1910729374519', '2f78a4f190161bbb1672fdcaec789ff7', 'done', '3fdb1b0d3e6bb8114f9c59ed07c12e86', ''),
(12, '340ddc288e7f2247616b43b416836fa7', '1111-11-11', '00:00:12', 'Alex', 'eu', '1910729374220', 'cdfab39f3f87ffff2c35abe71258c806', 'neculai', 'neculai', '1910729374510', '986f77e726b34d247b62bd981b50571a', 'done', '3fdb1b0d3e6bb8114f9c59ed07c12e86', ''),
(13, '340ddc288e7f2247616b43b416836fa7', '1111-11-11', '00:00:14', 'Andrei', 'Chelaru', '1910729374220', 'd743069b47060a609a12221398001fee', 'Alex', 'Eu', '1910729374519', '289ccb34ff105a981712a28091b41721', 'done', '3fdb1b0d3e6bb8114f9c59ed07c12e86', ''),
(14, '340ddc288e7f2247616b43b416836fa7', '1111-11-11', '00:00:13', 'Andrei', 'Chelaru', '1910729374220', 'd743069b47060a609a12221398001fee', 'Alex', 'Zamfir', '1910729374510', '8441bfa1c3f1ff04c1de42f800af3337', 'approved', '3fdb1b0d3e6bb8114f9c59ed07c12e86', '61b85da718e7e4f4a89fde1af1e239ae'),
(15, '340ddc288e7f2247616b43b416836fa7', '1111-11-11', '00:00:12', 'visitor2', 'visitor2', '297041252222', '8995de07f10e6c9f6335bd0534d0d83e', 'a', 'a', '14', '56c968ba413527105d0ab942f3363a9e', 'rejected', '3fdb1b0d3e6bb8114f9c59ed07c12e86', '61b85da718e7e4f4a89fde1af1e239ae'),
(16, '8995de07f10e6c9f6335bd0534d0d83e', '1212-12-12', '00:00:12', '', '', '', 'd41d8cd98f00b204e9800998ecf8427e', '', '', '', 'd41d8cd98f00b204e9800998ecf8427e', 'approved', '3fdb1b0d3e6bb8114f9c59ed07c12e86', '61b85da718e7e4f4a89fde1af1e239ae'),
(17, '8995de07f10e6c9f6335bd0534d0d83e', '1211-12-12', '00:00:14', 'neculai', 'androi', '1910729374220', 'e80812b0ddeddc5ab40fd826599f9902', 'a', 'aa', '1910729374519', 'f24bd0cf942f53a139328dd9ce6b9768', 'done', '3fdb1b0d3e6bb8114f9c59ed07c12e86', '61b85da718e7e4f4a89fde1af1e239ae'),
(18, '8995de07f10e6c9f6335bd0534d0d83e', '1111-11-11', '00:00:14', '', '', '', 'd41d8cd98f00b204e9800998ecf8427e', '', '', '', 'd41d8cd98f00b204e9800998ecf8427e', 'rejected', '3fdb1b0d3e6bb8114f9c59ed07c12e86', '61b85da718e7e4f4a89fde1af1e239ae'),
(19, '8995de07f10e6c9f6335bd0534d0d83e', '1010-10-10', '00:00:14', '', '', '', 'd41d8cd98f00b204e9800998ecf8427e', '', '', '', 'd41d8cd98f00b204e9800998ecf8427e', 'done', '3fdb1b0d3e6bb8114f9c59ed07c12e86', ''),
(20, '8995de07f10e6c9f6335bd0534d0d83e', '1111-11-11', '00:00:12', 'visitor', 'visitor', '2970412526985', '340ddc288e7f2247616b43b416836fa7', '', '', '', 'd41d8cd98f00b204e9800998ecf8427e', 'done', '3fdb1b0d3e6bb8114f9c59ed07c12e86', ''),
(21, '340ddc288e7f2247616b43b416836fa7', '0010-10-10', '00:00:14', 'alex', 'alex', '1910729374220', 'a20779de2241b0ed12e9e2d2ed58e18c', 'andrei', 'andrei', '1910729374519', '0f4662a67b69c2d700d22820729db406', 'done', '3fdb1b0d3e6bb8114f9c59ed07c12e86', ''),
(22, '340ddc288e7f2247616b43b416836fa7', '0011-11-11', '00:00:15', 'visitor2', 'visitor2', '297041252222', '8995de07f10e6c9f6335bd0534d0d83e', '', '', '', 'd41d8cd98f00b204e9800998ecf8427e', 'done', '3fdb1b0d3e6bb8114f9c59ed07c12e86', ''),
(23, '340ddc288e7f2247616b43b416836fa7', '0111-11-11', '00:00:12', 'a', 'a', '1910729374220', '9b8501b3ae721e0fd69b732ba9448033', 'visitor2', 'visitor2', '297041252222', '8995de07f10e6c9f6335bd0534d0d83e', 'approved', '3fdb1b0d3e6bb8114f9c59ed07c12e86', '61b85da718e7e4f4a89fde1af1e239ae'),
(24, '340ddc288e7f2247616b43b416836fa7', '0011-11-11', '00:00:13', 'visitor2', 'visitor2', '297041252222', '8995de07f10e6c9f6335bd0534d0d83e', 'alex', 'eu', '1910729374519', 'bf74ab8d86c2048f148869bb01a0dc5f', 'done', '3fdb1b0d3e6bb8114f9c59ed07c12e86', ''),
(30, '340ddc288e7f2247616b43b416836fa7', '2016-01-11', '00:00:13', '123', '123', '123', '4297f44b13955235245b2497399d7a93', '123', '123', '123', '4297f44b13955235245b2497399d7a93', 'rejected', '3fdb1b0d3e6bb8114f9c59ed07c12e86', '61b85da718e7e4f4a89fde1af1e239ae'),
(29, '340ddc288e7f2247616b43b416836fa7', '2016-01-01', '00:00:13', 'Neculai ', 'ALMARE', '1910729374220', '7b13db0c6d21245bf2cf888b4d6c0339', 'Neculai ', 'ALMIC', '1910729374510', '96271734742a625a77ea2add1d2cc8a7', 'rejected', '3fdb1b0d3e6bb8114f9c59ed07c12e86', '61b85da718e7e4f4a89fde1af1e239ae'),
(27, '340ddc288e7f2247616b43b416836fa7', '2016-06-11', '00:00:12', '', '', '', 'd41d8cd98f00b204e9800998ecf8427e', '', '', '', 'd41d8cd98f00b204e9800998ecf8427e', 'approved', '3fdb1b0d3e6bb8114f9c59ed07c12e86', '61b85da718e7e4f4a89fde1af1e239ae'),
(28, '340ddc288e7f2247616b43b416836fa7', '2016-05-11', '00:00:12', '', '', '', 'd41d8cd98f00b204e9800998ecf8427e', '', '', '', 'd41d8cd98f00b204e9800998ecf8427e', 'rejected', '3fdb1b0d3e6bb8114f9c59ed07c12e86', '61b85da718e7e4f4a89fde1af1e239ae'),
(31, '340ddc288e7f2247616b43b416836fa7', '2016-08-10', '00:00:13', 'neculaies', 'necu', '1910729374220', '3a8b28efa141133cf10ffe10436b27d0', '', '', '', NULL, 'approved', '3fdb1b0d3e6bb8114f9c59ed07c12e86', '61b85da718e7e4f4a89fde1af1e239ae'),
(32, '340ddc288e7f2247616b43b416836fa7', '2016-05-18', '00:00:12', 'Andrei', 'Chelaru', '1910729374220', 'd743069b47060a609a12221398001fee', 'Bogdan', 'Zamfir', '1910729374510', '8441bfa1c3f1ff04c1de42f800af3337', 'rejected', '3fdb1b0d3e6bb8114f9c59ed07c12e86', '61b85da718e7e4f4a89fde1af1e239ae'),
(33, '340ddc288e7f2247616b43b416836fa7', '2016-06-11', '00:00:12', '', '', '', NULL, '', '', '', NULL, 'pending', '3fdb1b0d3e6bb8114f9c59ed07c12e86', NULL),
(34, '340ddc288e7f2247616b43b416836fa7', '2016-05-18', '00:00:12', '', '', '', NULL, '', '', '', NULL, 'rejected', '3fdb1b0d3e6bb8114f9c59ed07c12e86', '61b85da718e7e4f4a89fde1af1e239ae'),
(35, '340ddc288e7f2247616b43b416836fa7', '2016-05-18', '00:00:12', '', '', '', NULL, '', '', '', NULL, 'rejected', '3fdb1b0d3e6bb8114f9c59ed07c12e86', '61b85da718e7e4f4a89fde1af1e239ae'),
(36, '340ddc288e7f2247616b43b416836fa7', '2016-05-12', '00:00:12', '', '', '', NULL, '', '', '', NULL, 'rejected', '3fdb1b0d3e6bb8114f9c59ed07c12e86', '61b85da718e7e4f4a89fde1af1e239ae'),
(37, '340ddc288e7f2247616b43b416836fa7', '2016-05-20', '00:00:15', '', '', '', NULL, '', '', '', NULL, 'approved', '3fdb1b0d3e6bb8114f9c59ed07c12e86', '61b85da718e7e4f4a89fde1af1e239ae'),
(38, '340ddc288e7f2247616b43b416836fa7', '2016-05-18', '12:00:00', 'neculai', 'neculai', '1910729374220', 'd0ccc6d5ea89ebe3e804e2e5c78eae2e', '', '', '', NULL, 'approved', '3fdb1b0d3e6bb8114f9c59ed07c12e86', '61b85da718e7e4f4a89fde1af1e239ae'),
(39, '340ddc288e7f2247616b43b416836fa7', '2016-05-18', '12:00:00', '', '', '', NULL, '', '', '', NULL, 'rejected', '3fdb1b0d3e6bb8114f9c59ed07c12e86', '61b85da718e7e4f4a89fde1af1e239ae'),
(40, '340ddc288e7f2247616b43b416836fa7', '2016-05-18', '13:00:00', '', '', '', NULL, '', '', '', NULL, 'approved', '3fdb1b0d3e6bb8114f9c59ed07c12e86', '61b85da718e7e4f4a89fde1af1e239ae'),
(41, '340ddc288e7f2247616b43b416836fa7', '2016-05-25', '12:00:00', '', '', '', NULL, '', '', '', NULL, 'approved', '3fdb1b0d3e6bb8114f9c59ed07c12e86', '61b85da718e7e4f4a89fde1af1e239ae'),
(42, '8995de07f10e6c9f6335bd0534d0d83e', '2016-05-18', '12:00:00', '', '', '', NULL, '', '', '', NULL, 'rejected', '3fdb1b0d3e6bb8114f9c59ed07c12e86', '61b85da718e7e4f4a89fde1af1e239ae'),
(43, '340ddc288e7f2247616b43b416836fa7', '2016-05-18', '12:00:00', '', '', '', NULL, '', '', '', NULL, 'noshow', '3fdb1b0d3e6bb8114f9c59ed07c12e86', '61b85da718e7e4f4a89fde1af1e239ae'),
(44, '340ddc288e7f2247616b43b416836fa7', '2016-05-24', '13:00:00', '', '', '', NULL, '', '', '', NULL, 'approved', '3fdb1b0d3e6bb8114f9c59ed07c12e86', '61b85da718e7e4f4a89fde1af1e239ae'),
(45, '340ddc288e7f2247616b43b416836fa7', '2016-05-19', '12:00:00', '', '', '', NULL, '', '', '', NULL, 'rejected', '3fdb1b0d3e6bb8114f9c59ed07c12e86', '61b85da718e7e4f4a89fde1af1e239ae'),
(46, '340ddc288e7f2247616b43b416836fa7', '2016-05-18', '14:00:00', '', '', '', NULL, '', '', '', NULL, 'approved', '3fdb1b0d3e6bb8114f9c59ed07c12e86', '61b85da718e7e4f4a89fde1af1e239ae'),
(47, '340ddc288e7f2247616b43b416836fa7', '2016-06-15', '13:00:00', '', '', '', NULL, '', '', '', NULL, 'pending', '655fe6a8474ec0055f4725114ca0c13e', NULL),
(48, '340ddc288e7f2247616b43b416836fa7', '2016-06-16', '12:00:00', '', '', '', NULL, '', '', '', NULL, 'pending', '655fe6a8474ec0055f4725114ca0c13e', NULL),
(49, '340ddc288e7f2247616b43b416836fa7', '2016-06-16', '12:00:00', '', '', '', NULL, '', '', '', NULL, 'pending', '655fe6a8474ec0055f4725114ca0c13e', NULL),
(50, '340ddc288e7f2247616b43b416836fa7', '2016-06-16', '12:00:00', 'BOGDAN', 'olariu', '1910729374220', '3cb757f13bdd803f305cb5a0640d8642', '', '', '', NULL, 'pending', '655fe6a8474ec0055f4725114ca0c13e', NULL),
(51, '340ddc288e7f2247616b43b416836fa7', '2016-06-16', '12:00:00', 'BOGDAN', 'olariu', '1910729374220', '3cb757f13bdd803f305cb5a0640d8642', '', '', '', NULL, 'pending', '655fe6a8474ec0055f4725114ca0c13e', NULL),
(52, '340ddc288e7f2247616b43b416836fa7', '2016-06-16', '16:00:00', 'BOGDAN', 'oLariu', '1910729374220', '7d3912b7d526d327911227b72b23afc3', '', '', '', NULL, 'pending', '655fe6a8474ec0055f4725114ca0c13e', NULL),
(53, '340ddc288e7f2247616b43b416836fa7', '2016-06-16', '16:00:00', 'BOGDAN', 'oLariu', '1910729374220', '7d3912b7d526d327911227b72b23afc3', 'SIEU', 'Care', '1910729374510', 'dac929cec2e90e4041ca1c1c6205b7d9', 'approved', '655fe6a8474ec0055f4725114ca0c13e', NULL),
(54, '340ddc288e7f2247616b43b416836fa7', '2016-06-16', '16:00:00', '', '', '', NULL, '', '', '', NULL, 'approved', '655fe6a8474ec0055f4725114ca0c13e', NULL),
(55, '340ddc288e7f2247616b43b416836fa7', '2016-06-16', '16:00:00', '', '', '', NULL, '', '', '', NULL, 'approved', '655fe6a8474ec0055f4725114ca0c13e', NULL),
(56, '340ddc288e7f2247616b43b416836fa7', '2016-06-16', '16:00:00', 'Test', 'Test', '1910729374220', '9eb14cb385fe872b89bec4190ad1f9c6', '', '', '', NULL, 'approved', '655fe6a8474ec0055f4725114ca0c13e', NULL),
(57, '340ddc288e7f2247616b43b416836fa7', '2016-06-16', '16:00:00', 'Test', 'Test', '1910729374220', '9eb14cb385fe872b89bec4190ad1f9c6', '', '', '', NULL, 'approved', '655fe6a8474ec0055f4725114ca0c13e', NULL),
(58, '340ddc288e7f2247616b43b416836fa7', '2016-08-11', '12:00:00', '', '', '', NULL, '', '', '', NULL, 'approved', '655fe6a8474ec0055f4725114ca0c13e', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bans`
--

DROP TABLE IF EXISTS `bans`;
CREATE TABLE IF NOT EXISTS `bans` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `InmateId` varchar(32) NOT NULL,
  `StartDate` date NOT NULL,
  `EndDate` date NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bans`
--

INSERT INTO `bans` (`Id`, `InmateId`, `StartDate`, `EndDate`) VALUES
(1, '3fdb1b0d3e6bb8114f9c59ed07c12e86', '2016-05-13', '2016-05-12'),
(2, '3fdb1b0d3e6bb8114f9c59ed07c12e86', '2016-05-13', '2016-05-12'),
(3, '3fdb1b0d3e6bb8114f9c59ed07c12e86', '2016-05-13', '2016-05-12'),
(9, '3fdb1b0d3e6bb8114f9c59ed07c12e86', '2016-05-13', '2016-05-12'),
(10, '3fdb1b0d3e6bb8114f9c59ed07c12e86', '2016-05-13', '2016-05-12'),
(11, '3fdb1b0d3e6bb8114f9c59ed07c12e86', '2016-05-13', '2016-05-12'),
(12, '3fdb1b0d3e6bb8114f9c59ed07c12e86', '2016-05-13', '2016-05-12'),
(13, '3fdb1b0d3e6bb8114f9c59ed07c12e86', '2016-05-13', '2016-05-12'),
(14, '3fdb1b0d3e6bb8114f9c59ed07c12e86', '2016-05-13', '2016-08-13'),
(15, '3fdb1b0d3e6bb8114f9c59ed07c12e86', '2016-05-13', '2016-11-13'),
(16, '3fdb1b0d3e6bb8114f9c59ed07c12e86', '2016-05-13', '2017-02-13'),
(17, '3fdb1b0d3e6bb8114f9c59ed07c12e86', '2016-05-13', '2017-05-13'),
(18, '3fdb1b0d3e6bb8114f9c59ed07c12e86', '2016-05-13', '2017-08-13'),
(19, '340ddc288e7f2247616b43b416836fa7', '2016-05-14', '2016-05-15'),
(20, '3fdb1b0d3e6bb8114f9c59ed07c12e26', '2016-05-19', '2016-05-18'),
(21, '655fe6a8474ec0055f4725114ca0c13e', '2016-05-19', '2016-05-18');

-- --------------------------------------------------------

--
-- Table structure for table `inmates`
--

DROP TABLE IF EXISTS `inmates`;
CREATE TABLE IF NOT EXISTS `inmates` (
  `Id` varchar(32) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `CNP` varchar(13) NOT NULL,
  `InstId` int(2) NOT NULL,
  `LawyerId` varchar(32) DEFAULT NULL,
  `DOB` date NOT NULL,
  `Sentence` int(2) NOT NULL,
  `Crime` varchar(100) NOT NULL,
  `IncarcerationDate` date NOT NULL,
  `ReleaseDate` date NOT NULL,
  UNIQUE KEY `Id` (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `inmates`
--

INSERT INTO `inmates` (`Id`, `FirstName`, `LastName`, `CNP`, `InstId`, `LawyerId`, `DOB`, `Sentence`, `Crime`, `IncarcerationDate`, `ReleaseDate`) VALUES
('3fdb1b0d3e6bb8114f9c59ed07c12e86', 'Jane', 'Doe', '2970412526985', 1, '', '1997-04-12', 1, 'reckless driving', '2016-04-17', '2017-04-17'),
('655fe6a8474ec0055f4725114ca0c13e', 'Dexter', 'Morgan', '1710102221234', 1, '8995de07f10e6c9f6335bd0534d0d83e', '1971-02-01', 25, 'murder', '2010-04-01', '2035-04-01'),
('3fdb1b0d3e6bb8114f9c59ed07c12e26', 'Janes', 'Doesss', '2970412527985', 1, '', '1997-04-10', 1, 'reckless driving', '2016-04-17', '2017-04-17');

-- --------------------------------------------------------

--
-- Table structure for table `institutions`
--

DROP TABLE IF EXISTS `institutions`;
CREATE TABLE IF NOT EXISTS `institutions` (
  `Id` int(2) NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NOT NULL,
  `Location` varchar(50) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id` (`Id`),
  UNIQUE KEY `Name` (`Name`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `institutions`
--

INSERT INTO `institutions` (`Id`, `Name`, `Location`) VALUES
(1, 'Iasi', 'Iasi'),
(2, 'Vaslui', 'Vaslui');

-- --------------------------------------------------------

--
-- Table structure for table `pictures`
--

DROP TABLE IF EXISTS `pictures`;
CREATE TABLE IF NOT EXISTS `pictures` (
  `Id` int(5) NOT NULL AUTO_INCREMENT,
  `UserId` varchar(32) NOT NULL,
  `Location` varchar(100) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id` (`Id`),
  UNIQUE KEY `UserId` (`UserId`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pictures`
--

INSERT INTO `pictures` (`Id`, `UserId`, `Location`) VALUES
(11, '8e4a59275483de5647acccd28a2a6f7f', 'uploadimg/8e4a59275483de5647acccd28a2a6f7f'),
(8, '340ddc288e7f2247616b43b416836fa7', 'uploadimg/340ddc288e7f2247616b43b416836fa7'),
(10, 'e1a72fa86ba3255c178a85075b20e5a3', 'uploadimg/e1a72fa86ba3255c178a85075b20e5a3'),
(12, '9014cbf694bc7558dbae3ef61fb9b232', 'uploadimg/9014cbf694bc7558dbae3ef61fb9b232');

-- --------------------------------------------------------

--
-- Table structure for table `remainingvisits`
--

DROP TABLE IF EXISTS `remainingvisits`;
CREATE TABLE IF NOT EXISTS `remainingvisits` (
  `InmateId` varchar(32) NOT NULL,
  `RemainingVisits` int(2) NOT NULL,
  UNIQUE KEY `InmateId` (`InmateId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `remainingvisits`
--

INSERT INTO `remainingvisits` (`InmateId`, `RemainingVisits`) VALUES
('3fdb1b0d3e6bb8114f9c59ed07c12e86', 3),
('655fe6a8474ec0055f4725114ca0c13e', 5),
('3fdb1b0d3e6bb8114f9c59ed07c12e26', 5);

-- --------------------------------------------------------

--
-- Table structure for table `visitors`
--

DROP TABLE IF EXISTS `visitors`;
CREATE TABLE IF NOT EXISTS `visitors` (
  `Id` varchar(32) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `CNP` varchar(13) NOT NULL,
  `UserName` varchar(50) NOT NULL,
  `PwdHash` varchar(32) NOT NULL,
  `Email` varchar(50) NOT NULL,
  UNIQUE KEY `UserName` (`UserName`),
  UNIQUE KEY `Id` (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `visitors`
--

INSERT INTO `visitors` (`Id`, `FirstName`, `LastName`, `CNP`, `UserName`, `PwdHash`, `Email`) VALUES
('340ddc288e7f2247616b43b416836fa7', 'visitor', 'visitor', '1910729374510', 'visitor', '202cb962ac59075b964b07152d234b70', 'exor@yahoo.com'),
('8995de07f10e6c9f6335bd0534d0d83e', 'visitor2', '', '297041252222', 'visitor2', '202cb962ac59075b964b07152d234b70', 'a@a.com'),
('9014cbf694bc7558dbae3ef61fb9b232', 'bbb', 'bbbbb', '1910729374510', 'visitor bb', '202cb962ac59075b964b07152d234b70', 'exo@yahoo.com'),
('8e4a59275483de5647acccd28a2a6f7f', 'visitora', 'aaa', '1910729374510', 'visitor a', '202cb962ac59075b964b07152d234b70', 'exo@yahoo.com');

-- --------------------------------------------------------

--
-- Table structure for table `visits`
--

DROP TABLE IF EXISTS `visits`;
CREATE TABLE IF NOT EXISTS `visits` (
  `Id` int(5) NOT NULL AUTO_INCREMENT,
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
  `GuardId` varchar(32) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id` (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=50 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `visits`
--

INSERT INTO `visits` (`Id`, `AppointmentId`, `SecondVisitor`, `ThirdVisitor`, `GivenObjects`, `ReceivedObjects`, `Relationship`, `Motive`, `Comments`, `Duration`, `InmatePhisicalState`, `InmateEmotionalState`, `GuardId`) VALUES
(11, 6, NULL, NULL, '', '', 'mama', '', '', 0, '1', '1', ''),
(16, 5, '1', NULL, 'Topor', 'Cutit', 'Tata', 'Evadare', 'E ok', 1000, '1', '1', ''),
(21, 14, 'd743069b47060a609a12221398001fee', '8441bfa1c3f1ff04c1de42f800af3337', 'test pentru id ', 'test pentru id', 'prieteni', 'test', 'sa vad daca reusesc', 70, '5', '5', ''),
(20, 13, 'd743069b47060a609a12221398001fee', 'absent', 'Nimic', 'Nimic', 'PRienteni', 'Degeaba', 'Nici macar un comment', 30, '5', '5', ''),
(22, 10, 'ad046e0d2300b73ecb78007966a30872', '2f78a4f190161bbb1672fdcaec789ff7', 'k', 'k', 'ok', 'k', 'kkkk', 60, '3', '3', ''),
(23, 12, 'cdfab39f3f87ffff2c35abe71258c806', 'absent', '', '', '', '', '', 60, '1', '1', ''),
(24, 15, 'absent', '56c968ba413527105d0ab942f3363a9e', '', 'aaaaaa', '', '', '', 60, '2', '2', ''),
(25, 16, NULL, 'absent', '', '', '', '', '', 60, '3', '3', ''),
(26, 16, NULL, 'absent', '', '', '', '', '', 60, '3', '3', ''),
(27, 16, NULL, 'absent', '', '', '', '', '', 60, '3', '3', ''),
(28, 16, 'absent', 'absent', '', '', '', '', '', 60, '3', '3', ''),
(29, 17, 'prezent', 'absent', '', '', 'asdasda', '', '', 60, '3', '3', ''),
(30, 17, 'absent', 'absent', '', '', 'asdasda', '', '', 60, '3', '3', ''),
(31, 18, NULL, 'absent', '', '', '', '', '', 60, '3', '3', ''),
(32, 19, NULL, NULL, '', '', '', '', '', 60, '3', '3', ''),
(33, 20, 'd41d8cd98f00b204e9800998ecf8427e', NULL, 'bbbbbbb', 'bbbbbbbbbbbb', '', '', '', 60, '5', '5', ''),
(49, 8, NULL, NULL, '', '', '', '', '', 60, '3', '3', '61b85da718e7e4f4a89fde1af1e239ae'),
(48, 17, 'e80812b0ddeddc5ab40fd826599f9902', 'f24bd0cf942f53a139328dd9ce6b9768', 'nothing', 'nothing', 'Father', 'sasda', 'asdasda', 60, '3', '3', '61b85da718e7e4f4a89fde1af1e239ae'),
(44, 5, '', NULL, '', '', '', '', '', 60, '3', '3', '61b85da718e7e4f4a89fde1af1e239ae'),
(45, 5, '', NULL, '', '', '', '', '', 60, '3', '3', '61b85da718e7e4f4a89fde1af1e239ae'),
(46, 5, '', NULL, '', '', '', '', '', 60, '3', '3', '61b85da718e7e4f4a89fde1af1e239ae'),
(47, 5, '', NULL, '', '', '', '', '', 60, '3', '3', '61b85da718e7e4f4a89fde1af1e239ae');


--
-- Events
--
DROP EVENT IF EXISTS `remainingvisits_update`;
CREATE EVENT `remainingvisits_update` ON SCHEDULE EVERY 1 MONTH STARTS '2016-04-13 13:11:10' ON COMPLETION NOT PRESERVE ENABLE DO UPDATE `remainingvisits` SET `RemainingVisits`= RemainingVisits + 5;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
