-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 29, 2014 at 09:09 AM
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
-- Dumping data for table `employees_evaluation_sections`
--

INSERT INTO `employees_evaluation_sections` (`id_section`, `name_ar`, `name_en`, `description_ar`, `description_en`, `active`, `created_date`, `created_by`, `modified_date`, `modified_by`) VALUES
(1, 'الجزء الأول: تقويم أداء الموظف:', 'PART I: EVALUATING THE EMPLOYEE PERFORMANCE:', 'تساعد الأسئلة الآتية في تحديد مستوى الاداء لدى الموظف.', ' The following questions help to identify the employee level of performance.', 1, '2014-10-29 00:00:00', NULL, NULL, NULL),
(2, 'الجزء الثاني: تقويم كفاءة الموظف:', 'PART II: EVALUATING THE EMPLOYEE POTENTIALS:', 'تساعد الأسئلة الآتية في تحديد مستوى الكفاءة لدى الموظف.', ' The following questions help to identify the employee level of potential.', 1, '2014-10-29 00:00:00', NULL, NULL, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
