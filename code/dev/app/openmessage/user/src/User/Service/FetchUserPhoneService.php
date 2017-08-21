<?php
namespace Openmessage\User\User\Service;

use Openmessage\User\User\Repo\FetchUserPhoneRepo;

class FetchUserPhoneService extends ServiceBase
{
    public function fetchOneByUserId($userId)
    {
        return obj(new FetchUserPhoneRepo($this->getDmg()))
            ->fetchOneByUserId($userId);
    }
}
