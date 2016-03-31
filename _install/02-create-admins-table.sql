
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