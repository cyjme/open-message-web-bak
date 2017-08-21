<?php
namespace Openmessage\MassClient\App\Service;

use Openmessage\MassClient\App\Repo\ListAppRepo;

class ListAppService extends ServiceBase
{
    public function listByUserId($userId)
    {
        return obj(new ListAppRepo($this->getDmg()))
            ->listByUserId($userId);
    }
}
