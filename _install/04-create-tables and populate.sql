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
('037f711223738ca3f83d3b1a63640101', 1, 'super admin', '81dc9bdb52d04dc20036dbd8313ed055', 0);

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
  `Visitor3FirstName` varchar(50) DEFAULT NULL,
  `Visitor3LastName` varchar(50) DEFAULT NULL,
  `Visitor3CNP` varchar(13) DEFAULT NULL,
  `State` varchar(20) NOT NULL,
  `InmateId` varchar(32) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`Id`, `VisitorId`, `DateOfAppointment`, `TimeOfAppointment`, `Visitor2FirstName`, `Visitor2LastName`, `Visitor2CNP`, `Visitor3FirstName`, `Visitor3LastName`, `Visitor3CNP`, `State`, `InmateId`) VALUES
(1, '59915c1693be834a516ee9c440250af0', '2016-04-29', '11:00:00', 'Alex', 'Alex', '12312312312', 'Andrei', 'Andrei', '12312312332', '0', '3fdb1b0d3e6bb8114f9c59ed07c12e86'),
(2, '59915c1693be834a516ee9c440250af0', '2016-04-29', '11:00:00', 'Alex', 'Alex', '12312312312', 'Andrei', 'Andrei', '12312312332', '1', '3fdb1b0d3e6bb8114f9c59ed07c12e86'),
(3, '59915c1693be834a516ee9c440250af0', '2016-04-29', '11:00:00', 'Alex', 'Alex', '12312312312', 'Andrei', 'Andrei', '12312312332', '2', '3fdb1b0d3e6bb8114f9c59ed07c12e86'),
(4, '59915c1693be834a516ee9c440250af0', '2016-04-29', '11:00:00', 'Alex', 'Alex', '12312312312', 'Andrei', 'Andrei', '12312312332', '3', '3fdb1b0d3e6bb8114f9c59ed07c12e86');

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
  `Lawyer` varchar(32) NOT NULL,
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

INSERT INTO `inmates` (`Id`, `FirstName`, `LastName`, `CNP`, `InstId`, `Lawyer`, `DOB`, `Sentence`, `Crime`, `IncarcerationDate`, `ReleaseDate`) VALUES
('3fdb1b0d3e6bb8114f9c59ed07c12e86', 'Jane', 'Doe', '2970412526985', 1, '', '1997-04-12', 1, 'reckless driving', '2016-04-17', '2017-04-17');

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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
('00370cf58ec6bfb7fe13a7169d7ff65c', 'Alexandru', 'Zamfir', '1910729374510', 'alexandru', 'e10adc3949ba59abbe56e057f20f883e', 'alexandru_zamfir_91@yahoo.com'),
('59915c1693be834a516ee9c440250af0', 'alex', 'alex', '1232131231212', 'alex', '81dc9bdb52d04dc20036dbd8313ed055', 'exor@yahoo.com');

-- --------------------------------------------------------

--
-- Table structure for table `visits`
--

DROP TABLE IF EXISTS `visits`;
CREATE TABLE IF NOT EXISTS `visits` (
  `Id` int(5) NOT NULL AUTO_INCREMENT,
  `AppointmentId` int(5) NOT NULL,
  `Done` tinyint(1) NOT NULL,
  `SecondVisitor` tinyint(1) NOT NULL,
  `ThirdVisitor` tinyint(1) NOT NULL,
  `GivenObjects` varchar(100) NOT NULL,
  `ReceivedObjects` varchar(100) NOT NULL,
  `Relationship` varchar(50) NOT NULL,
  `Motive` text NOT NULL,
  `Comments` text NOT NULL,
  `Duration` time NOT NULL,
  `InmatePhisicalState` varchar(100) NOT NULL,
  `InmateEmotionalState` varchar(100) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id` (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `visits`
--

INSERT INTO `visits` (`Id`, `AppointmentId`, `Done`, `SecondVisitor`, `ThirdVisitor`, `GivenObjects`, `ReceivedObjects`, `Relationship`, `Motive`, `Comments`, `Duration`, `InmatePhisicalState`, `InmateEmotionalState`) VALUES
(1, 2, 1, 0, 0, 'Nu a dat nimic', 'Nu a primit nimic', 'Frate', 'Vizita de adio', 'Nu s-a intamplat nimic important', '00:10:10', 'buna', 'buna');
