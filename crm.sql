-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 17, 2025 at 05:15 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `crm`
--

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `cid` varchar(100) NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `address` varchar(200) NOT NULL,
  `email` varchar(50) NOT NULL,
  `key_person` varchar(50) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `pin` int(10) NOT NULL,
  `product` varchar(100) NOT NULL,
  `variant` varchar(100) NOT NULL,
  `p_key` varchar(100) NOT NULL,
  `l_key` varchar(100) NOT NULL,
  `time` varchar(50) NOT NULL,
  `update_ctime` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`cid`, `company_name`, `city`, `country`, `mobile`, `address`, `email`, `key_person`, `phone`, `pin`, `product`, `variant`, `p_key`, `l_key`, `time`, `update_ctime`) VALUES
('CL2025080112353168932ff33ca32', 'Gainmax', 'Ahmedabad', 'Russia', '9658741230', 'Canada', 'henil3458@gmail.com', 'Henil Shah', '9685741231', 382443, 'E-Bike', 'XUV', 'abc123', '121212', '2025-08-06 11:49:32', '2025-08-12 11:30:40'),
('CL20250806120108689327e4f15a0', 'Taj Pharma', 'Ahmedabad', 'US', '2147483647', 'Devbhumi soc', 'pitrodanayan23@gmail.com', 'Nayan Pitroda', '', 380050, 'Sultan Tablet 5500mg', 'Extra Time', 'nay4472', '4472', '2025-08-06 12:01:08', '2025-08-12 11:24:37'),
('CL2025080612353168932ff33ca32', 'Ambrita', 'Ahmedabad', 'India', '2147483647', 'Isanpur', 'yash@gmail.com', 'Yash Khalas', '2147483647', 382443, 'SP-125', 'Sport', '2324', '3222', '2025-08-06 12:35:31', '2025-08-06 12:35:31'),
('CL202508111229526899c6206d578', 'English Sikkho', 'Rajkot', 'India', '9632541785', 'Bhulabhai Maninagar', 'hanuman@123gmail.com', 'Hardik Chauhan', '9856471230', 380022, 'Adivasi Hair Oil', 'Extra Oily', '043222', '0404', '2025-08-11 12:29:52', '2025-08-12 11:49:03');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `pass` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `pass`) VALUES
(1, 'admin', 'admin123@gmail.com', 'admin123'),
(2, 'mihir183', 'mihir183@gmail.com', '183'),
(3, 'demo', 'demo@gmail.com', '123'),
(6, 'UDP', 'udpproject96@gmail.com', '$2y$10$QRjm/B7jqFlMmZyOu8rpbO4RB4hqb2g9gHV9LKPpN1qqJ/w6E8Mjy');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
