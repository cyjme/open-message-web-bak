<?php
namespace Openmessage\User\User\Repo;

use Openmessage\User\User\Dto\UserAddrDto;

class ListAddrByUserRepo extends RepoBase
{
    public function listByUserId($userId)
    {
        $ssb = $this->cnn->select(
            ['u','*'],
            ['u_a', 'userAddrId', 'userAddrId'],
            ['u_a', 'addr', 'addr'],
            ['u_a', 'isPrimary', 'isPrimary']
        )
        ->from(['user_addr', 'u_a'])
        ->leftJoin(
            ['user', 'u'],
            ['u_a', 'userId'],
            '=',
            ['u', 'userId']
        )
        ->where(['u_a', 'userId'], '=', $userId)
        ->orderBy('created', 'desc');

        return $this->dataSet($ssb, UserAddrDto::class);
    }
}
