<?php
namespace Openmessage\User\User\Repo;

class FetchUserRepo extends RepoBase
{
    public function fetchOneByUserId($userId)
    {
        return $this->cnn->select()
            ->from('user')
            ->where('userId', '=', $userId)
            ->fetchDtoOne('Openmessage\User\User\Dto\UserDto');
    }
}
