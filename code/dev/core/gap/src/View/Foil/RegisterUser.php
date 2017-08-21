<?php
namespace Gap\View\Foil;

class RegisterUser extends RegisterBase
{
    public function register($controller)
    {
        $this->engine->registerFunction(
            'getCurrentUserId',
            function () use ($controller) {
                return $controller->getCurrentUserId();
            }
        );

        $this->engine->registerFunction(
            'getCurrentUser',
            function () use ($controller) {
                return $controller->getCurrentUser();
            }
        );

        $this->engine->registerFunction(
            'getUser',
            function ($userId) use ($controller) {
                return $controller->getUser($userId);
            }
        );
    }
}
