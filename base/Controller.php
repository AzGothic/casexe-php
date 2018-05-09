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

    public function view() {
        return App::i()->view;
    }

    public function partial($view, $params = null) {
        return $this->view()->partial($view, $params);
    }

    public function render($view, $params = null) {
        return $this->view()->render($view, $params);
    }
}

