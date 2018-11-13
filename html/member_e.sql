-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2018 at 04:22 AM
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
-- Table structure for table `activity`
--

CREATE TABLE `activity` (
  `id` int(11) NOT NULL,
  `driveId` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `activityName` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `belong` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `belongYear` int(10) NOT NULL,
  `crewMemberSheet` varchar(45) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `activity`
--

INSERT INTO `activity` (`id`, `driveId`, `activityName`, `belong`, `belongYear`, `crewMemberSheet`) VALUES
(3, '1nUmDApfCFZ8HyHSn7-mxAP4u20aFpIj1', 'testNewActGroup', '1WQzSml-Yd1X3BPo-LSH5gdpMIcGEKwCh', 105, '1sWV5ToyQtSnmwMZpUUaoPsyAj3S-hUdcNfIqTeTPWR8');

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
  `member_sheet_id` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `member_form_id` varchar(45) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `group`
--

INSERT INTO `group` (`id_group`, `groupName`, `groupID`, `crew_sheet_id`, `currentYear`, `member_sheet_id`, `member_form_id`) VALUES
(150, '暨南大學馬來西亞同學會', '1zM4lUnWEMaUEcjPX618lOUcRWaOYUVbq', '19SJsCLSLOSwnfT2Zx8zNvclOqCx2UCJOTsYiPfGirMw', '105', '1UBGcpujWwIpoQ81Ccank2DLeNK3JI4mcRpmivLjI0oI', ''),
(157, '測試測試會', '1WQzSml-Yd1X3BPo-LSH5gdpMIcGEKwCh', '1bODk4d6_x5P_I5BBD-YfKCHE8G4xMQzYY_A4FQZTBHk', '105', '1z94fE0UQnOTnpUXUlBiICphiFO3MQ2yloEJlTCe3_Lg', '');

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
  `pin` tinyint(1) NOT NULL,
  `postBy` varchar(45) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `time`, `title`, `fileId`, `belong`, `type`, `pin`, `postBy`) VALUES
(26, '2018-11-12 02:54:04', 'RURURURU', '1DVyprJiZ3KXzLaIw5E4rf4fFRAGM1lw0nl8Dh_tNBYE', '1WQzSml-Yd1X3BPo-LSH5gdpMIcGEKwCh', 2, 0, 'junanyeap@gmail.com');

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
(39, '1DVyprJiZ3KXzLaIw5E4rf4fFRAGM1lw0nl8Dh_tNBYE', 26);

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
(272, 'junanyeap@gmail.com1', '1zM4lUnWEMaUEcjPX618lOUcRWaOYUVbq', '105', 99),
(273, 's104213071@mail1.ncnu.edu.tw', '1zM4lUnWEMaUEcjPX618lOUcRWaOYUVbq', '105', 98),
(316, 'yranyran19@gmail.com', '1WQzSml-Yd1X3BPo-LSH5gdpMIcGEKwCh', '104', 89),
(317, 's104213059@mail1.ncnu.edu.tw', '1WQzSml-Yd1X3BPo-LSH5gdpMIcGEKwCh', '105', 89),
(318, 'junanyeap@gmail.com', '1WQzSml-Yd1X3BPo-LSH5gdpMIcGEKwCh', '105', 99),
(319, 's104213070@mail1.ncnu.edu.tw', '1WQzSml-Yd1X3BPo-LSH5gdpMIcGEKwCh', '106', 99),
(320, 'kanjingterng@gmail.com', '1WQzSml-Yd1X3BPo-LSH5gdpMIcGEKwCh', '106', 99);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `activity`
--
ALTER TABLE `activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `group`
--
ALTER TABLE `group`
  MODIFY `id_group` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=158;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `postattach`
--
ALTER TABLE `postattach`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user_group` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `useraccessiblegroup`
--
ALTER TABLE `useraccessiblegroup`
  MODIFY `uAG_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=321;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
