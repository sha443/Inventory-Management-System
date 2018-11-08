-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 23, 2017 at 01:07 AM
-- Server version: 5.6.38
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kazimobi_kmh`
--

-- --------------------------------------------------------

--
-- Table structure for table `bankdeposite`
--

CREATE TABLE `bankdeposite` (
  `id` int(11) NOT NULL,
  `tokenNo` varchar(30) NOT NULL,
  `bankName` varchar(60) NOT NULL,
  `netAmount` float NOT NULL,
  `date` date NOT NULL,
  `seId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bankdeposite`
--

INSERT INTO `bankdeposite` (`id`, `tokenNo`, `bankName`, `netAmount`, `date`, `seId`) VALUES
(1, '13133', 'SIBL', 30000, '2017-12-22', 2),
(2, '13132', 'SIBL', 5000, '2017-12-22', 3),
(3, '32321', 'SIBL', 53574, '2017-12-22', 1);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(4, 'Device'),
(1, 'Flexi Load'),
(5, 'Mobi Cash'),
(3, 'SIM Card'),
(2, 'Scratch Card');

-- --------------------------------------------------------

--
-- Table structure for table `closinginventory`
--

CREATE TABLE `closinginventory` (
  `id` int(11) NOT NULL,
  `subCategoryId` int(11) NOT NULL,
  `explanation` varchar(200) NOT NULL,
  `pcs` int(11) NOT NULL,
  `unitPrice` float NOT NULL,
  `netAmount` float NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `closinginventory`
--

INSERT INTO `closinginventory` (`id`, `subCategoryId`, `explanation`, `pcs`, `unitPrice`, `netAmount`, `date`) VALUES
(10, 1, 'Corn Job', 540000, 0.9625, 519750, '2017-12-22'),
(19, 2, 'Corn Job', 100000, 1, 100000, '2017-12-22'),
(1, 5, 'Corn Job', 4200, 9.643, 40500.6, '2017-12-22'),
(6, 6, 'Corn Job', 4200, 19.286, 81001.2, '2017-12-22'),
(7, 7, 'Corn Job', 0, 48.215, 0, '2017-12-22'),
(5, 9, 'Corn Job', 4200, 18.3217, 76951.1, '2017-12-22'),
(13, 11, 'Corn Job', 0, 119, 0, '2017-12-22'),
(12, 12, 'Corn Job', 40, 83, 3320, '2017-12-22'),
(20, 14, 'Corn Job', 0, 2410, 0, '2017-12-22'),
(23, 15, 'Corn Job', 0, 5460, 0, '2017-12-22'),
(26, 16, 'Corn Job', 0, 4212, 0, '2017-12-22'),
(16, 17, 'Corn Job', 0, 3960, 0, '2017-12-22'),
(24, 18, 'Corn Job', 0, 5020, 0, '2017-12-22'),
(3, 19, 'Corn Job', 4200, 9.643, 40500.6, '2017-12-22'),
(2, 20, 'Corn Job', 4200, 9.643, 40500.6, '2017-12-22'),
(4, 21, 'Corn Job', 0, 18.3217, 0, '2017-12-22'),
(14, 22, 'Corn Job', 0, 83, 0, '2017-12-22'),
(21, 23, 'Corn Job', 140, 94.7, 13258, '2017-12-22'),
(9, 24, 'Corn Job', 0, 337, 0, '2017-12-22'),
(11, 25, 'Corn Job', 9, 1341, 12069, '2017-12-22'),
(18, 26, 'Corn Job', 7, 3970, 27790, '2017-12-22'),
(15, 27, 'Corn Job', 0, 2874, 0, '2017-12-22'),
(22, 28, 'Corn Job', 10, 2708, 27080, '2017-12-22'),
(8, 29, 'Corn Job', 0, 83, 0, '2017-12-22'),
(25, 30, 'Corn Job', 0, 4970, 0, '2017-12-22'),
(17, 31, 'Corn Job', 0, 2730, 0, '2017-12-22');

-- --------------------------------------------------------

--
-- Table structure for table `closingvault`
--

CREATE TABLE `closingvault` (
  `id` int(11) NOT NULL,
  `netAmount` float NOT NULL,
  `date` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `closingvault`
--

INSERT INTO `closingvault` (`id`, `netAmount`, `date`) VALUES
(1, 100000, '2017-12-22');

-- --------------------------------------------------------

--
-- Table structure for table `expensecategory`
--

CREATE TABLE `expensecategory` (
  `id` int(11) NOT NULL,
  `name` varchar(60) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `expensecategory`
--

INSERT INTO `expensecategory` (`id`, `name`) VALUES
(1, 'Convence'),
(8, 'Electricity Bill'),
(2, 'Fuel'),
(7, 'House Rent'),
(13, 'Inner House Salary'),
(4, 'Mobil Change'),
(11, 'Motorcycle Rep'),
(3, 'Others'),
(6, 'SC Discount'),
(12, 'Salary'),
(10, 'Stationary'),
(14, 'Water Bill');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` int(11) NOT NULL,
  `explanation` varchar(200) DEFAULT NULL,
  `amount` float NOT NULL,
  `date` date NOT NULL,
  `expenseCategoryId` int(11) NOT NULL,
  `seId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `explanation`, `amount`, `date`, `expenseCategoryId`, `seId`) VALUES
(1, '', 500, '2017-12-22', 1, 2),
(2, '', 500, '2017-12-22', 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `flag`
--

CREATE TABLE `flag` (
  `id` int(11) NOT NULL,
  `submit` tinyint(2) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `incentive`
--

CREATE TABLE `incentive` (
  `id` int(11) NOT NULL,
  `explanation` text NOT NULL,
  `netAmount` float NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `subCategoryId` int(11) NOT NULL,
  `explanation` varchar(200) NOT NULL,
  `pcs` int(11) NOT NULL,
  `unitPrice` float NOT NULL,
  `netAmount` float NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `subCategoryId`, `explanation`, `pcs`, `unitPrice`, `netAmount`, `date`) VALUES
(1, 1, '', 500000, 0.9625, 481250, '2017-12-22'),
(2, 26, '', 10, 3970, 39700, '2017-12-22'),
(3, 28, '', 10, 2708, 27080, '2017-12-22'),
(4, 25, '', 10, 1341, 13410, '2017-12-22'),
(5, 2, '', 100000, 1, 100000, '2017-12-22'),
(6, 12, '', 100, 83, 8300, '2017-12-22'),
(7, 23, '', 200, 94.7, 18940, '2017-12-22'),
(8, 5, '', 5000, 9.643, 48215, '2017-12-22'),
(9, 6, '', 5000, 19.286, 96430, '2017-12-22'),
(10, 9, '', 5000, 18.3217, 91608.5, '2017-12-22'),
(11, 19, '', 5000, 9.643, 48215, '2017-12-22'),
(12, 20, '', 5000, 9.643, 48215, '2017-12-22'),
(13, 1, '', 100000, 0.9625, 96250, '2017-12-22');

-- --------------------------------------------------------

--
-- Table structure for table `mfs`
--

CREATE TABLE `mfs` (
  `id` int(11) NOT NULL,
  `subCategoryId` int(11) NOT NULL,
  `explanation` varchar(200) DEFAULT NULL,
  `pcs` int(11) NOT NULL,
  `unitPrice` float NOT NULL,
  `netAmount` float NOT NULL,
  `seId` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mfs`
