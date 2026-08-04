-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 10, 2021 at 08:50 AM
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
-- Table structure for table `oc_member`
--

CREATE TABLE `oc_member` (
  `member_id` int(11) NOT NULL,
  `member_name` varchar(255) NOT NULL,
  `member_email` varchar(255) NOT NULL,
  `member_phone` varchar(255) NOT NULL,
  `member_password` varchar(255) NOT NULL,
  `member_datetime_create` datetime NOT NULL,
  `member_ip_create` varchar(255) NOT NULL,
  `member_datetime_update` datetime NOT NULL,
  `member_ip_update` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `oc_member`
--

INSERT INTO `oc_member` (`member_id`, `member_name`, `member_email`, `member_phone`, `member_password`, `member_datetime_create`, `member_ip_create`, `member_datetime_update`, `member_ip_update`) VALUES
(1, 'Ford Fuji', 'nirvanaford94@gmail.com', '0999999999', 'qwaszx', '2021-03-10 06:23:35', '::1', '2021-03-10 06:23:35', '::1'),
(2, 'สิทธิพร ตรองวิเชียร', 'nirvanaford94@gmail.com', '0999999999', 'qwaszx', '2021-03-10 07:31:00', '::1', '2021-03-10 07:31:00', '::1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `oc_member`
--
ALTER TABLE `oc_member`
  ADD PRIMARY KEY (`member_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `oc_member`
--
ALTER TABLE `oc_member`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
