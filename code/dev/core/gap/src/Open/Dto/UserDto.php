<?php
namespace Gap\Open\Dto;

use Gap\Contract\Dto\DtoBase;

class UserDto extends DtoBase
{
    protected $userId;
    protected $zcode;
    protected $nick;
    protected $weixin;
    protected $phone;
    protected $email;
    protected $privilege;
    protected $isActive;
    protected $logined;
    protected $created;
    protected $changed;
    protected $avt;
}
