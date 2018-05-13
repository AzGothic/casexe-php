<?php

namespace app\base;

/**
 * Migrate class definition
 */
class Migrate extends ModelDb
{
    public $table = 'migration_casexe';

    public function __construct()
    {
        parent::__construct();
    }

    public function prepareTable()
    {
        $sth = $this->db->prepare("
            CREATE TABLE IF NOT EXISTS `" . static::table() . "` (
                `key` VARCHAR(100) NULL DEFAULT NULL,
                `date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                UNIQUE INDEX `key` (`key`)
            )
            COLLATE='utf8_general_ci'
            ENGINE=InnoDB;
        ");

        return $sth->execute();
    }

    public function getOld()
    {
        $sth = $this->db->prepare(
            "SELECT * "
            . "FROM `" . static::table() . "`"
        );
        $sth->execute();

        return $sth->fetchAll();
    }

    public function add($key)
    {
        $sth = static::db()->prepare(
            "INSERT INTO `" . static::table() . "` "
            . "(`key`) "
            . "VALUES "
            . "(:key)"
        );
        $sth->bindParam(':key', $key, Db::PARAM_STR);

        return $sth->execute();
    }
}

