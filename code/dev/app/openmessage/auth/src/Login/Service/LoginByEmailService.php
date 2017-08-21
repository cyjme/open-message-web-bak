<?php
namespace Openmessage\Auth\Login\Service;

use Openmessage\Auth\User\Repo\FetchUserByEmailRepo;
use Openmessage\Auth\Login\Repo\UpdateLoginedRepo;
use Gap\Security\PasshashProvider;
use Gap\Exception\ClientException;

class LoginByEmailService extends ServiceBase
{
    public function login($email, $password)
    {
        $user = obj(new FetchUserByEmailRepo($this->getDmg()))
            ->fetchOneByEmail($email);

        if (!$user) {
            throw new ClientException('not-found', 'email');
        }

        if (!$user->getIsActive()) {
            throw new ClientException('not-active', 'email');
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
