-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 08, 2018 at 02:16 PM
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
(147, '暨南大學馬來西亞同學會', '1fvWi7jDch_hxiwYfJPH2aSIGCtFTQbzu', '19SJsCLSLOSwnfT2Zx8zNvclOqCx2UCJOTsYiPfGirMw', '105', '1usz2S7u6jS4YXd__ex3h8veQrwkXCrlpXYNdMxAnN1M');

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

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `time`, `title`, `fileId`, `belong`, `type`, `pin`) VALUES
(17, '2018-11-06 14:38:46', 'test1', '1TFu_0f1Pl7IsYJSzM8gIgX9lu-WGj-o5Il3g6jPzZdE', '1fvWi7jDch_hxiwYfJPH2aSIGCtFTQbzu', 2, 0),
(24, '2018-11-08 12:47:58', 'importTant', '1S5P9d3zljvA7BJ7tta3sRzTG6um6p5Xd0dFiYmq7ngg', '1YPIU7jCmaDj8Wt9ZlhwTfO9uTY_eyNeb', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `postattach`
--

CREATE TABLE `postattach` (
  `id` int(11) NOT NULL,
  `attachId` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `postId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `postattach`
--

INSERT INTO `postattach` (`id`, `attachId`, `postId`) VALUES
(17, '1TFu_0f1Pl7IsYJSzM8gIgX9lu-WGj-o5Il3g6jPzZdE', 17),
(18, '1K6tRHHEfgFzrwXWgL1yBIYieaT_DMG8M-m5tbjvHQnQ', 17),
(19, '1usz2S7u6jS4YXd__ex3h8veQrwkXCrlpXYNdMxAnN1M', 17),
(35, '1S5P9d3zljvA7BJ7tta3sRzTG6um6p5Xd0dFiYmq7ngg', 24);

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
(52, 'junanyeap@gmail.com'),
(53, 'junanbackup@gmail.com'),
(54, 'kanjingterng@gmail.com'),
(55, 's104213070@mail1.ncnu.edu.tw'),
(56, 's104213059@mail1.ncnu.edu.tw'),
(57, 'yranyran19@gmail.com'),
(58, 's104213071@mail1.ncnu.edu.tw');

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
(246, 'junanyeap@gmail.com', '1fvWi7jDch_hxiwYfJPH2aSIGCtFTQbzu', '104', 89),
(247, 'junanbackup@gmail.com', '1fvWi7jDch_hxiwYfJPH2aSIGCtFTQbzu', '105', 89),
(248, 'kanjingterng@gmail.com', '1fvWi7jDch_hxiwYfJPH2aSIGCtFTQbzu', '105', 88),
(249, 's104213070@mail1.ncnu.edu.tw', '1fvWi7jDch_hxiwYfJPH2aSIGCtFTQbzu', '105', 88),
(250, 's104213059@mail1.ncnu.edu.tw', '1fvWi7jDch_hxiwYfJPH2aSIGCtFTQbzu', '104', 88),
(251, 'yranyran19@gmail.com', '1fvWi7jDch_hxiwYfJPH2aSIGCtFTQbzu', '105', 99),
(252, 's104213071@mail1.ncnu.edu.tw', '1fvWi7jDch_hxiwYfJPH2aSIGCtFTQbzu', '105', 98);

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
  MODIFY `id_group` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=148;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `postattach`
--
ALTER TABLE `postattach`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user_group` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `useraccessiblegroup`
--
ALTER TABLE `useraccessiblegroup`
  MODIFY `uAG_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=253;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
