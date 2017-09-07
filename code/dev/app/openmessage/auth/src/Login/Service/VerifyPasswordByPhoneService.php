<?php
namespace Openmessage\Auth\Login\Service;

use Gap\Exception\ClientException;
use Gap\Security\PasshashProvider;
use Openmessage\Auth\User\Repo\FetchUserByPhoneRepo;

class VerifyPasswordByPhoneService extends ServiceBase
{
    public function verify($phone, $password)
    {
        $user = obj(new FetchUserByPhoneRepo($this->getDmg()))->fetchOneByPhone($phone);

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