--

INSERT INTO `mfs` (`id`, `subCategoryId`, `explanation`, `pcs`, `unitPrice`, `netAmount`, `seId`, `date`) VALUES
(1, 1, '', 50000, 0.9725, 48625, 2, '2017-12-22'),
(2, 2, '', 20000, 1, 20000, 2, '2017-12-22'),
(3, 12, '', 30, 92, 2760, 2, '2017-12-22'),
(4, 23, '', 30, 96.5, 2895, 2, '2017-12-22'),
(5, 5, '', 500, 9.74, 4870, 2, '2017-12-22'),
(6, 6, '', 500, 19.48, 9740, 2, '2017-12-22'),
(7, 9, '', 500, 18.5, 9250, 2, '2017-12-22'),
(8, 19, '', 500, 9.74, 4870, 2, '2017-12-22'),
(9, 20, '', 500, 9.74, 4870, 2, '2017-12-22'),
(10, 26, '', 2, 4050, 8100, 2, '2017-12-22'),
(11, 26, '', 2, 4050, 8100, 3, '2017-12-22'),
(12, 1, '', 50000, 0.9725, 48625, 3, '2017-12-22'),
(13, 2, '', 20000, 1, 20000, 3, '2017-12-22'),
(14, 12, '', 30, 92, 2760, 3, '2017-12-22'),
(15, 23, '', 30, 96.5, 2895, 3, '2017-12-22'),
(16, 5, '', 500, 9.74, 4870, 3, '2017-12-22'),
(17, 6, '', 500, 19.48, 9740, 3, '2017-12-22'),
(18, 9, '', 500, 18.5, 9250, 3, '2017-12-22'),
(19, 19, '', 500, 9.74, 4870, 3, '2017-12-22'),
(20, 20, '', 500, 9.74, 4870, 3, '2017-12-22'),
(21, 25, '', 1, 1359, 1359, 3, '2017-12-22');

