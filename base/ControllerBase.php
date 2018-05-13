<?php

namespace app\base;

use App;

/**
 * ControllerBase class definition
 */
class ControllerBase
{
    public function __construct() {

    }

    public function request() {
        return App::i()->request;
    }

    public static function runAction($controller, $action) {
        if (!($controller instanceof ControllerBase)) {
            if (strpos($controller, 'Controller') === false) {
                $controller .= 'Controller';
            }
            $controller = new $controller();
        }
        if (strpos($action, 'Action') === false) {
            $action .= 'Action';
        }
        return $controller->$action();
    }
}

