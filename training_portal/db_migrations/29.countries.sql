-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 01, 2015 at 05:10 AM
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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;