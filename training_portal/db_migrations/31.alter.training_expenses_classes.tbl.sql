ALTER TABLE `training_expenses_classes` ADD `manageable` BOOLEAN NOT NULL DEFAULT TRUE ;
INSERT INTO `training_portal`.`training_expenses_classes` (
`id_class` ,
`name` ,
`active` ,
`manageable`
)
VALUES (
NULL , 'رسوم البرنامج', '1', '0'
), (
NULL , 'بدل انتداب', '1', '0'
), (
NULL, 'التذكرة', '1', '0');

