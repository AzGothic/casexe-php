<?php

namespace app\base;

/**
 * RequestCli definition class
 */
class RequestCli
{
    protected $commandParams = [];
    protected $route;

    public function __construct() {

    }

    public function __get($name) {
        if ($name === 'route') {
            return $this->route();
        }

        return null;
    }

    public function server($prop = null, $default = null) {
        return $this->params($_SERVER, $prop, $default);
    }

    public function command($prop = null, $default = null) {
        return $this->params($this->commandParams, $prop, $default);
    }

    protected function params($props, $prop = null, $default = null) {
        if ($prop === null) {
            return $props;
        }

        return (isset($props[$prop]) ? $props[$prop] : $default);
    }

    public function commandProperties(array $props)
    {
        foreach ($props as $key => $name) {
            if ($this->command($key) !== null)
                $this->commandParams[$name] = $this->command($key);
        }

        return $this;
    }

    public function route() {
        if ($this->route !== null) {
            return $this->route;
        }

        $routeUri = '';
        $argv     = [];
        if (!empty($this->server('argv'))) {
            $argv = $this->server('argv');
        }
        $commandLine = implode(' ', $argv);
        if (!empty($argv[1]))
            $routeUri = $argv[1];
        if (count($argv) > 2) {
            unset($argv[0], $argv[1]);
            $this->commandParams = array_values($argv);
        }

        $routeString = strtolower(trim($routeUri, '/'));
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
            'commandLine' => $commandLine,
            'uri'         => $routeUri,
            'string'      => $routeString,
            'parts'       => $routeParts,
            'module'      => $routeParts[0],
            'controller'  => $routeParts[1],
            'action'      => $routeParts[2],
        ];
    }
}

