<?php

use app\base\{
    Config,
    Db,
    RequestCli,
    ControllerCli
};

/**
 * App Cli class definition
 */
class App extends app\base\AppBase
{
    protected function load($config)
    {
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

        /* set timezone */
        if (self::i()->config->timeZone) {
            if (function_exists('date_default_timezone_set')) {
                date_default_timezone_set(self::i()->config->timeZone);
            }
        }

        /* set request */
        static::$app['request'] = new RequestCli;

        /* routing */
        $route      = self::i()->request->route;
        $controller = '\\app' . ($route['module'] != 'index' ? "\\module\\" . $route['module'] : '')
            . '\\command\\' . $route['controller'] . 'Controller';
        $action     = $route['action'] . 'Action';

        /* process action */
        ControllerCli::runAction($controller, $action);
    }
}

