<?php
namespace Openmessage\MassUser\User\Service;

use Openmessage\MassUser\User\Repo\SetWeixinOfUserRepo;
use Openmessage\User\User\Dto\UserDto;

class SetWeixinOfUserService extends ServiceBase
{
    public function setWeixinOfUser(UserDto $user)
    {
        obj(new SetWeixinOfUserRepo($this->getDmg()))
            ->setWeixinOfUser($user);
    }
}
