<?php
namespace Openmessage\Auth\Login\Service;

use Gap\Exception\ClientException;
use Gap\Security\PasshashProvider;
use Openmessage\Auth\User\Repo\FetchUserByEmailRepo;

class VerifyPasswordByEmailService extends ServiceBase
{
    public function verify($email, $password)
    {
        $user = obj(new FetchUserByEmailRepo($this->getDmg()))->fetchOneByEmail($email);

        if (!$user) {
            throw new ClientException('user not exists');
        }

        if (!$user->getIsActive()) {
            throw new ClientException('user not active');
        }

        if (!obj(new PasshashProvider())->verify(
            $password,
            $user->getPasshash()
        )) {
            return false;
        }

        return true;
    }
}
