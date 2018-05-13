<?php

namespace app\migrate;

use app\base\ModelDb;

class Migrate_1526239389_items extends ModelDb
{
    public static function up()
    {
        $sth = static::db()->prepare("
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
        ");

        return $sth->execute();
    }
}