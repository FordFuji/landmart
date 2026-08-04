-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 09, 2021 at 08:48 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.3.20

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
-- Table structure for table `oc_b2b`
--

CREATE TABLE `oc_b2b` (
  `b2b_id` int(11) NOT NULL,
  `b2b_name_surname` varchar(255) NOT NULL,
  `b2b_province` varchar(255) NOT NULL,
  `b2b_business_type` text NOT NULL,
  `b2b_phone` varchar(255) NOT NULL,
  `b2b_email` varchar(255) NOT NULL,
  `b2b_message` text NOT NULL,
  `b2b_datetime_create` datetime NOT NULL,
  `b2b_ip_create` varchar(255) NOT NULL,
  `b2b_datetime_update` datetime NOT NULL,
  `b2b_ip_update` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `oc_b2b`
--
ALTER TABLE `oc_b2b`
  ADD PRIMARY KEY (`b2b_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `oc_b2b`
--
ALTER TABLE `oc_b2b`
  MODIFY `b2b_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
