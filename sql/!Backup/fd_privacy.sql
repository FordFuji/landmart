-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 26 เม.ย. 2022 เมื่อ 03:00 PM
-- เวอร์ชันของเซิร์ฟเวอร์: 5.6.33-log
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `landmartco_new`
--

-- --------------------------------------------------------

--
-- โครงสร้างตาราง `fd_privacy`
--

CREATE TABLE `fd_privacy` (
  `privacy_id` int(11) NOT NULL,
  `privacy_detail` longtext NOT NULL,
  `privacy_datetime_update` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- dump ตาราง `fd_privacy`
--

INSERT INTO `fd_privacy` (`privacy_id`, `privacy_detail`, `privacy_datetime_update`) VALUES
(1, '', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fd_privacy`
--
ALTER TABLE `fd_privacy`
  ADD PRIMARY KEY (`privacy_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fd_privacy`
--
ALTER TABLE `fd_privacy`
  MODIFY `privacy_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
