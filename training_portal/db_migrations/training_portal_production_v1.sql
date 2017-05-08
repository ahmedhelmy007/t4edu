-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 18, 2015 at 08:14 AM
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
CREATE DATABASE IF NOT EXISTS `training_portal` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `training_portal`;

-- --------------------------------------------------------

--
-- Table structure for table `budgets`
--

CREATE TABLE IF NOT EXISTS `budgets` (
  `id_budget` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_budget`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `id` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `name_ar` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `name_en` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name_ar`, `name_en`) VALUES
('AD', 'أندورا', 'Andorra'),
('AE', 'الامارات العربية المتحدة', 'United Arab Emirates'),
('AF', 'أفغانستان', 'Afghanistan'),
('AG', 'أنتيجوا وبربودا', 'Antigua and Barbuda'),
('AI', 'أنجويلا', 'Anguilla'),
('AL', 'ألبانيا', 'Albania'),
('AM', 'أرمينيا', 'Armenia'),
('AN', 'جزر الأنتيل الهولندية', 'Netherlands Antilles'),
('AO', 'أنجولا', 'Angola'),
('AQ', 'القطب الجنوبي', 'Antarctica'),
('AR', 'الأرجنتين', 'Argentina'),
('AS', 'ساموا الأمريكية', 'American Samoa'),
('AT', 'النمسا', 'Austria'),
('AU', 'أستراليا', 'Australia'),
('AW', 'آروبا', 'Aruba'),
('AX', 'جزر أولان', 'Åland Islands'),
('AZ', 'أذربيجان', 'Azerbaijan'),
('BA', 'البوسنة والهرسك', 'Bosnia and Herzegovina'),
('BB', 'بربادوس', 'Barbados'),
('BD', 'بنجلاديش', 'Bangladesh'),
('BE', 'بلجيكا', 'Belgium'),
('BF', 'بوركينا فاسو', 'Burkina Faso'),
('BG', 'بلغاريا', 'Bulgaria'),
('BH', 'البحرين', 'Bahrain'),
('BI', 'بوروندي', 'Burundi'),
('BJ', 'بنين', 'Benin'),
('BM', 'برمودا', 'Bermuda'),
('BN', 'بروناي', 'Brunei'),
('BO', 'بوليفيا', 'Bolivia'),
('BR', 'البرازيل', 'Brazil'),
('BS', 'الباهاما', 'Bahamas'),
('BT', 'بوتان', 'Bhutan'),
('BV', 'جزيرة بوفيه', 'Bouvet Island'),
('BW', 'بتسوانا', 'Botswana'),
('BY', 'روسيا البيضاء', 'Belarus'),
('BZ', 'بليز', 'Belize'),
('CA', 'كندا', 'Canada'),
('CC', 'جزر كوكوس', 'Cocos [Keeling] Islands'),
('CD', 'جمهورية الكونغو الديمقراطية', 'Congo - Kinshasa'),
('CF', 'جمهورية افريقيا الوسطى', 'Central African Republic'),
('CG', 'الكونغو - برازافيل', 'Congo - Brazzaville'),
('CH', 'سويسرا', 'Switzerland'),
('CI', 'ساحل العاج', 'Côte d’Ivoire'),
('CK', 'جزر كوك', 'Cook Islands'),
('CL', 'شيلي', 'Chile'),
('CM', 'الكاميرون', 'Cameroon'),
('CN', 'الصين', 'China'),
('CO', 'كولومبيا', 'Colombia'),
('CR', 'كوستاريكا', 'Costa Rica'),
('CS', 'صربيا والجبل الأسود', 'Serbia and Montenegro'),
('CU', 'كوبا', 'Cuba'),
('CV', 'الرأس الأخضر', 'Cape Verde'),
('CX', 'جزيرة الكريسماس', 'Christmas Island'),
('CY', 'قبرص', 'Cyprus'),
('CZ', 'جمهورية التشيك', 'Czech Republic'),
('DE', 'ألمانيا', 'Germany'),
('DJ', 'جيبوتي', 'Djibouti'),
('DK', 'الدانمرك', 'Denmark'),
('DM', 'دومينيكا', 'Dominica'),
('DO', 'جمهورية الدومينيك', 'Dominican Republic'),
('DZ', 'الجزائر', 'Algeria'),
('EC', 'الاكوادور', 'Ecuador'),
('EE', 'استونيا', 'Estonia'),
('EG', 'مصر', 'Egypt'),
('EH', 'الصحراء الغربية', 'Western Sahara'),
('ER', 'اريتريا', 'Eritrea'),
('ES', 'أسبانيا', 'Spain'),
('ET', 'اثيوبيا', 'Ethiopia'),
('FI', 'فنلندا', 'Finland'),
('FJ', 'فيجي', 'Fiji'),
('FK', 'جزر فوكلاند', 'Falkland Islands'),
('FM', 'ميكرونيزيا', 'Micronesia'),
('FO', 'جزر فارو', 'Faroe Islands'),
('FR', 'فرنسا', 'France'),
('GA', 'الجابون', 'Gabon'),
('GB', 'المملكة المتحدة', 'United Kingdom'),
('GD', 'جرينادا', 'Grenada'),
('GE', 'جورجيا', 'Georgia'),
('GF', 'غويانا', 'French Guiana'),
('GH', 'غانا', 'Ghana'),
('GI', 'جبل طارق', 'Gibraltar'),
('GL', 'جرينلاند', 'Greenland'),
('GM', 'غامبيا', 'Gambia'),
('GN', 'غينيا', 'Guinea'),
('GP', 'جوادلوب', 'Guadeloupe'),
('GQ', 'غينيا الاستوائية', 'Equatorial Guinea'),
('GR', 'اليونان', 'Greece'),
('GS', 'جورجيا الجنوبية وجزر ساندويتش الجنوبية', 'South Georgia and the South Sandwich Islands'),
('GT', 'جواتيمالا', 'Guatemala'),
('GU', 'جوام', 'Guam'),
('GW', 'غينيا بيساو', 'Guinea-Bissau'),
('GY', 'غيانا', 'Guyana'),
('HK', 'هونج كونج الصينية', 'Hong Kong SAR China'),
('HM', 'جزيرة هيرد وماكدونالد', 'Heard Island and McDonald Islands'),
('HN', 'هندوراس', 'Honduras'),
('HR', 'كرواتيا', 'Croatia'),
('HT', 'هايتي', 'Haiti'),
('HU', 'المجر', 'Hungary'),
('ID', 'اندونيسيا', 'Indonesia'),
('IE', 'أيرلندا', 'Ireland'),
('IL', 'اسرائيل', 'Israel'),
('IM', 'جزيرة مان', 'Isle of Man'),
('IN', 'الهند', 'India'),
('IO', 'المحيط الهندي البريطاني', 'British Indian Ocean Territory'),
('IQ', 'العراق', 'Iraq'),
('IR', 'ايران', 'Iran'),
('IS', 'أيسلندا', 'Iceland'),
('IT', 'ايطاليا', 'Italy'),
('JE', 'جيرسي', 'Jersey'),
('JM', 'جامايكا', 'Jamaica'),
('JO', 'الأردن', 'Jordan'),
('JP', 'اليابان', 'Japan'),
('KE', 'كينيا', 'Kenya'),
('KG', 'قرغيزستان', 'Kyrgyzstan'),
('KH', 'كمبوديا', 'Cambodia'),
('KI', 'كيريباتي', 'Kiribati'),
('KM', 'جزر القمر', 'Comoros'),
('KN', 'سانت كيتس ونيفيس', 'Saint Kitts and Nevis'),
('KP', 'كوريا الشمالية', 'North Korea'),
('KR', 'كوريا الجنوبية', 'South Korea'),
('KW', 'الكويت', 'Kuwait'),
('KY', 'جزر الكايمن', 'Cayman Islands'),
('KZ', 'كازاخستان', 'Kazakhstan'),
('LA', 'لاوس', 'Laos'),
('LB', 'لبنان', 'Lebanon'),
('LC', 'سانت لوسيا', 'Saint Lucia'),
('LI', 'ليختنشتاين', 'Liechtenstein'),
('LK', 'سريلانكا', 'Sri Lanka'),
('LR', 'ليبيريا', 'Liberia'),
('LS', 'ليسوتو', 'Lesotho'),
('LT', 'ليتوانيا', 'Lithuania'),
('LU', 'لوكسمبورج', 'Luxembourg'),
('LV', 'لاتفيا', 'Latvia'),
('LY', 'ليبيا', 'Libya'),
('MA', 'المغرب', 'Morocco'),
('MC', 'موناكو', 'Monaco'),
('MD', 'مولدافيا', 'Moldova'),
('ME', 'الجبل الأسود', 'Montenegro'),
('MF', 'سانت مارتين', 'Saint Martin'),
('MG', 'مدغشقر', 'Madagascar'),
('MH', 'جزر المارشال', 'Marshall Islands'),
('MK', 'مقدونيا', 'Macedonia'),
('ML', 'مالي', 'Mali'),
('MM', 'ميانمار', 'Myanmar [Burma]'),
('MN', 'منغوليا', 'Mongolia'),
('MO', 'ماكاو الصينية', 'Macau SAR China'),
('MP', 'جزر ماريانا الشمالية', 'Northern Mariana Islands'),
('MQ', 'مارتينيك', 'Martinique'),
('MR', 'موريتانيا', 'Mauritania'),
('MS', 'مونتسرات', 'Montserrat'),
('MT', 'مالطا', 'Malta'),
('MU', 'موريشيوس', 'Mauritius'),
('MV', 'جزر الملديف', 'Maldives'),
('MW', 'ملاوي', 'Malawi'),
('MX', 'المكسيك', 'Mexico'),
('MY', 'ماليزيا', 'Malaysia'),
('MZ', 'موزمبيق', 'Mozambique'),
('NA', 'ناميبيا', 'Namibia'),
('NC', 'كاليدونيا الجديدة', 'New Caledonia'),
('NE', 'النيجر', 'Niger'),
('NF', 'جزيرة نورفوك', 'Norfolk Island'),
('NG', 'نيجيريا', 'Nigeria'),
('NI', 'نيكاراجوا', 'Nicaragua'),
('NL', 'هولندا', 'Netherlands'),
('NO', 'النرويج', 'Norway'),
('NP', 'نيبال', 'Nepal'),
('NR', 'نورو', 'Nauru'),
('NU', 'نيوي', 'Niue'),
('NZ', 'نيوزيلاندا', 'New Zealand'),
('OM', 'عمان', 'Oman'),
('PA', 'بنما', 'Panama'),
('PE', 'بيرو', 'Peru'),
('PF', 'بولينيزيا الفرنسية', 'French Polynesia'),
('PG', 'بابوا غينيا الجديدة', 'Papua New Guinea'),
('PH', 'الفيلبين', 'Philippines'),
('PK', 'باكستان', 'Pakistan'),
('PL', 'بولندا', 'Poland'),
('PM', 'سانت بيير وميكولون', 'Saint Pierre and Miquelon'),
('PN', 'بتكايرن', 'Pitcairn Islands'),
('PR', 'بورتوريكو', 'Puerto Rico'),
('PS', 'فلسطين', 'Palestinian Territories'),
('PT', 'البرتغال', 'Portugal'),
('PW', 'بالاو', 'Palau'),
('PY', 'باراجواي', 'Paraguay'),
('QA', 'قطر', 'Qatar'),
('RE', 'روينيون', 'Réunion'),
('RO', 'رومانيا', 'Romania'),
('RS', 'صربيا', 'Serbia'),
('RU', 'روسيا', 'Russia'),
('RW', 'رواندا', 'Rwanda'),
('SA', 'المملكة العربية السعودية', 'Saudi Arabia'),
('SB', 'جزر سليمان', 'Solomon Islands'),
('SC', 'سيشل', 'Seychelles'),
('SD', 'السودان', 'Sudan'),
('SE', 'السويد', 'Sweden'),
('SG', 'سنغافورة', 'Singapore'),
('SH', 'سانت هيلنا', 'Saint Helena'),
('SI', 'سلوفينيا', 'Slovenia'),
('SJ', 'سفالبارد وجان مايان', 'Svalbard and Jan Mayen'),
('SK', 'سلوفاكيا', 'Slovakia'),
('SL', 'سيراليون', 'Sierra Leone'),
('SM', 'سان مارينو', 'San Marino'),
('SN', 'السنغال', 'Senegal'),
('SO', 'الصومال', 'Somalia'),
('SR', 'سورينام', 'Suriname'),
('ST', 'ساو تومي وبرينسيبي', 'São Tomé and Príncipe'),
('SV', 'السلفادور', 'El Salvador'),
('SY', 'سوريا', 'Syria'),
('SZ', 'سوازيلاند', 'Swaziland'),
('TC', 'جزر الترك وجايكوس', 'Turks and Caicos Islands'),
('TD', 'تشاد', 'Chad'),
('TF', 'المقاطعات الجنوبية الفرنسية', 'French Southern Territories'),
('TG', 'توجو', 'Togo'),
('TH', 'تايلند', 'Thailand'),
('TJ', 'طاجكستان', 'Tajikistan'),
('TK', 'توكيلو', 'Tokelau'),
('TL', 'تيمور الشرقية', 'Timor-Leste'),
('TM', 'تركمانستان', 'Turkmenistan'),
('TN', 'تونس', 'Tunisia'),
('TO', 'تونجا', 'Tonga'),
('TR', 'تركيا', 'Turkey'),
('TT', 'ترينيداد وتوباغو', 'Trinidad and Tobago'),
('TV', 'توفالو', 'Tuvalu'),
('TW', 'تايوان', 'Taiwan'),
('TZ', 'تانزانيا', 'Tanzania'),
('UA', 'أوكرانيا', 'Ukraine'),
('UG', 'أوغندا', 'Uganda'),
('UM', 'جزر الولايات المتحدة البعيدة الصغيرة', 'U.S. Minor Outlying Islands'),
('US', 'الولايات المتحدة الأمريكية', 'United States'),
('UY', 'أورجواي', 'Uruguay'),
('UZ', 'أوزبكستان', 'Uzbekistan'),
('VA', 'الفاتيكان', 'Vatican City'),
('VC', 'سانت فنسنت وغرنادين', 'Saint Vincent and the Grenadines'),
('VE', 'فنزويلا', 'Venezuela'),
('VG', 'جزر فرجين البريطانية', 'British Virgin Islands'),
('VI', 'جزر فرجين الأمريكية', 'U.S. Virgin Islands'),
('VN', 'فيتنام', 'Vietnam'),
('VU', 'فانواتو', 'Vanuatu'),
('WF', 'جزر والس وفوتونا', 'Wallis and Futuna'),
('WS', 'ساموا', 'Samoa'),
('YE', 'اليمن', 'Yemen'),
('YT', 'مايوت', 'Mayotte'),
('ZA', 'جمهورية جنوب افريقيا', 'South Africa'),
('ZM', 'زامبيا', 'Zambia'),
('ZW', 'زيمبابوي', 'Zimbabwe'),
('ZZ', 'منطقة غير معرفة', 'Unknown or Invalid Region');

