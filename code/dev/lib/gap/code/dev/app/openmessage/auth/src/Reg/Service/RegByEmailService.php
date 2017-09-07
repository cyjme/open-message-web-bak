<?php
namespace Openmessage\Auth\Reg\Service;

use Openmessage\Auth\User\Dto\UserDto;
use Openmessage\Auth\Reg\Repo\RegByEmailRepo;

class RegByEmailService extends ServiceBase
{
    public function create(UserDto $user, $email)
    {
        obj(new RegByEmailRepo($this->getDmg()))->create($user, $email);
    }
}
