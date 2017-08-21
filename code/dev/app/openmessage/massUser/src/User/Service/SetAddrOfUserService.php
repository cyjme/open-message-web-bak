<?php
namespace Openmessage\MassUser\User\Service;

use Openmessage\MassUser\User\Repo\SetAddrOfUserRepo;
use Openmessage\User\User\Dto\UserAddrDto;

class SetAddrOfUserService extends ServiceBase
{
    public function setAddrOfUser(UserAddrDto $userAddr)
    {
        obj(new SetAddrOfUserRepo($this->getDmg()))
            ->setAddrOfUser($userAddr);
    }
}
