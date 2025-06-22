-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 22, 2025 at 07:33 PM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `school`
--

-- --------------------------------------------------------

--
-- Table structure for table `advanced_programming`
--

DROP TABLE IF EXISTS `advanced_programming`;
CREATE TABLE IF NOT EXISTS `advanced_programming` (
  `stu_id` int NOT NULL,
  `stu_name` varchar(255) DEFAULT NULL,
  `stu_surname` varchar(255) DEFAULT NULL,
  `stu_mid` int DEFAULT NULL,
  `stu_final` int DEFAULT NULL,
  `absent_days` int DEFAULT NULL,
  `stu_grade_letter` varchar(2) DEFAULT 'FF',
  `stu_grade` float DEFAULT '0',
  PRIMARY KEY (`stu_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `advanced_programming`
--

INSERT INTO `advanced_programming` (`stu_id`, `stu_name`, `stu_surname`, `stu_mid`, `stu_final`, `absent_days`, `stu_grade_letter`, `stu_grade`) VALUES
(1, 'Melike', 'Demir', 60, 88, 0, 'CB', 76.8),
(2, 'Melike Işıl', 'Utal', 70, 90, 2, 'FF', 0),
(3, 'Mehmet Can', 'Cantaş', 85, 70, 1, 'FF', 0);

-- --------------------------------------------------------

--
-- Table structure for table `advanced_programming_attendance`
--

DROP TABLE IF EXISTS `advanced_programming_attendance`;
CREATE TABLE IF NOT EXISTS `advanced_programming_attendance` (
  `stu_id` int NOT NULL,
  `week_no` int NOT NULL,
  PRIMARY KEY (`stu_id`,`week_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `advanced_programming_attendance`
--

INSERT INTO `advanced_programming_attendance` (`stu_id`, `week_no`) VALUES
(1, 1),
(2, 1),
(2, 2),
(3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `machine_learning`
--

DROP TABLE IF EXISTS `machine_learning`;
CREATE TABLE IF NOT EXISTS `machine_learning` (
  `stu_id` int NOT NULL,
  `stu_name` varchar(255) DEFAULT NULL,
  `stu_surname` varchar(255) DEFAULT NULL,
  `stu_mid` int DEFAULT NULL,
  `stu_final` int DEFAULT NULL,
  `absent_days` int DEFAULT NULL,
  `stu_grade_letter` varchar(2) DEFAULT 'FF',
  `stu_grade` float DEFAULT '0',
  PRIMARY KEY (`stu_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `machine_learning`
--

INSERT INTO `machine_learning` (`stu_id`, `stu_name`, `stu_surname`, `stu_mid`, `stu_final`, `absent_days`, `stu_grade_letter`, `stu_grade`) VALUES
(1, 'Melike', 'Demir', 90, 85, 0, 'BA', 87),
(2, 'Melike Işıl', 'Utal', 80, 80, 1, 'FF', 0),
(3, 'Mehmet Can', 'Cantaş', 60, 75, 2, 'FF', 0);

-- --------------------------------------------------------

--
-- Table structure for table `machine_learning_attendance`
--

DROP TABLE IF EXISTS `machine_learning_attendance`;
CREATE TABLE IF NOT EXISTS `machine_learning_attendance` (
  `stu_id` int NOT NULL,
  `week_no` int NOT NULL,
  PRIMARY KEY (`stu_id`,`week_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `machine_learning_attendance`
--

INSERT INTO `machine_learning_attendance` (`stu_id`, `week_no`) VALUES
(1, 1),
(1, 2),
(2, 1),
(3, 1),
(3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
CREATE TABLE IF NOT EXISTS `students` (
  `stu_id` int NOT NULL,
  `stu_name` varchar(255) DEFAULT NULL,
  `stu_surname` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`stu_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`stu_id`, `stu_name`, `stu_surname`) VALUES
(1, 'Melike', 'Demir'),
(2, 'Melike Işıl', 'Utal'),
(3, 'Mehmet Can', 'Cantaş');

-- --------------------------------------------------------

--
-- Table structure for table `web_programming`
--

DROP TABLE IF EXISTS `web_programming`;
CREATE TABLE IF NOT EXISTS `web_programming` (
  `stu_id` int NOT NULL,
  `stu_name` varchar(255) DEFAULT NULL,
  `stu_surname` varchar(255) DEFAULT NULL,
  `stu_mid` int DEFAULT NULL,
  `stu_final` int DEFAULT NULL,
  `absent_days` int DEFAULT NULL,
  `stu_grade` int DEFAULT NULL,
  `stu_grade_letter` varchar(2) DEFAULT 'FF',
  PRIMARY KEY (`stu_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `web_programming`
--

INSERT INTO `web_programming` (`stu_id`, `stu_name`, `stu_surname`, `stu_mid`, `stu_final`, `absent_days`, `stu_grade`, `stu_grade_letter`) VALUES
(1, 'Melike', 'Demir', 70, 80, 2, 76, 'CB'),
(2, 'Melike Işıl', 'Utal', 65, 85, 1, 77, 'CB'),
(3, 'Mehmet Can', 'Cantaş', 75, 80, 3, NULL, 'FF');

-- --------------------------------------------------------

--
-- Table structure for table `web_programming_attendance`
--

DROP TABLE IF EXISTS `web_programming_attendance`;
CREATE TABLE IF NOT EXISTS `web_programming_attendance` (
  `stu_id` int NOT NULL,
  `week_no` int NOT NULL,
  PRIMARY KEY (`stu_id`,`week_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `web_programming_attendance`
--

INSERT INTO `web_programming_attendance` (`stu_id`, `week_no`) VALUES
(1, 1),
(1, 2),
(2, 1),
(3, 1),
(3, 2),
(3, 3);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
