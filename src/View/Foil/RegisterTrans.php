<?php
namespace Gap\View\Foil;

class RegisterTrans extends RegisterBase
{
    public function register($translator)
    {
        $this->engine->registerFunction(
            'trans',
            function ($str, $vars = [], $localeKey = '') use ($translator) {
                if ($str) {
                    return $translator->get($str, $vars, $localeKey);
                }

                return '';
            }
        );
    }
}
