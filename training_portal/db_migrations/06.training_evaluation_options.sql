-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 29, 2014 at 09:31 AM
-- Server version: 5.5.32
-- PHP Version: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

ALTER TABLE `training_evaluation_options` CHANGE `id_option` `id_option` TINYINT( 3 ) UNSIGNED NOT NULL AUTO_INCREMENT ;
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `training_portal`
--

--
-- Dumping data for table `training_evaluation_options`
--

INSERT INTO `training_evaluation_options` (`id_option`, `name_ar`, `name_en`, `active`, `section_id`) VALUES
(1, '1', '1', 1, 1),
(2, '2', '2', 1, 1),
(3, '3', '3', 1, 1),
(4, '4', '4', 1, 1),
(5, '5', '5', 1, 1),
(6, '1', '1', 1, 2),
(7, '2', '2', 1, 2),
(8, '3', '3', 1, 2),
(9, '4', '4', 1, 2),
(10, '5', '5', 1, 2),
(11, '1', '1', 1, 3),
(12, '2', '2', 1, 3),
(13, '3', '3', 1, 3),
(14, '4', '4', 1, 3),
(15, '5', '5', 1, 3),
(16, '1', '1', 1, 4),
(17, '2', '2', 1, 4),
(18, '3', '3', 1, 4),
(19, '4', '4', 1, 4),
(20, '5', '5', 1, 4);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
