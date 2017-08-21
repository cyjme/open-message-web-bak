<?php
namespace Openmessage\MassUser\User\Repo;

use Openmessage\User\User\Dto\UserDto;

class SetNameOfUserRepo extends RepoBase
{
    public function setNameOfUser(UserDto $user)
    {
        $now = micro_date();
        $user->setChanged($now);

        $this->cnn->update('user')
            ->where('userId', '=', $user->getUserId())
            
            ->set('nick', trim($user->getNick()))
            ->execute();
    }
}
