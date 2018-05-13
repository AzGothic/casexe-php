<?php

namespace app\migrate;

use app\base\ModelDb;

class Migrate_1526239241_admins extends ModelDb
{
    public static function up()
    {
        $sth = static::db()->prepare("
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
        ");

        return $sth->execute();
    }
}