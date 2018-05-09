<?php

namespace app\base;

use App;

/**
 * Session class definition
 */
class Session
{
    public $duration = 86400; // 1*24*60*60 seconds, default - 1 day

    public function __construct() {

    }

    public function __get($name) {
        if ($name === 'id') {
            return $this->id();
        }
        if ($name === 'isActive') {
            return $this->isActive();
        }

        return null;
    }

    public function start() {
        if (!$this->isActive) {
            session_start();
        }

        if (!$this->get('__CREATED')) {
            $this->set('__CREATED', time());
        }
        elseif ((time() - $this->get('__CREATED')) > $this->duration) {
            session_regenerate_id(true);
            $this->set('__CREATED', time());
        }

        return $this;
    }

    public function isActive() {
        return session_status() === PHP_SESSION_ACTIVE;
    }

    public function id() {
        return session_id();
    }

    public function get($prop = null, $default = null) {
        if (!$prop)
            return isset($_SESSION) ? $_SESSION : [];
        return isset($_SESSION[$prop]) ? $_SESSION[$prop] : $default;
    }

    public function set($prop, $val) {
        $_SESSION[$prop] = $val;

        return $this;
    }

    public function remove($prop) {
        unset($_SESSION[$prop]);

        return $this;
    }

    public function close() {
        session_write_close();

        return $this;
    }
}