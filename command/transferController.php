<?php

namespace app\command;

use app\model\{
    Winners,
    Payment
};

class transferController extends \app\base\ControllerCli
{
    public function indexAction()
    {
        $limit = (int) $this->request()->command(0, 10 /* default: 10 */);
        $this->_('Search winners, limit ' . $limit);
        $winners = Winners::getForTransfer($limit);

        if (!$winners)
            return $this->_('Nothing found');
        $this->_('Found ' . count($winners) . ' winners for transfer')->n();

        foreach ($winners as $num => $winner) {
            $this->_(++$num . '. ' . $winner->value . ' EURO --> ' . $winner->user->name . ' (card ' . $winner->user->card . ')');
            Payment::process($winner->user->id);
            $this->_('Done')->n();
        }

        return $this->_('All selected payments transfered');
    }
}