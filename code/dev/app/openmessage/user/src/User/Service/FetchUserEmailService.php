<?php
namespace Openmessage\User\User\Service;

use Openmessage\User\User\Repo\FetchUserEmailRepo;

class FetchUserEmailService extends ServiceBase
{
    public function fetchOneByUserId($userId)
    {
        return obj(new FetchUserEmailRepo($this->getDmg()))
            ->fetchOneByUserId($userId);
    }
}
