-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 14, 2017 at 08:26 AM
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
-- Table structure for table `labinfo`
--

CREATE TABLE `labinfo` (
  `lab` varchar(50) CHARACTER SET utf8 NOT NULL,
  `labtitle` varchar(50) CHARACTER SET utf8mb4 NOT NULL,
  `fullscorelab` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `labinfo`
--

INSERT INTO `lab_classinfo` (`chapter_id`, `chapter_name`, `chapter_fullmark`) VALUES
(01, 'การเขียนโปรแกรมภาษาซีเบื้องต้น', 10),
(02, 'การเขียนโปรแกรมเบื้องต้นและคำสั่งแสดงผล', 10),
(03, 'การใช้งานคำสั่ง Input Output และการคำนวณต่างๆ', 10),
(04, 'การเขียนโปรแกรมแบบกำหนดเงื่อนไข', 10),
(05, 'การเขียนโปรแกรมแบบวนซ้ำ', 10),
(06, 'การเขียนโปรแกรมแบบวนซ้ำ และกำหนดเงื่อนไข', 10),
(07, 'ตัวแปรแถวลำดับ', 10),
(08, 'โครงสร้างข้อมูล', 10),
(09, 'ตัวชี้', 10),
(10, 'ฟังก์ชัน', 10),
(11, 'การเขียนโปรแกรมติดต่อกับ Text File', 10);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `labinfo`
--
ALTER TABLE `labinfo`
  ADD PRIMARY KEY (`lab`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
