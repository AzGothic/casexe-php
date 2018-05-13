<?php

namespace app\base;

use App;

/**
 * ModelDb class definition
 */
class ModelDb extends Model
{
    public $table;

    public function __construct() {
        parent::__construct();
    }

    public function __get($name) {
        if ($name == 'db') {
            return self::db();
        }
    }

    public static function db() {
        return App::i()->db;
    }

    public static function table() {
        return (new static)->table;
    }
}

