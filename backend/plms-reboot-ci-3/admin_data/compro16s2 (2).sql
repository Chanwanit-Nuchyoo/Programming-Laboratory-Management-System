-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 16, 2017 at 08:35 AM
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
-- Table structure for table `exercise_constrain`
--

CREATE TABLE `exercise_constrain` (
  `constrain_id` int(11) NOT NULL,
  `lab_id` int(11) DEFAULT NULL,
  `content` varchar(1024) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `exercise_submission`
--

CREATE TABLE `exercise_submission` (
  `submission_id` int(11) NOT NULL,
  `stu_id` int(11) NOT NULL,
  `lab_id` int(11) NOT NULL,
  `sourcecode` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `exercise_testcase`
--

CREATE TABLE `exercise_testcase` (
  `testcase_id` int(11) NOT NULL,
  `lab_id` int(11) NOT NULL,
  `testcase_content` varchar(1024) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

-- --------------------------------------------------------

--
-- Table structure for table `lab_classinfo`
--

CREATE TABLE `lab_classinfo` (
  `chapter_id` int(11) NOT NULL,
  `chapter_name` varchar(256) NOT NULL,
  `chapter_fullmark` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='บทเรียนของวิชา';

--
-- Dumping data for table `lab_classinfo`
--

INSERT INTO `lab_classinfo` (`chapter_id`, `chapter_name`, `chapter_fullmark`) VALUES
(1, 'การเขียนโปรแกรมภาษาซีเบื้องต้น', 10),
(2, 'การเขียนโปรแกรมเบื้องต้นและคำสั่งแสดงผล', 10),
(3, 'การใช้งานคำสั่ง Input Output และการคำนวณต่างๆ', 10),
(4, 'การเขียนโปรแกรมแบบกำหนดเงื่อนไข', 10),
(5, 'การเขียนโปรแกรมแบบวนซ้ำ', 10),
(6, 'การเขียนโปรแกรมแบบวนซ้ำ และกำหนดเงื่อนไข', 10),
(7, 'ตัวแปรแถวลำดับ', 10),
(8, 'โครงสร้างข้อมูล', 10),
(9, 'ตัวชี้', 10),
(10, 'ฟังก์ชัน', 10),
(11, 'การเขียนโปรแกรมติดต่อกับ Text File', 10);

-- --------------------------------------------------------

--
-- Table structure for table `lab_class_group`
--

CREATE TABLE `lab_class_group` (
  `class_id` int(11) DEFAULT NULL,
  `group_n0` int(11) DEFAULT NULL,
  `chapter_id` int(11) DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lab_class_group`
--

INSERT INTO `lab_class_group` (`class_id`, `group_n0`, `chapter_id`, `start_time`, `end_time`) VALUES
(1, 19, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lab_class_item`
--

CREATE TABLE `lab_class_item` (
  `item_id` int(11) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `exercise_id` int(11) DEFAULT NULL,
  `item_point` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='กำหนด exercise ให้นักศึกษา แต่ละแลป';

-- --------------------------------------------------------

--
-- Table structure for table `lab_exercise`
--

CREATE TABLE `lab_exercise` (
  `lab_id` int(11) NOT NULL,
  `lab_chapter` int(3) DEFAULT NULL,
  `lab_level` enum('0','1','2','3','4','5','6') DEFAULT NULL,
  `lab_name` varchar(40) DEFAULT NULL,
  `lab_content` varchar(8192) DEFAULT NULL,
  `testcase` enum('no_input','yes') DEFAULT NULL,
  `sourcecode` varchar(50) DEFAULT NULL,
  `full_mark` int(4) NOT NULL DEFAULT '10',
  `added_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `added_by` varchar(40) DEFAULT NULL,
  `lab_constraint` varchar(1024) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='to store exercise';

--
-- Dumping data for table `lab_exercise`
--

INSERT INTO `lab_exercise` (`lab_id`, `lab_chapter`, `lab_level`, `lab_name`, `lab_content`, `testcase`, `sourcecode`, `full_mark`, `added_date`, `added_by`, `lab_constraint`) VALUES
(1, 1, '1', 'การทดลองที่ 1.1 หน้า 35', '<p style="text-align: left; ">หลังจากที่ ทำโปรแกรมในถึงหน้า 42 ให้นักศึกษาส่ง โปรแกรม<font face="Courier New"> helloword.c</font></p><ul><li style="text-align: left;">&nbsp; &nbsp; นามสกุลของไฟล์ ต้องเป็น <font face="Courier New">.c</font> &nbsp;เท่านั้น</li><li style="text-align: left;">&nbsp;&nbsp;&nbsp;&nbsp;<font face="Courier New">ถ้านามสกุลเป็น .cpp ให้ทำการ rename ก่อนส่ง</font></li></ul>', 'no_input', 'lab_01_01_helloworld.c', 10, '2017-01-13 10:40:12', 'kanut', '0'),
(2, 1, '2', 'แสดงผลตามตัวอย่าง 1', '<p style="text-align: left; ">ให้นักศึกษาเขียนโปรแกรมแสดงผลตามตัวอย่าง</p>', 'no_input', 'no_input', 10, '2017-01-13 10:43:34', 'kanut', '0'),
(3, 1, '3', 'แสดงผลตามตัวอย่าง 2', '<p style="text-align: left; "><span style="font-size: 18px;">ให้นักศึกษา เขียนโปรแกรมแสดงผลตามตัวอย่างที่กำหนดให้</span></p>', 'no_input', 'no_input', 10, '2017-01-13 10:47:01', 'kanut', '0'),
(4, 1, '4', 'การทดลอง 1.4  หน้า 45', '<p class="MsoNormal" style="color: rgb(51, 51, 51); background-color: rgb(245, 245, 245); text-align: justify;"><span lang="TH" style="font-size: 14pt; font-family: &quot;TH Sarabun New&quot;, sans-serif;">ทดลองกำหนดรูปแบบการพิมพ์ด้วย&nbsp;</span><font face="Courier New">\\n</font><font face="TH Sarabun New, sans-serif">&nbsp;</font><span lang="TH" style="font-size: 14pt; font-family: &quot;TH Sarabun New&quot;, sans-serif;">และ&nbsp;</span><font face="Courier New">\\t&nbsp;</font><span lang="TH" style="font-size: 14pt; font-family: &quot;TH Sarabun New&quot;, sans-serif;">ของคำสั่ง&nbsp;</span><font face="Courier New">printf</font><font face="TH Sarabun New, sans-serif"><o:p></o:p></font></p><p class="MsoNormal" style="color: rgb(51, 51, 51); background-color: rgb(245, 245, 245); text-align: justify;"><span lang="TH" style="font-size: 14pt; font-family: &quot;TH Sarabun New&quot;, sans-serif;">ให้นักศึกษาเขียนโปรแกรมแสดงข้อมูลของตัวนักศึกษาเอง ซึ่งประกอบด้วย รหัสนักศึกษา</span><span style="font-family: &quot;TH Sarabun New&quot;, sans-serif;">,</span><span lang="TH" style="font-size: 14pt; font-family: &quot;TH Sarabun New&quot;, sans-serif;">เบอร์โทรศัพท์</span><span style="font-family: &quot;TH Sarabun New&quot;, sans-serif;">,</span><span lang="TH" style="font-size: 14pt; font-family: &quot;TH Sarabun New&quot;, sans-serif;">ชื่อ-นามสกุล และจังหวัดที่อยู่ โดยมีรูปแบบการแสดงผลดังตัวอย่าง เก็บไว้ภายใต้โปรเจคเดิม คือ</span><font face="Courier New">&nbsp;Lab01&nbsp;</font><span lang="TH" style="font-size: 14pt; font-family: &quot;TH Sarabun New&quot;, sans-serif;">ชื่อโปรแกรม&nbsp;</span><font face="Courier New">Lab01_4</font><font face="TH Sarabun New, sans-serif"><o:p></o:p></font></p><ul type="disc" style="margin-top: 0cm; color: rgb(51, 51, 51); background-color: rgb(245, 245, 245);"><li class="MsoNormal" style="text-align: justify;"><span lang="TH" style="font-size: 14pt; font-family: &quot;TH Sarabun New&quot;, sans-serif;">ตัวอักษรแรกของบรรทัดที่ 1 จะมีการเว้นระยะจากขอบด้านซ้าย&nbsp;&nbsp;&nbsp;</span><span style="font-family: &quot;TH Sarabun New&quot;, sans-serif;"><o:p></o:p></span></li><li class="MsoNormal" style="text-align: justify;"><span lang="TH" style="font-size: 14pt;"><font face="TH Sarabun New, sans-serif">ตัว</font><font face="Courier New">&nbsp;</font></span><font face="Courier New">N</font><font face="TH Sarabun New, sans-serif">&nbsp;&nbsp;</font><span lang="TH" style="font-size: 14pt; font-family: &quot;TH Sarabun New&quot;, sans-serif;">ในบรรทัดที่</span><span lang="TH" style="font-size: 14pt;"><font face="Courier New"> 2&nbsp;</font></span><span lang="TH" style="font-size: 14pt;"><font face="TH Sarabun New, sans-serif">จะอยู่ตำแหน่งเดียวกับ</font><font face="Courier New">&nbsp;</font></span><font face="Courier New">I</font><font face="TH Sarabun New, sans-serif">&nbsp; &nbsp;</font><span lang="TH" style="font-size: 14pt; font-family: &quot;TH Sarabun New&quot;, sans-serif;">ในบรรทัดแรก</span><span style="font-family: &quot;TH Sarabun New&quot;, sans-serif;"><o:p></o:p></span></li><li class="MsoNormal" style="text-align: justify;"><span lang="TH" style="font-size: 14pt; font-family: &quot;TH Sarabun New&quot;, sans-serif;">&nbsp;ตัวอักษร&nbsp;</span><font face="Courier New">P</font><font face="TH Sarabun New, sans-serif">&nbsp;</font><span lang="TH" style="font-size: 14pt; font-family: &quot;TH Sarabun New&quot;, sans-serif;">ในบรรทัดที่</span><span lang="TH" style="font-size: 14pt;"><font face="Courier New"> 1</font></span><span lang="TH" style="font-size: 14pt; font-family: &quot;TH Sarabun New&quot;, sans-serif;"> และ</span><span lang="TH" style="font-size: 14pt;"><font face="Courier New"> 2</font></span><span lang="TH" style="font-size: 14pt; font-family: &quot;TH Sarabun New&quot;, sans-serif;">&nbsp; อยู่ตำแหน่งเดียวกัน</span><span style="font-family: &quot;TH Sarabun New&quot;, sans-serif;"><o:p></o:p></span></li><li class="MsoNormal" style="text-align: justify;"><span lang="TH" style="font-size: 14pt;"><font face="TH Sarabun New, sans-serif">โคลอน</font><font face="Courier New">&nbsp;</font></span><font face="Courier New">:&nbsp;</font><span lang="TH" style="font-size: 14pt; font-family: &quot;TH Sarabun New&quot;, sans-serif;">จะมีการเว้นระยะด้านซ้ายและขวา</span><span lang="TH" style="font-size: 14pt;"><font face="Courier New"> 1</font></span><span lang="TH" style="font-size: 14pt; font-family: &quot;TH Sarabun New&quot;, sans-serif;">&nbsp; ช่องตัวอักษร</span></li></ul>', 'no_input', 'no_sourcecode', 10, '2017-01-12 17:46:55', 'kanut', '0');

-- --------------------------------------------------------

--
-- Table structure for table `student_assigned_chapter_item`
--

CREATE TABLE `student_assigned_chapter_item` (
  `stu_id` int(11) NOT NULL,
  `chapter_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `exercise_id` int(11) NOT NULL,
  `full_mark` int(11) NOT NULL DEFAULT '0',
  `marking` int(11) NOT NULL DEFAULT '0',
  `added_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='เก็บข้อมูลของนักศึกษาแต่ละคน ทีจะทำแลป';

--
-- Dumping data for table `student_assigned_chapter_item`
--

INSERT INTO `student_assigned_chapter_item` (`stu_id`, `chapter_id`, `item_id`, `exercise_id`, `full_mark`, `marking`, `added_date`) VALUES
(59112233, 1, 1, 1, 1, 0, '2017-01-15 22:56:38'),
(59112233, 1, 2, 2, 2, 0, '2017-01-15 22:57:26'),
(59112233, 1, 3, 4, 4, 0, '2017-01-15 22:55:28'),
(59112233, 1, 4, 4, 4, 0, '2017-01-15 22:57:32');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(50) DEFAULT NULL,
  `role` enum('admin','editor','author','student','supervisor','staff') DEFAULT NULL,
  `added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` datetime DEFAULT NULL,
  `active` enum('yes','no') NOT NULL DEFAULT 'yes',
  `added_by` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `role`, `added`, `last_login`, `active`, `added_by`) VALUES
(9001, 'Admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', '2017-01-07 12:42:39', '2017-01-10 09:38:11', 'yes', NULL),
(9002, 'Editor', '344a7f427fb765610ef96eb7bce95257', 'editor', '2017-01-07 12:42:39', NULL, 'yes', NULL),
(9003, 'Author', 'a517747c3d12f99244ae598910d979c5', 'author', '2017-01-07 12:43:30', '2017-01-07 17:22:21', 'yes', NULL),
(900001, 'kanut', 'fdfc3e4e8497a543946c1e314297d9fe', 'supervisor', '2017-01-12 08:20:38', '2017-01-15 14:28:49', 'yes', NULL),
(900002, 'prasarn', 'd696fc998f687e4383d69c239b4bd3ea', 'supervisor', '2017-01-12 11:46:57', '2017-01-12 11:58:38', 'yes', NULL),
(11051105, '11051105', '81dc9bdb52d04dc20036dbd8313ed055', 'student', '2017-01-11 09:22:58', '2017-01-11 23:05:24', 'yes', NULL),
(31333133, '31333133', '9604431068c7b0f10b1637f235622cf9', 'student', '2017-01-11 09:43:20', NULL, 'yes', NULL),
(56010886, '56010886', '1eaf54e3686a1230c33d8799e67cf074', 'student', '2017-01-15 12:55:05', NULL, 'yes', 'kanut'),
(56010912, '56010912', '3a28f7e7a109c881ceb6af60b955e3a1', 'student', '2017-01-15 12:55:05', NULL, 'yes', 'kanut'),
(59010012, '59010012', '5205defd2b9424b86443fbbcac9815a1', 'student', '2017-01-15 12:55:05', NULL, 'yes', 'kanut'),
(59010059, '59010059', '4e3f43995139dfb85213f1026bd3e097', 'student', '2017-01-15 12:55:05', NULL, 'yes', 'kanut'),
(59010084, '59010084', '42227ac3763ce9ef6c763215008cc35c', 'student', '2017-01-15 12:55:05', NULL, 'yes', 'kanut'),
(59010182, '59010182', '4dbe747b3320ab6cf2d342f5fcf893dc', 'student', '2017-01-15 12:55:05', NULL, 'yes', 'kanut'),
(59010198, '59010198', '5113ed2a8dccfa421b7b0a3f18e46291', 'student', '2017-01-15 12:55:05', NULL, 'yes', 'kanut'),
(59010261, '59010261', '66909438d280edac7e87f9b998ea9135', 'student', '2017-01-15 12:55:05', NULL, 'yes', 'kanut'),
(59010427, '59010427', '6f38f81c1226096acced8b88eaec521c', 'student', '2017-01-15 12:55:05', NULL, 'yes', 'kanut'),
(59010465, '59010465', '642ffb576e3b9a6f74896274864d6f13', 'student', '2017-01-15 12:55:05', NULL, 'yes', 'kanut'),
(59010469, '59010469', '0f7f6593b481e23b8e014b4566e2a439', 'student', '2017-01-15 12:55:05', NULL, 'yes', 'kanut'),
(59010479, '59010479', '5263bbb95c5049f89c939bf09c73da8e', 'student', '2017-01-15 12:55:05', NULL, 'yes', 'kanut'),
(59010502, '59010502', '1945977742f8fb8f0fde34a92f8b4b7a', 'student', '2017-01-15 12:55:05', NULL, 'yes', 'kanut'),
(59010540, '59010540', '7bfaaca27575a11fc1de598afbb5f673', 'student', '2017-01-15 12:55:05', NULL, 'yes', 'kanut'),
(59010580, '59010580', 'd4becd4ed530a3b25ae8cc9bd2b657b1', 'student', '2017-01-15 12:55:05', NULL, 'yes', 'kanut'),
(59010635, '59010635', 'c7dea7bb216c52d77d355337d76707ee', 'student', '2017-01-15 12:55:05', NULL, 'yes', 'kanut'),
(59010658, '59010658', '12da3bcf9201b9a776a7eef480396c55', 'student', '2017-01-15 12:55:05', NULL, 'yes', 'kanut'),
(59010687, '59010687', 'c1d8a714786b9f1017a604eb379c56d4', 'student', '2017-01-15 12:55:05', NULL, 'yes', 'kanut'),
(59010741, '59010741', '7e5e63deda4313b7975fd2a1be0f22b3', 'student', '2017-01-15 12:55:05', NULL, 'yes', 'kanut'),
(59010798, '59010798', 'a4fd3b05d1be66b2fa9ebb071835d664', 'student', '2017-01-15 12:55:05', NULL, 'yes', 'kanut'),
(59010834, '59010834', '2cb6a10a66cd4af5818e3f0bc49cef60', 'student', '2017-01-15 12:55:05', NULL, 'yes', 'kanut'),
(59010896, '59010896', '73c24c1368270aa01e6dc29a1c656b28', 'student', '2017-01-15 12:55:05', NULL, 'yes', 'kanut'),
(59010900, '59010900', '571313ddca0cc85e415b27f1fb7b667b', 'student', '2017-01-15 12:55:06', NULL, 'yes', 'kanut'),
(59010910, '59010910', '409f5de0143e32c0ec505d7ee985bf1d', 'student', '2017-01-15 12:55:06', NULL, 'yes', 'kanut'),
(59011025, '59011025', 'bbdee7df1863c6060ca45a4742935842', 'student', '2017-01-15 12:55:06', NULL, 'yes', 'kanut'),
(59011042, '59011042', '60491a121910a91c2c609f030a1601a0', 'student', '2017-01-15 12:55:06', NULL, 'yes', 'kanut'),
(59011118, '59011118', '4ff43ff7435d7fe2dc0a37b0f3e2751c', 'student', '2017-01-15 12:55:06', NULL, 'yes', 'kanut'),
(59011133, '59011133', '14d74bc02494dfc4761e52065485340f', 'student', '2017-01-15 12:55:06', NULL, 'yes', 'kanut'),
(59011188, '59011188', '36d38ce0245f17ccc441c837d3dd7c3c', 'student', '2017-01-15 12:55:06', NULL, 'yes', 'kanut'),
(59011208, '59011208', '95eeb217ee35b8f42667ebf2c987e655', 'student', '2017-01-15 12:55:06', NULL, 'yes', 'kanut'),
(59011217, '59011217', 'd5aa1c191d1e3f0438e633d970915d78', 'student', '2017-01-15 12:55:06', NULL, 'yes', 'kanut'),
(59011232, '59011232', 'd1e51adad05f69869e898dad779c89af', 'student', '2017-01-15 12:55:06', NULL, 'yes', 'kanut'),
(59011239, '59011239', 'd1ce56a910e7a49611d854fc1b471007', 'student', '2017-01-15 12:55:06', NULL, 'yes', 'kanut'),
(59011476, '59011476', '248387260f6e077ce5651b1c0ee66cb9', 'student', '2017-01-15 12:55:06', NULL, 'yes', 'kanut'),
(59011491, '59011491', '10951a4cf6e92b28585495888b992e28', 'student', '2017-01-15 12:55:06', NULL, 'yes', 'kanut'),
(59011544, '59011544', 'aad9ed3b260ca533338ee1d64bfce3a2', 'student', '2017-01-15 12:55:06', NULL, 'yes', 'kanut'),
(59011566, '59011566', 'aa69ea0c4e3063e3a3442279e5c49a13', 'student', '2017-01-15 12:55:06', NULL, 'yes', 'kanut'),
(59011577, '59011577', '19eeb6544d5ca133b22df3de04fdef16', 'student', '2017-01-15 12:55:06', NULL, 'yes', 'kanut'),
(59112233, '59112233', '25f9e794323b453885f5181f1b624d0b', 'student', '2017-01-07 12:44:15', '2017-01-15 21:57:29', 'yes', NULL),
(76037603, '76037603', '81dc9bdb52d04dc20036dbd8313ed055', 'student', '2017-01-11 09:45:32', '2017-01-11 14:02:47', 'yes', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_student`
--

CREATE TABLE `user_student` (
  `stu_id` int(11) NOT NULL,
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
(11051105, 'female', 'มุทิตา', 'อุเบกขา', 'สวดมนต์', '0000-00-00', 'image_11051105_58764385bd163.jpg', '', '', '', 0, ''),
(56010886, 'male', 'นายพีระวิช', 'แก้วสาคร', NULL, NULL, NULL, NULL, NULL, NULL, 19, NULL),
(56010912, 'male', 'นายภัทรฉัตร', 'บุษบงค์', NULL, NULL, NULL, NULL, NULL, NULL, 19, NULL),
(59010012, 'female', 'นางสาวกนกอร', 'ทัดเทียม', NULL, NULL, NULL, NULL, NULL, NULL, 19, NULL),
(59010059, 'male', 'นายกษิเดช', 'เมฆแสงอรุณรุ่ง', NULL, NULL, NULL, NULL, NULL, NULL, 19, NULL),
(59010084, 'male', 'นายกันตวิชญ์', 'พรหมทอง', NULL, NULL, NULL, NULL, NULL, NULL, 19, NULL),
(59010182, 'male', 'นายจักรกฤษณ์', 'พาทีทิน', NULL, NULL, NULL, NULL, NULL, NULL, 19, NULL),
(59010198, 'male', 'นายจิตติพล', 'คำอุไร', NULL, NULL, NULL, NULL, NULL, NULL, 19, NULL),
(59010261, 'female', 'นางสาวชนกจิต', 'น้อยคำ', NULL, NULL, NULL, NULL, NULL, NULL, 19, NULL),
(59010427, 'female', 'นางสาวณัฐณิชา', 'รุ่งเรืองไพโรจน์', NULL, NULL, NULL, NULL, NULL, NULL, 19, NULL),
(59010465, 'male', 'นายณัฐภัทร', 'วิศรียา', NULL, NULL, NULL, NULL, NULL, NULL, 19, NULL),
(59010469, 'male', 'นายณัฐรัฐ', 'เเย้มโพธิ์ใช้', NULL, NULL, NULL, NULL, NULL, NULL, 19, NULL),
(59010479, 'male', 'นายณัฐวุฒิ', 'ทวีรประยูร', NULL, NULL, NULL, NULL, NULL, NULL, 19, NULL),
(59010502, 'female', 'นางสาวดุุษฎี', 'นาคบัว', NULL, NULL, NULL, NULL, NULL, NULL, 19, NULL),
(59010540, 'male', 'นายแทนไท', 'กิจชูตระกูล', NULL, NULL, NULL, NULL, NULL, NULL, 19, NULL),
(59010580, 'female', 'นางสาวธนภรณ์', 'บัญชาดิฐ', NULL, NULL, NULL, NULL, NULL, NULL, 19, NULL),
(59010635, 'male', 'นายธัชพล', 'อรรถประวิทย์', NULL, NULL, NULL, NULL, NULL, NULL, 19, NULL),
(59010658, 'male', 'นายธีรเดช', 'ธัญญเจริญ', NULL, NULL, NULL, NULL, NULL, NULL, 19, NULL),
(59010687, 'male', 'นายนพรัตน์', 'ตันประเสริฐ', NULL, NULL, NULL, NULL, NULL, NULL, 19, NULL),
(59010741, 'male', 'นายนิธิศภัทร', 'จิตรเดชขจร', NULL, NULL, NULL, NULL, NULL, NULL, 19, NULL),
(59010798, 'female', 'นางสาวปภานัน', 'จิตจำ', NULL, NULL, NULL, NULL, NULL, NULL, 19, NULL),
(59010834, 'male', 'นายปัญญวุฒิ', 'ล่วนเส้ง', NULL, NULL, NULL, NULL, NULL, NULL, 19, NULL),
(59010896, 'male', 'นายพงศธรณ์', 'คงธนทรัพย์', NULL, NULL, NULL, NULL, NULL, NULL, 19, NULL),
(59010900, 'male', 'นายพงศวัฒน์', 'อรรถวานิช', NULL, NULL, NULL, NULL, NULL, NULL, 19, NULL),
(59010910, 'male', 'นายพชรพล', 'ประภารัตน์', NULL, NULL, NULL, NULL, NULL, NULL, 19, NULL),
(59011025, 'male', 'นายภัคธร', 'ขวัญตา', NULL, NULL, NULL, NULL, NULL, NULL, 19, NULL),
(59011042, 'male', 'นายภัทรสันติ์', 'แก้วคำภา', NULL, NULL, NULL, NULL, NULL, NULL, 19, NULL),
(59011118, 'male', 'นายรณชัย', 'อดิเรกลาภวงศ์', NULL, NULL, NULL, NULL, NULL, NULL, 19, NULL),
(59011133, 'male', 'นายรัฐ', 'จินดาศิลป์', NULL, NULL, NULL, NULL, NULL, NULL, 19, NULL),
(59011188, 'female', 'นางสาววรางคณา', 'ไกรยา', NULL, NULL, NULL, NULL, NULL, NULL, 19, NULL),
(59011208, 'female', 'นางสาววศินี', 'ลิ้มสกุล', NULL, NULL, NULL, NULL, NULL, NULL, 19, NULL),
(59011217, 'female', 'นางสาววันศิริ', 'สระรัมย์', NULL, NULL, NULL, NULL, NULL, NULL, 19, NULL),
(59011232, 'female', 'นางสาววิภา', 'พิมพ์สมาน', NULL, NULL, NULL, NULL, NULL, NULL, 19, NULL),
(59011239, 'male', 'นายวิโรจน์', 'ตระกาลจันทร์', NULL, NULL, NULL, NULL, NULL, NULL, 19, NULL),
(59011476, 'male', 'นายอดิศร', 'อนุสรณ์วาณิช', NULL, NULL, NULL, NULL, NULL, NULL, 19, NULL),
(59011491, 'male', 'นายอนุวัต', 'ธินันท์', NULL, NULL, NULL, NULL, NULL, NULL, 19, NULL),
(59011544, 'female', 'นางสาวอัญมณี', 'ราชแสง', NULL, NULL, NULL, NULL, NULL, NULL, 19, NULL),
(59011566, 'female', 'นางสาวอาภรณ์', 'สาแก้ว', NULL, NULL, NULL, NULL, NULL, NULL, 19, NULL),
(59011577, 'male', 'นายอิทธิชัย', 'ส่งศรี', NULL, NULL, NULL, NULL, NULL, NULL, 19, NULL),
(59112233, 'other', 'His name is ', 'john cena!', 'john cena', '1996-12-31', 'image_59112233_587b7ec3efcf9.jpg', '123456@gmail.com', '0839037933', 'วิศวกรรมคอมพิวเตอร์', 19, ''),
(76037603, 'other', 'a', '', '', '0000-00-00', '', '', '', '', 0, '');

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
(900001, 'male', 'คณัฐ', 'ตังติสานนท์', 'ยู้', '1967-09-03', '', 'kanut.ta@kmitl.ac.th', '0866101013', 'วิศวกรรมคอมพิวเตอร์'),
(900002, 'male', 'p', 't', '', '0000-00-00', '', '', '', 'วิศวกรรมคอมพิวเตอร์');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `exercise_constrain`
--
ALTER TABLE `exercise_constrain`
  ADD PRIMARY KEY (`constrain_id`);

--
-- Indexes for table `exercise_submission`
--
ALTER TABLE `exercise_submission`
  ADD PRIMARY KEY (`submission_id`);

--
-- Indexes for table `group_assigned_chapter_item`
--
ALTER TABLE `group_assigned_chapter_item`
  ADD PRIMARY KEY (`group_id`,`chapter_id`,`item_id`);

--
-- Indexes for table `lab_classinfo`
--
ALTER TABLE `lab_classinfo`
  ADD PRIMARY KEY (`chapter_id`);

--
-- Indexes for table `lab_exercise`
--
ALTER TABLE `lab_exercise`
  ADD PRIMARY KEY (`lab_id`);

--
-- Indexes for table `student_assigned_chapter_item`
--
ALTER TABLE `student_assigned_chapter_item`
  ADD PRIMARY KEY (`stu_id`,`chapter_id`,`item_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `user_student`
--
ALTER TABLE `user_student`
  ADD PRIMARY KEY (`stu_id`);

--
-- Indexes for table `user_supervisor`
--
ALTER TABLE `user_supervisor`
  ADD PRIMARY KEY (`supervisor_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `exercise_constrain`
--
ALTER TABLE `exercise_constrain`
  MODIFY `constrain_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lab_exercise`
--
ALTER TABLE `lab_exercise`
  MODIFY `lab_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
