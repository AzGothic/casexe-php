<?php

namespace app\model;

use App;
use app\base\Db;

class Items extends \app\base\ModelDb
{
    const STATUS_IN_LOTTERY = 0;
    const STATUS_WAITING    = 1; // waiting for winner decision
    const STATUS_ACCEPTED   = 2; // accepted by winner

    public $table = 'items';

    public static function getForLottery() {
        return self::getByStatus(self::STATUS_IN_LOTTERY);
    }

    public static function getByStatus($status = 0) {
        $sth = static::db()->prepare(
                "SELECT * "
                . "FROM `" . static::table() . "` "
                . "WHERE `status` = :status "
                . "ORDER BY `points` DESC, `name`"
            );
        $sth->bindParam(':status', $status, Db::PARAM_INT);
        $sth->execute();

        return $sth->fetchAll();
    }

    public static function getById($id) {
        $sth = static::db()->prepare(
                "SELECT * "
                . "FROM `" . static::table() . "` "
                . "WHERE id = :id "
                . "LIMIT 1"
            );
        $sth->bindParam(':id', $id, Db::PARAM_INT);
        $sth->execute();

        return $sth->fetch();
    }

    public static function setStatusById($id, $status) {
        $sth = static::db()->prepare(
                "UPDATE `" . static::table() . "` "
                . "SET `status` = :status "
                . "WHERE id = :id "
                . "LIMIT 1"
            );
        $sth->bindParam(':id', $id, Db::PARAM_INT);
        $sth->bindParam(':status', $status, Db::PARAM_INT);

        return $sth->execute();
    }
}
