-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 10, 2016 at 04:21 PM
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
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;

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
(14, '340ddc288e7f2247616b43b416836fa7', '1111-11-11', '00:00:13', 'Andrei', 'Chelaru', '1910729374220', 'd743069b47060a609a12221398001fee', 'Alex', 'Zamfir', '1910729374510', '8441bfa1c3f1ff04c1de42f800af3337', 'pending', '3fdb1b0d3e6bb8114f9c59ed07c12e86', ''),
(15, '340ddc288e7f2247616b43b416836fa7', '1111-11-11', '00:00:12', 'visitor2', 'visitor2', '297041252222', '8995de07f10e6c9f6335bd0534d0d83e', 'a', 'a', '14', '56c968ba413527105d0ab942f3363a9e', 'pending', '3fdb1b0d3e6bb8114f9c59ed07c12e86', ''),
(16, '8995de07f10e6c9f6335bd0534d0d83e', '1212-12-12', '00:00:12', '', '', '', 'd41d8cd98f00b204e9800998ecf8427e', '', '', '', 'd41d8cd98f00b204e9800998ecf8427e', 'pending', '3fdb1b0d3e6bb8114f9c59ed07c12e86', ''),
(17, '8995de07f10e6c9f6335bd0534d0d83e', '1211-12-12', '00:00:14', 'neculai', 'androi', '1910729374220', 'e80812b0ddeddc5ab40fd826599f9902', 'a', 'aa', '1910729374519', 'f24bd0cf942f53a139328dd9ce6b9768', 'done', '3fdb1b0d3e6bb8114f9c59ed07c12e86', '61b85da718e7e4f4a89fde1af1e239ae'),
(18, '8995de07f10e6c9f6335bd0534d0d83e', '1111-11-11', '00:00:14', '', '', '', 'd41d8cd98f00b204e9800998ecf8427e', '', '', '', 'd41d8cd98f00b204e9800998ecf8427e', 'rejected', '3fdb1b0d3e6bb8114f9c59ed07c12e86', '61b85da718e7e4f4a89fde1af1e239ae'),
(19, '8995de07f10e6c9f6335bd0534d0d83e', '1010-10-10', '00:00:14', '', '', '', 'd41d8cd98f00b204e9800998ecf8427e', '', '', '', 'd41d8cd98f00b204e9800998ecf8427e', 'done', '3fdb1b0d3e6bb8114f9c59ed07c12e86', ''),
(20, '8995de07f10e6c9f6335bd0534d0d83e', '1111-11-11', '00:00:12', 'visitor', 'visitor', '2970412526985', '340ddc288e7f2247616b43b416836fa7', '', '', '', 'd41d8cd98f00b204e9800998ecf8427e', 'done', '3fdb1b0d3e6bb8114f9c59ed07c12e86', ''),
(21, '340ddc288e7f2247616b43b416836fa7', '0010-10-10', '00:00:14', 'alex', 'alex', '1910729374220', 'a20779de2241b0ed12e9e2d2ed58e18c', 'andrei', 'andrei', '1910729374519', '0f4662a67b69c2d700d22820729db406', 'done', '3fdb1b0d3e6bb8114f9c59ed07c12e86', ''),
(22, '340ddc288e7f2247616b43b416836fa7', '0011-11-11', '00:00:15', 'visitor2', 'visitor2', '297041252222', '8995de07f10e6c9f6335bd0534d0d83e', '', '', '', 'd41d8cd98f00b204e9800998ecf8427e', 'done', '3fdb1b0d3e6bb8114f9c59ed07c12e86', ''),
(23, '340ddc288e7f2247616b43b416836fa7', '0111-11-11', '00:00:12', 'a', 'a', '1910729374220', '9b8501b3ae721e0fd69b732ba9448033', 'visitor2', 'visitor2', '297041252222', '8995de07f10e6c9f6335bd0534d0d83e', 'approved', '3fdb1b0d3e6bb8114f9c59ed07c12e86', '61b85da718e7e4f4a89fde1af1e239ae'),
(24, '340ddc288e7f2247616b43b416836fa7', '0011-11-11', '00:00:13', 'visitor2', 'visitor2', '297041252222', '8995de07f10e6c9f6335bd0534d0d83e', 'alex', 'eu', '1910729374519', 'bf74ab8d86c2048f148869bb01a0dc5f', 'done', '3fdb1b0d3e6bb8114f9c59ed07c12e86', '');
