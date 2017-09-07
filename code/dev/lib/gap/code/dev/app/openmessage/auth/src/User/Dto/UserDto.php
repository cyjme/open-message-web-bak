<?php
namespace Openmessage\Auth\User\Dto;

class UserDto extends DtoBase
{
    protected $userId;
    protected $type;
    protected $zcode;
    protected $nick;
    protected $passhash;
    protected $verifyCode;
    protected $privilege = 0;
    protected $isActive = 0;
    protected $weixin;
    protected $avt;
    protected $logined;
    protected $created;
    protected $changed;
}
