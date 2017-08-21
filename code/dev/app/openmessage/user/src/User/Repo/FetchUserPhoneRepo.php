<?php
namespace Openmessage\User\User\Repo;

class FetchUserPhoneRepo extends RepoBase
{
    public function fetchOneByUserId($userId)
    {
        return $this->cnn->select()
            ->from('user_phone')
            ->where('userId', '=', $userId)
            ->fetchDtoOne('Openmessage\User\User\Dto\UserPhoneDto');
    }
}
