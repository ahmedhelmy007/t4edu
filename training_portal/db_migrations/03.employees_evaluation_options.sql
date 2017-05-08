-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 29, 2014 at 09:13 AM
-- Server version: 5.5.32
-- PHP Version: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

ALTER TABLE `employees_evaluation_options` CHANGE `id_option` `id_option` TINYINT( 3 ) UNSIGNED NOT NULL AUTO_INCREMENT ;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `training_portal`
--

--
-- Dumping data for table `employees_evaluation_options`
--

INSERT INTO `employees_evaluation_options` (`id_option`, `name_ar`, `name_en`, `active`, `section_id`) VALUES
(1, 'نعم', 'Yes', 1, 1),
(2, 'لا', 'No', 1, 1),
(3, 'نعم', 'Yes', 1, 2),
(4, 'لا', 'No', 1, 2);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
