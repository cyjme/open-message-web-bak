<?php
namespace Gap\Valid;

class ValidStrLength extends Base\ValidBase
{
    protected $min = 3;
    protected $max = 15;

    public function setMin($min)
    {
        $this->min = $min;
        return $this;
    }

    public function setMax($max)
    {
        $this->max = $max;
        return $this;
    }

    public function assert($input, $key = '')
    {
        $len = mb_strlen($input);
        if ($len < $this->min || $len > $this->max) {
            throw $this->exportException(
                ['exception-str-length-min-%s-max-%s', $this->min, $this->max],
                $key
            );
        }
    }
}
