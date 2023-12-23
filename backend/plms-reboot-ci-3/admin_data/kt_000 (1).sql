-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 04, 2016 at 01:20 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kt_000`
--

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `dept_id` int(4) UNSIGNED NOT NULL,
  `dept_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `exercise`
--

CREATE TABLE `exercise` (
  `exercise_id` int(10) UNSIGNED NOT NULL,
  `chapter` int(2) UNSIGNED DEFAULT NULL,
  `level` int(10) UNSIGNED DEFAULT NULL,
  `short_desc` varchar(255) DEFAULT NULL,
  `content` varchar(4096) DEFAULT NULL,
  `constraint` varchar(1024) DEFAULT NULL,
  `testcase` varchar(1024) DEFAULT NULL,
  `sample` varchar(45) DEFAULT NULL,
  `file_path` varchar(45) DEFAULT NULL,
  `created_by` int(8) UNSIGNED DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `last_modified_by` int(11) DEFAULT NULL,
  `last_modified_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lab_room`
--

CREATE TABLE `lab_room` (
  `room_id` int(4) UNSIGNED NOT NULL,
  `room_name` varchar(10) DEFAULT NULL,
  `room_capacity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lab_room`
--

INSERT INTO `lab_room` (`room_id`, `room_name`, `room_capacity`) VALUES
(1, 'CE_706', 60),
(2, 'CE_704', 60);

-- --------------------------------------------------------

--
-- Table structure for table `lab_submit`
--

CREATE TABLE `lab_submit` (
  `lab_submit_id` int(11) NOT NULL,
  `stu_id` int(8) UNSIGNED NOT NULL,
  `marking_auto` int(4) UNSIGNED DEFAULT NULL,
  `marking_staff` int(4) UNSIGNED NOT NULL,
  `time_submit` datetime DEFAULT NULL,
  `exercise_id` int(10) UNSIGNED NOT NULL,
  `file_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `selected_exercise`
--

CREATE TABLE `selected_exercise` (
  `exercise_id` int(10) UNSIGNED NOT NULL,
  `workout_id` int(10) UNSIGNED NOT NULL,
  `stu_group_id` int(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `stu_attendance`
--

CREATE TABLE `stu_attendance` (
  `id` int(10) UNSIGNED NOT NULL,
  `stu_id` int(8) UNSIGNED NOT NULL,
  `time_in` datetime DEFAULT NULL,
  `time_out` datetime DEFAULT NULL,
  `login_ip` varchar(20) DEFAULT NULL,
  `login_computer` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `stu_group`
--

CREATE TABLE `stu_group` (
  `group_id` int(4) UNSIGNED NOT NULL,
  `year` int(4) UNSIGNED DEFAULT NULL,
  `semester` int(4) UNSIGNED DEFAULT NULL,
  `group_no` int(4) UNSIGNED DEFAULT NULL,
  `added_date` datetime DEFAULT NULL,
  `room_id` int(4) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stu_group`
--

INSERT INTO `stu_group` (`group_id`, `year`, `semester`, `group_no`, `added_date`, `room_id`) VALUES
(1, 2559, 2, 99, '2016-12-02 14:03:27', 1),
(2, 2559, 2, 1, '2016-12-02 14:05:22', 1);

-- --------------------------------------------------------

--
-- Table structure for table `stu_group_staff`
--

CREATE TABLE `stu_group_staff` (
  `group_staff_id` int(8) UNSIGNED NOT NULL,
  `group_id` int(4) UNSIGNED DEFAULT NULL,
  `staff_id` int(8) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `syllabus`
--

CREATE TABLE `syllabus` (
  `syllabus_id` int(10) UNSIGNED NOT NULL,
  `chapter` int(2) UNSIGNED DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `items` int(2) DEFAULT NULL,
  `full_mark` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `syllabus`
--

INSERT INTO `syllabus` (`syllabus_id`, `chapter`, `description`, `items`, `full_mark`) VALUES
(1, 1, 'Introduction', 5, 10),
(2, 2, 'printf statement', 5, 10),
(3, 3, 'scanf', 5, 10),
(4, 4, 'if statement', 5, 10),
(5, 5, 'loop statement', 5, 10),
(6, 6, 'loop + if', 5, 10),
(7, 7, 'array', 5, 10),
(8, 8, 'structure', 5, 10),
(9, 9, 'pointer', 5, 10),
(10, 10, 'function', 5, 10),
(11, 11, 'file', 5, 10);

-- --------------------------------------------------------

--
-- Table structure for table `user_staff`
--

CREATE TABLE `user_staff` (
  `staff_id` int(8) UNSIGNED NOT NULL,
  `staff_name` varchar(45) DEFAULT NULL,
  `staff_surname` varchar(45) DEFAULT NULL,
  `staff_email` varchar(100) DEFAULT NULL,
  `added_date` datetime DEFAULT NULL,
  `staff_acl` varchar(45) DEFAULT NULL,
  `staff_password` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_student`
--

CREATE TABLE `user_student` (
  `stu_id` int(8) UNSIGNED NOT NULL,
  `stu_name` varchar(45) DEFAULT NULL,
  `stu_surname` varchar(45) DEFAULT NULL,
  `stu_nickname` varchar(45) DEFAULT NULL,
  `stu_password` varchar(255) DEFAULT NULL,
  `stu_email` varchar(100) DEFAULT NULL,
  `added_date` datetime DEFAULT NULL,
  `stu_phone` varchar(12) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `stu_group` int(4) UNSIGNED NOT NULL,
  `dept_id` int(4) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `workout`
--

CREATE TABLE `workout` (
  `workout_id` int(10) UNSIGNED NOT NULL,
  `syllabus_id` int(10) UNSIGNED NOT NULL,
  `item_max` int(2) DEFAULT NULL,
  `short_desc` varchar(1024) DEFAULT NULL,
  `full_mark` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`dept_id`),
  ADD KEY `dept_id` (`dept_id`);

--
-- Indexes for table `exercise`
--
ALTER TABLE `exercise`
  ADD PRIMARY KEY (`exercise_id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `last_modified_by` (`last_modified_by`);

--
-- Indexes for table `lab_room`
--
ALTER TABLE `lab_room`
  ADD PRIMARY KEY (`room_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `lab_submit`
--
ALTER TABLE `lab_submit`
  ADD PRIMARY KEY (`lab_submit_id`),
  ADD KEY `lab_submit_id` (`lab_submit_id`),
  ADD KEY `stu_id` (`stu_id`),
  ADD KEY `exercise_id` (`exercise_id`);

--
-- Indexes for table `selected_exercise`
--
ALTER TABLE `selected_exercise`
  ADD PRIMARY KEY (`exercise_id`,`workout_id`,`stu_group_id`),
  ADD KEY `exercise_id` (`exercise_id`),
  ADD KEY `workout_id` (`workout_id`),
  ADD KEY `stu_group_id` (`stu_group_id`);

--
-- Indexes for table `stu_attendance`
--
ALTER TABLE `stu_attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stu_id` (`stu_id`);

--
-- Indexes for table `stu_group`
--
ALTER TABLE `stu_group`
  ADD PRIMARY KEY (`group_id`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `group_id_2` (`group_id`),
  ADD KEY `room_id` (`room_id`),
  ADD KEY `group_no` (`group_no`);

--
-- Indexes for table `stu_group_staff`
--
ALTER TABLE `stu_group_staff`
  ADD PRIMARY KEY (`group_staff_id`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Indexes for table `syllabus`
--
ALTER TABLE `syllabus`
  ADD PRIMARY KEY (`syllabus_id`);

--
-- Indexes for table `user_staff`
--
ALTER TABLE `user_staff`
  ADD PRIMARY KEY (`staff_id`);

--
-- Indexes for table `user_student`
--
ALTER TABLE `user_student`
  ADD PRIMARY KEY (`stu_id`),
  ADD KEY `dept_id` (`dept_id`),
  ADD KEY `dept_id_2` (`dept_id`),
  ADD KEY `stu_group` (`stu_group`);

--
-- Indexes for table `workout`
--
ALTER TABLE `workout`
  ADD PRIMARY KEY (`workout_id`),
  ADD KEY `syllabus_id` (`syllabus_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lab_submit`
--
ALTER TABLE `lab_submit`
  MODIFY `lab_submit_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stu_attendance`
--
ALTER TABLE `stu_attendance`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `exercise`
--
ALTER TABLE `exercise`
  ADD CONSTRAINT `exercise_chapter` FOREIGN KEY (`exercise_id`) REFERENCES `syllabus` (`syllabus_id`),
  ADD CONSTRAINT `exercise_created_by_staff` FOREIGN KEY (`created_by`) REFERENCES `user_staff` (`staff_id`);

--
-- Constraints for table `lab_submit`
--
ALTER TABLE `lab_submit`
  ADD CONSTRAINT `student_submit` FOREIGN KEY (`stu_id`) REFERENCES `user_student` (`stu_id`),
  ADD CONSTRAINT `submit_lab_exercise` FOREIGN KEY (`exercise_id`) REFERENCES `exercise` (`exercise_id`);

--
-- Constraints for table `stu_attendance`
--
ALTER TABLE `stu_attendance`
  ADD CONSTRAINT `student_attendance` FOREIGN KEY (`stu_id`) REFERENCES `user_student` (`stu_id`);

--
-- Constraints for table `stu_group`
--
ALTER TABLE `stu_group`
  ADD CONSTRAINT `group_room` FOREIGN KEY (`room_id`) REFERENCES `lab_room` (`room_id`);

--
-- Constraints for table `stu_group_staff`
--
ALTER TABLE `stu_group_staff`
  ADD CONSTRAINT `group_has_staff` FOREIGN KEY (`staff_id`) REFERENCES `user_staff` (`staff_id`),
  ADD CONSTRAINT `group_of_student` FOREIGN KEY (`group_id`) REFERENCES `stu_group` (`group_id`);

--
-- Constraints for table `user_student`
--
ALTER TABLE `user_student`
  ADD CONSTRAINT `student_department` FOREIGN KEY (`dept_id`) REFERENCES `department` (`dept_id`),
  ADD CONSTRAINT `student_is_in_group` FOREIGN KEY (`stu_group`) REFERENCES `stu_group` (`group_id`);

--
-- Constraints for table `workout`
--
ALTER TABLE `workout`
  ADD CONSTRAINT `workout_ibfk_1` FOREIGN KEY (`syllabus_id`) REFERENCES `syllabus` (`syllabus_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
