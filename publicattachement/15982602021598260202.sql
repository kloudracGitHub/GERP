-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 23, 2020 at 07:08 PM
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
-- Table structure for table `chat_box`
--

CREATE TABLE `chat_box` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `reciever_id` int(11) DEFAULT NULL,
  `msg` varchar(255) DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `time` time DEFAULT NULL,
  `day` varchar(50) DEFAULT NULL,
  `view` int(11) NOT NULL DEFAULT 0 COMMENT '1 =>seen, 0 => unseen',
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `chat_box`
--

INSERT INTO `chat_box` (`id`, `sender_id`, `reciever_id`, `msg`, `attachment`, `time`, `day`, `view`, `created_at`) VALUES
(47, 6, 13, 'sdfsd', '', '12:41:23', 'Sun', 1, '2020-08-23 07:11:23'),
(48, 6, 1, 'dfghdfgfdg', '', '12:42:23', 'Sun', 0, '2020-08-23 07:12:23'),
(49, 13, 6, 'ghjgj', '', '12:57:23', 'Sun', 1, '2020-08-23 07:27:23'),
(50, 6, 1, 'hiiwerw  how asd', '', '12:58:23', 'Sun', 0, '2020-08-23 07:28:23'),
(51, 13, 6, 'please check now', '', '01:03:23', 'Sun', 1, '2020-08-22 19:33:23'),
(52, 13, 6, 'you shoud fabouls', '', '01:03:23', 'Sun', 1, '2020-08-22 19:33:23'),
(53, 6, 13, 'dsfgsdf', '', '01:05:23', 'Sun', 1, '2020-08-22 19:35:23'),
(54, 13, 6, NULL, 'http://localhost/multivendor/public/uploads/attach/files/1598188185.csv', '01:09:23', 'Sun', 1, '2020-08-22 19:39:23'),
(55, 13, 6, NULL, 'http://localhost/multivendor/public/uploads/attach/files/1598188697.png', '01:18:23', 'Sun', 1, '2020-08-22 19:48:23'),
(56, 13, 6, NULL, 'http://localhost/multivendor/public/uploads/attach/files/1598188734.jpeg', '01:18:23', 'Sun', 1, '2020-08-22 19:48:23'),
(57, 13, 6, NULL, 'http://localhost/multivendor/public/uploads/attach/files/1598188796.png', '01:19:23', 'Sun', 1, '2020-08-22 19:49:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chat_box`
--
ALTER TABLE `chat_box`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chat_box`
--
ALTER TABLE `chat_box`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
