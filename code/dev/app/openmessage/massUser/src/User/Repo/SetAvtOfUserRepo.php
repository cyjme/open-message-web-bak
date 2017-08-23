<?php
namespace Openmessage\MassUser\User\Repo;

use Gap\Exception\ClientException;
use Openmessage\User\User\Dto\UserDto;

class SetAvtOfUserRepo extends RepoBase
{
    public function setAvtOfUser(UserDto $user)
    {
        if (!$userId = $user->getUserId()) {
            throw new ClientException('userId cannot be null');
        }

        $now = micro_date();
        $user->setChanged($now);

        $this->cnn->update('user')
            ->where('userId', '=', $userId)
            ->set('avt', trim($user->getAvt()))
            ->execute();
    }
}