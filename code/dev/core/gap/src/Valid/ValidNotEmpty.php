<?php
namespace Gap\Valid;

class ValidNotEmpty extends Base\ValidBase
{
    public function assert($input, $key = '')
    {
        if (is_string($input)) {
            $input = trim($input);
        }

        if (empty($input)) {
            throw $this->exportException(
                "exception-should-not-empty",
                $key
            );
        }
    }
}
