-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 04, 2022 at 06:44 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.0.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project_database`
--
CREATE DATABASE IF NOT EXISTS `project_database` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `project_database`;

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE IF NOT EXISTS `account` (
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `phoneNumber` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `fullname` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `gender` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `birthday` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `idCard_front` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `idCard_back` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `initialPassword` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `wrongPassCount` int(10) DEFAULT 0,
  `deleted` tinyint(1) DEFAULT 0,
  `active` tinyint(1) DEFAULT 0,
  `role` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT 'pending',
  `createdAt` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '0',
  `updatedAt` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '0',
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`email`, `phoneNumber`, `fullname`, `gender`, `address`, `birthday`, `idCard_front`, `idCard_back`, `password`, `initialPassword`, `wrongPassCount`, `deleted`, `active`, `role`, `createdAt`, `updatedAt`) VALUES
('truonggiangit793@gmail.com', '0702907154', 'Phạm Trường Giang', 'Male', '793/49/3 Trần Xuân Soạn, Tân Hưng, Quận 7, HCM', '986213568000', 'http://localhost/public/assest/img/uploads/bf2fb4c8ff7e99592437_AnyConv.com%2032690b7c2eb039d076c73cadaeb27a8c.png', 'http://localhost/public/assest/img/uploads/bf2fb4c8ff7e99592437_AnyConv.com%2032690b7c2eb039d076c73cadaeb27a8c.png', '$2y$10$87q6YIRspzNxDeGCeXp9v.VTDMeL.STqRH7lVjD5/quv4xihpxBAC', 'NULL', 0, 0, 0, 'pending', '1646324757', '1646409143');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
