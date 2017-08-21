<?php
namespace Openmessage\MassUser\User\Service;

use Openmessage\MassUser\User\Repo\SetAvtOfUserRepo;
use Openmessage\User\User\Dto\UserDto;

class SetAvtOfUserService extends ServiceBase
{
    public function setAvtOfUser(UserDto $user)
    {
        obj(new SetAvtOfUserRepo($this->getDmg()))
            ->setAvtOfUser($user);
    }
}
