<?php
namespace Openmessage\Auth\Reg\Service;

use Openmessage\Auth\User\Dto\UserDto;
use Openmessage\Auth\Reg\Repo\RegByPhoneRepo;

class RegByPhoneService extends ServiceBase
{
    public function create(UserDto $user, $phone)
    {
        obj(new RegByPhoneRepo($this->getDmg()))->create($user, $phone);
    }
}
