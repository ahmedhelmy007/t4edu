
ALTER TABLE `evaluation_periods` ADD `training_needs_start_date` DATE NULL AFTER `reminder_date` ,
ADD `training_needs_end_date` DATE NULL AFTER `training_needs_start_date` ,
ADD `training_needs_active` TINYINT NULL AFTER `training_needs_end_date` ,
ADD `training_needs_reminder_date` DATE NULL AFTER `training_needs_active` ;

DROP TABLE `training_needs_periods` ;