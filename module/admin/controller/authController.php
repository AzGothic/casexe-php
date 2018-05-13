<?php

namespace app\module\admin\controller;

use App;
use app\module\admin\model\Admin;
use app\base\helper\HelperArray;

class authController extends base\Controller
{
    public function indexAction() {
        return $this->redirect('/admin/auth/login', 301);
    }

    public function loginAction() {
        $redirect = urldecode($this->request()->get('redirect', '/admin'));

        if (Admin::relogin()) {
            return $this->redirect($redirect);
        }

        $form = [
            'email'    => '',
            'password' => '',
        ];
        if ($this->request()->isPost()) {
            $form = HelperArray::merge($form, $this->request()->post());
            if ((new Admin)->loginByEmailPassword($form['email'], $form['password'])) {
                return $this->redirect($redirect);
            }
        }

        return $this->render(['auth/login', 'admin'], [
            'form' => $form,
        ]);
    }

    public function logoutAction() {
        (new Admin)->logout();
        return $this->redirect('/admin/auth/login', 302);
    }
}

