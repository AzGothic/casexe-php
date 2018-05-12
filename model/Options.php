<?php

namespace app\model;

use App;
use app\base\Db;

class Options extends \app\base\ModelDb
{
    public $table = 'options';

    protected static $_options;

    public static function get($option = null, $default = null) {
        $options = self::$_options;
        if (!$options) {
            $sth = static::db()->prepare(
                    "SELECT `key`, `value` "
                    . "FROM `" . static::table() . "` "
                );
            $sth->execute();

            $options = $sth->fetchAll(Db::FETCH_KEY_PAIR);
            self::$_options = $options;
        }

        if (!$option) {
            return $options;
        }
        return isset($options[$option]) ? $options[$option] : $default;
    }

    public static function minusPrizePool($minus) {
        self::get();
        self::$_options['prize_pool_left'] -= $minus;
        if (self::$_options['prize_pool_left'] < 0) {
            self::$_options['prize_pool_left'] = 0;
        }

        $sth = static::db()->prepare(
                "UPDATE `" . static::table() . "` "
                . "SET `value` = :value "
                . "WHERE `key` = :key "
                . "LIMIT 1"
            );
        $key = 'prize_pool_left';
        $sth->bindParam(':key', $key, Db::PARAM_STR);
        $sth->bindParam(':value', self::$_options['prize_pool_left'], Db::PARAM_INT);

        return $sth->execute();
    }

    public static function plusPrizePool($plus) {
        return self::minusPrizePool((-$plus));
    }
}
