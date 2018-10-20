-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 14, 2018 at 10:38 AM
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
  `groupName` varchar(45) NOT NULL,
  `groupID` varchar(45) NOT NULL,
  `drive_folder_id` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `group`
--

INSERT INTO `group` (`id_group`, `groupName`, `groupID`, `drive_folder_id`) VALUES
(17, '[project]104', '1NbEH9cTWg3i3gVyC8y-Sz-0Q3dxw2l1G', '1jRQ1jr6DlxAv8VbM5z-NopMTcB0DpT1oqHVzM4BYC1o');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user_group` int(11) NOT NULL,
  `email` varchar(320) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user_group`, `email`) VALUES
(23, 'junanyeap@gmail.com'),
(24, 's104213070@mail1.ncnu.edu.tw'),
(25, 'junanbackup@gmail.com'),
(26, 's104213059@mail1.ncnu.edu.tw'),
(27, 'yranyran19@gmail.com'),
(28, 'kanjinterng@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `useraccessiblegroup`
--

CREATE TABLE `useraccessiblegroup` (
  `uAG_id` int(11) NOT NULL,
  `email` varchar(320) NOT NULL,
  `groupID` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `useraccessiblegroup`
--

INSERT INTO `useraccessiblegroup` (`uAG_id`, `email`, `groupID`) VALUES
(21, 'junanyeap@gmail.com', '1NbEH9cTWg3i3gVyC8y-Sz-0Q3dxw2l1G'),
(22, 's104213070@mail1.ncnu.edu.tw', '1NbEH9cTWg3i3gVyC8y-Sz-0Q3dxw2l1G'),
(23, 'junanbackup@gmail.com', '1NbEH9cTWg3i3gVyC8y-Sz-0Q3dxw2l1G'),
(24, 's104213059@mail1.ncnu.edu.tw', '1NbEH9cTWg3i3gVyC8y-Sz-0Q3dxw2l1G'),
(25, 'yranyran19@gmail.com', '1NbEH9cTWg3i3gVyC8y-Sz-0Q3dxw2l1G'),
(26, 'kanjinterng@gmail.com', '1NbEH9cTWg3i3gVyC8y-Sz-0Q3dxw2l1G');

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
  ADD PRIMARY KEY (`id_user_group`,`email`);

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
  MODIFY `id_group` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user_group` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `useraccessiblegroup`
--
ALTER TABLE `useraccessiblegroup`
  MODIFY `uAG_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
