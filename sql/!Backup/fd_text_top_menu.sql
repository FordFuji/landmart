-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 28, 2021 at 10:31 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.4.18

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
-- Table structure for table `fd_text_top_menu`
--

CREATE TABLE `fd_text_top_menu` (
  `text_top_menu_id` int(11) NOT NULL,
  `text_top_menu_name` varchar(1000) NOT NULL,
  `text_top_menu_datetime_update` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fd_text_top_menu`
--

INSERT INTO `fd_text_top_menu` (`text_top_menu_id`, `text_top_menu_name`, `text_top_menu_datetime_update`) VALUES
(1, '', '2021-10-28 10:31:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fd_text_top_menu`
--
ALTER TABLE `fd_text_top_menu`
  ADD PRIMARY KEY (`text_top_menu_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fd_text_top_menu`
--
ALTER TABLE `fd_text_top_menu`
  MODIFY `text_top_menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
