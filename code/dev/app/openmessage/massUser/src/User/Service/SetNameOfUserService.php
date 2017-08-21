<?php
namespace Openmessage\MassUser\User\Service;

use Openmessage\MassUser\User\Repo\SetNameOfUserRepo;
use Openmessage\User\User\Dto\UserDto;

class SetNameOfUserService extends ServiceBase
{
    public function setNameOfUser(UserDto $user)
    {
        obj(new SetNameOfUserRepo($this->getDmg()))
            ->setNameOfUser($user);
    }
}
