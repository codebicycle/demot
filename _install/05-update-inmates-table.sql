--
-- Database: `demot`
--

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

--
-- Indexes for dumped tables
--

--
-- Indexes for table `inmates`
--
ALTER TABLE `inmates`
  ADD UNIQUE KEY `Id` (`Id`);
