

ALTER TABLE `training_needs` DROP FOREIGN KEY `training_needs_assignedtogroup_fk` ;

ALTER TABLE `training_needs` DROP FOREIGN KEY `training_needs_assignedtorole_fk` ;

ALTER TABLE `training_needs` DROP FOREIGN KEY `training_needs_assignedtotrsp_fk` ;

ALTER TABLE `training_needs` DROP `assigned_to_group` ,
DROP `assigned_to_role` ,
DROP `assigned_to_training_specialist` ;