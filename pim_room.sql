-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 11, 2021 at 05:53 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pim_room`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_event`
--

CREATE TABLE `tb_event` (
  `id` int(11) NOT NULL,
  `id_member` varchar(15) NOT NULL,
  `status` int(1) NOT NULL,
  `rooms` int(3) NOT NULL,
  `title` varchar(100) NOT NULL,
  `start` varchar(30) NOT NULL,
  `end` varchar(30) NOT NULL,
  `hour` int(10) NOT NULL,
  `people` int(3) NOT NULL,
  `member` varchar(200) CHARACTER SET utf32 NOT NULL,
  `department` varchar(200) DEFAULT NULL,
  `other` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='ทดสอบปฏิทิน';

--
-- Dumping data for table `tb_event`
--

INSERT INTO `tb_event` (`id`, `id_member`, `status`, `rooms`, `title`, `start`, `end`, `hour`, `people`, `member`, `department`, `other`) VALUES
(102, '1', 1, 1, 'อ่าน/ติวหนังสือ', '2021-05-13T12:00:00', '2021-05-13T13:00:00', 0, 1, 'แอดมิน  ระบบ', 'เจ้าหน้าที่ห้องสมุด', ''),
(104, '1', 2, 1, 'อ่าน/ติวหนังสือ', '2021-05-13T16:00:00', '2021-05-13T17:00:00', 0, 1, 'แอดมิน  ระบบ', 'เจ้าหน้าที่ห้องสมุด', ''),
(99, '1', 1, 1, 'อ่าน/ติวหนังสือ', '2021-05-19T10:00:00', '2021-05-19T11:00:00', 1, 1, 'แอดมิน  ระบบ', 'เจ้าหน้าที่ห้องสมุด', ''),
(111, '6152300355', 0, 3, 'ถ่ายVDO', '2021-05-17T9:00:00', '2021-05-17T11:00:00', 2, 4, 'ภูวพันธุ์ ญาณโกมุท', 'วิศวกรรมศาสตร์และเทคโนโลยี', ''),
(105, '1', 1, 3, 'ประชุมงาน/Presentงาน/ทำงานกลุ่ม', '2021-05-19T15:00:00', '2021-05-19T17:00:00', 2, 3, 'แอดมิน  ระบบ', 'เจ้าหน้าที่ห้องสมุด', ''),
(107, '1', 1, 1, 'อ่าน/ติวหนังสือ', '2021-05-19T11:00:00', '2021-05-19T12:00:00', 1, 1, 'แอดมิน  ระบบ', 'เจ้าหน้าที่ห้องสมุด', ''),
(109, '1', 1, 1, 'อ่าน/ติวหนังสือ', '2021-05-13T08:30:00', '2021-05-13T10:30:00', 2, 4, 'แอดมิน  ระบบ', 'เจ้าหน้าที่ห้องสมุด', ''),
(114, '6152300321', 1, 1, 'อ่าน/ติวหนังสือ', '2021-05-28T08:00:00', '2021-05-28T09:00:00', 1, 1, 'นครินทร์ เสือคนอง', 'วิศวกรรมศาสตร์และเทคโนโลยี', 'ytytyty'),
(136, '1', 1, 1, 'ถ่ายVDO', '2021-06-09T08:00:00', '2021-06-09T10:00:00', 2, 6, 'แอดมิน  ระบบ', 'เจ้าหน้าที่ห้องสมุด', ''),
(137, '1', 1, 2, 'อ่าน/ติวหนังสือ', '2021-06-09T08:00:00', '2021-06-09T09:00:00', 1, 4, 'แอดมิน  ระบบ', 'เจ้าหน้าที่ห้องสมุด', ''),
(131, '1', 3, 1, 'อ่าน/ติวหนังสือ', '2021-06-04T8:01', '2021-06-04T10:00:00', 2, 6, 'แอดมิน  ระบบ', 'เจ้าหน้าที่ห้องสมุด', ''),
(139, '6152300355', 1, 3, 'อ่าน/ติวหนังสือ', '2021-06-10T08:00:00', '2021-06-10T10:00:00', 2, 4, 'ภูวพันธุ์ ญาณโกมุท', 'วิศวกรรมศาสตร์และเทคโนโลยี', ''),
(140, '6152300355', 0, 1, 'อ่าน/ติวหนังสือ', '2021-06-10T10:01:00', '2021-06-10T12:00:00', 2, 6, 'ภูวพันธุ์ ญาณโกมุท', 'วิศวกรรมศาสตร์และเทคโนโลยี', '');

-- --------------------------------------------------------

--
-- Table structure for table `tb_member`
--

CREATE TABLE `tb_member` (
  `id_member` int(10) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `ntitle` varchar(10) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `status` varchar(5) NOT NULL,
  `position` varchar(200) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `active` int(1) NOT NULL,
  `login_date` datetime NOT NULL,
  `login_times` int(6) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_member`
--

INSERT INTO `tb_member` (`id_member`, `username`, `password`, `ntitle`, `firstname`, `surname`, `email`, `status`, `position`, `phone`, `active`, `login_date`, `login_times`, `create_date`) VALUES
(1, 'admin', '123456', 'นาย', 'แอดมิน', 'ระบบ', 'admin@mail.com', 'admin', 'ผู้ดูแลระบบ', '0999999999', 1, '2021-06-09 11:31:39', 141, '2020-07-01 00:00:00'),
(53, 'admin2', '123456', 'นางสาว', 'แอดมิน', 'ระบบ', 'admin@gmail.com', 'admin', 'ผู้ดูแล', '0888888888', 0, '2021-05-29 19:50:48', 2, '2021-05-30 00:44:39');

-- --------------------------------------------------------

--
-- Table structure for table `tb_rooms`
--

CREATE TABLE `tb_rooms` (
  `id_rooms` int(3) NOT NULL,
  `name_rooms` varchar(200) NOT NULL,
  `people_rooms` int(4) NOT NULL,
  `image_rooms` varchar(250) NOT NULL,
  `detail_rooms` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_rooms`
--

INSERT INTO `tb_rooms` (`id_rooms`, `name_rooms`, `people_rooms`, `image_rooms`, `detail_rooms`) VALUES
(4, '4-12A05', 6, 'Room6.jpg', 'จำนวน 6 ที่นั่งอุปกรณ์ ทีวีขนาด 32นิ้ว, HDMI'),
(3, '4-12A04', 6, 'Room6.jpg', 'จำนวน 6 ที่นั่งอุปกรณ์ ทีวีขนาด 32นิ้ว, HDMI'),
(1, '4-12A02', 8, 'Room8.jpg', 'จำนวน 8 ที่นั่ง อุปกรณ์ภายในห้อง Projector, HDMI'),
(2, '4-12A03', 6, 'Room6.jpg', 'จำนวน 6 ที่นั่งอุปกรณ์ ทีวีขนาด 32นิ้ว, HDMI');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_event`
--
ALTER TABLE `tb_event`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_member`
--
ALTER TABLE `tb_member`
  ADD PRIMARY KEY (`id_member`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `tb_rooms`
--
ALTER TABLE `tb_rooms`
  ADD PRIMARY KEY (`id_rooms`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_event`
--
ALTER TABLE `tb_event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT for table `tb_member`
--
ALTER TABLE `tb_member`
  MODIFY `id_member` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `tb_rooms`
--
ALTER TABLE `tb_rooms`
  MODIFY `id_rooms` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
