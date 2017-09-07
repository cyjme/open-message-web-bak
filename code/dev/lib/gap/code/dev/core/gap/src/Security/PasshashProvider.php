<?php

namespace Gap\Security;

use Gap\Valid\PasswordValid;

class PasshashProvider
{
    public function hash($password)
    {
        $validator = new PasswordValid();
        $validator->assert($password);

        // Options:
        //  - salt: a random salt will be generated
        //  - cost: a default value of 10 will be used
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function randCode($cost = 8)
    {
        return bin2hex(random_bytes($cost));
    }

    public function verify($password, $hash)
    {
        return password_verify($password, $hash);
    }
}
