<?php
namespace Openmessage\MassPush\Push\Service;

use Openmessage\MassPush\Push\Dto\PushDto;
use Openmessage\MassPush\Push\Repo\CreatePushRepo;

class ListPushService extends ServiceBase
{
    public function list()
    {
        return obj(new ListPushService($this->getDmg()))
            ->list();
    }
}
