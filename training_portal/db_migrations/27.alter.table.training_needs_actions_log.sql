ALTER TABLE `training_needs_actions_log` ADD `actor_role` TINYINT UNSIGNED NULL DEFAULT NULL AFTER `actor_id` ,
ADD `actor_group` TINYINT UNSIGNED NULL DEFAULT NULL AFTER `actor_role` ;

ALTER TABLE `training_needs_actions_log` ADD INDEX ( `actor_role` ) ;
ALTER TABLE `training_needs_actions_log` ADD INDEX ( `actor_group` ) ;

ALTER TABLE `training_needs_actions_log` CHANGE `actor_group` `actor_group` INT( 10 ) UNSIGNED NULL DEFAULT NULL ;

ALTER TABLE `training_needs_actions_log` ADD FOREIGN KEY ( `actor_role` ) REFERENCES `roles` (
`id_role`
) ON DELETE NO ACTION ON UPDATE NO ACTION ;

ALTER TABLE `training_needs_actions_log` ADD FOREIGN KEY ( `actor_group` ) REFERENCES `groups` (
`id_group`
) ON DELETE NO ACTION ON UPDATE NO ACTION ;