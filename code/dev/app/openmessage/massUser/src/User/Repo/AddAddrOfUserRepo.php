<?php
namespace Openmessage\MassUser\User\Repo;

use Openmessage\User\User\Dto\UserAddrDto;

class AddAddrOfUserRepo extends RepoBase
{
    public function add(UserAddrDto $userAddr)
    {
        $now = micro_date();
        $userAddr->setCreated($now);
        $userAddr->setChanged($now);
        $userAddr->setIsActive(1);
        $userAddr->setIsPrimary(0);
        $userAddr->setUserAddrId($this->cnn->zid());

        $this->cnn->insert('user_addr')
            ->value('userAddrId', $userAddr->getUserAddrId())
            ->value('userId', $userAddr->getUserId())
            ->value('addr', $userAddr->getAddr())
            ->value('isActive', $userAddr->getIsActive())
            ->value('isPrimary', $userAddr->getIsPrimary())
            ->value('created', $userAddr->getCreated())
            ->value('changed', $userAddr->getChanged())
            ->execute();
    }
}
