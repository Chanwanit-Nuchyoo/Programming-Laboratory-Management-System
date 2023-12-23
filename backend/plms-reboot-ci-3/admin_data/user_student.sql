-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 12, 2017 at 11:28 AM
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
-- Table structure for table `user_student`
--

CREATE TABLE `user_student` (
  `stu_id` varchar(8) NOT NULL,
  `stu_gender` enum('male','female','other') DEFAULT NULL,
  `stu_firstname` varchar(40) DEFAULT NULL,
  `stu_lastname` varchar(32) DEFAULT NULL,
  `stu_nickname` varchar(20) DEFAULT NULL,
  `stu_dob` date DEFAULT NULL,
  `stu_avatar` varchar(128) DEFAULT NULL,
  `stu_email` varchar(64) DEFAULT NULL,
  `stu_tel` varchar(12) DEFAULT NULL,
  `stu_department` varchar(40) DEFAULT NULL,
  `stu_group` int(2) DEFAULT NULL,
  `note` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_student`
--

INSERT INTO `user_student` (`stu_id`, `stu_gender`, `stu_firstname`, `stu_lastname`, `stu_nickname`, `stu_dob`, `stu_avatar`, `stu_email`, `stu_tel`, `stu_department`, `stu_group`, `note`) VALUES
('11051105', 'female', 'มุทิตา', 'อุเบกขา', 'สวดมนต์', '0000-00-00', 'image_11051105_58764385bd163.jpg', '', '', '', 0, ''),
('59112233', 'male', 'โรเบิร์ต', 'ไอซ์เสกต', 'แดงดำ', '1996-08-11', 'image_59112233_58763f15924a0.jpg', '123456@gmail.com', '0839037933', 'วิศวกรรมคอมพิวเตอร์', 19, ''),
('76037603', 'other', 'a', '', '', '0000-00-00', '', '', '', '', 0, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user_student`
--
ALTER TABLE `user_student`
  ADD PRIMARY KEY (`stu_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
