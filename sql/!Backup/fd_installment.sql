-- phpMyAdmin SQL Dump
-- version 4.9.10
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 05 ก.ค. 2022 เมื่อ 03:06 PM
-- เวอร์ชันของเซิร์ฟเวอร์: 10.4.24-MariaDB-log
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
-- Database: `zford_landmart`
--

-- --------------------------------------------------------

--
-- โครงสร้างตาราง `fd_who_installment`
--

CREATE TABLE `fd_who_installment` (
  `who_installment_id` int(11) NOT NULL,
  `who_installment_boolean` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `who_installment_datetime_update` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- dump ตาราง `fd_who_installment`
--

INSERT INTO `fd_who_installment` (`who_installment_id`, `who_installment_boolean`, `who_installment_datetime_update`) VALUES
(1, 'false', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fd_who_installment`
--
ALTER TABLE `fd_who_installment`
  ADD PRIMARY KEY (`who_installment_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fd_who_installment`
--
ALTER TABLE `fd_who_installment`
  MODIFY `who_installment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
