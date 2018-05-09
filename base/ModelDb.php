<?php

namespace app\base;

use App;

/**
 * ModelDb class definition
 */
class ModelDb extends Model
{
    public $table;

    public function __get($name) {
        if ($name == 'db') {
            return $this->db();
        }
    }

    public function db() {
        return App::i()->db;
    }
}

