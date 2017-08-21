<?php
namespace Openmessage\Msg\Msg\Service;

use Openmessage\Msg\Msg\Repo\UpdateReadAllTimeRepo;

class UpdateReadAllTimeService extends ServiceBase
{
    public function updateByToken($token)
    {
        return obj(new UpdateReadAllTimeRepo($this->getDmg()))
            ->updateByToken($token);
    }
}
