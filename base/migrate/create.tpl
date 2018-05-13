<?php

namespace app\migrate;

use app\base\ModelDb;

class {name} extends ModelDb
{
    public static function up()
    {
        $sth = static::db()->prepare("-- Query");
        // $sth->bindParam(':value', $value);

        return $sth->execute();
    }
}