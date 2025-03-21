-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 20, 2025 at 09:27 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aptease`
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
('HartTenant', '123', 'TENANT', 'admin', '03/19/2025'),
('trylandlord', 'trylandlord', 'LANDLORD', 'admin', '03/12/2025'),
('trytenant', 'trytenant', 'TENANT', 'admin', '03/12/2025');

-- --------------------------------------------------------

--
-- Table structure for table `tbllogs`
--

CREATE TABLE `tbllogs` (
  `datelog` varchar(20) NOT NULL,
  `timelog` varchar(20) NOT NULL,
  `action` varchar(20) NOT NULL,
  `module` varchar(20) NOT NULL,
  `ID` varchar(50) NOT NULL,
  `performedby` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbllogs`
--

INSERT INTO `tbllogs` (`datelog`, `timelog`, `action`, `module`, `ID`, `performedby`) VALUES
('03/18/2025', '12:59:12', 'Delete', 'Accounts Management', 'asd', 'trylandlord'),
('03/18/2025', '12:59:18', 'Delete', 'Accounts Management', 'asdaa', 'trylandlord'),
('03/18/2025', '01:10:13', 'Update', 'Accounts Management', 'asdaasd', 'trylandlord'),
('03/18/2025', '01:11:49', 'Update', 'Accounts Management', 'asdaasd', 'trylandlord'),
('03/19/2025', '07:52:19', 'Update', 'Accounts Management', 'asdaasd', 'trylandlord'),
('03/19/2025', '07:52:34', 'Delete', 'Accounts Management', 'asdaasd', 'trylandlord'),
('20/03/2025', '03:00:20pm', 'Create', 'Accounts Management', 'aaaaaaaaaaa', 'trylandlord'),
('03/20/2025', '03:23:26', 'Update', 'Accounts Management', 'aaaaaaaaaaa', 'trylandlord'),
('03/20/2025', '03:23:31', 'Delete', 'Accounts Management', 'aaaaaaaaaaa', 'trylandlord'),
('20/03/2025', '04:22:14pm', 'Create', 'Tenants Management', '', 'trylandlord');

-- --------------------------------------------------------

--
-- Table structure for table `tblmaintenance`
--

CREATE TABLE `tblmaintenance` (
  `ticketID` varchar(50) NOT NULL,
  `description` varchar(200) NOT NULL,
  `dateSubmitted` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblpayments`
--

CREATE TABLE `tblpayments` (
  `amount` varchar(30) NOT NULL,
  `date` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbltenants`
--

CREATE TABLE `tbltenants` (
  `apartmentNo` varchar(10) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `middlename` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `contactNo` varchar(40) NOT NULL,
  `downpayment` varchar(20) NOT NULL,
  `addedby` varchar(30) NOT NULL,
  `dateadded` varchar(39) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbltenants`
--

INSERT INTO `tbltenants` (`apartmentNo`, `firstname`, `middlename`, `lastname`, `contactNo`, `downpayment`, `addedby`, `dateadded`) VALUES
('0001', 'Amos', 'Amos', 'Amos', '0999999999', 'YES', 'trylandlord', '03/20/2025'),
('123', 'asd', 'asd', 'asd', 'asd', 'YES', 'trylandlord', '03/20/2025');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblaccounts`
--
ALTER TABLE `tblaccounts`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `tblmaintenance`
--
ALTER TABLE `tblmaintenance`
  ADD PRIMARY KEY (`ticketID`);

--
-- Indexes for table `tbltenants`
--
ALTER TABLE `tbltenants`
  ADD PRIMARY KEY (`apartmentNo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
