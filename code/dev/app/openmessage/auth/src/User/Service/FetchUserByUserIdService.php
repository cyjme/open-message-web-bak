<?php
namespace Openmessage\Auth\User\Service;

use Gap\Exception\ClientException;
use Openmessage\Auth\User\Repo\FetchUserByEmailRepo;
use Openmessage\Auth\User\Repo\FetchUserByPhoneRepo;
use Openmessage\Auth\User\Repo\FetchUserByUserIdRepo;

class FetchUserByUserIdService extends ServiceBase
{
    public function fetchOneByUserId($userId)
    {
        return obj(new FetchUserByUserIdRepo($this->getDmg()))->fetchOneByUserId($userId);
    }
}
