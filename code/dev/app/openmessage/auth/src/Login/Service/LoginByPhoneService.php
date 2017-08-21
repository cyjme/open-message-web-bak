<?php
namespace Openmessage\Auth\Login\Service;

use Openmessage\Auth\User\Repo\FetchUserByPhoneRepo;
use Openmessage\Auth\Login\Repo\UpdateLoginedRepo;
use Gap\Security\PasshashProvider;
use Gap\Exception\ClientException;

class LoginByPhoneService extends ServiceBase
{
    public function login($phone, $password)
    {
        $user = obj(new FetchUserByPhoneRepo($this->getDmg()))
            ->fetchOneByPhone($phone);

        if (!$user) {
            throw new ClientException('not-found', 'phone');
        }

        if (!$user->getIsActive()) {
            throw new ClientException('not-active', 'phone');
        }

        if (!obj(new PasshashProvider)
            ->verify($password, $user->getPasshash())
        ) {
            throw new ClientException('not-match', 'password');
        }

        obj(new UpdateLoginedRepo($this->getDmg()))
            ->updateByUserId($user->getUserId(), micro_date());

        return $user;
    }
}
