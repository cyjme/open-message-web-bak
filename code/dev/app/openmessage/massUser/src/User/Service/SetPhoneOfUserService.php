<?php
namespace Openmessage\MassUser\User\Service;

use Openmessage\MassUser\User\Repo\SetPhoneOfUserRepo;
use Openmessage\User\User\Dto\UserPhoneDto;

class SetPhoneOfUserService extends ServiceBase
{
    public function setPhoneOfUser(UserPhoneDto $user)
    {
        obj(new SetPhoneOfUserRepo($this->getDmg()))
            ->setPhoneOfUser($user);
    }
}
