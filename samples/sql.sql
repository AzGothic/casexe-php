-- Author:  Z.Alex
-- Created: 09.05.2018
-- Updated: 13.05.2018

CREATE TABLE `user` (
	`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`email` VARCHAR(50) NULL DEFAULT NULL,
	`password` VARCHAR(32) NULL DEFAULT NULL,
	`name` VARCHAR(50) NULL DEFAULT NULL COMMENT 'User name',
	`points` INT(11) NOT NULL DEFAULT '0',
	`card` BIGINT(16) NOT NULL COMMENT 'User card for payments',
	PRIMARY KEY (`id`),
	UNIQUE INDEX `email` (`email`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;

-- users
INSERT INTO `user` (`id`, `email`, `password`, `name`, `points`, `card`) VALUES (1, 'user1@example.com', '96e79218965eb72c92a549dd5a330112', 'User 1', 0, 1111222233334444);
INSERT INTO `user` (`id`, `email`, `password`, `name`, `points`, `card`) VALUES (2, 'user2@example.com', '96e79218965eb72c92a549dd5a330112', 'User 2', 0, 2222333344445555);
INSERT INTO `user` (`id`, `email`, `password`, `name`, `points`, `card`) VALUES (3, 'user3@example.com', '96e79218965eb72c92a549dd5a330112', 'User 3', 0, 3333444455556666);



CREATE TABLE `options` (
	`key` VARCHAR(50) NOT NULL,
	`value` VARCHAR(100) NULL DEFAULT NULL,
	`comments` TEXT NULL,
	UNIQUE INDEX `key` (`key`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;

-- options
INSERT INTO `options` (`key`, `value`, `comments`) VALUES ('convertation_ratio', '2', 'convertation ration EURO to Points');
INSERT INTO `options` (`key`, `value`, `comments`) VALUES ('max_points', '50', 'max prize in Points');
INSERT INTO `options` (`key`, `value`, `comments`) VALUES ('max_prize', '20', 'max prize in EURO');
INSERT INTO `options` (`key`, `value`, `comments`) VALUES ('min_points', '20', 'min prize in Points');
INSERT INTO `options` (`key`, `value`, `comments`) VALUES ('min_prize', '5', 'min prize in EURO');
INSERT INTO `options` (`key`, `value`, `comments`) VALUES ('prize_pool', '200', 'money prize pool for lottery (in EURO)');
INSERT INTO `options` (`key`, `value`, `comments`) VALUES ('prize_pool_left', '200', 'money prize pool left for lottery (in EURO)');



CREATE TABLE `items` (
	`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(50) NOT NULL,
	`points` INT(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'price in points',
	`status` SMALLINT(2) UNSIGNED NOT NULL DEFAULT '0' COMMENT '0 - in lottery, 1 - waiting, 2 - accepted',
	PRIMARY KEY (`id`),
	INDEX `status` (`status`)
)
COMMENT='Items in Lottery'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;

-- items
INSERT INTO `items` (`id`, `name`, `points`, `status`) VALUES (1, 'Book', 10, 0);
INSERT INTO `items` (`id`, `name`, `points`, `status`) VALUES (2, 'Notebook', 5, 0);
INSERT INTO `items` (`id`, `name`, `points`, `status`) VALUES (3, 'Notebook', 5, 0);
INSERT INTO `items` (`id`, `name`, `points`, `status`) VALUES (4, 'Pen', 2, 0);
INSERT INTO `items` (`id`, `name`, `points`, `status`) VALUES (5, 'Bag', 20, 0);



CREATE TABLE `winners` (
	`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`user_id` INT(11) NOT NULL,
	`type` INT(2) UNSIGNED NOT NULL DEFAULT '0' COMMENT '0 - points, 1 - euro, 2 - item',
	`value` INT(11) NOT NULL COMMENT 'value for euro/points, id for items',
	`status` INT(2) UNSIGNED NOT NULL DEFAULT '0' COMMENT '0 - waiting, 1 - accepted, 2 - rejected, 3 -  done',
	`date_win` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`date_updated` DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`),
	INDEX `user_id` (`user_id`),
	INDEX `status` (`status`),
	INDEX `type` (`type`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;



CREATE TABLE `admin` (
	`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`email` VARCHAR(50) NULL DEFAULT NULL,
	`password` VARCHAR(32) NULL DEFAULT NULL,
	`name` VARCHAR(50) NULL DEFAULT NULL COMMENT 'Admin name',
	PRIMARY KEY (`id`),
	UNIQUE INDEX `email` (`email`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;

-- admins
INSERT INTO `admin` (`id`, `email`, `password`, `name`) VALUES (1, 'admin@example.com', '96e79218965eb72c92a549dd5a330112', 'Mega Admin');