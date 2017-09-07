<?php
namespace Gap\Valid;

// deprecated

class DateTimeAtomValid extends Base\ValidBase
{
    public function assert($input, $key = '')
    {
        //if (\DateTime::createFromFormat(DATE_ATOM, $input) === false) {
        if (date_create_from_format(DATE_ATOM, $input) === false) {
            throw $this->exportException('datetime-error-format', $key);
        }
    }
}
