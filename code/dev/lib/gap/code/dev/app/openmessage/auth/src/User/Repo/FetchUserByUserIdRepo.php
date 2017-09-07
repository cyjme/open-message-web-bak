<?php
namespace Openmessage\Auth\User\Repo;

use Gap\Exception\ClientException;

class FetchUserByUserIdRepo extends RepoBase
{
    public function fetchOneByUserId($userId)
    {
        if (!$userId) {
            throw new ClientException('userId cannot be null');
        }

        return $this->cnn->select()
            ->from(['user', 'u'])
            ->where('userId', '=', $userId)
            ->fetchDtoOne('Openmessage\Auth\User\Dto\UserDto');
    }
}
