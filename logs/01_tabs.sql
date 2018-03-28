use dnd;

CREATE TABLE `rem_reminders` (
	`ID` INT(11) NOT NULL AUTO_INCREMENT,
	`user_id` INT(11) NOT NULL,
	`message` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`after_exec` CHAR(1) NOT NULL DEFAULT 'D' COLLATE 'utf8_unicode_ci',
	`repeat_after` VARCHAR(20) NULL DEFAULT '0' COMMENT 'expressed in minutes' COLLATE 'utf8_unicode_ci',
	`eventstart` INT(11) NULL DEFAULT NULL,
	`state` CHAR(1) NULL DEFAULT 'A' COLLATE 'utf8_unicode_ci',
	PRIMARY KEY (`ID`),
	INDEX `uid_mex` (`user_id`)
)
COLLATE='utf8_unicode_ci'
ENGINE=MyISAM
AUTO_INCREMENT=20
;
