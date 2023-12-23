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

INSERT INTO `labinfo` (`lab`, `labtitle`, `fullscorelab`) VALUES
('01', 'การเขียนโปรแกรมภาษาซีเบื้องต้น', 1),
('02', 'การเขียนโปรแกรมเบื้องต้นและคำสั่งแสดงผล', 1),
('03', 'การใช้งานคำสั่ง Input Output และการคำนวณต่างๆ', 1),
('04', 'การเขียนโปรแกรมแบบกำหนดเงื่อนไข', 1),
('05', 'การเขียนโปรแกรมแบบวนซ้ำ', 1),
('06', 'การเขียนโปรแกรมแบบวนซ้ำ และกำหนดเงื่อนไข', 1),
('07', 'ตัวแปรแถวลำดับ', 1),
('08', 'โครงสร้างข้อมูล', 1),
('09', 'ตัวชี้', 1),
('10', 'ฟังก์ชัน', 1),
('11', 'การเขียนโปรแกรมติดต่อกับ Text File', 1);

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
