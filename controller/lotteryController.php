<?php

namespace app\controller;

use App;
use app\controller\base\Controller;
use app\model\{
    User,
    Items,
    Options,
    Winners,
    Lottery,
    Payment
};

class lotteryController extends Controller
{
    public function indexAction() {
        return $this->render('lottery/index');
    }

    public function prizesAction() {
        if (!$this->request()->isAjax()) {
            return $this->render('errors/denied');
        }

        return $this->partial('lottery/prizes', [
            'items'   => Items::getForLottery(),
            'options' => Options::get(),
        ]);
    }

    public function boxAction() {
        if (!$this->request()->isAjax()) {
            return $this->render('errors/denied');
        }

        return $this->partial('lottery/box', [
            'winner' => Winners::getByUserId(),
        ]);
    }

    public function playAction() {
        if (!$this->request()->isAjax()) {
            return $this->render('errors/denied');
        }

        if (Winners::existsByUserId()) {
            return $this->render('errors/played');
        }

        Lottery::process();

        return static::runAction($this, 'box');
    }

    public function acceptAction() {
        if (!$this->request()->isAjax()) {
            return $this->render('errors/denied');
        }

        if (!Winners::existsByUserId()) {
            return $this->render('errors/denied');
        }

        Lottery::acceptPrize();

        return static::runAction($this, 'box');
    }

    public function rejectAction() {
        if (!$this->request()->isAjax()) {
            return $this->render('errors/denied');
        }

        if (!Winners::existsByUserId()) {
            return $this->render('errors/denied');
        }

        Lottery::rejectPrize();

        return static::runAction($this, 'box');
    }

    public function paymentAction() {
        if (!$this->request()->isAjax()) {
            return $this->render('errors/denied');
        }

        if (!Winners::existsByUserId()) {
            return $this->render('errors/denied');
        }

        Payment::process();

        return static::runAction($this, 'box');
    }

    /**
     * Only for DEVELOPMENT
     */
    public function clearAction() {
        if (APP_ENV === 'prod') {
            return $this->render('errors/denied');
        }

        Winners::clearByUserId();
        return $this->redirect('/lottery', 301);
    }
}

