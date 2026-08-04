-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 23, 2021 at 04:25 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `landmart`
--

-- --------------------------------------------------------

--
-- Table structure for table `fd_bank_account`
--

CREATE TABLE `fd_bank_account` (
  `bank_account_id` int(11) NOT NULL,
  `bank_account_image` varchar(255) NOT NULL,
  `bank_account_company_name_th` varchar(255) NOT NULL,
  `bank_account_company_name_en` varchar(255) NOT NULL,
  `bank_account_account` varchar(255) NOT NULL,
  `bank_account_branch` varchar(255) NOT NULL,
  `bank_account_datetime_create` datetime NOT NULL,
  `bank_account_datetime_update` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fd_bank_account`
--

INSERT INTO `fd_bank_account` (`bank_account_id`, `bank_account_image`, `bank_account_company_name_th`, `bank_account_company_name_en`, `bank_account_account`, `bank_account_branch`, `bank_account_datetime_create`, `bank_account_datetime_update`) VALUES
(1, '', '', '', '', '', '2021-09-23 04:25:01', '2021-09-23 04:25:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fd_bank_account`
--
ALTER TABLE `fd_bank_account`
  ADD PRIMARY KEY (`bank_account_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fd_bank_account`
--
ALTER TABLE `fd_bank_account`
  MODIFY `bank_account_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
