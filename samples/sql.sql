/**
 * Author:  Z.Alex
 * Created: 09.05.2018
 */

CREATE TABLE `user` (
	`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`email` VARCHAR(50) NULL DEFAULT NULL,
	`password` VARCHAR(32) NULL DEFAULT NULL,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `email` (`email`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;

INSERT INTO `user` (`email`, `password`) VALUES ('casexe@example.com', '96e79218965eb72c92a549dd5a330112'); -- password: 111111