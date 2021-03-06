<?php

namespace app\base;

/**
 * Request definition class
 */
class Request
{
    protected $route;

    public function __construct() {

    }

    public function __get($name) {
        if ($name === 'route') {
            return $this->route();
        }

        return null;
    }

    public function isAjax() {
        return (($this->server('HTTP_X_REQUESTED_WITH')
            and strtolower($this->server('HTTP_X_REQUESTED_WITH')) == 'xmlhttprequest'));
    }

    public function isGet() {
        return $this->getMethod() === 'GET';
    }

    public function isPost() {
        return $this->getMethod() === 'POST';
    }

    public function getMethod() {
        if ($this->server('HTTP_X_HTTP_METHOD_OVERRIDE')) {
            return strtoupper($this->server('HTTP_X_HTTP_METHOD_OVERRIDE'));
        }
        if ($this->server('REQUEST_METHOD')) {
            return strtoupper($this->server('REQUEST_METHOD'));
        }

        return 'GET';
    }

    public function request($prop = null, $default = null) {
        return $this->params($_REQUEST, $prop, $default);
    }

    public function get($prop = null, $default = null) {
        return $this->params($_GET, $prop, $default);
    }

    public function post($prop = null, $default = null) {
        return $this->params($_POST, $prop, $default);
    }

    public function server($prop = null, $default = null) {
        return $this->params($_SERVER, $prop, $default);
    }

    protected function params($props, $prop = null, $default = null) {
        if ($prop === null) {
            return $props;
        }

        return (isset($props[$prop]) ? $props[$prop] : $default);
    }

    public function route() {
        if ($this->route !== null) {
            return $this->route;
        }

        $routeUri = $this->server('REQUEST_URI');
        $routeString = strtolower(trim(parse_url($routeUri, PHP_URL_PATH), '/'));
        if ($routeString == 'index.php') {
            $routeString = '';
        }
        if (!$routeString) {
            $routeString = 'index/index/index';
        }

        $routeParts = explode('/', $routeString);
        $module = $routeParts[0];
        if (!is_dir(MODULE_PATH . $module)) {
            $module = 'index';
            $routeParts = array_combine(range(1, count($routeParts)), array_values($routeParts));
            $routeParts[0] = $module;
            ksort($routeParts);
        }
        for ($i = 1; $i <= 2; $i++) {
            if (empty($routeParts[$i]))
                $routeParts[$i] = 'index';
        }

        return [
            'uri'         => $routeUri,
            'string'      => $routeString,
            'parts'       => $routeParts,
            'module'      => $routeParts[0],
            'controller'  => $routeParts[1],
            'action'      => $routeParts[2],
        ];
    }
}

