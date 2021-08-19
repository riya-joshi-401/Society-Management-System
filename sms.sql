-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 25, 2021 at 07:29 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sms`
--

-- --------------------------------------------------------

--
-- Table structure for table `additional_charges`
--

CREATE TABLE `additional_charges` (
  `ChargeID` int(11) NOT NULL,
  `FlatID` bigint(20) NOT NULL,
  `Amount` int(11) NOT NULL,
  `Reason` varchar(500) NOT NULL,
  `Bill_month` varchar(100) NOT NULL,
  `Updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `Updated_by` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `AdminID` bigint(20) NOT NULL,
  `Username` varchar(100) NOT NULL,
  `Name` text NOT NULL,
  `Password` varchar(150) NOT NULL,
  `ContactNumber` bigint(10) NOT NULL,
  `EmailID` varchar(100) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`AdminID`, `Username`, `Name`, `Password`, `ContactNumber`, `EmailID`, `updated_at`) VALUES
(1, 'Admin1', 'Purvi Harniya', '382e0360e4eb7b70034fbaa69bec5786', 9999999999, 'purvi.h@somaiya.edu', '2021-04-23 08:42:52'),
(2, 'Admin2', 'admin surname', 'e10adc3949ba59abbe56e057f20f883e', 9999999998, 'abcd@gmail.com', '2021-04-14 09:38:08');

-- --------------------------------------------------------

--
-- Table structure for table `allotments`
--

