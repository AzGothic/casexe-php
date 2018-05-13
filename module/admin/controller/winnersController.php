<?php

namespace app\module\admin\controller;

use app\model\{
    Winners,
    Payment
};

class winnersController extends base\Controller
{
    public function indexAction()
    {
        return $this->render(['winners/index', 'admin'], [
            'winners' => Winners::getAll(),
        ]);
    }

    public function sentAction()
    {
        if (!$this->request()->isAjax())
            return $this->render('errors/denied');

        if (!$winnerId = $this->request()->post('winnerId'))
            return 0;

        return (int) Winners::setStatusById($winnerId, Winners::STATUS_DONE);
    }

    public function transferAction()
    {
        if (!$this->request()->isAjax())
            return $this->render('errors/denied');

        if (!$userId = $this->request()->post('userId'))
            return 0;

        return (int) Payment::process($userId);
    }
}