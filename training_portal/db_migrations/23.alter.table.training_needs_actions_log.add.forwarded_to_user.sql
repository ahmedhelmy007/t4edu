ALTER TABLE `training_needs_actions_log` ADD `forwarded_to_user` INT( 10 ) NOT NULL ;
ALTER TABLE `training_needs_actions_log` ADD INDEX ( `forwarded_to_user` ) ;
ALTER TABLE `training_needs_actions_log` CHANGE `forwarded_to_user` `forwarded_to_user` INT( 10 ) UNSIGNED NOT NULL ;
ALTER TABLE `training_needs_actions_log` ADD FOREIGN KEY ( `forwarded_to_user` ) REFERENCES `users` (
`id_user`
) ON DELETE NO ACTION ON UPDATE NO ACTION ;
