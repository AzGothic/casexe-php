<?php

namespace app\base;

use App;

/**
 * Controller class definition
 */
class Controller
{
    public function __construct() {
        return $this;
    }

    public function request() {
        return App::i()->request;
    }

    public function response() {
        return App::i()->response;
    }

    public function view() {
        return App::i()->view;
    }

    public function partial($view, $params = null) {
        return $this->view()->partial($view, $params);
    }

    public function render($view, $params = null) {
        return $this->view()->render($view, $params);
    }

    public function redirect($url, $code = 302, $messageException = '') {
        return $this->response()->redirect($url, $code, $messageException);
    }

    public static function runAction($controller, $action) {
        if (!($controller instanceof Controller)) {
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

