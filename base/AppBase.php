<?php

namespace app\base;

use app\base\exception\RedirectException;

/**
 * AppBase class definition
 */
class AppBase extends AppStatic
{
    public function __construct() {

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

        /* set and connect db */
        static::$app['db'] = new Db;

        /* set and start session */
        static::$app['session'] = new Session;
        if (self::i()->config->session) {
            if (!empty(self::i()->config->session['duration'])) {
                self::i()->session->duration = self::i()->config->session['duration'];
                ini_set('session.gc_maxlifetime', self::i()->config->session['duration']);
                session_set_cookie_params(self::i()->config->session['duration']);
            }
        }
        self::i()->session->start();

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
        $controller = '\\app' . ($route['module'] != 'index' ? "\\module\\" . $route['module'] : '')
            . '\\controller\\' . $route['controller'] . 'Controller';
        $action     = $route['action'] . 'Action';

        /* process action */
        $redirected = false;
        try {
            $content = Controller::runAction($controller, $action);
        } catch (RedirectException $e) {
            $redirected = true;
        }

        if (!$redirected) {
            echo $content;
        }

        /* close session */
        self::i()->session->close();
    }

    /**
     * App::init()
     * @param array|\app\base\Config $config
     * @return object App::$instance
     */
    public static function init($config) {
        if (!static::$instance or !(static::$instance instanceof AppBase)) {
            static::$instance = new static;
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

