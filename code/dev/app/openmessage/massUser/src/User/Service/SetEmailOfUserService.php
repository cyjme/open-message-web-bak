<?php
namespace Openmessage\MassUser\User\Service;

use Openmessage\MassUser\User\Repo\SetEmailOfUserRepo;
use Openmessage\User\User\Dto\UserEmailDto;

class SetEmailOfUserService extends ServiceBase
{
    public function setEmailOfUser(UserEmailDto $user)
    {
        obj(new SetEmailOfUserRepo($this->getDmg()))
            ->setEmailOfUser($user);
    }
}
