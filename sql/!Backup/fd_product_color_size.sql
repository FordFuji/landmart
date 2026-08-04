-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 06, 2021 at 08:35 AM
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
-- Table structure for table `fd_product_color_size`
--

CREATE TABLE `fd_product_color_size` (
  `product_color_size_id` int(11) NOT NULL,
  `product_color_size_name` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_color_size_image` varchar(255) NOT NULL,
  `product_color_size_datetime_create` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fd_product_color_size`
--

INSERT INTO `fd_product_color_size` (`product_color_size_id`, `product_color_size_name`, `product_id`, `product_color_size_image`, `product_color_size_datetime_create`) VALUES
(9, 'สีแดง/ขนาดเล็ก', 59, '', '2021-05-04 08:00:27'),
(10, 'สีขาว/ขนาดมาตรฐาน', 59, '', '2021-05-04 08:00:27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fd_product_color_size`
--
ALTER TABLE `fd_product_color_size`
  ADD PRIMARY KEY (`product_color_size_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fd_product_color_size`
--
ALTER TABLE `fd_product_color_size`
  MODIFY `product_color_size_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