-- --------------------------------------------------------

--
-- Table structure for table `department_budgets`
--

CREATE TABLE IF NOT EXISTS `department_budgets` (
  `id_dept_budget` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `budget_id` tinyint(3) unsigned DEFAULT NULL,
  `department_id` int(10) unsigned DEFAULT NULL,
  `original_value` int(10) unsigned DEFAULT NULL,
  `remaining_value` int(10) unsigned DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `modified_by` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id_dept_budget`),
  UNIQUE KEY `budget_id` (`budget_id`,`department_id`),
  KEY `department_budgets_budgetid_fk_idx` (`budget_id`),
  KEY `department_budgets_createdby_idx` (`created_by`),
  KEY `department_budgets_modifiedby_fk_idx` (`modified_by`),
  KEY `department_budgets_deptid_fk_idx` (`department_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

--
-- Table structure for table `employees_evaluations`
--

CREATE TABLE IF NOT EXISTS `employees_evaluations` (
  `id_evaluation` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` int(10) unsigned NOT NULL,
  `group_id` int(10) unsigned NOT NULL,
  `evaluation_period_id` tinyint(3) unsigned NOT NULL,
  `created_date` datetime DEFAULT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `modified_by` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id_evaluation`),
  KEY `employees_evaluations_employeeid_fk_idx` (`employee_id`),
  KEY `employees_evaluations_evalperiodid_fk_idx` (`evaluation_period_id`),
  KEY `employees_evaluations_createdby_fk_idx` (`created_by`),
  KEY `employees_evaluations_modifiedby_fk_idx` (`modified_by`),
  KEY `employees_evaluations_groupid_fk_idx` (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- Table structure for table `employees_evaluation_criterias`
--

CREATE TABLE IF NOT EXISTS `employees_evaluation_criterias` (
  `id_criteria` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name_ar` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name_en` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `section_id` tinyint(3) unsigned DEFAULT NULL,
  `active` tinyint(4) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `modified_by` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id_criteria`),
  KEY `employees_evaluation_criterias_sectionid_fk_idx` (`section_id`),
  KEY `employees_evaluation_criterias_createdby_fk_idx` (`created_by`),
  KEY `employees_evaluation_criterias_modifiedby_fk_idx` (`modified_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=17 ;

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

-- --------------------------------------------------------

--
-- Table structure for table `employees_evaluation_options`
--

CREATE TABLE IF NOT EXISTS `employees_evaluation_options` (
  `id_option` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name_ar` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name_en` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(4) DEFAULT NULL,
  `section_id` tinyint(3) unsigned DEFAULT NULL,
  PRIMARY KEY (`id_option`),
  KEY `employees_evaluation_options_sectionid_fk_idx` (`section_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `employees_evaluation_options`
--

INSERT INTO `employees_evaluation_options` (`id_option`, `name_ar`, `name_en`, `active`, `section_id`) VALUES
(1, 'نعم', 'Yes', 1, 1),
(2, 'لا', 'No', 1, 1),
(3, 'نعم', 'Yes', 1, 2),
(4, 'لا', 'No', 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `employees_evaluation_sections`
--

CREATE TABLE IF NOT EXISTS `employees_evaluation_sections` (
  `id_section` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name_ar` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name_en` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description_ar` text COLLATE utf8_unicode_ci,
  `description_en` text COLLATE utf8_unicode_ci,
  `active` tinyint(4) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `modified_by` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id_section`),
  KEY `employees_evaluation_sections_createdby_fk_idx` (`created_by`),
  KEY `employees_evaluation_sections_modifiedby_fk_idx` (`modified_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `employees_evaluation_sections`
--

INSERT INTO `employees_evaluation_sections` (`id_section`, `name_ar`, `name_en`, `description_ar`, `description_en`, `active`, `created_date`, `created_by`, `modified_date`, `modified_by`) VALUES
(1, 'الجزء الأول: تقويم أداء الموظف:', 'PART I: EVALUATING THE EMPLOYEE PERFORMANCE:', 'تساعد الأسئلة الآتية في تحديد مستوى الاداء لدى الموظف.', 'The following questions help to identify the employee level of performance.', 1, '2014-10-29 00:00:00', NULL, NULL, NULL),
(2, 'الجزء الثاني: تقويم كفاءة الموظف:', 'PART II: EVALUATING THE EMPLOYEE POTENTIALS:', 'تساعد الأسئلة الآتية في تحديد مستوى الكفاءة لدى الموظف.', 'The following questions help to identify the employee level of potential.', 1, '2014-10-29 00:00:00', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employees_evaluation_values`
--

CREATE TABLE IF NOT EXISTS `employees_evaluation_values` (
  `id_value` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `evaluation_id` int(10) unsigned DEFAULT NULL,
  `criteria_id` int(10) unsigned DEFAULT NULL,
  `selected_option_id` tinyint(3) unsigned DEFAULT NULL,
  PRIMARY KEY (`id_value`),
  KEY `employees_evaluations_evaluationid_fk_idx` (`evaluation_id`),
  KEY `employees_evaluations_criteriaid_fk_idx` (`criteria_id`),
  KEY `employees_evaluations_selectedoptionid_fk_idx` (`selected_option_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `evaluation_periods`
--

CREATE TABLE IF NOT EXISTS `evaluation_periods` (
  `id_period` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `active` tinyint(4) DEFAULT NULL,
  `reminder_date` date NOT NULL,
  `training_needs_start_date` date NOT NULL,
  `training_needs_end_date` date NOT NULL,
  `training_needs_active` tinyint(4) DEFAULT NULL,
  `training_needs_reminder_date` date NOT NULL,
  `created_date` datetime DEFAULT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `modified_by` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id_period`),
  UNIQUE KEY `name` (`name`),
  KEY `evaluation_periods_createdby_fk_idx` (`created_by`),
  KEY `evaluation_periods_modifiedby_fk_idx` (`modified_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id_group` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` tinytext COLLATE utf8_unicode_ci,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `modified_by` int(10) unsigned DEFAULT NULL,
  `deleted` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id_group`),
  KEY `groups_createddby_idx` (`created_by`),
  KEY `groups_parent_idx` (`parent_id`),
  KEY `groups_modifiedby_idx` (`modified_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=131 ;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE IF NOT EXISTS `languages` (
  `id_language` tinyint(11) unsigned NOT NULL AUTO_INCREMENT,
  `name_ar` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name_en` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_language`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id_language`, `name_ar`, `name_en`) VALUES
(1, 'العربية', 'Arabic'),
(2, 'الإنجليزية', 'English'),
(3, 'أخرى', 'Other');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE IF NOT EXISTS `permissions` (
  `id_permission` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `role_id` tinyint(3) unsigned NOT NULL,
  `group_id` int(10) unsigned DEFAULT NULL,
  `commissioned` tinyint(4) DEFAULT '0',
  `created_date` datetime DEFAULT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id_permission`),
  KEY `userid_idx` (`user_id`),
  KEY `roleid_idx` (`role_id`),
  KEY `createdby_idx` (`created_by`),
  KEY `permissions_groupid_fk_idx` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `preferences`
--

CREATE TABLE IF NOT EXISTS `preferences` (
  `id_preferences` int(11) NOT NULL AUTO_INCREMENT,
  `evaluation_duration` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_preferences`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `preferences`
--

INSERT INTO `preferences` (`id_preferences`, `evaluation_duration`) VALUES
(1, '3');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id_role` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name_ar` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name_en` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_role`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id_role`, `name_ar`, `name_en`) VALUES
(1, 'مدير النظام', 'System Admin'),
(2, 'مدير إدارة', 'Department Manager'),
(3, 'مدير مجموعة', 'Group Leader'),
(4, 'مسؤول هيكل', 'Structure Responsible'),
(5, 'موظف', 'Employee'),
(6, 'مسؤول بإدارة التدريب', 'Training Department Responsible'),
(7, 'أخصائي تدريب', 'Training Specialist'),
(8, 'مدير إدارة التدريب', 'Training Department Manage'),
(9, 'مدير الموارد البشرية', 'HR Manager');

-- --------------------------------------------------------

--
-- Table structure for table `trainings`
--

CREATE TABLE IF NOT EXISTS `trainings` (
  `id_training` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `provider_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `duration` int(10) unsigned DEFAULT NULL,
  `country` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `training_needs_program_id` int(10) unsigned DEFAULT NULL,
  `approved_by_hr` tinyint(4) DEFAULT NULL,
  `language_id` tinyint(3) unsigned DEFAULT NULL,
  `language_other` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `chosen_by_employee` tinyint(4) DEFAULT NULL,
  `training_content` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `trainee_attendance_report` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `employee_roles` text COLLATE utf8_unicode_ci,
  `hr_recommendations` text COLLATE utf8_unicode_ci,
  `department_budget_id` int(10) unsigned DEFAULT NULL,
  `tna` tinyint(4) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `modified_by` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id_training`),
  KEY `trainings_training_needs_id_idx` (`training_needs_program_id`),
  KEY `trainings_languageid_fk_idx` (`language_id`),
  KEY `trainings_deptbudgetid_fk_idx` (`department_budget_id`),
  KEY `trainings_createdby_fk_idx` (`created_by`),
  KEY `trainings_modifiedby_fk_idx` (`modified_by`),
  KEY `country` (`country`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=55 ;

-- --------------------------------------------------------

--
-- Table structure for table `training_attachments`
--

CREATE TABLE IF NOT EXISTS `training_attachments` (
  `id_attachment` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `training_id` int(10) unsigned DEFAULT NULL,
  `type` enum('training contents','attendance report') COLLATE utf8_unicode_ci DEFAULT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `original_file_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted` tinyint(4) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `modified_by` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id_attachment`),
  KEY `training_attachments_createdby_fk_idx` (`created_by`),
  KEY `training_attachments_modifiedby_fk_idx` (`modified_by`),
  KEY `training_attachments_trainingid_fk_idx` (`training_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `training_evaluations`
--

CREATE TABLE IF NOT EXISTS `training_evaluations` (
  `id_evaluation` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `training_id` int(10) unsigned NOT NULL,
  `trainee_id` int(10) unsigned DEFAULT NULL,
  `trainee_comment` text COLLATE utf8_unicode_ci,
  `created_date` datetime DEFAULT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `modified_by` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id_evaluation`),
  KEY `training_evaluations_trainingid_fk_idx` (`training_id`),
  KEY `training_evaluations_traineeid_fk_idx` (`trainee_id`),
  KEY `training_evaluations_createdby_fk_idx` (`created_by`),
  KEY `training_evaluations_modifiedby_fk_idx` (`modified_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `training_evaluation_criterias`
--

CREATE TABLE IF NOT EXISTS `training_evaluation_criterias` (
  `id_criteria` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name_ar` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name_en` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `section_id` tinyint(3) unsigned DEFAULT NULL,
  `active` tinyint(4) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `modified_by` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id_criteria`),
  KEY `training_evaluation_criterias_createdby_fk_idx` (`created_by`),
  KEY `training_evaluation_criterias_modifiedby_fk_idx` (`modified_by`),
  KEY `training_evaluation_criterias_sectionid_fk_idx` (`section_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=19 ;

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

-- --------------------------------------------------------

--
-- Table structure for table `training_evaluation_options`
--

CREATE TABLE IF NOT EXISTS `training_evaluation_options` (
  `id_option` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name_ar` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name_en` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(4) DEFAULT NULL,
  `section_id` tinyint(3) unsigned DEFAULT NULL,
  PRIMARY KEY (`id_option`),
  KEY `training_evaluation_options_sectionid_fk_idx` (`section_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=21 ;

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

-- --------------------------------------------------------

--
-- Table structure for table `training_evaluation_sections`
--

CREATE TABLE IF NOT EXISTS `training_evaluation_sections` (
  `id_section` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name_ar` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name_en` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(4) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `modified_by` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id_section`),
  KEY `training_evaluation_sections_createdby_fk_idx` (`created_by`),
  KEY `training_evaluation_sections_modifiedby_fk_idx` (`modified_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `training_evaluation_sections`
--

INSERT INTO `training_evaluation_sections` (`id_section`, `name_ar`, `name_en`, `active`, `created_date`, `created_by`, `modified_date`, `modified_by`) VALUES
(1, 'محتوى البرنامج', 'Program Content', 1, '2014-10-29 00:00:00', NULL, NULL, NULL),
(2, 'المحاضر', 'Instructor', 1, '2014-10-29 00:00:00', NULL, NULL, NULL),
(3, 'القاعة التدريبية', 'Training Venue', 1, '2014-10-29 00:00:00', NULL, NULL, NULL),
(4, 'التقييم العام', 'Overall Evaluation', 1, '2014-10-29 00:00:00', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `training_evaluation_values`
--

CREATE TABLE IF NOT EXISTS `training_evaluation_values` (
  `id_value` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `evaluation_id` int(10) unsigned DEFAULT NULL,
  `criteria_id` int(10) unsigned DEFAULT NULL,
  `selected_option_id` tinyint(3) unsigned DEFAULT NULL,
  PRIMARY KEY (`id_value`),
  KEY `training_evaluations_evaluationid_fk_idx` (`evaluation_id`),
  KEY `training_evaluations_criteriaid_fk_idx` (`criteria_id`),
  KEY `training_evaluations_selectedoptionid_fk_idx` (`selected_option_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `training_expenses`
--

CREATE TABLE IF NOT EXISTS `training_expenses` (
  `id_training_expense` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `expense_class_id` tinyint(3) unsigned DEFAULT NULL,
  `training_id` int(10) unsigned DEFAULT NULL,
  `value` decimal(11,2) DEFAULT NULL,
  `remarks` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id_training_expense`),
  KEY `training_expenses_triningid_fk_idx` (`training_id`),
  KEY `training_expenses_expenseclassid_fk` (`expense_class_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=47 ;

-- --------------------------------------------------------

--
-- Table structure for table `training_expenses_classes`
--

CREATE TABLE IF NOT EXISTS `training_expenses_classes` (
  `id_class` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(4) DEFAULT NULL,
  `manageable` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_class`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `training_expenses_classes`
--

INSERT INTO `training_expenses_classes` (`id_class`, `name`, `active`, `manageable`) VALUES
(1, 'رسوم البرنامج', 1, 0),
(2, 'بدل إنتداب', 1, 0),
(3, 'التذكرة', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `training_needs`
--

CREATE TABLE IF NOT EXISTS `training_needs` (
  `id_need` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `requested_for_employee` int(10) unsigned NOT NULL,
  `employee_group_id` int(10) unsigned NOT NULL,
  `employee_notes` text COLLATE utf8_unicode_ci,
  `is_finally_approved` tinyint(4) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `modified_by` int(10) unsigned DEFAULT NULL,
  `trainingneed_period_id` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id_need`),
  KEY `training_needs_employeeid_fk_idx` (`requested_for_employee`),
  KEY `training_needs_createdby_fk_idx` (`created_by`),
  KEY `training_needs_modifiedby_fk_idx` (`modified_by`),
  KEY `training_needs_groupid_fk_idx` (`employee_group_id`),
  KEY `trainingneed_period_id` (`trainingneed_period_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=100 ;

-- --------------------------------------------------------

--
-- Table structure for table `training_needs_actions_log`
--

CREATE TABLE IF NOT EXISTS `training_needs_actions_log` (
  `id_action` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `training_need_id` int(10) unsigned DEFAULT NULL,
  `actor_id` int(10) unsigned DEFAULT NULL,
  `actor_role` tinyint(3) unsigned DEFAULT NULL,
  `actor_group` int(10) unsigned DEFAULT NULL,
  `action` enum('approve','reject','feedback','forward') COLLATE utf8_unicode_ci DEFAULT NULL,
  `actor_comment` text COLLATE utf8_unicode_ci,
  `created_date` datetime DEFAULT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  `forwarded_to_user` int(10) unsigned DEFAULT NULL,
  `assigned_to_group` int(10) unsigned DEFAULT NULL,
  `assigned_to_role` tinyint(3) unsigned DEFAULT NULL,
  `assigned_to_training_specialist` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id_action`),
  KEY `training_needs_actions_log_actorid_fk_idx` (`actor_id`),
  KEY `training_needs_actions_log_trainingneedid_fk_idx` (`training_need_id`),
  KEY `forwarded_to_user` (`forwarded_to_user`),
  KEY `assigned_to_group` (`assigned_to_group`),
  KEY `assigned_to_role` (`assigned_to_role`),
  KEY `assigned_to_training_specialist` (`assigned_to_training_specialist`),
  KEY `actor_role` (`actor_role`),
  KEY `actor_group` (`actor_group`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `training_needs_options`
--

CREATE TABLE IF NOT EXISTS `training_needs_options` (
  `id_option` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name_ar` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name_en` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id_option`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `training_needs_options`
--

INSERT INTO `training_needs_options` (`id_option`, `name_ar`, `name_en`, `deleted`) VALUES
(1, 'منخفض', 'Low  ', 0),
(2, 'متوسط', 'Middle ', 0),
(3, 'مرتفع', 'High', 0);

-- --------------------------------------------------------

--
-- Table structure for table `training_needs_values`
--

CREATE TABLE IF NOT EXISTS `training_needs_values` (
  `id_value` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `training_need_id` int(10) unsigned DEFAULT NULL,
  `selected_option_id` tinyint(3) unsigned DEFAULT NULL,
  `section` enum('objectives','appraisal trainings','additional trainings','suggested trainings by HR') COLLATE utf8_unicode_ci DEFAULT NULL,
  `value_ar` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value_en` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id_value`),
  KEY `training_needs_values_needid_fk_idx` (`training_need_id`),
  KEY `training_needs_values_optionid_fk_idx` (`selected_option_id`),
  KEY `training_needs_values_createdby_idx` (`created_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `employee_grade` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(4) DEFAULT NULL,
  `able_to_request_training` tinyint(4) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `modified_by` int(10) unsigned DEFAULT NULL,
  `password` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `arabic_fullname` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `english_fullname` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `username_UNIQUE` (`username`),
  KEY `users_createdby_fk_idx` (`created_by`),
  KEY `users_modifiedby_fk_idx` (`modified_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=55 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `username`, `employee_grade`, `active`, `able_to_request_training`, `created_date`, `created_by`, `modified_date`, `modified_by`, `password`, `arabic_fullname`, `english_fullname`) VALUES
(1, 'admin', NULL, 1, NULL, '2014-11-12 09:41:00', NULL, '2014-11-16 11:08:48', NULL, '', 'Super Admin', 'Super Admin');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `department_budgets`
--
ALTER TABLE `department_budgets`
  ADD CONSTRAINT `department_budgets_budgetid_fk` FOREIGN KEY (`budget_id`) REFERENCES `budgets` (`id_budget`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `department_budgets_createdby_fk` FOREIGN KEY (`created_by`) REFERENCES `users` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `department_budgets_deptid_fk` FOREIGN KEY (`department_id`) REFERENCES `groups` (`id_group`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `department_budgets_modifiedby_fk` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `employees_evaluations`
--
ALTER TABLE `employees_evaluations`
  ADD CONSTRAINT `employees_evaluations_createdby_fk` FOREIGN KEY (`created_by`) REFERENCES `users` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `employees_evaluations_employeeid_fk` FOREIGN KEY (`employee_id`) REFERENCES `users` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `employees_evaluations_evalperiodid_fk` FOREIGN KEY (`evaluation_period_id`) REFERENCES `evaluation_periods` (`id_period`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `employees_evaluations_groupid_fk` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id_group`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `employees_evaluations_modifiedby_fk` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `employees_evaluation_criterias`
--
ALTER TABLE `employees_evaluation_criterias`
  ADD CONSTRAINT `employees_evaluation_criterias_createdby_fk` FOREIGN KEY (`created_by`) REFERENCES `users` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `employees_evaluation_criterias_modifiedby_fk` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `employees_evaluation_criterias_sectionid_fk` FOREIGN KEY (`section_id`) REFERENCES `employees_evaluation_sections` (`id_section`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `employees_evaluation_options`
--
ALTER TABLE `employees_evaluation_options`
  ADD CONSTRAINT `employees_evaluation_options_sectionid_fk` FOREIGN KEY (`section_id`) REFERENCES `employees_evaluation_sections` (`id_section`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `employees_evaluation_sections`
--
ALTER TABLE `employees_evaluation_sections`
  ADD CONSTRAINT `employees_evaluation_sections_createdby_fk` FOREIGN KEY (`created_by`) REFERENCES `users` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `employees_evaluation_sections_modifiedby_fk` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `employees_evaluation_values`
--
ALTER TABLE `employees_evaluation_values`
  ADD CONSTRAINT `employees_evaluations_criteriaid_fk` FOREIGN KEY (`criteria_id`) REFERENCES `employees_evaluation_criterias` (`id_criteria`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `employees_evaluations_evaluationid_fk` FOREIGN KEY (`evaluation_id`) REFERENCES `employees_evaluations` (`id_evaluation`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `employees_evaluations_selectedoptionid_fk` FOREIGN KEY (`selected_option_id`) REFERENCES `employees_evaluation_options` (`id_option`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `evaluation_periods`
--
ALTER TABLE `evaluation_periods`
  ADD CONSTRAINT `evaluation_periods_createdby_fk` FOREIGN KEY (`created_by`) REFERENCES `users` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `evaluation_periods_modifiedby_fk` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `groups`
--
ALTER TABLE `groups`
  ADD CONSTRAINT `groups_createdby_fk` FOREIGN KEY (`created_by`) REFERENCES `users` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `groups_modifiedby_fk` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `groups_parentid_fk` FOREIGN KEY (`parent_id`) REFERENCES `groups` (`id_group`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `permissions`
--
ALTER TABLE `permissions`
  ADD CONSTRAINT `permissions_createdby` FOREIGN KEY (`created_by`) REFERENCES `users` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `permissions_groupid_fk` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id_group`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `permissions_roleid_fk` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id_role`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `permissions_userid_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `trainings`
--
ALTER TABLE `trainings`
  ADD CONSTRAINT `trainings_createdby_fk` FOREIGN KEY (`created_by`) REFERENCES `users` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `trainings_deptbudgetid_fk` FOREIGN KEY (`department_budget_id`) REFERENCES `department_budgets` (`id_dept_budget`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `trainings_ibfk_1` FOREIGN KEY (`training_needs_program_id`) REFERENCES `training_needs_values` (`id_value`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `trainings_ibfk_2` FOREIGN KEY (`country`) REFERENCES `countries` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `trainings_ibfk_3` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id_language`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `trainings_modifiedby_fk` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `training_attachments`
--
ALTER TABLE `training_attachments`
  ADD CONSTRAINT `training_attachments_createdby_fk` FOREIGN KEY (`created_by`) REFERENCES `users` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `training_attachments_modifiedby_fk` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `training_attachments_trainingid_fk` FOREIGN KEY (`training_id`) REFERENCES `trainings` (`id_training`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `training_evaluations`
--
ALTER TABLE `training_evaluations`
  ADD CONSTRAINT `training_evaluations_createdby_fk` FOREIGN KEY (`created_by`) REFERENCES `users` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `training_evaluations_modifiedby_fk` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `training_evaluations_traineeid_fk` FOREIGN KEY (`trainee_id`) REFERENCES `users` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `training_evaluations_trainingid_fk` FOREIGN KEY (`training_id`) REFERENCES `trainings` (`id_training`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `training_evaluation_criterias`
--
ALTER TABLE `training_evaluation_criterias`
  ADD CONSTRAINT `training_evaluation_criterias_createdby_fk` FOREIGN KEY (`created_by`) REFERENCES `users` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `training_evaluation_criterias_modifiedby_fk` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `training_evaluation_criterias_sectionid_fk` FOREIGN KEY (`section_id`) REFERENCES `training_evaluation_sections` (`id_section`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `training_evaluation_options`
--
ALTER TABLE `training_evaluation_options`
  ADD CONSTRAINT `training_evaluation_options_sectionid_fk` FOREIGN KEY (`section_id`) REFERENCES `training_evaluation_sections` (`id_section`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `training_evaluation_sections`
--
ALTER TABLE `training_evaluation_sections`
  ADD CONSTRAINT `training_evaluation_sections_createdby_fk` FOREIGN KEY (`created_by`) REFERENCES `users` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `training_evaluation_sections_modifiedby_fk` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `training_evaluation_values`
--
ALTER TABLE `training_evaluation_values`
  ADD CONSTRAINT `training_evaluations_criteriaid_fk` FOREIGN KEY (`criteria_id`) REFERENCES `training_evaluation_criterias` (`id_criteria`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `training_evaluations_evaluationid_fk` FOREIGN KEY (`evaluation_id`) REFERENCES `training_evaluations` (`id_evaluation`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `training_evaluations_selectedoptionid_fk` FOREIGN KEY (`selected_option_id`) REFERENCES `training_evaluation_options` (`id_option`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `training_expenses`
--
ALTER TABLE `training_expenses`
  ADD CONSTRAINT `training_expenses_expenseclassid_fk` FOREIGN KEY (`expense_class_id`) REFERENCES `training_expenses_classes` (`id_class`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `training_expenses_triningid_fk` FOREIGN KEY (`training_id`) REFERENCES `trainings` (`id_training`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `training_needs`
--
ALTER TABLE `training_needs`
  ADD CONSTRAINT `training_needs_createdby_fk` FOREIGN KEY (`created_by`) REFERENCES `users` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `training_needs_employeeid_fk` FOREIGN KEY (`requested_for_employee`) REFERENCES `users` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `training_needs_groupid_fk` FOREIGN KEY (`employee_group_id`) REFERENCES `groups` (`id_group`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `training_needs_ibfk_1` FOREIGN KEY (`trainingneed_period_id`) REFERENCES `evaluation_periods` (`id_period`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `training_needs_modifiedby_fk` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `training_needs_actions_log`
--
ALTER TABLE `training_needs_actions_log`
  ADD CONSTRAINT `training_needs_actions_log_actorid_fk` FOREIGN KEY (`actor_id`) REFERENCES `users` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `training_needs_actions_log_ibfk_1` FOREIGN KEY (`forwarded_to_user`) REFERENCES `users` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `training_needs_actions_log_ibfk_2` FOREIGN KEY (`assigned_to_group`) REFERENCES `groups` (`id_group`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `training_needs_actions_log_ibfk_3` FOREIGN KEY (`assigned_to_role`) REFERENCES `roles` (`id_role`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `training_needs_actions_log_ibfk_4` FOREIGN KEY (`assigned_to_training_specialist`) REFERENCES `users` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `training_needs_actions_log_ibfk_5` FOREIGN KEY (`actor_role`) REFERENCES `roles` (`id_role`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `training_needs_actions_log_ibfk_6` FOREIGN KEY (`actor_group`) REFERENCES `groups` (`id_group`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `training_needs_actions_log_trainingneedid_fk` FOREIGN KEY (`training_need_id`) REFERENCES `training_needs` (`id_need`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `training_needs_values`
--
ALTER TABLE `training_needs_values`
  ADD CONSTRAINT `training_needs_values_createdby` FOREIGN KEY (`created_by`) REFERENCES `users` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `training_needs_values_needid_fk` FOREIGN KEY (`training_need_id`) REFERENCES `training_needs` (`id_need`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `training_needs_values_optionid_fk` FOREIGN KEY (`selected_option_id`) REFERENCES `training_needs_options` (`id_option`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_createdby_fk` FOREIGN KEY (`created_by`) REFERENCES `users` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `users_modifiedby_fk` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
