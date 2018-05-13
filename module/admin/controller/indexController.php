<?php

namespace app\module\admin\controller;

class indexController extends base\Controller
{
    public function indexAction ()
    {
        return $this->redirect('/admin/winners', 301);
    }
}