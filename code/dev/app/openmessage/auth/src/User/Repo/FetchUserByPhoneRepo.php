<?php
namespace Openmessage\Auth\User\Repo;

class FetchUserByPhoneRepo extends RepoBase
{
    public function fetchOneByPhone($phone)
    {
        return $this->cnn->select()
            ->from(['user', 'u'])
            ->leftJoin(
                ['user_phone', 'ue'],
                ['ue', 'userId'],
                '=',
                ['u', 'userId']
            )
            ->where(['ue', 'phone'], '=', $phone)
            ->fetchDtoOne('Openmessage\Auth\User\Dto\UserDto');
    }
}
