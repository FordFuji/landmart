-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 24, 2021 at 05:54 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.14

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
-- Table structure for table `fd_warranty`
--

CREATE TABLE `fd_warranty` (
  `warranty_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `warranty_type` varchar(255) NOT NULL,
  `warranty_day` int(11) NOT NULL,
  `warranty_condition` text NOT NULL,
  `warranty_datetime_create` datetime NOT NULL,
  `warranty_ip_create` varchar(255) NOT NULL,
  `warranty_datetime_update` datetime NOT NULL,
  `warranty_ip_update` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fd_warranty`
--
ALTER TABLE `fd_warranty`
  ADD PRIMARY KEY (`warranty_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fd_warranty`
--
ALTER TABLE `fd_warranty`
  MODIFY `warranty_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
