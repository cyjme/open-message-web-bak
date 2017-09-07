<?php
namespace Openmessage\User\User\Repo;

class FetchUserEmailRepo extends RepoBase
{
    public function fetchOneByUserId($userId)
    {
        return $this->cnn->select()
            ->from('user_email')
            ->where('userId', '=', $userId)
            ->fetchDtoOne('Openmessage\User\User\Dto\UserEmailDto');
    }
}
