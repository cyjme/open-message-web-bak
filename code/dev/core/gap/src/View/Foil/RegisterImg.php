<?php
namespace Gap\View\Foil;

class RegisterImg extends RegisterBase
{
    public function register($urlManager)
    {
        $this->engine->registerFunction(
            'imgSrc',
            function ($imgArr, $size, $protocol = '') use ($urlManager) {
                return $urlManager->imgSrc($imgArr, $size, $protocol);
            }
        );
    }
}
