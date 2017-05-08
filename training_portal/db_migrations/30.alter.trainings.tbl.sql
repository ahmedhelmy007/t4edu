ALTER TABLE `trainings` ADD INDEX ( `country` ) ;
ALTER TABLE `trainings` ADD FOREIGN KEY ( `country` ) REFERENCES `training_portal`.`countries` (
`id`
) ON DELETE NO ACTION ON UPDATE NO ACTION ;
