<?php

namespace app\base;

use App;

/**
 * Controller class definition
 */
class Controller extends ControllerBase
{
    public function __construct() {
        parent::__construct();
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
}

