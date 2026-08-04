-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 23, 2021 at 07:30 AM
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
-- Table structure for table `fd_customer_address`
--

CREATE TABLE `fd_customer_address` (
  `customer_address_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `customer_address_name` varchar(255) NOT NULL,
  `customer_address_surname` varchar(255) NOT NULL,
  `customer_address_phone` varchar(255) NOT NULL,
  `customer_address_email` varchar(255) NOT NULL,
  `customer_address_address1` text NOT NULL,
  `customer_address_address2` text NOT NULL,
  `customer_address_postcode` varchar(255) NOT NULL,
  `customer_address_province` int(11) NOT NULL,
  `customer_address_amphur` int(11) NOT NULL,
  `customer_address_tumbol` int(11) NOT NULL,
  `customer_address_invoice_name` varchar(255) NOT NULL,
  `customer_address_invoice_address` text NOT NULL,
  `customer_address_invoice_address2` text NOT NULL,
  `customer_address_invoice_postcode` varchar(255) NOT NULL,
  `customer_address_invoice_province` int(11) NOT NULL,
  `customer_address_invoice_amphur` int(11) NOT NULL,
  `customer_address_invoice_tumbol` int(11) NOT NULL,
  `customer_address_invoice_card_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fd_customer_address`
--
ALTER TABLE `fd_customer_address`
  ADD PRIMARY KEY (`customer_address_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fd_customer_address`
--
ALTER TABLE `fd_customer_address`
  MODIFY `customer_address_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
