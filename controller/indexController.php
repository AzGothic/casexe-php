<?php

namespace app\controller;

use App;
use app\controller\base\Controller;
use app\model\User;

class indexController extends Controller
{
    public function indexAction() {
        return $this->render('index/index', [
            'user' => User::get(),
        ]);
    }

    public function pointsAction() {
        if (!$this->request()->isAjax()) {
            return $this->render('errors/denied');
        }

        return User::get()->points;
    }
}

