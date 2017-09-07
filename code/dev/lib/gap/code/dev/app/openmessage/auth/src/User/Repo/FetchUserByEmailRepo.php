<?php
namespace Openmessage\Auth\User\Repo;

class FetchUserByEmailRepo extends RepoBase
{
    public function fetchOneByEmail($email)
    {
        return $this->cnn->select()
            ->from(['user', 'u'])
            ->leftJoin(
                ['user_email', 'ue'],
                ['ue', 'userId'],
                '=',
                ['u', 'userId']
            )
            ->where(['ue', 'email'], '=', $email)
            ->fetchDtoOne('Openmessage\Auth\User\Dto\UserDto');
    }
}
