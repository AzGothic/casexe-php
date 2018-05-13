<?php

namespace app\model;

use app\base\Db;

class Winners extends \app\base\ModelDb
{
    const TYPE_POINTS       = 0; // prize in points
    const TYPE_EURO         = 1; // prize in euro
    const TYPE_ITEM         = 2; // item prize

    const STATUS_WAITING    = 0; // waiting for winner decision
    const STATUS_ACCEPTED   = 1; // accepted by winner
    const STATUS_REJECTED   = 2; // rejected by winner
    const STATUS_DONE       = 3; // prize sent/processed

    public $table = 'winners';

    public static function getAll()
    {
        $sth = static::db()->prepare(
            "SELECT * "
            . "FROM `" . static::table() . "` "
            . "ORDER BY `id` DESC "
        );
        $sth->execute();

        if (!$winners = $sth->fetchAll()) {
            return false;
        }

        foreach ($winners as $key => $winner) {
            $winners[$key] = new Winner($winner);
        }

        return $winners;
    }

    public static function getByUserId($userId = null)
    {
        if ($userId == null) {
            $userId = User::get()->id;
        }

        $sth = static::db()->prepare(
            "SELECT * "
            . "FROM `" . static::table() . "` "
            . "WHERE `user_id` = :user_id "
            . "ORDER BY `id` DESC "
            . "LIMIT 1"
        );
        $sth->bindParam(':user_id', $userId, Db::PARAM_INT);
        $sth->execute();

        if (!$winner = $sth->fetch()) {
            return false;
        }

        return new Winner($winner);
    }

    public static function existsByUserId($userId = null)
    {
        return (bool) self::getByUserId($userId);
    }

    public static function setWinner($userId, $type, $value, $status) {
        $sth = static::db()->prepare(
                "INSERT INTO `" . static::table() . "` "
                . "(`user_id`, `type`, `value`, `status`) "
                . "VALUES "
                . "(:user_id, :type, :value, :status)"
            );
        $sth->bindParam(':user_id', $userId, Db::PARAM_INT);
        $sth->bindParam(':type', $type, Db::PARAM_INT);
        $sth->bindParam(':value', $value, Db::PARAM_INT|Db::PARAM_STR);
        $sth->bindParam(':status', $status, Db::PARAM_INT);

        return $sth->execute();
    }

    public static function setStatusById($id, $status) {
        $sth = static::db()->prepare(
                "UPDATE `" . static::table() . "` "
                . "SET `status` = :status "
                . "WHERE `id` = :id "
                . "LIMIT 1"
            );
        $sth->bindParam(':id', $id, Db::PARAM_INT);
        $sth->bindParam(':status', $status, Db::PARAM_INT);

        return $sth->execute();
    }

    public static function clearByUserId($userId = null) {
        if ($userId == null) {
            $userId = User::get()->id;
        }

        $sth = static::db()->prepare(
                "DELETE "
                . "FROM `" . static::table() . "` "
                . "WHERE `user_id` = :user_id "
                . "LIMIT 1"
            );
        $sth->bindParam(':user_id', $userId, Db::PARAM_INT);

        return $sth->execute();
    }

    public static function getForTransfer($limit)
    {
        $sth = static::db()->prepare("
            SELECT *
            FROM `" . static::table() . "`
            WHERE `type` = :type
                AND `status` = :status
            ORDER BY `id` ASC
            LIMIT :limit
        ");
        $type   = self::TYPE_EURO;
        $status = self::STATUS_ACCEPTED;
        $sth->bindParam(':type', $type, Db::PARAM_INT);
        $sth->bindParam(':status', $status, Db::PARAM_INT);
        $sth->bindParam(':limit', $limit, Db::PARAM_INT);
        $sth->execute();

        if (!$winners = $sth->fetchAll())
            return false;

        foreach ($winners as $key => $winner)
            $winners[$key] = new Winner($winner);

        return $winners;
    }
}
