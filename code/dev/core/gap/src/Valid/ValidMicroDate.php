<?php
namespace Gap\Valid;

class ValidMicroDate extends Base\ValidBase
{
    public function assert($input, $key = '')
    {
        if (date_create_from_format('Y-m-d\TH:i:s.u', $input) === false) {
            throw $this->exportException('datetime-error-format', $key);
        }
    }
}
