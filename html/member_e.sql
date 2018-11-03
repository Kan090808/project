-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 31, 2018 at 03:47 AM
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
(73, '暨馬同學會', '11bug-RkV_a0FirVOiNgeBhbRjFsLf3vq', '1x3G0jigHF81fYYvgzOmjo2SUS6MoIrhXXswedQxaS-k', '105', '1x3G0jigHF81fYYvgzOmjo2SUS6MoIrhXXswedQxaS-k'),
(77, 'testgroup', '1FNWlbEzQxhuQjekZbvyuzAOFEExFl-TY', '1Ei9A0woqv9iQWBPuCEiwgeDwZYhF_MsUvi49dzYRhmI', '105', '1gZktJWaw3VpDiF8AcMdP8_gDOWnnkZJPcvxguxYv3w0');

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
  `year` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `role` int(99) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `useraccessiblegroup`
--

INSERT INTO `useraccessiblegroup` (`uAG_id`, `email`, `groupID`, `year`, `role`) VALUES
(39, 'junanyeap@gmail.com', '11bug-RkV_a0FirVOiNgeBhbRjFsLf3vq', '104', 99),
(40, 'junanbackup@gmail.com', '11bug-RkV_a0FirVOiNgeBhbRjFsLf3vq', '105', 99),
(41, 'kanjingterng@gmail.com', '11bug-RkV_a0FirVOiNgeBhbRjFsLf3vq', '105', 99),
(42, 's104213070@mail1.ncnu.edu.tw', '11bug-RkV_a0FirVOiNgeBhbRjFsLf3vq', '105', 99),
(43, 'junanyeap@gmail.com', '11bug-RkV_a0FirVOiNgeBhbRjFsLf3vq', '105', 99),
(54, 'junanyeap@gmail.com', '1FNWlbEzQxhuQjekZbvyuzAOFEExFl-TY', '104', 0),
(55, 'junanbackup@gmail.com', '1FNWlbEzQxhuQjekZbvyuzAOFEExFl-TY', '105', 99),
(56, 'kanjingterng@gmail.com', '1FNWlbEzQxhuQjekZbvyuzAOFEExFl-TY', '105', 0),
(57, 's104213070@mail1.ncnu.edu.tw', '1FNWlbEzQxhuQjekZbvyuzAOFEExFl-TY', '105', 0),
(58, 'junanyeap@gmail.com', '1FNWlbEzQxhuQjekZbvyuzAOFEExFl-TY', '105', 0);

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
  MODIFY `id_group` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user_group` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `useraccessiblegroup`
--
ALTER TABLE `useraccessiblegroup`
  MODIFY `uAG_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
