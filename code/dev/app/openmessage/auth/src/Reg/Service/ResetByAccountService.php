<?php
namespace Openmessage\Auth\Reg\Service;

use Openmessage\Auth\Reg\Repo\ResetByAccountRepo;
use Openmessage\Auth\User\Dto\UserDto;

class ResetByAccountService extends ServiceBase
{
    public function resetByAccount(UserDto $user)
    {
        return obj(new ResetByAccountRepo($this->getDmg()))->resetByAccount($user);
    }
}
