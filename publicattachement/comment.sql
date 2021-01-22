-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 23, 2020 at 07:02 PM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.2.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `marketplacedemo_db1`
--

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `msg` longtext DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`id`, `post_id`, `msg`, `created_by`, `created_at`) VALUES
(7, 10, 'sdafsdfs', 6, '2020-08-23 06:27:27'),
(8, 9, 'sdsfsdf sdfsdf', 6, '2020-08-23 06:27:35'),
(9, 9, 'hrtr', 6, '2020-08-23 06:27:39'),
(10, 9, 'fghdfghf', 6, '2020-08-23 06:37:36'),
(11, 9, 'sdfsdfdsf sdfdsfsd', 6, '2020-08-23 06:38:17'),
(12, 9, 'sdfsdfsd', 6, '2020-08-23 06:38:50'),
(13, 9, 'fdgdfg sdfgdfg', 6, '2020-08-23 06:38:54'),
(14, 8, 'sdfsdf', 6, '2020-08-23 06:39:01'),
(15, 10, 'heelo', 6, '2020-08-23 06:46:16'),
(16, 11, 'nic', 6, '2020-08-23 06:46:22'),
(17, 8, 'nic to meet u', 6, '2020-08-22 19:36:22'),
(18, 10, 'sdfadfasdf', 6, '2020-08-22 20:29:47'),
(19, 10, 'sadfasfdasdf', 6, '2020-08-22 20:30:08'),
(20, 10, 'asdfasdfa', 6, '2020-08-22 20:30:13'),
(21, 9, 'asdfas', 6, '2020-08-22 20:30:19'),
(22, 8, 'asdfasdfas', 6, '2020-08-22 20:30:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
