<?php

namespace app\model;

use App;

class Lottery extends \app\base\Model
{
    public static function process($userId = null) {
        if ($userId == null) {
            $userId = User::get()->id;
        }

        $pull = [];
        $pull[Winners::TYPE_POINTS] = Winners::TYPE_POINTS;
        if (Options::get('min_prize') <= Options::get('prize_pool_left')) {
            $pull[Winners::TYPE_EURO] = Winners::TYPE_EURO;
        }
        if ($items = Items::getForLottery()) {
            $pull[Winners::TYPE_ITEM] = Winners::TYPE_ITEM;
        }

        /**
         * Processed Type
         */
        $type = array_rand($pull, 1);

        /**
         * Processed Prize by Type
         */
        switch ($type) {
            case Winners::TYPE_ITEM:
                $key   = array_rand($items, 1);
                $value = $items[$key]->id;
                /* block item from lottery */
                Items::setStatusById($value, Items::STATUS_WAITING);
            break;
            case Winners::TYPE_EURO:
                $min   = Options::get('min_prize');
                $max   = Options::get('max_prize') <= Options::get('prize_pool_left')
                        ? Options::get('max_prize')
                        : Options::get('prize_pool_left');
                $value = rand($min, $max);
                /* change prize pool left */
                Options::minusPrizePool($value);
            break;
            case Winners::TYPE_POINTS:
            default:
                $type  = Winners::TYPE_POINTS;
                $min   = Options::get('min_points');
                $max   = Options::get('max_points');
                $value = rand($min, $max);
            break;
        }

        return Winners::setWinner($userId, $type, $value, Winners::STATUS_WAITING);
    }

    public static function acceptPrize($userId = null) {
        if ($userId == null) {
            $userId = User::get()->id;
        }

        if (!$winner = Winners::getByUserId($userId) or $winner->status != Winners::STATUS_WAITING) {
            return false;
        }

        $newStatus = Winners::STATUS_ACCEPTED;
        switch ($winner->type) {
            case Winners::TYPE_ITEM:
                Items::setStatusById($winner->item->id, Items::STATUS_ACCEPTED);
                break;
            case Winners::TYPE_EURO:
                break;
            case Winners::TYPE_POINTS:
            default:
                User::plusPointsById($winner->user_id, $winner->value);
                $newStatus = Winners::STATUS_DONE;
                break;
        }

        return Winners::setStatusById($winner->id, $newStatus);
    }

    public static function changePrize($userId = null) {
        if ($userId == null) {
            $userId = User::get()->id;
        }

        if (!$winner = Winners::getByUserId($userId) or $winner->status != Winners::STATUS_WAITING) {
            return false;
        }

        $newStatus = Winners::STATUS_DONE;
        switch ($winner->type) {
            case Winners::TYPE_ITEM:
                $points = $winner->item->points;
                break;
            case Winners::TYPE_EURO:
                $points = ceil($winner->value * Options::get('convertation_ratio'));
                break;
            case Winners::TYPE_POINTS:
            default:
                return false;
                break;
        }

        User::plusPointsById($winner->user_id, (int) $points);
        return Winners::setStatusById($winner->id, $newStatus);
    }

    public static function rejectPrize($userId = null) {
        if ($userId == null) {
            $userId = User::get()->id;
        }

        if (!$winner = Winners::getByUserId($userId) or $winner->status != Winners::STATUS_WAITING) {
            return false;
        }

        switch ($winner->type) {
            case Winners::TYPE_ITEM:
                Items::setStatusById($winner->item->id, Items::STATUS_IN_LOTTERY);
            break;
            case Winners::TYPE_EURO:
                Options::plusPrizePool($winner->value);
            break;
            case Winners::TYPE_POINTS:
            default:
            break;
        }

        return Winners::setStatusById($winner->id, Winners::STATUS_REJECTED);
    }
}

