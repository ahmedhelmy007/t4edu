-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 29, 2014 at 09:18 AM
-- Server version: 5.5.32
-- PHP Version: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `training_portal`
--

--
-- Dumping data for table `training_evaluation_sections`
--

INSERT INTO `training_evaluation_sections` (`id_section`, `name_ar`, `name_en`, `active`, `created_date`, `created_by`, `modified_date`, `modified_by`) VALUES
(1, 'محتوى البرنامج', 'Program Content', 1, '2014-10-29 00:00:00', NULL, NULL, NULL),
(2, 'المحاضر', 'Instructor', 1, '2014-10-29 00:00:00', NULL, NULL, NULL),
(3, 'القاعة التدريبية', 'Training Venue', 1, '2014-10-29 00:00:00', NULL, NULL, NULL),
(4, 'التقييم العام', 'Overall Evaluation', 1, '2014-10-29 00:00:00', NULL, NULL, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
