<?php
namespace Openmessage\Auth\User\Service;

use Gap\Exception\ClientException;
use Openmessage\Auth\User\Repo\FetchUserByEmailRepo;
use Openmessage\Auth\User\Repo\FetchUserByPhoneRepo;

class FetchUserByAccountService extends ServiceBase
{
    public function fetchOneByAccount($account)
    {
        if (filter_var($account, FILTER_VALIDATE_EMAIL)) {
            $user = obj(new FetchUserByEmailRepo($this->getDmg()))->fetchOneByEmail($account);
            return $user ?? null;
        }

        if (preg_match('~^(\d{11})$~u', $account)) {
            $user = obj(new FetchUserByPhoneRepo($this->getDmg()))->fetchOneByPhone($account);
            return $user ?? null;
        }
    }
}
