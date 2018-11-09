-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 09, 2018 at 01:48 PM
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
(150, '暨南大學馬來西亞同學會', '1zM4lUnWEMaUEcjPX618lOUcRWaOYUVbq', '19SJsCLSLOSwnfT2Zx8zNvclOqCx2UCJOTsYiPfGirMw', '', '1UBGcpujWwIpoQ81Ccank2DLeNK3JI4mcRpmivLjI0oI'),
(151, '測試測試會', '1fgoBC77fXJ820S58a8zIgnZGqQTosj7J', '1bODk4d6_x5P_I5BBD-YfKCHE8G4xMQzYY_A4FQZTBHk', '', '1gB8VFb7YZFFM-MAnNn2dgXd0DKGcU4Zp3bsM61qEzDA');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `fileId` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `belong` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `pin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `postattach`
--

CREATE TABLE `postattach` (
  `id` int(11) NOT NULL,
  `attachId` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `postId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
(59, 'yranyran19@gmail.com'),
(60, 'junanbackup@gmail.com'),
(61, 'kanjingterng@gmail.com'),
(62, 's104213070@mail1.ncnu.edu.tw'),
(63, 's104213059@mail1.ncnu.edu.tw'),
(64, 'junanyeap@gmail.com'),
(65, 's104213071@mail1.ncnu.edu.tw');

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
(267, 'yranyran19@gmail.com', '1zM4lUnWEMaUEcjPX618lOUcRWaOYUVbq', '104', 89),
(268, 'junanbackup@gmail.com', '1zM4lUnWEMaUEcjPX618lOUcRWaOYUVbq', '105', 89),
(269, 'kanjingterng@gmail.com', '1zM4lUnWEMaUEcjPX618lOUcRWaOYUVbq', '105', 88),
(270, 's104213070@mail1.ncnu.edu.tw', '1zM4lUnWEMaUEcjPX618lOUcRWaOYUVbq', '105', 88),
(271, 's104213059@mail1.ncnu.edu.tw', '1zM4lUnWEMaUEcjPX618lOUcRWaOYUVbq', '104', 88),
(272, 'junanyeap@gmail.com', '1zM4lUnWEMaUEcjPX618lOUcRWaOYUVbq', '105', 99),
(273, 's104213071@mail1.ncnu.edu.tw', '1zM4lUnWEMaUEcjPX618lOUcRWaOYUVbq', '105', 98),
(274, 'yranyran19@gmail.com', '1fgoBC77fXJ820S58a8zIgnZGqQTosj7J', '104', 89),
(275, 'junanbackup@gmail.com', '1fgoBC77fXJ820S58a8zIgnZGqQTosj7J', '105', 89),
(276, 'kanjingterng@gmail.com', '1fgoBC77fXJ820S58a8zIgnZGqQTosj7J', '105', 88),
(277, 's104213070@mail1.ncnu.edu.tw', '1fgoBC77fXJ820S58a8zIgnZGqQTosj7J', '105', 88),
(278, 's104213059@mail1.ncnu.edu.tw', '1fgoBC77fXJ820S58a8zIgnZGqQTosj7J', '104', 88),
(279, 'junanyeap@gmail.com', '1fgoBC77fXJ820S58a8zIgnZGqQTosj7J', '105', 99),
(280, 's104213071@mail1.ncnu.edu.tw', '1fgoBC77fXJ820S58a8zIgnZGqQTosj7J', '105', 98);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `group`
--
ALTER TABLE `group`
  ADD PRIMARY KEY (`id_group`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `postattach`
--
ALTER TABLE `postattach`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id_group` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=152;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `postattach`
--
ALTER TABLE `postattach`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user_group` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `useraccessiblegroup`
--
ALTER TABLE `useraccessiblegroup`
  MODIFY `uAG_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=281;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
