<?php

namespace app\base;

use App;
use PDO;
use PDOException;

/**
 * Db class definition
 * extends php PDO class
 */
class Db extends PDO
{
    public function __construct() {
        if (!$config = App::i()->config->db) {
            throw new PDOException('Undefined config for "db"');
        }

        if (
                !isset($config['host'])
                or !isset($config['dbname'])
                or !isset($config['username'])
                or !isset($config['password'])
        ) {
            throw new PDOException('Wrong config for "db"');
        }

        $dsn = 'mysql:dbname=' . $config['dbname'] . ';host=' . $config['host'];
        parent::__construct($dsn, $config['username'], $config['passwrod']);

        $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

        return $this;
    }
}

