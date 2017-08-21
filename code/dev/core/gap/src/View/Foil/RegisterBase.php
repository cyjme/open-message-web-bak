<?php
namespace Gap\View\Foil;

class RegisterBase
{
    protected $engine;

    public function __construct($engine)
    {
        $this->engine = $engine;
    }
}
