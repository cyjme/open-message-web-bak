<?php
namespace Openmessage\MassUser\User\Service;

use Openmessage\MassUser\User\Repo\AddAddrOfUserRepo;
use Openmessage\User\User\Dto\UserAddrDto;

class AddAddrOfUserService extends ServiceBase
{
    public function add(UserAddrDto $userAddr)
    {
        obj(new AddAddrOfUserRepo($this->getDmg()))
            ->add($userAddr);
    }
}
