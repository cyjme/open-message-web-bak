<?php
namespace Openmessage\User\User\Service;

use Openmessage\User\User\Repo\FetchUserRepo;

class FetchUserService extends ServiceBase
{
    public function fetchOneByUserId($userId)
    {
        return obj(new FetchUserRepo($this->getDmg()))
            ->fetchOneByUserId($userId);
    }
}
