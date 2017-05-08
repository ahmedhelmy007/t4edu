-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 29, 2014 at 09:26 AM
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
-- Dumping data for table `training_evaluation_criterias`
--

INSERT INTO `training_evaluation_criterias` (`id_criteria`, `name_ar`, `name_en`, `section_id`, `active`, `created_date`, `created_by`, `modified_date`, `modified_by`) VALUES
(1, 'كان الموضوع واهداف البرنامج التدريبي محددة بشكل واضح', 'The topic was clearly defined and training objectives were clearly stated', 1, 1, '2014-10-29 00:00:00', NULL, NULL, NULL),
(2, 'البرنامج التدريبي كان متوازي بين التطبيق العملي والنظري', 'The Training topic was balanced between theory and practice', 1, 1, '2014-10-29 00:00:00', NULL, NULL, NULL),
(3, 'المحتوى التدريبي كان منظماً وسهل الإتباع', 'The content was organized and easy to follow', 1, 1, '2014-10-29 00:00:00', NULL, NULL, NULL),
(4, 'البرنامج التدريبي غطى جميع النواحي المتوقعة منه', 'The training covered everything I had expected it to', 1, 1, '2014-10-29 00:00:00', NULL, NULL, NULL),
(5, 'تمارين البرنامج التدريبي كانت مناسبة', 'The case studies and exercises were sufficient', 1, 1, '2014-10-29 00:00:00', NULL, NULL, NULL),
(6, 'جدول البرنامج التدريبي كان مناسب لتغطية جميع النشاطات المقترحة', 'The schedule for the training provided sufficient time to cover all of the proposed activities.', 1, 1, '2014-10-29 00:00:00', NULL, NULL, NULL),
(7, 'يمتلك المحاضر المعرفة حول البرنامج التدريبي', 'The instructor was knowledgeable about the program', 2, 1, '2014-10-29 00:00:00', NULL, NULL, NULL),
(8, 'كان المحاضر منظم ومجهز', 'The instructor was well organized and prepared', 2, 1, '2014-10-29 00:00:00', NULL, NULL, NULL),
(9, 'اجاب المحاضر على الأسئلة بصورة كاملة وواضحة', 'The instructor answered questions in a complete and clear manner', 2, 1, '2014-10-29 00:00:00', NULL, NULL, NULL),
(10, 'كان هنالك الوقت الكافي للنقاش والأسئلة', 'Adequate time was provided for questions and discussion', 2, 1, '2014-10-29 00:00:00', NULL, NULL, NULL),
(11, 'مكان انعقاد البرنامج التدريبي سهل الوصول إليه', 'The location of the training venue was easy to reach', 3, 1, '2014-10-29 00:00:00', NULL, NULL, NULL),
(12, 'كان إعداد الأجهزة الصوتية والمرئية جيد', 'Good training aids and audio-visual aids were used', 3, 1, '2014-10-29 00:00:00', NULL, NULL, NULL),
(13, 'إعداد القاعة التدريبية والتجهيزات المرافقة مريح ومجهز بشكل جيد ', 'The Training room and related facilities provided a comfortable setting for the training', 3, 1, '2014-10-29 00:00:00', NULL, NULL, NULL),
(14, 'الوجبات الخفيفة والغذاء المقدمة كانت ذو جودة عالية (إذا تم تقديمة)', 'The refreshments and food provided were of high quality (If Provided)', 3, 1, '2014-10-29 00:00:00', NULL, NULL, NULL),
(15, 'الرجاء تقييم رضاءك بشكل عام حول هذا البرنامج التدريبي', 'Please evaluate your overall satisfaction the program', 4, 1, '2014-10-29 00:00:00', NULL, NULL, NULL),
(16, 'الرجاء تقييم المدرب بشكل عام', 'Please evaluate the instructor overall', 4, 1, '2014-10-29 00:00:00', NULL, NULL, NULL),
(17, 'الرجاء تقييم رضاءك بشكل عام حول تجهيزات القاعة التدريبية', 'Please evaluate your overall satisfaction about the class participation', 4, 1, '2014-10-29 00:00:00', NULL, NULL, NULL),
(18, 'البرنامج التدريبي حقق الأهداف المحددة منه ', 'The Training met the stated objectives', 4, 1, '2014-10-29 00:00:00', NULL, NULL, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
