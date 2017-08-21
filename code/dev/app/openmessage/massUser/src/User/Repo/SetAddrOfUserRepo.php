<?php
namespace Openmessage\MassUser\User\Repo;

use Openmessage\User\User\Dto\UserAddrDto;

class SetAddrOfUserRepo extends RepoBase
{
    public function setAddrOfUser(UserAddrDto $userAddr)
    {
        $now = micro_date();
        $userAddr->setChanged($now);

        $this->cnn->update('user_addr')
            ->where('userAddrId', '=', $userAddr->getUserAddrId())
            
            ->set('addr', trim($userAddr->getAddr()))
            ->execute();
    }
}
