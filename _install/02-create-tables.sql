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
  KEY `InstId` (`InstId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

DROP TABLE IF EXISTS `appointments`;
CREATE TABLE IF NOT EXISTS `appointments` (
  `Id` int(5) NOT NULL AUTO_INCREMENT,
  `VisitorId` varchar(32) NOT NULL,
  `Date` date NOT NULL,
  `Time` time NOT NULL,
  `Visitor2FirstName` varchar(50) DEFAULT NULL,
  `Visitor2LastName` varchar(50) DEFAULT NULL,
  `Visitor2CNP` varchar(13) DEFAULT NULL,
  `Visitor3FirstName` varchar(50) DEFAULT NULL,
  `Visitor3LastName` varchar(50) DEFAULT NULL,
  `Visitor3CNP` varchar(13) DEFAULT NULL,
  `State` varchar(20) NOT NULL,
  `InstitutionId` int(2) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `institutions`
--

DROP TABLE IF EXISTS `institutions`;
CREATE TABLE IF NOT EXISTS `institutions` (
  `Id` int(2) NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NOT NULL,
  `Location` varchar(50) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pictures`
--

DROP TABLE IF EXISTS `pictures`;
CREATE TABLE IF NOT EXISTS `pictures` (
  `Id` int(5) NOT NULL AUTO_INCREMENT,
  `UserId` varchar(32) NOT NULL,
  `Location` varchar(100) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `remainingvisits`
--

DROP TABLE IF EXISTS `remainingvisits`;
CREATE TABLE IF NOT EXISTS `remainingvisits` (
  `InmateId` varchar(32) NOT NULL,
  `RemainingVisits` int(2) NOT NULL
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
  `Email` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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
  `RecivedObjects` varchar(100) NOT NULL,
  `Relationship` varchar(50) NOT NULL,
  `Motive` text NOT NULL,
  `Comments` text NOT NULL,
  `Duration` time NOT NULL,
  `InmatePhisicalState` varchar(100) NOT NULL,
  `InmateEmotionalState` varchar(100) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
