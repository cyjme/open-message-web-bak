<?php

namespace Gap\Contract\Valid;

use Gap\Exception\ClientException;

abstract class ValidBase
{
    abstract public function assert($input, $key = '');

    public function exportException($msg, $key = '')
    {
        return new ClientException($msg, $key);
    }
}
