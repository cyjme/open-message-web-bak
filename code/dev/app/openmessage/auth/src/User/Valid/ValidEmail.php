<?php
namespace Openmessage\Auth\User\Valid;

use Gap\Valid\NotEmptyValid;
use Gap\Valid\EmailValid;

class ValidEmail extends ValidBase
{
    public function assert($email, $key = 'email')
    {
        obj(new NotEmptyValid())->assert($email, $key);
        obj(new EmailValid())->assert($email, $key);
    }
}
