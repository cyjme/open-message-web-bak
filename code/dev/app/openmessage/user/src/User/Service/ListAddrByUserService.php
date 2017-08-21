<?php
namespace Openmessage\User\User\Service;

use Openmessage\User\User\Repo\ListAddrByUserRepo;

class ListAddrByUserService extends ServiceBase
{
    public function listByUserId($userId)
    {
        return obj(new ListAddrByUserRepo($this->getDmg()))
            ->listByUserId($userId);
    }
}
