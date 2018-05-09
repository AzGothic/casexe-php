<?php

namespace app\base;

/**
 * AppBase class definition
 */
class AppBase extends AppStatic
{
    public function __construct() {
        return $this;
    }

    public function __get($name) {
        if (isset(static::$app[$name])) {
            return static::$app[$name];
        }

        return null;
    }

    protected function load($config) {
        /* set config */
        if ($config instanceof Config) {
            static::$app['config'] = $config;
        } elseif (is_array($config)) {
            static::$app['config'] = new Config($config);
        }
        else {
            throw new \Exception('Wrong config');
        }

        /* set timezone */
        if (self::i()->config->timeZone) {
            if (function_exists('date_default_timezone_set')) {
                date_default_timezone_set(self::i()->config->timeZone);
            }
        }

        /* set view */
        static::$app['view'] = new View;
        if (self::i()->config->view) {
            if (!empty(self::i()->config->view['layout'])) {
                self::i()->view->layout = self::i()->config->view['layout'];
            }
            if (!empty(self::i()->config->view['title'])) {
                self::i()->view->title = self::i()->config->view['title'];
            }
        }

        /* set request */
        static::$app['request'] = new Request;

        /* set response */
        static::$app['response'] = new Response;

        /* routing */
        $route      = self::i()->request->route;
        $controller = '\\app\\controller\\' . $route['controller'] . 'Controller';
        $action     = $route['action'] . 'Action';

        /* process action */
        $content = (new $controller())->$action();
        echo $content;

        return self::i();
    }

    /**
     * App::init()
     * @param array|\app\base\Config $config
     * @return object App::$instance
     */
    public static function init($config) {
        if (!static::$instance or !(static::$instance instanceof App)) {
            static::$instance = new self;
            static::$instance->load($config);
        }

        return static::$instance;
    }

    /**
     * App::i()
     * @return object App::$instance
     */
    public static function i() {
        return static::$instance;
    }
}

