ALTER TABLE `training_needs` ADD `trainingneed_period_id` TINYINT( 3 ) NOT NULL ;
ALTER TABLE `training_needs` ADD INDEX ( `trainingneed_period_id` ) ;
ALTER TABLE `training_needs` CHANGE `trainingneed_period_id` `trainingneed_period_id` TINYINT( 3 ) UNSIGNED NOT NULL ;
ALTER TABLE `training_needs` ADD FOREIGN KEY ( `trainingneed_period_id` ) REFERENCES `evaluation_periods` (
`id_period`
) ON DELETE NO ACTION ON UPDATE NO ACTION ;