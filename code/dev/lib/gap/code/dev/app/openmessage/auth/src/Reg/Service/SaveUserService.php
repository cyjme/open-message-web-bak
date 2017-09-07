<?php
namespace Openmessage\Auth\Reg\Service;

use Openmessage\Auth\Reg\Repo\SaveUserRepo;
use Openmessage\Auth\User\Dto\UserDto;

class SaveUserService extends ServiceBase
{
    public function save(UserDto $user, $email = '', $phone = '')
    {
        return obj(new SaveUserRepo($this->getDmg()))->save($user, $email, $phone);
    }
}
