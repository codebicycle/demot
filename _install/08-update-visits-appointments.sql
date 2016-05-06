
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
  `InstId` int(2) NOT NULL,
  `UserName` varchar(50) NOT NULL,
  `PwdHash` varchar(32) NOT NULL,
  `Rank` int(1) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `UserName` (`UserName`),
  KEY `InstId` (`InstId`)
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
CREATE TABLE IF NOT EXISTS `appointments` (
  `Id` int(5) NOT NULL AUTO_INCREMENT,
  `VisitorId` varchar(32) NOT NULL,
  `DateOfAppointment` date NOT NULL,
  `TimeOfAppointment` time NOT NULL,
  `Visitor2FirstName` varchar(50) DEFAULT NULL,
  `Visitor2LastName` varchar(50) DEFAULT NULL,
  `Visitor2CNP` varchar(13) DEFAULT NULL,
  `Visitor2Id` varchar(32) NOT NULL,
  `Visitor3FirstName` varchar(50) DEFAULT NULL,
  `Visitor3LastName` varchar(50) DEFAULT NULL,
  `Visitor3CNP` varchar(13) DEFAULT NULL,
  `Visitor3Id` varchar(32) NOT NULL,
  `State` varchar(20) NOT NULL,
  `InmateId` varchar(32) NOT NULL,
  `GuardId` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`Id`, `VisitorId`, `DateOfAppointment`, `TimeOfAppointment`, `Visitor2FirstName`, `Visitor2LastName`, `Visitor2CNP`, `Visitor2Id`, `Visitor3FirstName`, `Visitor3LastName`, `Visitor3CNP`, `Visitor3Id`, `State`, `InmateId`, `GuardId`) VALUES
(1, '8995de07f10e6c9f6335bd0534d0d83e', '2016-04-29', '11:00:00', 'Alex', 'Alex', '12312312312', '', 'Andrei', 'Andrei', '12312312332', '', 'noshow', '3fdb1b0d3e6bb8114f9c59ed07c12e86', ''),
(2, '8995de07f10e6c9f6335bd0534d0d83e', '2016-04-29', '11:00:00', 'Alex', 'Alex', '12312312312', '', 'Andrei', 'Andrei', '12312312332', '340ddc288e7f2247616b43b416836fa7', 'done', '3fdb1b0d3e6bb8114f9c59ed07c12e86', ''),
(3, '8995de07f10e6c9f6335bd0534d0d83e', '2016-04-29', '11:00:00', 'Alex', 'Alex', '12312312312', '340ddc288e7f2247616b43b416836fa7', 'Andrei', 'Andrei', '12312312332', '', 'noshow', '3fdb1b0d3e6bb8114f9c59ed07c12e86', ''),
(4, '8995de07f10e6c9f6335bd0534d0d83e', '2016-04-29', '11:00:00', 'Alex', 'Alex', '12312312312', '340ddc288e7f2247616b43b416836fa7', 'Andrei', 'Andrei', '12312312332', '', 'rejected', '3fdb1b0d3e6bb8114f9c59ed07c12e86', '');

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
CREATE TABLE IF NOT EXISTS `institutions` (
  `Id` int(2) NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NOT NULL,
  `Location` varchar(50) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id` (`Id`),
  UNIQUE KEY `Name` (`Name`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

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
CREATE TABLE IF NOT EXISTS `remainingvisits` (
  `InmateId` varchar(32) NOT NULL,
  `RemainingVisits` int(2) NOT NULL,
  UNIQUE KEY `InmateId` (`InmateId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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
CREATE TABLE IF NOT EXISTS `visits` (
  `Id` int(5) NOT NULL AUTO_INCREMENT,
  `AppointmentId` int(5) NOT NULL,
  `Done` tinyint(1) NOT NULL,
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
) ENGINE=MyISAM AUTO_INCREMENT=48 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `visits`
--

INSERT INTO `visits` (`Id`, `AppointmentId`, `Done`, `SecondVisitor`, `ThirdVisitor`, `GivenObjects`, `ReceivedObjects`, `Relationship`, `Motive`, `Comments`, `Duration`, `InmatePhisicalState`, `InmateEmotionalState`, `GuardId`) VALUES
(16, 5, 1, '1', NULL, 'Topor', 'Cutit', 'Tata', 'Evadare', 'E ok', 1000, '1', '1', ''),
(21, 14, 1, 'd743069b47060a609a12221398001fee', '8441bfa1c3f1ff04c1de42f800af3337', 'test pentru id ', 'test pentru id', 'prieteni', 'test', 'sa vad daca reusesc', 70, '5', '5', ''),
(20, 13, 1, 'd743069b47060a609a12221398001fee', 'absent', 'Nimic', 'Nimic', 'PRienteni', 'Degeaba', 'Nici macar un comment', 30, '5', '5', ''),
(22, 10, 1, 'ad046e0d2300b73ecb78007966a30872', '2f78a4f190161bbb1672fdcaec789ff7', 'k', 'k', 'ok', 'k', 'kkkk', 60, '3', '3', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
