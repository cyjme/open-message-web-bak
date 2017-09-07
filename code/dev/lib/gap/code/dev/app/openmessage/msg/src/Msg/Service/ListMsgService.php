<?php
namespace Openmessage\Msg\Msg\Service;

use Openmessage\Msg\Msg\Repo\ListMsgRepo;

class ListMsgService extends ServiceBase
{
    public function list($accId)
    {
        return obj(new ListMsgRepo($this->getDmg()))
            ->list($accId);
    }
}
