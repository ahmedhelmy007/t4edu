
ALTER TABLE `budgets` CHANGE `start_date` `start_date` DATE NULL DEFAULT NULL ,
CHANGE `end_date` `end_date` DATE NULL DEFAULT NULL;

ALTER TABLE `evaluation_periods` CHANGE `start_date` `start_date` DATE NULL DEFAULT NULL ,
CHANGE `end_date` `end_date` DATE NULL DEFAULT NULL ,
CHANGE `reminder_date` `reminder_date` DATE NULL DEFAULT NULL ;

ALTER TABLE `training_needs_periods` CHANGE `start_date` `start_date` DATE NULL DEFAULT NULL ,
CHANGE `end_date` `end_date` DATE NULL DEFAULT NULL ,
CHANGE `reminder_date` `reminder_date` DATE NULL DEFAULT NULL ;

ALTER TABLE `trainings` CHANGE `start_date` `start_date` DATE NULL DEFAULT NULL ,
CHANGE `end_date` `end_date` DATE NULL DEFAULT NULL ;