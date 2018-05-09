<?php

namespace app\controller;

use App;
use app\controller\base\Auth;
use app\model\User;

class indexController extends Auth
{
    public function indexAction() {
        return $this->render('index/index', [
            'user' => User::get(),
        ]);
    }
}

