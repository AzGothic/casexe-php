<?php

namespace app\base;

/**
 * Config class definition
 */
class Config
{
    protected static $config;

    public function __construct(array $config) {
        self::$config = $config;

        return $this;
    }

    public function __get($name) {
        return isset(self::$config[$name])
                ? self::$config[$name]
                : null;
    }
}

