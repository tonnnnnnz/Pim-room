-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 20, 2021 at 06:13 AM
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
  `color` varchar(20) NOT NULL,
  `hour` int(10) NOT NULL,
  `people` int(3) NOT NULL,
  `member` varchar(200) CHARACTER SET utf32 NOT NULL,
  `department` varchar(200) DEFAULT NULL,
  `other` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='ทดสอบปฏิทิน';

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
(1, 'admin', '123456', 'นาย', 'แอดมิน', 'ระบบ', 'admin@mail.com', 'admin', 'ผู้ดูแลระบบ', '0999999999', 1, '2021-06-20 05:58:46', 150, '2020-07-01 00:00:00'),
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;

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
