ALTER TABLE `trainings` ADD `self_request_trainingneed_id` INT( 10 ) NULL ;
ALTER TABLE `trainings` ADD INDEX ( `self_request_trainingneed_id` ) ;
ALTER TABLE `trainings` CHANGE `self_request_trainingneed_id` `self_request_trainingneed_id` INT( 10 ) UNSIGNED NULL DEFAULT NULL ;
ALTER TABLE `trainings` ADD FOREIGN KEY ( `self_request_trainingneed_id` ) REFERENCES `training_portal`.`training_needs` (
`id_need`
) ON DELETE NO ACTION ON UPDATE NO ACTION ;

ALTER TABLE `trainings` ADD `related_tasks` TEXT NOT NULL ;