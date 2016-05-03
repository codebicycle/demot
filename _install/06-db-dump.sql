-- phpMyAdmin SQL Dump
-- version 4.5.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 03, 2016 at 01:29 PM
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
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
  `Id` varchar(32) NOT NULL,
  `InstId` int(2) NOT NULL,
  `UserName` varchar(50) NOT NULL,
  `PwdHash` varchar(32) NOT NULL,
  `Rank` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`Id`, `InstId`, `UserName`, `PwdHash`, `Rank`) VALUES
('037f711223738ca3f83d3b1a63640101', 1, 'super admin', '202cb962ac59075b964b07152d234b70', 0),
('23bc3abe956f1737b197255bf17d5a9b', 1, 'admin', '202cb962ac59075b964b07152d234b70', 1),
('61b85da718e7e4f4a89fde1af1e239ae', 1, 'guard', '202cb962ac59075b964b07152d234b70', 2);

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

DROP TABLE IF EXISTS `appointments`;
CREATE TABLE `appointments` (
  `Id` int(5) NOT NULL,
  `VisitorId` varchar(32) NOT NULL,
  `DateOfAppointment` date NOT NULL,
  `TimeOfAppointment` time NOT NULL,
  `Visitor2FirstName` varchar(50) DEFAULT NULL,
  `Visitor2LastName` varchar(50) DEFAULT NULL,
  `Visitor2CNP` varchar(13) DEFAULT NULL,
  `Visitor3FirstName` varchar(50) DEFAULT NULL,
  `Visitor3LastName` varchar(50) DEFAULT NULL,
  `Visitor3CNP` varchar(13) DEFAULT NULL,
  `State` varchar(20) NOT NULL,
  `InmateId` varchar(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`Id`, `VisitorId`, `DateOfAppointment`, `TimeOfAppointment`, `Visitor2FirstName`, `Visitor2LastName`, `Visitor2CNP`, `Visitor3FirstName`, `Visitor3LastName`, `Visitor3CNP`, `State`, `InmateId`) VALUES
(1, '59915c1693be834a516ee9c440250af0', '2016-04-29', '11:00:00', 'Alex', 'Alex', '12312312312', 'Andrei', 'Andrei', '12312312332', '0', '3fdb1b0d3e6bb8114f9c59ed07c12e86'),
(2, '59915c1693be834a516ee9c440250af0', '2016-04-29', '11:00:00', 'Alex', 'Alex', '12312312312', 'Andrei', 'Andrei', '12312312332', '0', '3fdb1b0d3e6bb8114f9c59ed07c12e86'),
(3, '59915c1693be834a516ee9c440250af0', '2016-04-29', '11:00:00', 'Alex', 'Alex', '12312312312', 'Andrei', 'Andrei', '12312312332', '2', '3fdb1b0d3e6bb8114f9c59ed07c12e86'),
(4, '59915c1693be834a516ee9c440250af0', '2016-04-29', '11:00:00', 'Alex', 'Alex', '12312312312', 'Andrei', 'Andrei', '12312312332', '3', '3fdb1b0d3e6bb8114f9c59ed07c12e86'),
(5, '340ddc288e7f2247616b43b416836fa7', '2016-05-10', '10:00:00', 'Ion', 'Ion', '1234512345123', '', '', '', '0', '3fdb1b0d3e6bb8114f9c59ed07c12e86'),
(6, '340ddc288e7f2247616b43b416836fa7', '2016-05-11', '10:00:00', 'Ioana', 'Ioana', '2234512345123', '', '', '', '0', '3fdb1b0d3e6bb8114f9c59ed07c12e86'),
(7, '340ddc288e7f2247616b43b416836fa7', '2016-05-12', '10:00:00', 'Paul', 'Paul', '3234512345123', '', '', '', '0', '3fdb1b0d3e6bb8114f9c59ed07c12e86'),
(8, '8995de07f10e6c9f6335bd0534d0d83e', '2016-05-10', '12:00:00', '', '', '', '', '', '', '1', '3fdb1b0d3e6bb8114f9c59ed07c12e86');

-- --------------------------------------------------------

--
-- Table structure for table `inmates`
--

DROP TABLE IF EXISTS `inmates`;
CREATE TABLE `inmates` (
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
  `ReleaseDate` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `inmates`
--

INSERT INTO `inmates` (`Id`, `FirstName`, `LastName`, `CNP`, `InstId`, `LawyerId`, `DOB`, `Sentence`, `Crime`, `IncarcerationDate`, `ReleaseDate`) VALUES
('3fdb1b0d3e6bb8114f9c59ed07c12e86', 'Jane', 'Doe', '2970412526985', 1, '', '1997-04-12', 1, 'reckless driving', '2016-04-17', '2017-04-17'),
('655fe6a8474ec0055f4725114ca0c13e', 'Dexter', 'Morgan', '1710102221234', 1, NULL, '1971-02-01', 25, 'murder', '2010-04-01', '2035-04-01');

-- --------------------------------------------------------

--
-- Table structure for table `institutions`
--

DROP TABLE IF EXISTS `institutions`;
CREATE TABLE `institutions` (
  `Id` int(2) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Location` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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
CREATE TABLE `pictures` (
  `Id` int(5) NOT NULL,
  `UserId` varchar(32) NOT NULL,
  `Location` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pictures`
--

INSERT INTO `pictures` (`Id`, `UserId`, `Location`) VALUES
(2, '340ddc288e7f2247616b43b416836fa7', 'uploadimg/2016-05-03.08.47.07Dexter-dexters-laboratory.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `remainingvisits`
--

DROP TABLE IF EXISTS `remainingvisits`;
CREATE TABLE `remainingvisits` (
  `InmateId` varchar(32) NOT NULL,
  `RemainingVisits` int(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `visitors`
--

DROP TABLE IF EXISTS `visitors`;
CREATE TABLE `visitors` (
  `Id` varchar(32) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `CNP` varchar(13) NOT NULL,
  `UserName` varchar(50) NOT NULL,
  `PwdHash` varchar(32) NOT NULL,
  `Email` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `visitors`
--

INSERT INTO `visitors` (`Id`, `FirstName`, `LastName`, `CNP`, `UserName`, `PwdHash`, `Email`) VALUES
('340ddc288e7f2247616b43b416836fa7', 'visitor', 'visitor', '2970412526985', 'visitor', '202cb962ac59075b964b07152d234b70', 'a@a.com'),
('8995de07f10e6c9f6335bd0534d0d83e', 'visitor2', 'visitor2', '297041252222', 'visitor2', '202cb962ac59075b964b07152d234b70', 'a@a.com');

-- --------------------------------------------------------

--
-- Table structure for table `visits`
--

DROP TABLE IF EXISTS `visits`;
CREATE TABLE `visits` (
  `Id` int(5) NOT NULL,
  `AppointmentId` int(5) NOT NULL,
  `Done` tinyint(1) NOT NULL,
  `SecondVisitor` tinyint(1) DEFAULT NULL,
  `ThirdVisitor` tinyint(1) DEFAULT NULL,
  `GivenObjects` varchar(100) NOT NULL,
  `ReceivedObjects` varchar(100) NOT NULL,
  `Relationship` varchar(50) NOT NULL,
  `Motive` text NOT NULL,
  `Comments` text NOT NULL,
  `Duration` time NOT NULL,
  `InmatePhisicalState` varchar(100) NOT NULL,
  `InmateEmotionalState` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `UserName` (`UserName`),
  ADD KEY `InstId` (`InstId`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `inmates`
--
ALTER TABLE `inmates`
  ADD UNIQUE KEY `Id` (`Id`);

--
-- Indexes for table `institutions`
--
ALTER TABLE `institutions`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Id` (`Id`),
  ADD UNIQUE KEY `Name` (`Name`);

--
-- Indexes for table `pictures`
--
ALTER TABLE `pictures`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Id` (`Id`),
  ADD UNIQUE KEY `UserId` (`UserId`);

--
-- Indexes for table `remainingvisits`
--
ALTER TABLE `remainingvisits`
  ADD UNIQUE KEY `InmateId` (`InmateId`);

--
-- Indexes for table `visitors`
--
ALTER TABLE `visitors`
  ADD UNIQUE KEY `UserName` (`UserName`),
  ADD UNIQUE KEY `Id` (`Id`);

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
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `Id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `institutions`
--
ALTER TABLE `institutions`
  MODIFY `Id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `pictures`
--
ALTER TABLE `pictures`
  MODIFY `Id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `visits`
--
ALTER TABLE `visits`
  MODIFY `Id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
