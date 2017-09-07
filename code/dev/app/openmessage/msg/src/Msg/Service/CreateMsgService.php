<?php
namespace Openmessage\Msg\Msg\Service;

use Openmessage\Msg\Msg\Repo\CreateMsgRepo;
use Openmessage\Msg\Msg\Dto\MsgDto;

class CreateMsgService extends ServiceBase
{
    public function create(MsgDto $msg)
    {
        return obj(new CreateMsgRepo($this->getDmg()))
            ->create($msg);
    }
}
