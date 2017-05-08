ALTER TABLE `training_needs_actions_log` ADD `assigned_to_group` INT( 10 ) UNSIGNED NULL DEFAULT NULL ,
ADD `assigned_to_role` TINYINT( 3 ) UNSIGNED NULL DEFAULT NULL ,
ADD `assigned_to_training_specialist` INT( 10 ) UNSIGNED NULL DEFAULT NULL ;

ALTER TABLE `training_needs_actions_log` ADD INDEX ( `assigned_to_group` ) ;
ALTER TABLE `training_needs_actions_log` ADD INDEX ( `assigned_to_role` ) ;
ALTER TABLE `training_needs_actions_log` ADD INDEX ( `assigned_to_training_specialist` ) ;

ALTER TABLE `training_needs_actions_log` ADD FOREIGN KEY ( `assigned_to_group` ) REFERENCES `groups` (
`id_group`
) ON DELETE NO ACTION ON UPDATE NO ACTION ;

ALTER TABLE `training_needs_actions_log` ADD FOREIGN KEY ( `assigned_to_role` ) REFERENCES `roles` (
`id_role`
) ON DELETE NO ACTION ON UPDATE NO ACTION ;
ALTER TABLE `training_needs_actions_log` ADD FOREIGN KEY ( `assigned_to_training_specialist` ) REFERENCES `users` (
`id_user`
) ON DELETE NO ACTION ON UPDATE NO ACTION ;
