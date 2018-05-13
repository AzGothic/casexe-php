<?php

namespace app\model;

use App;
use app\base\Db;

class Winner extends \app\base\Model
{
    protected $user;
    protected $item;

    public function __construct($properties = [])
    {
        parent::__construct();
        foreach ($properties as $property => $value)
            $this->$property = $value;
    }

    public function __get($name)
    {
        if ($name == 'item') {
            if ($this->type != Winners::TYPE_ITEM)
                return null;
            if ($this->item)
                return $this->item;
            return $this->item = Items::getById((int) $this->value);
        }
        elseif ($name == 'user') {
            if ($this->user)
                return $this->user;
            return $this->user = (new User)->find($this->user_id);
        }
        elseif ($name == 'typeText') {
            switch ($this->type) {
                case Winners::TYPE_ITEM:
                    return 'Item';
                    break;
                case Winners::TYPE_EURO:
                    return 'EURO';
                    break;
                case Winners::TYPE_POINTS:
                default:
                    return 'Points';
                    break;
            }
        }
        elseif ($name == 'statusText') {
            switch ($this->status) {
                case Winners::STATUS_ACCEPTED:
                    return 'Accepted';
                    break;
                case Winners::STATUS_REJECTED:
                    return 'Rejected';
                    break;
                case Winners::STATUS_DONE:
                    return 'Done';
                    break;
                case Winners::STATUS_WAITING:
                default:
                    return 'Waiting';
                    break;
            }
        }
    }
}
