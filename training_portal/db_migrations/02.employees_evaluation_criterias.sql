-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 29, 2014 at 09:07 AM
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
-- Dumping data for table `employees_evaluation_criterias`
--

INSERT INTO `employees_evaluation_criterias` (`id_criteria`, `name_ar`, `name_en`, `section_id`, `active`, `created_date`, `created_by`, `modified_date`, `modified_by`) VALUES
(1, 'هل تجد لدى الموظف أداء يفوق التوقعات في مجال واحد من مجالات الأداء؟', 'Do you find the employee has exceeded performance expectations in one of the areas of performance?', 1, 1, '2014-10-29 00:00:00', NULL, NULL, NULL),
(2, 'هل ترى أن هذا الموظف يتجاوز التوقعات في معظم (أو كل) مجالات الأداء؟', 'Do you see that this employee exceeds expectations in most (or all) areas of performance?', 1, 1, '2014-10-29 00:00:00', NULL, NULL, NULL),
(3, 'هل يلبي هذا الموظف التوقعات أو يتفوق عليها في جميع مجالات الأداء؟', 'Is this employee meets expectations or outdone in all areas of performance?', 1, 1, '2014-10-29 00:00:00', NULL, NULL, NULL),
(4, 'هل تجد هذا الموظف مساهماً مهماً في عمل الفريق وفي الشركة عموماً؟', 'Do you find this employee as an important contributor to the in the company and in the team work in general?', 1, 1, '2014-10-29 00:00:00', NULL, NULL, NULL),
(5, 'هل يتصرف هذا الموظف وفق تغذية راجعة تصحيحية للأداء لكي يحسن أداءه؟', 'Does the employee act in accordance with the corrective feedback in order to improve his performance?', 1, 1, '2014-10-29 00:00:00', NULL, NULL, NULL),
(6, 'هل سبق وقدمت لهذا الموظف مكافآت مهمة وخاصة في مجال الأداء (مثل علاوة خاصة، شهادة تقدير ... إلخ)؟', 'Have you ever given bonuses for this employee, in the area of performance (such as a special bonus, a certificate of appreciation ... etc.)?', 1, 1, '2014-10-29 00:00:00', NULL, NULL, NULL),
(7, 'هل بمقدور هذا الموظف تقديم أداء بمستوى أعلى في موقع آخر أو أن يكلف بمسؤوليات أكثر خلال العام القادم؟ (نفكر فقط بمقدرته دون التفكير فيما إذا كان الموقع متاحاً ويدعم نموه)', 'Is the employee able to perform a higher performance in another location or to be assigned more responsibilities over the next year?', 2, 1, '2014-10-29 00:00:00', NULL, NULL, NULL),
(8, 'هل بمقدور هذا الموظف تقديم أداء بمستوى أعلى في موقع آخر أو ان يكلّف بمسؤوليات أكثر خلال الأعوام الثلاثة القادمة؟ (نفكر فقط بمقدرته دون التفكير فيما إذا كان الموقع متاحاً ويدعم نموه)', 'Is the employee able to perform a higher performance in another location or to be assigned more responsibilities during the next three years?', 2, 1, '2014-10-29 00:00:00', NULL, NULL, NULL),
(9, 'هل يمكن تصور هذا الموظف وهو يقوم بأداء في مستوى أعلى من موقعه الحالي بمستويين بعد خمس أو ست سنوات من الآن؟', 'Can you imagine this employee, which performs at a higher level from his current level at two levels higher after five or six years from now?', 2, 1, '2014-10-29 00:00:00', NULL, NULL, NULL),
(10, 'هل من الممكن أن تتحمل الشركة نمو مهارات وكفاءات هذا الموظف على مدى السنوات القادمة؟', 'Is it possible the company to bear growth in skills and competencies of the employee over the coming years?', 2, 1, '2014-10-29 00:00:00', NULL, NULL, NULL),
(11, 'هل بمقدور هذا الموظف أن يتعلم مهارات وكفاءات إضافية يحتاجها ليتمكن من الأداء بمستوى أعلى أو مختلف؟', 'Is this employee able to learn additional skills and competencies needed to be able to perform higher or different?', 2, 1, '2014-10-29 00:00:00', NULL, NULL, NULL),
(12, 'هل تظهر على هذا الموظف قدرات قيادية – اتخاذ زمام الأمور المبادرة مثلاً، أو إبداء الرؤية، أو الوفاء بوعود قطعها بخصوص النتائج، التواصل بطريقة فعالة؟', 'Does it appear that the employee has leadership abilities - to take initiatives, for example, express vision, or fulfill promises made regarding the results or communicate in an effective manner?', 2, 1, '2014-10-29 00:00:00', NULL, NULL, NULL),
(13, 'هل تظهر على هذا الموظف مقدرة التفاعل بارتياح مع أشخاص في مستوى أعلى من مستواه أو في مجالات عمل تختلف عن مجاله؟', 'Does it appear that the employee has the ability to interact comfortably with people at higher level than his or in different areas of work than his respective fields?', 2, 1, '2014-10-29 00:00:00', NULL, NULL, NULL),
(14, 'هل تظهر على هذا الموظف علامات ارتياح إذا كان للشركة منظور أكثر اتساعاً مما يقتضيه عمله الحالي؟', 'Does it appear that the employee signs of relief if the company has a wider perspective than required by current work?', 2, 1, '2014-10-29 00:00:00', NULL, NULL, NULL),
(15, 'هل يبدي هذا الموظف مرونة وحماسةً للانتقال إلى مجال عمل قد يختلف عن أي مجال عمل آخر موجود حالياً؟', 'Is the employee flexible and enthusiasm to move to another area of work which may differ from any area of work or currently exist?', 2, 1, '2014-10-29 00:00:00', NULL, NULL, NULL),
(16, 'هل يرحب هذا الموظف بالفرص التي تتاح له للتعلم والتطور؟', 'Is the employee welcomes the opportunities that are available to him for learning and development?', 2, 1, '2014-10-29 00:00:00', NULL, NULL, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
