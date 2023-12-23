-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 12, 2017 at 11:26 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `compro16s2`
--

-- --------------------------------------------------------

--
-- Table structure for table `user_supervisor`
--

CREATE TABLE `user_supervisor` (
  `supervisor_id` int(11) NOT NULL,
  `supervisor_gender` enum('male','female','other') DEFAULT NULL,
  `supervisor_firstname` varchar(50) DEFAULT NULL,
  `supervisor_lastname` varchar(50) DEFAULT NULL,
  `supervisor_nickname` varchar(50) DEFAULT NULL,
  `supervisor_dob` date DEFAULT NULL,
  `supervisor_avatar` varchar(64) DEFAULT NULL,
  `supervisor_email` varchar(64) DEFAULT NULL,
  `supervisor_tel` varchar(12) DEFAULT NULL,
  `supervisor_department` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_supervisor`
--

INSERT INTO `user_supervisor` (`supervisor_id`, `supervisor_gender`, `supervisor_firstname`, `supervisor_lastname`, `supervisor_nickname`, `supervisor_dob`, `supervisor_avatar`, `supervisor_email`, `supervisor_tel`, `supervisor_department`) VALUES
(900001, 'other', '', '', '', '0000-00-00', '', '', '', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user_supervisor`
--
ALTER TABLE `user_supervisor`
  ADD PRIMARY KEY (`supervisor_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
