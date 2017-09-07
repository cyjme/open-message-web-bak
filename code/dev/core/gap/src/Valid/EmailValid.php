<?php
namespace Gap\Valid;

// deprecated

class EmailValid extends Base\ValidBase
{
    public function assert($email, $key = '')
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw $this->exportException('not-email', $key);
        }
    }
}
