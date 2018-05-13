<?php

namespace app\migrate;

use app\base\ModelDb;

class Migrate_1526239454_winners extends ModelDb
{
    public static function up()
    {
        $sth = static::db()->prepare("
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
        ");

        return $sth->execute();
    }
}