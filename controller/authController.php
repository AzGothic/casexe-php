<?php

namespace app\controller;

use App;
use app\base\Controller;
use app\model\User;
use app\base\helper\HelperArray;

class authController extends Controller
{
    public function indexAction() {
        return $this->redirect('/auth/login', 301);
    }

    public function loginAction() {
        $redirect = urldecode($this->request()->get('redirect', '/'));

        if (User::relogin()) {
            return $this->redirect($redirect);
        }

        $form = [
            'email'    => '',
            'password' => '',
        ];
        if ($this->request()->isPost()) {
            $form = HelperArray::merge($form, $this->request()->post());
            if ($user = (new User)->loginByEmailPassword($form['email'], $form['password'])) {
                return $this->redirect($redirect);
            }
        }

        return $this->render('auth/login', [
            'form' => $form,
        ]);
    }

    public function logoutAction() {
        (new User)->logout();
        return $this->redirect('/auth/login', 302);
    }
}

