<?php
namespace Openmessage\Auth\User\Valid;

use Gap\Valid\WordValid;

class ValidNick
{
    public function assert($word, $key = 'nick')
    {
        obj(new WordValid())
            ->setMin(3)
            ->setMax(32)
            ->assert($word, $key);
    }
}
