<?php
namespace Openmessage\Auth\Reg\Repo;

use Openmessage\Auth\User\Dto\UserDto;

class ResetByAccountRepo extends RepoBase
{
    public function resetByAccount(UserDto $user)
    {
        $now = micro_date();
        $this->cnn->update('user')
            ->where('userId', '=', $user->getUserId())
            ->set('passhash', $user->getPasshash())
            ->set('changed', $now)
            ->execute();
    }
}
