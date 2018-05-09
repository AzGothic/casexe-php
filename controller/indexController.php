<?php

namespace app\controller;

class indexController extends \app\base\Controller
{
    public function indexAction() {
        return $this->render('index/index', [
            
        ]);
    }
}

