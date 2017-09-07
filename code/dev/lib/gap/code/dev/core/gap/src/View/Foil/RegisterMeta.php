<?php
namespace Gap\View\Foil;

class RegisterMeta extends RegisterBase
{
    public function register($meta)
    {
        $this->engine->registerFunction(
            'meta',
            function ($str, $vars = [], $localeKey = '') use ($meta) {
                return $meta->get($str, $vars, $localeKey);
            }
        );
    }
}
