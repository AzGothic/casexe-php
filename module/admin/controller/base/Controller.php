<?php

namespace app\module\admin\controller\base;

use App;
use app\module\admin\model\Admin;

class Controller extends \app\base\Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!in_array($this->request()->route['controller'], ['auth'])) {
            if (!Admin::relogin()) {
                $this->redirect('/admin/auth/login?redirect=' . urlencode($this->request()->route['uri']), 301, '401 Unauthorized');
            }
        }

        $this->view()->title = 'Admin';
        $this->view()->layout = ['layout/index', 'admin'];
    }
}

