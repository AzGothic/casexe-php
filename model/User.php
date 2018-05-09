<?php

namespace app\model;

use App;
use app\base\Db;

class User extends \app\base\ModelDb
{
    public $table = 'user';

    protected static $user;

    public static function get() {
        return self::$user;
    }

    public static function isGuest() {
        return (bool) self::$user;
    }

    public static function logout() {
        App::i()->session->remove('USER_ID');

        return true;
    }

    public static function relogin() {
        if (!App::i()->session->get('USER_ID')) {
            return false;
        }

        return (new self)->loginById(App::i()->session->get('USER_ID'));
    }

    public function loginById($id) {
        if (!$user = $this->find($id)) {
            App::i()->session->remove('USER_ID');
            return false;
        }

        App::i()->session->set('USER_ID', $user->id);

        return self::$user = $user;
    }

    public function loginByEmailPassword($email, $password) {
        if (!$user = $this->find($email, 'email')) {
            App::i()->session->remove('USER_ID');
            return false;
        }
        if ($this->passwordHash($password) !== $user->password) {
            App::i()->session->remove('USER_ID');
            return false;
        }

        App::i()->session->set('USER_ID', $user->id);

        return self::$user = $user;
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
                . "FROM `$this->table` "
                . "WHERE `$col` = :value "
                . "LIMIT 1"
            );
        $sth->bindParam(':value', $value, Db::PARAM_INT|Db::PARAM_STR);
        $sth->execute();

        if (!$rows = $sth->fetchAll()) {
            return false;
        }

        return $rows[0];
    }
}
