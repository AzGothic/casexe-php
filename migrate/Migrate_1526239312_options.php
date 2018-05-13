<?php

namespace app\migrate;

use app\base\ModelDb;

class Migrate_1526239312_options extends ModelDb
{
    public static function up()
    {
        $sth = static::db()->prepare("
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
        ");

        return $sth->execute();
    }
}