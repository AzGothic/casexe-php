<?php

namespace app\migrate;

use app\base\ModelDb;

class Migrate_1526239185_users extends ModelDb
{
    public static function up()
    {
        $sth = static::db()->prepare("
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
        ");

        return $sth->execute();
    }
}