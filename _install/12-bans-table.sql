-- phpMyAdmin SQL Dump
-- version 4.5.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 13, 2016 at 08:48 PM
-- Server version: 5.5.49-0ubuntu0.14.04.1
-- PHP Version: 7.0.6-6+donate.sury.org~trusty+1

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
-- Table structure for table `bans`
--

CREATE TABLE `bans` (
  `Id` int(11) NOT NULL,
  `InmateId` varchar(32) NOT NULL,
  `StartDate` date NOT NULL,
  `EndDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(13, '3fdb1b0d3e6bb8114f9c59ed07c12e86', '2016-05-13', '2016-05-20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bans`
--
ALTER TABLE `bans`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bans`
--
ALTER TABLE `bans`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
