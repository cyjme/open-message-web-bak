<?php

namespace Gap\Valid;

class ValidPassword extends WordValid
{
    protected $min = 3;
    protected $max = 21;
}