-- --------------------------------------------------------

--
-- Table structure for table `profit`
--

CREATE TABLE `profit` (
  `id` int(11) NOT NULL,
  `buy` float NOT NULL,
  `sale` float NOT NULL,
  `subCategoryId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `profit`
--

INSERT INTO `profit` (`id`, `buy`, `sale`, `subCategoryId`) VALUES
(1, 9.643, 9.74, 5),
(2, 9.643, 9.74, 20),
(3, 9.643, 9.74, 19),
(4, 18.3217, 18.5, 21),
(5, 18.3217, 18.5, 9),
(6, 19.286, 19.48, 6),
(7, 48.215, 48.7, 7),
(8, 83, 92, 12),
(9, 0.9625, 0.9725, 1),
(10, 94.7, 96.5, 23),
(12, 83, 92, 29),
(14, 337, 337, 24),
(15, 1341, 1359, 25),
(17, 119, 119, 11),
(18, 83, 92, 22),
(19, 2874, 2910, 27),
(20, 3960, 4050, 17),
(21, 3970, 4050, 26),
(22, 2410, 2450, 14),
(24, 2708, 2742, 28),
(25, 5460, 5500, 15),
(26, 5020, 5050, 18),
(27, 4212, 4250, 16),
(28, 1, 1, 2),
(29, 4970, 5090, 30),
(30, 2730, 2785, 31);

-- --------------------------------------------------------

--
-- Table structure for table `remarks`
--

CREATE TABLE `remarks` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `text` text NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `returns`
--

CREATE TABLE `returns` (
  `id` int(11) NOT NULL,
  `subCategoryId` int(11) NOT NULL,
  `explanation` varchar(200) NOT NULL,
  `pcs` int(11) NOT NULL,
  `unitPrice` float NOT NULL,
  `netAmount` float NOT NULL,
  `seId` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `returns`
--

INSERT INTO `returns` (`id`, `subCategoryId`, `explanation`, `pcs`, `unitPrice`, `netAmount`, `seId`, `date`) VALUES
(1, 2, '', 30000, 1, 30000, 2, '2017-12-22'),
(2, 2, '', 10000, 1, 10000, 3, '2017-12-22'),
(3, 1, '', 20000, 0.9625, 19250, 2, '2017-12-22'),
(4, 26, '', 1, 3970, 3970, 2, '2017-12-22'),
(5, 5, '', 200, 9.643, 1928.6, 2, '2017-12-22'),
(6, 6, '', 200, 19.286, 3857.2, 2, '2017-12-22'),
(7, 9, '', 200, 18.3217, 3664.34, 2, '2017-12-22'),
(8, 19, '', 200, 9.643, 1928.6, 2, '2017-12-22'),
(9, 20, '', 200, 9.643, 1928.6, 2, '2017-12-22'),
(10, 1, '', 20000, 0.9625, 19250, 3, '2017-12-22');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `subCategoryId` int(11) NOT NULL,
  `explanation` varchar(200) NOT NULL,
  `pcs` int(11) NOT NULL DEFAULT '0',
  `unitPrice` float NOT NULL DEFAULT '0',
  `netAmount` float NOT NULL,
  `seId` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `subCategoryId`, `explanation`, `pcs`, `unitPrice`, `netAmount`, `seId`, `date`) VALUES
(1, 1, '', 30000, 0.9725, 29175, 2, '2017-12-22'),
(2, 26, '', 1, 4050, 4050, 2, '2017-12-22'),
(3, 2, '', 20000, 1, 20000, 2, '2017-12-22'),
(4, 12, '', 30, 92, 2760, 2, '2017-12-22'),
(5, 23, '', 30, 96.5, 2895, 2, '2017-12-22'),
(6, 5, '', 300, 9.74, 2922, 2, '2017-12-22'),
(7, 6, '', 300, 19.48, 5844, 2, '2017-12-22'),
(8, 9, '', 300, 18.5, 5550, 2, '2017-12-22'),
(9, 19, '', 300, 9.74, 2922, 2, '2017-12-22'),
(10, 20, '', 300, 9.74, 2922, 2, '2017-12-22'),
(11, 1, '', 30000, 0.9725, 29175, 3, '2017-12-22'),
(12, 25, '', 1, 1359, 1359, 3, '2017-12-22'),
(13, 2, '', 20000, 1, 20000, 3, '2017-12-22');

-- --------------------------------------------------------

--
-- Table structure for table `salesexecutive`
--

CREATE TABLE `salesexecutive` (
  `id` int(11) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `phoneNo` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `address` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `salesexecutive`
--

INSERT INTO `salesexecutive` (`id`, `name`, `phoneNo`, `address`) VALUES
(1, 'Rasel', '0123456789', 'Dumuria'),
(2, 'Yeasin', '1234567890', 'Dumuria'),
(3, 'A. Salam', '1234567890', 'Dumuria'),
(4, 'Lovelu', '1234567890', 'Dumuria'),
(5, 'Karimul', '1234567890', 'Dumuria'),
(6, 'Babla', '1234567890', 'Dumuria'),
(7, 'Barun', '1234567890', 'Dumuria'),
(8, 'Jibon', '1234567890', 'Dumuria'),
(9, 'Nahid', '1234567890', 'Dumuria'),
(10, 'Shohug', '1234567890', 'Dumuria');

-- --------------------------------------------------------

--
-- Table structure for table `subcategory`
--

CREATE TABLE `subcategory` (
  `id` int(11) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `categoryId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subcategory`
--

INSERT INTO `subcategory` (`id`, `name`, `categoryId`) VALUES
(5, '10TK', 2),
(20, '10TK Internet', 2),
(19, '10TK Voice', 2),
(21, '19TK', 2),
(9, '19TK Internet', 2),
(6, '20TK', 2),
(7, '50TK', 2),
(29, 'EKota Prepaid', 3),
(24, 'Explore', 3),
(1, 'Flexi Load', 1),
(25, 'GP 3G Modem Z-710', 4),
(12, 'GP Prepaid', 3),
(11, 'Internet SIM Postpaid', 3),
(22, 'Internet SIM Prepaid', 3),
(27, 'Itel 1409', 4),
(17, 'Lava Iris 605', 4),
(31, 'Lava Irish 505', 4),
(26, 'Micromax Q354', 4),
(2, 'Mobi Cash', 5),
(14, 'Okapia Alo', 4),
(23, 'R Kit 2', 3),
(28, 'Symphony G20', 4),
(15, 'Symphony i20', 4),
(18, 'Symphony v100', 4),
(30, 'Symphony v110', 4),
(16, 'Symphony v49', 4);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `userName` varchar(30) NOT NULL,
  `password` varchar(300) NOT NULL,
  `role` varchar(30) NOT NULL DEFAULT 'User'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `userName`, `password`, `role`) VALUES
(1, 'shahid', '', 'Admin'),
(3, 'Admin', '', 'Admin'),
(4, 'Accountant', '', 'User');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bankdeposite`
--
ALTER TABLE `bankdeposite`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seId` (`seId`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `closinginventory`
--
ALTER TABLE `closinginventory`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subCategoryId_2` (`subCategoryId`,`explanation`,`pcs`,`unitPrice`,`netAmount`,`date`),
  ADD KEY `subCategoryId` (`subCategoryId`);

--
-- Indexes for table `closingvault`
--
ALTER TABLE `closingvault`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expensecategory`
--
ALTER TABLE `expensecategory`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `accountId` (`expenseCategoryId`),
  ADD KEY `seId` (`seId`);

--
-- Indexes for table `flag`
--
ALTER TABLE `flag`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `date` (`date`);

--
-- Indexes for table `incentive`
--
ALTER TABLE `incentive`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subCategoryId` (`subCategoryId`);

--
-- Indexes for table `mfs`
--
ALTER TABLE `mfs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seId` (`seId`),
  ADD KEY `subCategoryId` (`subCategoryId`);

--
-- Indexes for table `profit`
--
ALTER TABLE `profit`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subCategoryId_2` (`subCategoryId`),
  ADD KEY `subCategoryId` (`subCategoryId`);

--
-- Indexes for table `remarks`
--
ALTER TABLE `remarks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `returns`
--
ALTER TABLE `returns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subCategoryId` (`subCategoryId`),
  ADD KEY `seId` (`seId`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subCategoryId` (`subCategoryId`),
  ADD KEY `seId` (`seId`);

--
-- Indexes for table `salesexecutive`
--
ALTER TABLE `salesexecutive`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subcategory`
--
ALTER TABLE `subcategory`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `name_2` (`name`,`categoryId`),
  ADD KEY `categoryId` (`categoryId`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `userName` (`userName`,`password`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bankdeposite`
--
ALTER TABLE `bankdeposite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `closinginventory`
--
ALTER TABLE `closinginventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `closingvault`
--
ALTER TABLE `closingvault`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `expensecategory`
--
ALTER TABLE `expensecategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `flag`
--
ALTER TABLE `flag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `incentive`
--
ALTER TABLE `incentive`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `mfs`
--
ALTER TABLE `mfs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `profit`
--
ALTER TABLE `profit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `remarks`
--
ALTER TABLE `remarks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `returns`
--
ALTER TABLE `returns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `salesexecutive`
--
ALTER TABLE `salesexecutive`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `subcategory`
--
ALTER TABLE `subcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `bankdeposite`
--
ALTER TABLE `bankdeposite`
  ADD CONSTRAINT `bankdeposite_ibfk_1` FOREIGN KEY (`seId`) REFERENCES `salesexecutive` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `closinginventory`
--
ALTER TABLE `closinginventory`
  ADD CONSTRAINT `closinginventory_ibfk_1` FOREIGN KEY (`subCategoryId`) REFERENCES `subcategory` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expenses_ibfk_1` FOREIGN KEY (`expenseCategoryId`) REFERENCES `expensecategory` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `expenses_ibfk_2` FOREIGN KEY (`seId`) REFERENCES `salesexecutive` (`id`);

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`subCategoryId`) REFERENCES `subcategory` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mfs`
--
ALTER TABLE `mfs`
  ADD CONSTRAINT `mfs_ibfk_1` FOREIGN KEY (`subCategoryId`) REFERENCES `subcategory` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mfs_ibfk_2` FOREIGN KEY (`seId`) REFERENCES `salesexecutive` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `profit`
--
ALTER TABLE `profit`
  ADD CONSTRAINT `profit_ibfk_1` FOREIGN KEY (`subCategoryId`) REFERENCES `subcategory` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `remarks`
--
ALTER TABLE `remarks`
  ADD CONSTRAINT `remarks_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `returns`
--
ALTER TABLE `returns`
  ADD CONSTRAINT `returns_ibfk_1` FOREIGN KEY (`subCategoryId`) REFERENCES `subcategory` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `returns_ibfk_2` FOREIGN KEY (`seId`) REFERENCES `salesexecutive` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`subCategoryId`) REFERENCES `subcategory` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sales_ibfk_2` FOREIGN KEY (`seId`) REFERENCES `salesexecutive` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `subcategory`
--
ALTER TABLE `subcategory`
  ADD CONSTRAINT `subcategory_ibfk_1` FOREIGN KEY (`categoryId`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
