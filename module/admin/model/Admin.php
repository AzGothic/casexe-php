<?php

namespace app\module\admin\model;

use App;
use app\base\Db;

class Admin extends \app\base\ModelDb
{
    public $table = 'admin';

    protected static $admin;

    public static function get() {
        return self::$admin;
    }

    public static function logout() {
        App::i()->session->remove('ADMIN_ID');

        return true;
    }

    public static function relogin() {
        if (!App::i()->session->get('ADMIN_ID')) {
            return false;
        }

        return (new self)->loginById(App::i()->session->get('ADMIN_ID'));
    }

    public function loginById($id) {
        if (!$admin = $this->find($id)) {
            App::i()->session->remove('ADMIN_ID');
            return false;
        }

        App::i()->session->set('ADMIN_ID', $admin->id);

        return self::$admin = $admin;
    }

    public function loginByEmailPassword($email, $password) {
        if (!$admin = $this->find($email, 'email')) {
            App::i()->session->remove('ADMIN_ID');
            return false;
        }
        if ($this->passwordHash($password) !== $admin->password) {
            App::i()->session->remove('ADMIN_ID');
            return false;
        }

        App::i()->session->set('ADMIN_ID', $admin->id);

        return self::$admin = $admin;
    }

    protected function passwordHash($password) {
        return md5($password);
    }

    public function find($value, $col = 'id') {
        if (!$value or !$col) {
            return false;
        }

        $sth = $this->db->prepare(
                "SELECT * "
                . "FROM `" . static::table() . "` "
                . "WHERE `$col` = :value "
                . "LIMIT 1"
            );
        $sth->bindParam(':value', $value, Db::PARAM_INT|Db::PARAM_STR);
        $sth->execute();

        return $sth->fetch();
    }
}
