-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 07, 2025 at 03:52 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `AptEase`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblaccounts`
--

CREATE TABLE `tblaccounts` (
  `username` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `usertype` varchar(20) NOT NULL,
  `createdby` varchar(30) NOT NULL,
  `datecreated` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblaccounts`
--

INSERT INTO `tblaccounts` (`username`, `password`, `usertype`, `createdby`, `datecreated`) VALUES
('tryadmin', 'tryadmin', 'ADMIN', 'ADMIN', '22/02/25');

-- --------------------------------------------------------

--
-- Table structure for table `tbltenants`
--

CREATE TABLE `tbltenants` (
  `apartmentID` varchar(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `downpayment` varchar(15) NOT NULL,
  `contactNo` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblaccounts`
--
ALTER TABLE `tblaccounts`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `tbltenants`
--
ALTER TABLE `tbltenants`
  ADD PRIMARY KEY (`apartmentID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
