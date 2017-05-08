ALTER TABLE `trainings` DROP FOREIGN KEY `trainings_trainingneedsid_fk` ;

ALTER TABLE `trainings` DROP FOREIGN KEY `trainings_ibfk_5` ;

ALTER TABLE `trainings` CHANGE `training_needs_id` `training_needs_program_id` INT( 10 ) UNSIGNED NULL DEFAULT NULL ;

ALTER TABLE `trainings` ADD FOREIGN KEY ( `training_needs_program_id` ) REFERENCES `training_needs_values` (
`id_value`
) ON DELETE NO ACTION ON UPDATE NO ACTION ;