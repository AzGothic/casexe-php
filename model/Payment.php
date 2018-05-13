<?php

namespace app\model;

use App;

class Payment extends \app\base\Model
{
    public static function process($userId = null) {
        if ($userId == null) {
            $userId = User::get()->id;
        }
        $user = (new User)->find($userId);

        if (!$winner = Winners::getByUserId($user->id)
            or $winner->type != Winners::TYPE_EURO
            or $winner->status != Winners::STATUS_ACCEPTED) {
            return false;
        }

        /**
         * Some functionality for working with payment service
         */
        $creditCard     = $user->card;
        $amount         = $winner->value; // in EURO
        $paymentStatus  = true;

        if (!$paymentStatus) {
            return false;
        }

        return Winners::setStatusById($winner->id, Winners::STATUS_DONE);
    }
}

