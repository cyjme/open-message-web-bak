<?php
namespace Openmessage\MassPush\Push\Service;

use Openmessage\MassPush\Push\Dto\PushDto;
use Openmessage\MassPush\Push\Repo\CreatePushRepo;

class CreatePushService extends ServiceBase
{
    public function create(PushDto $push)
    {
        return obj(new CreatePushRepo($this->getDmg()))
            ->create($push);
    }
}
