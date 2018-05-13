<?php

namespace app\base;


/**
 * ControllerCli class definition
 */
class ControllerCli extends ControllerBase
{
    public function __construct() {
        parent::__construct();
    }

    public function _(string $str)
    {
        echo $str;
        return $this->n();
    }

    public function n()
    {
        echo PHP_EOL;
        return $this;
    }
}

