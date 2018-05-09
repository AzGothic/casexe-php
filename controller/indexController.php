<?php

namespace app\controller;

use App;

class indexController extends \app\base\Controller
{
    public function indexAction() {
//        $sth = App::i()->db->prepare("SELECT * FROM user LIMIT 1");
//        $sth->execute();
//
//        $result = $sth->fetchAll();
//        echo '<pre>';
//        print_r($result);
//        exit;

//        App::i()->session->set('test', '1111');

        return $this->render('index/index', [
            
        ]);
    }
}

