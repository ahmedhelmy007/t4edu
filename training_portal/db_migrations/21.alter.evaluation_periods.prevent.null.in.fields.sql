

ALTER TABLE `evaluation_periods` CHANGE `name` `name` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
CHANGE `start_date` `start_date` DATE NOT NULL ,
CHANGE `end_date` `end_date` DATE NOT NULL ,
CHANGE `reminder_date` `reminder_date` DATE NOT NULL ,
CHANGE `training_needs_start_date` `training_needs_start_date` DATE NOT NULL ,
CHANGE `training_needs_end_date` `training_needs_end_date` DATE NOT NULL ,
CHANGE `training_needs_reminder_date` `training_needs_reminder_date` DATE NOT NULL ;