CREATE TABLE `allotments` (
  `AllotmentID` bigint(20) NOT NULL,
  `FlatID` bigint(20) NOT NULL,
  `FlatNumber` varchar(20) NOT NULL,
  `BlockNumber` varchar(50) NOT NULL,
  `OwnerName` varchar(500) NOT NULL,
  `OwnerEmail` varchar(100) NOT NULL,
  `OwnerContactNumber` bigint(10) NOT NULL,
  `OwnerAlternateContactNumber` bigint(10) NOT NULL,
  `OwnerMemberCount` bigint(20) NOT NULL,
  `isRent` tinyint(1) NOT NULL,
  `RenteeName` varchar(500) DEFAULT NULL,
  `RenteeEmail` varchar(100) DEFAULT NULL,
  `RenteeContactNumber` bigint(10) DEFAULT NULL,
  `RenteeAlternateContactNumber` bigint(10) DEFAULT NULL,
  `RenteeMemberCount` bigint(20) DEFAULT NULL,
  `updated_by` varchar(50) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `allotments`
--

INSERT INTO `allotments` (`AllotmentID`, `FlatID`, `FlatNumber`, `BlockNumber`, `OwnerName`, `OwnerEmail`, `OwnerContactNumber`, `OwnerAlternateContactNumber`, `OwnerMemberCount`, `isRent`, `RenteeName`, `RenteeEmail`, `RenteeContactNumber`, `RenteeAlternateContactNumber`, `RenteeMemberCount`, `updated_by`, `updated_at`) VALUES
(1, 13, '401', 'A', 'Riya', 'riya.joshi@somaiya.edu', 9999999999, 9999999999, 3, 1, '', 'abcd@gmail.com', 9999999999, 9999999999, 4, 'Admin1', '2021-04-14 13:06:50'),
(15, 76, '103', 'D', 'abcd', 'purvi.harniya@gmail.com', 9999999999, 9999999999, 4, 0, '-', '-', 0, 0, 0, 'Admin1', '2021-04-23 12:21:35'),
(16, 77, '104', 'D', 'efgh', 'purvi.harniya@gmail.com', 9999999999, 9999999999, 3, 0, '-', '-', 0, 0, 0, 'Admin1', '2021-04-23 12:21:35'),
(17, 78, '201', 'D', 'ijkl', 'riya.joshi@somaiya.edu', 9999999999, 9999999999, 5, 1, 'Riya', 'riya.joshi@somaiya.edu', 9999999999, 9999999999, 5, 'Admin1', '2021-04-23 12:21:35'),
(18, 79, '202', 'D', 'mnop', 'esha.gupta@somaiya.edu', 9999999999, 9999999999, 4, 1, 'Esha', 'esha.gupta@somaiya.edu', 9999999999, 9999999999, 7, 'Admin1', '2021-04-23 12:21:35'),
(19, 80, '203', 'D', 'qrst', 'jill25@somaiya.edu', 9999999999, 9999999999, 3, 0, '-', '-', 0, 0, 0, 'Admin1', '2021-04-23 12:21:35');

-- --------------------------------------------------------

--
-- Table structure for table `bills_paid`
--

CREATE TABLE `bills_paid` (
  `BillID` bigint(20) NOT NULL,
  `BillQueueID` bigint(20) NOT NULL,
  `FlatID` bigint(20) NOT NULL,
  `BillAmount` double NOT NULL,
  `Status` int(11) NOT NULL,
  `Receipt` blob NOT NULL,
  `ReceiptName` varchar(100) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `bill_queue`
--

CREATE TABLE `bill_queue` (
  `bill_id` bigint(20) NOT NULL,
  `FlatID` bigint(20) NOT NULL,
  `to_email` varchar(100) NOT NULL,
  `bill_month` varchar(255) NOT NULL,
  `maintenance_charges` bigint(15) NOT NULL,
  `additional_charges` int(11) NOT NULL,
  `total_charges` int(11) NOT NULL,
  `bill_gen_date` date NOT NULL,
  `bill_due_date` date NOT NULL,
  `charges_after_due` bigint(15) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `filemime` varchar(255) NOT NULL,
  `data` blob NOT NULL,
  `is_sent` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `RequestID` bigint(20) NOT NULL,
  `ComplaintType` varchar(50) NOT NULL,
  `Description` varchar(1000) NOT NULL,
  `BlockNumber` varchar(10) NOT NULL,
  `FlatNumber` int(11) NOT NULL,
  `ContactNumber` bigint(10) NOT NULL,
  `RaisedDate` date NOT NULL,
  `AdminRemark` varchar(50) NOT NULL,
  `Status` varchar(50) NOT NULL,
  `ResolvedDate` date NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `complaints`
--

INSERT INTO `complaints` (`RequestID`, `ComplaintType`, `Description`, `BlockNumber`, `FlatNumber`, `ContactNumber`, `RaisedDate`, `AdminRemark`, `Status`, `ResolvedDate`, `updated_at`) VALUES
(12, '5', 'Some complaint description', 'A', 101, 9029996333, '2021-03-23', 'action has being taken', '0', '2021-04-16', '2021-04-16 14:52:02'),
(13, '11', 'This year, on republic day we should plan for an event which all can participate in.', 'A', 802, 9029996333, '2021-03-23', 'event has been planned', '2', '2021-04-16', '2021-04-16 14:50:40'),
(16, '2', 'Electric board has stopped working', 'A', 802, 9029996333, '2021-03-24', 'Remark', '2', '2021-04-23', '2021-04-23 12:26:02'),
(17, '13', 'Problem description', 'A', 802, 9029996333, '2021-04-06', 'Problem solved\r\n', '2', '2021-04-16', '2021-04-16 14:52:27'),
(21, '6', 'Some Complaint description. Some Complaint description. Some Complaint description. ', 'A', 101, 9029996333, '2021-04-03', 'Remark', '1', '0000-00-00', '2021-04-23 12:25:45'),
(22, '8', 'Some Complaint description. Some Complaint description. Some Complaint description. ', 'A', 101, 9029996333, '2021-04-04', 'some remark', '1', '0000-00-00', '2021-04-19 03:22:35'),
(23, '4', 'Complaint description', 'A', 101, 7506062123, '2021-04-23', 'No remark', '0', '0000-00-00', '2021-04-23 12:35:49');

-- --------------------------------------------------------

--
-- Table structure for table `complainttypes`
--

CREATE TABLE `complainttypes` (
  `complaint_id` int(11) NOT NULL,
  `complaint_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `complainttypes`
--

INSERT INTO `complainttypes` (`complaint_id`, `complaint_type`) VALUES
(1, 'Carpenter'),
(2, 'Electrical'),
(3, 'Plumbing'),
(4, 'Common Area'),
(5, 'Security'),
(6, 'Lift'),
(7, 'Sports & Recreational'),
(8, 'Parking'),
(9, 'Fire'),
(10, 'Billing & Payment'),
(11, 'Events'),
(12, 'Landscaping'),
(13, 'Other');

-- --------------------------------------------------------

--
-- Table structure for table `flatarea`
--

CREATE TABLE `flatarea` (
  `FlatAreaID` bigint(20) NOT NULL,
  `BlockNumber` varchar(20) NOT NULL,
  `FlatSeries` bigint(20) NOT NULL,
  `FlatArea` bigint(20) NOT NULL,
  `FlatType` varchar(10) NOT NULL,
  `Ratepsq` double NOT NULL,
  `Updatedby` varchar(20) NOT NULL,
  `UpdatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `flatarea`
--

INSERT INTO `flatarea` (`FlatAreaID`, `BlockNumber`, `FlatSeries`, `FlatArea`, `FlatType`, `Ratepsq`, `Updatedby`, `UpdatedAt`) VALUES
(135, 'A', 1, 35, '1BHK', 45, 'Admin1', '2021-04-23 15:34:46'),
(136, 'A', 2, 342, '2BHK', 432, 'Admin1', '2021-04-23 15:34:58'),
(139, 'B', 2, 234, '1BHK', 3, 'Admin1', '2021-04-23 15:35:53');

-- --------------------------------------------------------

--
-- Table structure for table `flats`
--

CREATE TABLE `flats` (
  `FlatID` bigint(20) NOT NULL,
  `FlatNumber` bigint(20) NOT NULL,
  `BlockNumber` varchar(20) NOT NULL,
  `Floor` bigint(20) NOT NULL,
  `FlatAreaID` bigint(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `flats`
--

INSERT INTO `flats` (`FlatID`, `FlatNumber`, `BlockNumber`, `Floor`, `FlatAreaID`, `created_at`, `updated_at`) VALUES
(83, 101, 'A', 1, 135, '2021-04-23 15:37:26', '2021-04-23 15:37:26');

-- --------------------------------------------------------

--
-- Table structure for table `security`
--

CREATE TABLE `security` (
  `SecurityID` bigint(20) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `ContactNumber` bigint(10) NOT NULL,
  `Shift` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `security`
--

INSERT INTO `security` (`SecurityID`, `Name`, `ContactNumber`, `Shift`, `created_at`, `updated_at`) VALUES
(1, 'Ramesh K', 9920835460, 'Afternoon', '2021-04-14 12:13:40', '2021-04-23 12:32:23'),
(2, 'Name Surname', 9920835460, 'Evening', '2021-04-23 12:31:47', '2021-04-23 12:31:47'),
(3, 'Security 1', 7898767898, 'Evening', '2021-04-23 12:32:01', '2021-04-23 12:32:01'),
(4, 'Rakesh Kumarr', 9029996333, 'Morning', '2021-04-14 12:11:26', '2021-04-23 11:17:40');

-- --------------------------------------------------------

--
-- Table structure for table `securitylogin`
--

CREATE TABLE `securitylogin` (
  `SecID` bigint(20) NOT NULL,
  `SecurityID` bigint(20) NOT NULL,
  `Username` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `securitylogin`
--

INSERT INTO `securitylogin` (`SecID`, `SecurityID`, `Username`, `Password`, `updated_at`) VALUES
(1, 4, 'rk', '382e0360e4eb7b70034fbaa69bec5786', '2021-04-09 21:33:02'),
(2, 1, 'ramesh', '5f4dcc3b5aa765d61d8327deb882cf99', '2021-04-18 16:51:29');

-- --------------------------------------------------------

--
-- Table structure for table `shoutbox`
--

CREATE TABLE `shoutbox` (
  `ShoutBoxID` bigint(20) NOT NULL,
  `Admin` varchar(50) NOT NULL,
  `FlatID` varchar(20) NOT NULL,
  `Chat` varchar(10000) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `shoutbox`
--

INSERT INTO `shoutbox` (`ShoutBoxID`, `Admin`, `FlatID`, `Chat`, `created_at`) VALUES
(15, 'Admin1', '', 'Hello everyone, welcome to the dashboard of our society! From today this shoutbox will be used to report any situations and alerts, so please keep checking it regularly!', '2021-03-27 07:17:24'),
(26, 'Admin2', '', 'Meeting at 7pm, Venue: Google meet, Link will be shared later', '2021-04-16 09:16:58'),
(30, 'Admin1', '', 'Random message', '2021-04-23 07:00:40');

-- --------------------------------------------------------

--
-- Table structure for table `visitors`
--

CREATE TABLE `visitors` (
  `VisitorID` bigint(20) NOT NULL,
  `FlatID` bigint(20) NOT NULL,
  `VisitorName` varchar(100) NOT NULL,
  `VisitorContactNo` bigint(10) NOT NULL,
  `AlternateVisitorContactNo` bigint(20) NOT NULL,
  `BlockNumber` varchar(50) NOT NULL,
  `FlatNumber` bigint(20) NOT NULL,
  `NoOfPeople` int(11) NOT NULL,
  `WhomToMeet` varchar(100) NOT NULL,
  `ReasonToMeet` varchar(1000) NOT NULL,
  `OTP` bigint(20) NOT NULL,
  `StartDate` date NOT NULL,
  `Duration` bigint(20) NOT NULL,
  `updated_by` varchar(50) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `additional_charges`
--
ALTER TABLE `additional_charges`
  ADD PRIMARY KEY (`ChargeID`),
  ADD UNIQUE KEY `Added_by` (`ChargeID`),
  ADD KEY `additional_charges_ibfk_1` (`FlatID`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`AdminID`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD UNIQUE KEY `ContactNumber` (`ContactNumber`);

--
-- Indexes for table `allotments`
--
ALTER TABLE `allotments`
  ADD PRIMARY KEY (`AllotmentID`),
  ADD UNIQUE KEY `FlatNumber` (`FlatNumber`,`BlockNumber`,`isRent`),
  ADD KEY `FOREIGN` (`FlatID`);

--
-- Indexes for table `bills_paid`
--
ALTER TABLE `bills_paid`
  ADD PRIMARY KEY (`BillID`),
  ADD KEY `FOREIGN` (`FlatID`),
  ADD KEY `BillQueueID` (`BillQueueID`);

--
-- Indexes for table `bill_queue`
--
ALTER TABLE `bill_queue`
  ADD PRIMARY KEY (`bill_id`),
  ADD KEY `FlatID` (`FlatID`);

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`RequestID`);

--
-- Indexes for table `complainttypes`
--
ALTER TABLE `complainttypes`
  ADD PRIMARY KEY (`complaint_id`);

--
-- Indexes for table `flatarea`
--
ALTER TABLE `flatarea`
  ADD PRIMARY KEY (`FlatAreaID`),
  ADD UNIQUE KEY `BlockNumber` (`BlockNumber`,`FlatSeries`);

--
-- Indexes for table `flats`
--
ALTER TABLE `flats`
  ADD PRIMARY KEY (`FlatID`),
  ADD UNIQUE KEY `FlatNumber` (`FlatNumber`,`BlockNumber`),
  ADD KEY `FlatAreaID` (`FlatAreaID`);

--
-- Indexes for table `security`
--
ALTER TABLE `security`
  ADD PRIMARY KEY (`SecurityID`),
  ADD UNIQUE KEY `Name` (`Name`,`ContactNumber`);

--
-- Indexes for table `securitylogin`
--
ALTER TABLE `securitylogin`
  ADD PRIMARY KEY (`SecID`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD UNIQUE KEY `SecurityID` (`SecurityID`),
  ADD KEY `FOREIGN` (`SecurityID`);

--
-- Indexes for table `shoutbox`
--
ALTER TABLE `shoutbox`
  ADD PRIMARY KEY (`ShoutBoxID`),
  ADD KEY `FOREIGN` (`FlatID`);

--
-- Indexes for table `visitors`
--
ALTER TABLE `visitors`
  ADD PRIMARY KEY (`VisitorID`),
  ADD KEY `FOREIGN` (`FlatID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `additional_charges`
--
ALTER TABLE `additional_charges`
  MODIFY `ChargeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=239;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `AdminID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `allotments`
--
ALTER TABLE `allotments`
  MODIFY `AllotmentID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `bills_paid`
--
ALTER TABLE `bills_paid`
  MODIFY `BillID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `bill_queue`
--
ALTER TABLE `bill_queue`
  MODIFY `bill_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=254;

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `RequestID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `complainttypes`
--
ALTER TABLE `complainttypes`
  MODIFY `complaint_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `flatarea`
--
ALTER TABLE `flatarea`
  MODIFY `FlatAreaID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;

--
-- AUTO_INCREMENT for table `flats`
--
ALTER TABLE `flats`
  MODIFY `FlatID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `security`
--
ALTER TABLE `security`
  MODIFY `SecurityID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123457;

--
-- AUTO_INCREMENT for table `securitylogin`
--
ALTER TABLE `securitylogin`
  MODIFY `SecID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `shoutbox`
--
ALTER TABLE `shoutbox`
  MODIFY `ShoutBoxID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `visitors`
--
ALTER TABLE `visitors`
  MODIFY `VisitorID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `additional_charges`
--
ALTER TABLE `additional_charges`
  ADD CONSTRAINT `additional_charges_ibfk_1` FOREIGN KEY (`FlatID`) REFERENCES `flats` (`FlatID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `bills_paid`
--
ALTER TABLE `bills_paid`
  ADD CONSTRAINT `bills_paid_ibfk_1` FOREIGN KEY (`BillQueueID`) REFERENCES `bill_queue` (`bill_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bills_paid_ibfk_2` FOREIGN KEY (`FlatID`) REFERENCES `bill_queue` (`FlatID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `bill_queue`
--
ALTER TABLE `bill_queue`
  ADD CONSTRAINT `bill_queue_ibfk_1` FOREIGN KEY (`FlatID`) REFERENCES `flats` (`FlatID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `flats`
--
ALTER TABLE `flats`
  ADD CONSTRAINT `flats_ibfk_1` FOREIGN KEY (`FlatAreaID`) REFERENCES `flatarea` (`FlatAreaID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
