-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 27, 2019 at 05:47 PM
-- Server version: 5.7.27-0ubuntu0.18.04.1
-- PHP Version: 7.2.21-1+ubuntu18.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `id` int(11) NOT NULL,
  `grade` int(11) NOT NULL,
  `studendID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`id`, `grade`, `studendID`) VALUES
(1, 10, 1),
(2, 7, 1),
(3, 9, 3),
(4, 7, 5),
(5, 8, 5),
(6, 9, 5),
(7, 10, 7),
(8, 5, 7),
(9, 9, 7),
(10, 6, 9),
(11, 10, 11),
(12, 8, 11),
(13, 5, 11),
(14, 5, 13),
(15, 7, 15),
(16, 7, 15),
(17, 10, 17),
(18, 9, 19),
(19, 5, 21),
(20, 7, 23),
(21, 8, 23),
(22, 7, 23),
(23, 7, 23),
(24, 5, 25),
(25, 10, 25),
(26, 6, 25),
(27, 10, 27),
(28, 9, 29),
(29, 9, 31),
(30, 9, 31),
(31, 6, 33),
(32, 10, 33),
(33, 10, 33),
(34, 7, 35),
(35, 5, 35),
(36, 9, 37),
(37, 6, 37),
(38, 7, 39),
(39, 9, 39),
(40, 10, 39),
(41, 5, 41),
(42, 10, 41),
(43, 9, 41),
(44, 10, 41),
(45, 7, 43),
(46, 10, 45),
(47, 8, 45),
(48, 8, 2),
(49, 8, 2),
(50, 8, 2),
(51, 7, 4),
(52, 5, 4),
(53, 10, 6),
(54, 7, 6),
(55, 8, 6),
(56, 10, 8),
(57, 6, 10),
(58, 7, 12),
(59, 7, 12),
(60, 8, 12),
(61, 6, 14),
(62, 8, 16),
(63, 6, 16),
(64, 6, 18),
(65, 10, 18),
(66, 8, 20),
(67, 7, 20),
(68, 5, 20),
(69, 9, 20),
(70, 10, 22),
(71, 5, 22),
(72, 6, 22),
(73, 10, 24),
(74, 7, 24),
(75, 6, 24),
(76, 5, 24),
(77, 7, 26),
(78, 6, 26),
(79, 6, 28),
(80, 7, 28),
(81, 8, 28),
(82, 5, 30),
(83, 10, 32),
(84, 9, 32),
(85, 5, 32),
(86, 9, 32),
(87, 9, 34),
(88, 8, 34),
(89, 7, 34),
(90, 6, 34),
(91, 9, 36),
(92, 9, 36),
(93, 7, 36),
(94, 10, 36),
(95, 7, 38),
(96, 5, 38),
(97, 9, 40),
(98, 7, 40),
(99, 9, 42),
(100, 5, 44),
(101, 8, 44),
(102, 8, 44);

-- --------------------------------------------------------

--
-- Table structure for table `school`
--

CREATE TABLE `school` (
  `id` int(11) NOT NULL,
  `schoolBoard` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `school`
--

INSERT INTO `school` (`id`, `schoolBoard`) VALUES
(1, 'CSM'),
(2, 'CSMB');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `studentName` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `studentSchool` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `studentName`, `studentSchool`) VALUES
(1, 'Marko', 1),
(2, 'Janko', 2),
(3, 'Žika', 1),
(4, 'Laza', 2),
(5, 'Marica', 1),
(6, 'Radovan', 2),
(7, 'Igor', 1),
(8, 'Perica', 2),
(9, 'Vukota', 1),
(10, 'Miloje', 2),
(11, 'Ana', 1),
(12, 'Obrad', 2),
(13, 'Dušan', 1),
(14, 'Nikola', 2),
(15, 'Andrea', 1),
(16, 'Nataša', 2),
(17, 'Aca', 1),
(18, 'Aleksandar', 2),
(19, 'Jovana', 1),
(20, 'Nebojša', 2),
(21, 'Aleksa', 1),
(22, 'Uroš', 2),
(23, 'Đurđa', 1),
(24, 'Katarina', 2),
(25, 'Branislav', 1),
(26, 'Marija', 2),
(27, 'Ivana', 1),
(28, 'Dušica', 2),
(29, 'Gordana', 1),
(30, 'Jelisaveta', 2),
(31, 'Milena', 1),
(32, 'Mileva', 2),
(33, 'Tanja', 1),
(34, 'Radivoje', 2),
(35, 'Nemanja', 1),
(36, 'Gabrijela', 2),
(37, 'Milica', 1),
(38, 'Anica', 2),
(39, 'Boban', 1),
(40, 'Blagoje', 2),
(41, 'Daniela', 1),
(42, 'Danica', 2),
(43, 'Dragana', 1),
(44, 'Elena', 2),
(45, 'Jasna', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Student_ID` (`studendID`);

--
-- Indexes for table `school`
--
ALTER TABLE `school`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `StudentSchool_ID` (`studentSchool`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `school`
--
ALTER TABLE `school`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `Student_ID` FOREIGN KEY (`studendID`) REFERENCES `students` (`id`);

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `StudentSchool_ID` FOREIGN KEY (`studentSchool`) REFERENCES `school` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
