-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 15, 2017 at 08:26 PM
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
-- Table structure for table `group_assigned_chapter_item`
--

CREATE TABLE `group_assigned_chapter_item` (
  `group_id` int(11) NOT NULL,
  `chapter_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `exercise_id_list` varchar(1024) DEFAULT NULL,
  `full_mark` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='เก็บข้อมูล ของกลุ่ม';

--
-- Dumping data for table `group_assigned_chapter_item`
--

INSERT INTO `group_assigned_chapter_item` (`group_id`, `chapter_id`, `item_id`, `exercise_id_list`, `full_mark`) VALUES
(19, 1, 1, '1', 1),
(19, 1, 2, '2', 2),
(19, 1, 3, '3', 3),
(19, 1, 4, '4', 4);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
