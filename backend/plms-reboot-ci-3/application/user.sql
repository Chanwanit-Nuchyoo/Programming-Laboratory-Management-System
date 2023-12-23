-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 21, 2017 at 09:41 AM
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
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(50) DEFAULT NULL,
  `role` enum('admin','editor','author','student','supervisor','staff') DEFAULT NULL,
  `added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` datetime DEFAULT NULL,
  `last_seen` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('online','offline') NOT NULL DEFAULT 'offline',
  `active` enum('yes','no') NOT NULL DEFAULT 'yes',
  `added_by` varchar(40) DEFAULT NULL,
  `ci_session` int(11) DEFAULT NULL,
  `session_id` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `role`, `added`, `last_login`, `last_seen`, `status`, `active`, `added_by`, `ci_session`, `session_id`) VALUES
(9001, 'Admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', '2017-01-07 12:42:39', '2017-01-10 09:38:11', '2017-02-27 12:45:43', 'offline', 'no', NULL, NULL, NULL),
(9002, 'Editor', '344a7f427fb765610ef96eb7bce95257', 'editor', '2017-01-07 12:42:39', NULL, '2017-02-27 12:45:43', 'offline', 'no', NULL, NULL, NULL),
(9003, 'Author', 'a517747c3d12f99244ae598910d979c5', 'author', '2017-01-07 12:43:30', '2017-01-07 17:22:21', '2017-02-27 12:45:43', 'offline', 'no', NULL, NULL, NULL),
(9009, 'bundit', '3b7f46d7672fd210c1009c7b8dbec181', 'supervisor', '2017-01-17 17:46:04', '2017-01-17 17:47:52', '2017-02-27 12:45:43', 'offline', 'no', NULL, NULL, NULL),
(900001, 'kanut', 'fdfc3e4e8497a543946c1e314297d9fe', 'supervisor', '2017-01-12 08:20:38', '2017-07-19 15:36:20', '2017-02-27 12:45:43', 'offline', 'yes', NULL, NULL, NULL),
(900002, 'prasarn', 'd696fc998f687e4383d69c239b4bd3ea', 'supervisor', '2017-01-12 11:46:57', '2017-01-12 11:58:38', '2017-02-27 12:45:43', 'offline', 'no', NULL, NULL, NULL),
(11051105, '11051105', '81dc9bdb52d04dc20036dbd8313ed055', 'student', '2017-01-11 09:22:58', '2017-01-11 23:05:24', '2017-02-27 12:45:43', 'offline', 'no', NULL, NULL, NULL),
(31333133, '31333133', '9604431068c7b0f10b1637f235622cf9', 'student', '2017-01-11 09:43:20', NULL, '2017-02-27 12:45:43', 'offline', 'no', NULL, NULL, NULL),
(56010886, '56010886', '1eaf54e3686a1230c33d8799e67cf074', 'student', '2017-01-15 12:55:05', '2017-05-01 22:59:19', '2017-02-27 12:45:43', 'offline', 'no', 'kanut', NULL, NULL),
(56010912, '56010912', '3a28f7e7a109c881ceb6af60b955e3a1', 'student', '2017-01-15 12:55:05', '2017-05-06 16:02:22', '2017-02-27 12:45:43', 'offline', 'no', 'kanut', NULL, NULL),
(58010010, '58010010', '5796c320fc57746358429ef5bb5dc4f3', 'student', '2017-01-16 09:25:20', '2017-03-28 17:53:22', '2017-02-27 12:45:43', 'offline', 'no', NULL, NULL, NULL),
(58010752, '58010752', '511baa7add337cd35d0be6a4b5201b3d', 'student', '2017-01-16 09:25:20', '2017-03-19 14:32:18', '2017-02-27 12:45:43', 'offline', 'no', NULL, NULL, NULL),
(58011130, '58011130', '4b1f116ff75bf2775247330392d69df6', 'student', '2017-01-16 09:26:54', '2017-02-17 01:44:03', '2017-02-27 12:45:43', 'offline', 'no', NULL, NULL, NULL),
(59010012, '59010012', '5205defd2b9424b86443fbbcac9815a1', 'student', '2017-01-15 12:55:05', NULL, '2017-02-27 12:45:43', 'offline', 'no', 'kanut', NULL, NULL),
(59010025, '59010025', '59be762c0ec0719c91c8015363fc2291', 'student', '2017-01-17 17:16:26', '2017-04-02 17:59:37', '2017-02-27 12:45:43', 'offline', 'no', NULL, NULL, NULL),
(59010059, '59010059', '4e3f43995139dfb85213f1026bd3e097', 'student', '2017-01-15 12:55:05', NULL, '2017-02-27 12:45:43', 'offline', 'no', 'kanut', NULL, NULL),
(59010084, '59010084', '42227ac3763ce9ef6c763215008cc35c', 'student', '2017-01-15 12:55:05', NULL, '2017-02-27 12:45:43', 'offline', 'no', 'kanut', NULL, NULL),
(59010139, '59010139', 'e9bf8d5c702cca22c694839272234a3e', 'student', '2017-01-17 17:16:26', '2017-04-29 20:57:54', '2017-02-27 12:45:43', 'offline', 'no', NULL, NULL, NULL),
(59010182, '59010182', '4dbe747b3320ab6cf2d342f5fcf893dc', 'student', '2017-01-15 12:55:05', NULL, '2017-02-27 12:45:43', 'offline', 'no', 'kanut', NULL, NULL),
(59010198, '59010198', '5113ed2a8dccfa421b7b0a3f18e46291', 'student', '2017-01-15 12:55:05', NULL, '2017-02-27 12:45:43', 'offline', 'no', 'kanut', NULL, NULL),
(59010261, '59010261', '66909438d280edac7e87f9b998ea9135', 'student', '2017-01-15 12:55:05', NULL, '2017-02-27 12:45:43', 'offline', 'no', 'kanut', NULL, NULL),
(59010279, '59010279', 'f36dccf55c194d969ed7b55e7853a966', 'student', '2017-01-17 17:19:45', '2017-03-28 18:30:13', '2017-02-27 12:45:43', 'offline', 'no', NULL, NULL, NULL),
(59010371, '59010371', '4ca447e334d707044e0b7db348b5b231', 'student', '2017-01-17 17:20:36', '2017-04-30 22:20:00', '2017-02-27 12:45:43', 'offline', 'no', NULL, NULL, NULL),
(59010427, '59010427', '6f38f81c1226096acced8b88eaec521c', 'student', '2017-01-15 12:55:05', NULL, '2017-02-27 12:45:43', 'offline', 'no', 'kanut', NULL, NULL),
(59010465, '59010465', '642ffb576e3b9a6f74896274864d6f13', 'student', '2017-01-15 12:55:05', NULL, '2017-02-27 12:45:43', 'offline', 'no', 'kanut', NULL, NULL),
(59010469, '59010469', '0f7f6593b481e23b8e014b4566e2a439', 'student', '2017-01-15 12:55:05', NULL, '2017-02-27 12:45:43', 'offline', 'no', 'kanut', NULL, NULL),
(59010477, '59010477', 'c3f5668c54729ecdde79a230e449c60d', 'student', '2017-01-17 17:20:36', '2017-03-30 13:55:01', '2017-02-27 12:45:43', 'offline', 'no', NULL, NULL, NULL),
(59010479, '59010479', '5263bbb95c5049f89c939bf09c73da8e', 'student', '2017-01-15 12:55:05', NULL, '2017-02-27 12:45:43', 'offline', 'no', 'kanut', NULL, NULL),
(59010502, '59010502', '1945977742f8fb8f0fde34a92f8b4b7a', 'student', '2017-01-15 12:55:05', NULL, '2017-02-27 12:45:43', 'offline', 'no', 'kanut', NULL, NULL),
(59010507, '59010507', '4e27013c0a5e5d8bf50890d11a3b9dd9', 'student', '2017-01-17 17:25:10', '2017-04-04 12:27:26', '2017-02-27 12:45:43', 'offline', 'no', NULL, NULL, NULL),
(59010531, '59010531', 'bc1e5c34fa78ed44c0af408a2a5f481d', 'student', '2017-01-17 17:26:59', '2017-04-17 17:37:11', '2017-02-27 12:45:43', 'offline', 'no', NULL, NULL, NULL),
(59010540, '59010540', '7bfaaca27575a11fc1de598afbb5f673', 'student', '2017-01-15 12:55:05', NULL, '2017-02-27 12:45:43', 'offline', 'no', 'kanut', NULL, NULL),
(59010580, '59010580', 'd4becd4ed530a3b25ae8cc9bd2b657b1', 'student', '2017-01-15 12:55:05', NULL, '2017-02-27 12:45:43', 'offline', 'no', 'kanut', NULL, NULL),
(59010635, '59010635', 'c7dea7bb216c52d77d355337d76707ee', 'student', '2017-01-15 12:55:05', NULL, '2017-02-27 12:45:43', 'offline', 'no', 'kanut', NULL, NULL),
(59010658, '59010658', '12da3bcf9201b9a776a7eef480396c55', 'student', '2017-01-15 12:55:05', NULL, '2017-02-27 12:45:43', 'offline', 'no', 'kanut', NULL, NULL),
(59010687, '59010687', 'c1d8a714786b9f1017a604eb379c56d4', 'student', '2017-01-15 12:55:05', NULL, '2017-02-27 12:45:43', 'offline', 'no', 'kanut', NULL, NULL),
(59010708, '59010708', '4e0d7158e4cb88acff443ea2690feec9', 'student', '2017-01-17 17:27:25', '2017-03-28 18:29:53', '2017-02-27 12:45:43', 'offline', 'no', NULL, NULL, NULL),
(59010730, '59010730', '9b6f8dcd2d67d9021f0413c5fe10fa2f', 'student', '2017-01-17 17:27:50', '2017-04-02 14:30:33', '2017-02-27 12:45:43', 'offline', 'no', NULL, NULL, NULL),
(59010741, '59010741', '7e5e63deda4313b7975fd2a1be0f22b3', 'student', '2017-01-15 12:55:05', NULL, '2017-02-27 12:45:43', 'offline', 'no', 'kanut', NULL, NULL),
(59010793, '59010793', '9e69a2980dac07ac9c19878e83f39707', 'student', '2017-01-17 17:28:18', '2017-03-30 15:51:09', '2017-02-27 12:45:43', 'offline', 'no', NULL, NULL, NULL),
(59010798, '59010798', 'a4fd3b05d1be66b2fa9ebb071835d664', 'student', '2017-01-15 12:55:05', NULL, '2017-02-27 12:45:43', 'offline', 'no', 'kanut', NULL, NULL),
(59010825, '59010825', 'dc5730bd635977ae19703744b6d4d6d8', 'student', '2017-01-17 17:29:16', '2017-04-29 22:21:05', '2017-02-27 12:45:43', 'offline', 'no', NULL, NULL, NULL),
(59010834, '59010834', '2cb6a10a66cd4af5818e3f0bc49cef60', 'student', '2017-01-15 12:55:05', NULL, '2017-02-27 12:45:43', 'offline', 'no', 'kanut', NULL, NULL),
(59010859, '59010859', '319dd9a51f6f60abea70e7cb1bbfd095', 'student', '2017-01-17 17:30:04', '2017-04-30 22:26:50', '2017-02-27 12:45:43', 'offline', 'no', NULL, NULL, NULL),
(59010881, '59010881', '6fbb47a8fc1d0fb40e59e02bbebf9b89', 'student', '2017-01-17 17:30:41', '2017-03-28 18:29:21', '2017-02-27 12:45:43', 'offline', 'no', NULL, NULL, NULL),
(59010896, '59010896', '73c24c1368270aa01e6dc29a1c656b28', 'student', '2017-01-15 12:55:05', NULL, '2017-02-27 12:45:43', 'offline', 'no', 'kanut', NULL, NULL),
(59010900, '59010900', '571313ddca0cc85e415b27f1fb7b667b', 'student', '2017-01-15 12:55:06', NULL, '2017-02-27 12:45:43', 'offline', 'no', 'kanut', NULL, NULL),
(59010910, '59010910', '409f5de0143e32c0ec505d7ee985bf1d', 'student', '2017-01-15 12:55:06', NULL, '2017-02-27 12:45:43', 'offline', 'no', 'kanut', NULL, NULL),
(59010935, '59010935', '9a8f17f588736efbc31ad23ebf3254ef', 'student', '2017-01-17 17:31:45', '2017-03-21 13:33:07', '2017-02-27 12:45:43', 'offline', 'no', NULL, NULL, NULL),
(59010954, '59010954', '4a93c36c140fa35070c49df82e5ff0de', 'student', '2017-01-17 17:32:13', '2017-04-02 01:35:15', '2017-02-27 12:45:43', 'offline', 'no', NULL, NULL, NULL),
(59010991, '59010991', '191eb750f1c227766d788aef3701dfba', 'student', '2017-01-17 17:32:35', '2017-03-21 08:30:54', '2017-02-27 12:45:43', 'offline', 'no', NULL, NULL, NULL),
(59011022, '59011022', '60acf7774a65d80c903af3e1bb5c916b', 'student', '2017-01-17 17:33:00', '2017-05-05 22:56:49', '2017-02-27 12:45:43', 'offline', 'no', NULL, NULL, NULL),
(59011025, '59011025', 'bbdee7df1863c6060ca45a4742935842', 'student', '2017-01-15 12:55:06', NULL, '2017-02-27 12:45:43', 'offline', 'no', 'kanut', NULL, NULL),
(59011042, '59011042', '60491a121910a91c2c609f030a1601a0', 'student', '2017-01-15 12:55:06', NULL, '2017-02-27 12:45:43', 'offline', 'no', 'kanut', NULL, NULL),
(59011056, '59011056', 'def33233752d2532d7e7169702fee82a', 'student', '2017-01-17 17:33:29', '2017-04-09 23:46:01', '2017-02-27 12:45:43', 'offline', 'no', NULL, NULL, NULL),
(59011062, '59011062', '53ef17d082d6823a7ba8a49fca21f00f', 'student', '2017-01-17 17:34:34', '2017-04-30 22:13:35', '2017-02-27 12:45:43', 'offline', 'no', NULL, NULL, NULL),
(59011118, '59011118', '4ff43ff7435d7fe2dc0a37b0f3e2751c', 'student', '2017-01-15 12:55:06', NULL, '2017-02-27 12:45:43', 'offline', 'no', 'kanut', NULL, NULL),
(59011126, '59011126', '6fc2dee5f91f10604854bc20e91535d6', 'student', '2017-01-17 17:35:28', '2017-04-09 18:00:57', '2017-02-27 12:45:43', 'offline', 'no', NULL, NULL, NULL),
(59011133, '59011133', '14d74bc02494dfc4761e52065485340f', 'student', '2017-01-15 12:55:06', NULL, '2017-02-27 12:45:43', 'offline', 'no', 'kanut', NULL, NULL),
(59011145, '59011145', '8443ebd7766f6fe0dd24b6268cb1959a', 'student', '2017-01-17 17:36:18', '2017-03-30 14:32:36', '2017-02-27 12:45:43', 'offline', 'no', NULL, NULL, NULL),
(59011180, '59011180', '29d3ffbfa22c44cd53229950a3eda6f3', 'student', '2017-01-17 17:36:44', '2017-03-21 03:14:44', '2017-02-27 12:45:43', 'offline', 'no', NULL, NULL, NULL),
(59011188, '59011188', '36d38ce0245f17ccc441c837d3dd7c3c', 'student', '2017-01-15 12:55:06', NULL, '2017-02-27 12:45:43', 'offline', 'no', 'kanut', NULL, NULL),
(59011208, '59011208', '95eeb217ee35b8f42667ebf2c987e655', 'student', '2017-01-15 12:55:06', NULL, '2017-02-27 12:45:43', 'offline', 'no', 'kanut', NULL, NULL),
(59011217, '59011217', 'd5aa1c191d1e3f0438e633d970915d78', 'student', '2017-01-15 12:55:06', NULL, '2017-02-27 12:45:43', 'offline', 'no', 'kanut', NULL, NULL),
(59011232, '59011232', 'd1e51adad05f69869e898dad779c89af', 'student', '2017-01-15 12:55:06', NULL, '2017-02-27 12:45:43', 'offline', 'no', 'kanut', NULL, NULL),
(59011239, '59011239', 'd1ce56a910e7a49611d854fc1b471007', 'student', '2017-01-15 12:55:06', NULL, '2017-02-27 12:45:43', 'offline', 'no', 'kanut', NULL, NULL),
(59011255, '59011255', '080de37d6893d51dc8a8332de9bb08d7', 'student', '2017-01-17 17:39:01', '2017-03-30 15:48:08', '2017-02-27 12:45:43', 'offline', 'no', NULL, NULL, NULL),
(59011318, '59011318', '8664d0552c59c90309b6ff93de2ab480', 'student', '2017-01-17 17:39:54', '2017-03-28 18:03:33', '2017-02-27 12:45:43', 'offline', 'no', NULL, NULL, NULL),
(59011352, '59011352', 'b282a3bc2eedebe8d4752e2582180f2f', 'student', '2017-01-17 17:40:21', '2017-04-03 19:09:07', '2017-02-27 12:45:43', 'offline', 'no', NULL, NULL, NULL),
(59011374, '59011374', '9a4440109f1afcb9d94a7b706acab108', 'student', '2017-01-17 17:41:04', '2017-04-30 22:16:11', '2017-02-27 12:45:43', 'offline', 'no', NULL, NULL, NULL),
(59011393, '59011393', '20edfa5e328e7dcc6a3953a65efab8df', 'student', '2017-01-17 17:41:42', '2017-03-30 14:48:40', '2017-02-27 12:45:43', 'offline', 'no', NULL, NULL, NULL),
(59011422, '59011422', 'c080417ad586c10510adb1e645960486', 'student', '2017-01-17 17:42:04', '2017-04-02 15:42:56', '2017-02-27 12:45:43', 'offline', 'no', NULL, NULL, NULL),
(59011428, '59011428', '177ba84a7169b45ecf6423aeb1af7862', 'student', '2017-01-17 17:43:03', '2017-04-17 15:49:14', '2017-02-27 12:45:43', 'offline', 'no', NULL, NULL, NULL),
(59011476, '59011476', '248387260f6e077ce5651b1c0ee66cb9', 'student', '2017-01-15 12:55:06', NULL, '2017-02-27 12:45:43', 'offline', 'no', 'kanut', NULL, NULL),
(59011491, '59011491', '10951a4cf6e92b28585495888b992e28', 'student', '2017-01-15 12:55:06', NULL, '2017-02-27 12:45:43', 'offline', 'no', 'kanut', NULL, NULL),
(59011529, '59011529', '312e5e7afdcaaf81a4a9ec64b8cb633c', 'student', '2017-01-17 17:43:28', '2017-03-27 23:26:12', '2017-02-27 12:45:43', 'offline', 'no', NULL, NULL, NULL),
(59011533, '59011533', 'd25b5650a65cba5ec1611013a6020620', 'student', '2017-01-17 17:43:54', '2017-03-15 19:21:51', '2017-02-27 12:45:43', 'offline', 'no', NULL, NULL, NULL),
(59011544, '59011544', 'aad9ed3b260ca533338ee1d64bfce3a2', 'student', '2017-01-15 12:55:06', NULL, '2017-02-27 12:45:43', 'offline', 'no', 'kanut', NULL, NULL),
(59011566, '59011566', 'aa69ea0c4e3063e3a3442279e5c49a13', 'student', '2017-01-15 12:55:06', NULL, '2017-02-27 12:45:43', 'offline', 'no', 'kanut', NULL, NULL),
(59011577, '59011577', '19eeb6544d5ca133b22df3de04fdef16', 'student', '2017-01-15 12:55:06', NULL, '2017-02-27 12:45:43', 'offline', 'no', 'kanut', NULL, NULL),
(59011609, '59011609', 'b282a3bc2eedebe8d4752e2582180f2f', 'student', '2017-01-17 17:44:34', '2017-04-02 12:16:04', '2017-02-27 12:45:43', 'offline', 'no', NULL, NULL, NULL),
(59111111, '59111111', '2dbcd310a8bb62bb19664adf9d802772', 'student', '2017-02-07 13:09:07', '2017-02-07 13:09:29', '2017-02-27 12:45:43', 'offline', 'no', NULL, NULL, NULL),
(59112233, '59112233', '3af93c46398541f72828d164f7263e61', 'student', '2017-01-07 12:44:15', '2017-07-21 08:59:36', '2017-07-21 09:08:28', 'offline', 'yes', NULL, 0, NULL),
(59112244, '59112244', '2fc88ff25ff370fd3fbfd4f83c9574ae', 'student', '2017-02-14 17:31:28', '2017-02-14 17:31:40', '2017-02-27 12:45:43', 'offline', 'no', NULL, NULL, NULL),
(59123456, '59123456', 'e10adc3949ba59abbe56e057f20f883e', 'student', '2017-02-06 13:05:07', '2017-02-06 13:05:24', '2017-02-27 12:45:43', 'offline', 'no', NULL, NULL, NULL),
(59223344, '59223344', '13732b142e3270d32de2fc5dbcc08632', 'student', '2017-01-26 10:21:02', '2017-02-02 14:35:31', '2017-02-27 12:45:43', 'offline', 'no', 'kanut', NULL, NULL),
(59334455, '59334455', 'b91fbf40d47454fc9901193d3ba96f8a', 'student', '2017-01-26 10:32:45', '2017-01-26 17:28:01', '2017-02-27 12:45:43', 'offline', 'no', 'kanut', NULL, NULL),
(59441533, '59441533', '1935fc85b3851b5a77c6b6c954f61133', 'student', '2017-03-15 19:32:55', '2017-04-09 16:29:13', '2017-03-15 19:32:55', 'offline', 'no', 'kanut', NULL, NULL),
(59776655, '59776655', '09b098e69e4323db5555b09cf0785145', 'student', '2017-02-07 20:14:05', '2017-02-07 20:14:54', '2017-02-27 12:45:43', 'offline', 'no', NULL, NULL, NULL),
(76037603, '76037603', '81dc9bdb52d04dc20036dbd8313ed055', 'student', '2017-01-11 09:45:32', '2017-01-11 14:02:47', '2017-02-27 12:45:43', 'offline', 'no', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
