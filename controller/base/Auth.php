<?php

namespace app\controller\base;

use App;
use app\model\User;

class Auth extends \app\base\Controller
{
    public function __construct() {
        parent::__construct();

        if (!User::relogin()) {
            $this->redirect('/auth/login?redirect=' . urlencode($this->request()->route['uri']), 301, '401 Unauthorized');
        }
    }
}

