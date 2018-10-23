-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 23, 2018 at 02:32 PM
-- Server version: 10.1.35-MariaDB
-- PHP Version: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `member`
--

-- --------------------------------------------------------

--
-- Table structure for table `group`
--

CREATE TABLE `group` (
  `id_group` int(11) NOT NULL,
  `groupName` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `groupID` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `crew_sheet_id` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `currentYear` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `member_sheet_id` varchar(45) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `group`
--

INSERT INTO `group` (`id_group`, `groupName`, `groupID`, `crew_sheet_id`, `currentYear`, `member_sheet_id`) VALUES
(73, '暨馬同學會', '11bug-RkV_a0FirVOiNgeBhbRjFsLf3vq', '1x3G0jigHF81fYYvgzOmjo2SUS6MoIrhXXswedQxaS-k', '105', '1x3G0jigHF81fYYvgzOmjo2SUS6MoIrhXXswedQxaS-k');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user_group` int(11) NOT NULL,
  `email` varchar(300) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user_group`, `email`) VALUES
(27, 'junanyeap@gmail.com'),
(28, 'junanbackup@gmail.com'),
(29, 'kanjingterng@gmail.com'),
(30, 's104213070@mail1.ncnu.edu.tw');

-- --------------------------------------------------------

--
-- Table structure for table `useraccessiblegroup`
--

CREATE TABLE `useraccessiblegroup` (
  `uAG_id` int(11) NOT NULL,
  `email` varchar(320) COLLATE utf8_unicode_ci NOT NULL,
  `groupID` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `year` varchar(10) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `useraccessiblegroup`
--

INSERT INTO `useraccessiblegroup` (`uAG_id`, `email`, `groupID`, `year`) VALUES
(21, 'junanyeap@gmail.com', '1NbEH9cTWg3i3gVyC8y-Sz-0Q3dxw2l1G', ''),
(22, 's104213070@mail1.ncnu.edu.tw', '1NbEH9cTWg3i3gVyC8y-Sz-0Q3dxw2l1G', ''),
(23, 'junanbackup@gmail.com', '1NbEH9cTWg3i3gVyC8y-Sz-0Q3dxw2l1G', ''),
(24, 's104213059@mail1.ncnu.edu.tw', '1NbEH9cTWg3i3gVyC8y-Sz-0Q3dxw2l1G', ''),
(25, 'yranyran19@gmail.com', '1NbEH9cTWg3i3gVyC8y-Sz-0Q3dxw2l1G', ''),
(26, 'kanjinterng@gmail.com', '1NbEH9cTWg3i3gVyC8y-Sz-0Q3dxw2l1G', ''),
(39, 'junanyeap@gmail.com', '11bug-RkV_a0FirVOiNgeBhbRjFsLf3vq', '104'),
(40, 'junanbackup@gmail.com', '11bug-RkV_a0FirVOiNgeBhbRjFsLf3vq', '105'),
(41, 'kanjingterng@gmail.com', '11bug-RkV_a0FirVOiNgeBhbRjFsLf3vq', '105'),
(42, 's104213070@mail1.ncnu.edu.tw', '11bug-RkV_a0FirVOiNgeBhbRjFsLf3vq', '105'),
(43, 'junanyeap@gmail.com', '11bug-RkV_a0FirVOiNgeBhbRjFsLf3vq', '105');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `group`
--
ALTER TABLE `group`
  ADD PRIMARY KEY (`id_group`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user_group`);

--
-- Indexes for table `useraccessiblegroup`
--
ALTER TABLE `useraccessiblegroup`
  ADD PRIMARY KEY (`uAG_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `group`
--
ALTER TABLE `group`
  MODIFY `id_group` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user_group` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `useraccessiblegroup`
--
ALTER TABLE `useraccessiblegroup`
  MODIFY `uAG_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
