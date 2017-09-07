<?php
namespace Gap\View\Foil;

class RegisterUrl extends RegisterBase
{
    public function register($urlManager)
    {
        $this->engine->registerFunction(
            'url',
            function ($site, $uri, $protocol = '') use ($urlManager) {
                return $urlManager->url($site, $uri, $protocol);
            }
        );

        $this->engine->registerFunction(
            'staticUrl',
            function ($uri, $protocol = '') use ($urlManager) {
                return $urlManager->staticUrl($uri, $protocol);
            }
        );

        $this->engine->registerFunction(
            'routeUrl',
            function ($name, $params = [], $query = [], $protocol = '') use ($urlManager) {
                return $urlManager->routeUrl($name, $params, $query, $protocol);
            }
        );

        $this->engine->registerFunction(
            'routeGet',
            function ($name, $params = [], $query = [], $protocol = '') use ($urlManager) {
                return $urlManager->routeGet($name, $params, $query, $protocol);
            }
        );

        $this->engine->registerFunction(
            'routePost',
            function ($name, $params = [], $query = [], $protocol = '') use ($urlManager) {
                return $urlManager->routePost($name, $params, $query, $protocol);
            }
        );

        $this->engine->registerFunction(
            'routeGetRest',
            function ($name, $params = [], $query = [], $protocol = '') use ($urlManager) {
                return $urlManager->routeGetRest($name, $params, $query, $protocol);
            }
        );

        $this->engine->registerFunction(
            'routePostRest',
            function ($name, $params = [], $query = [], $protocol = '') use ($urlManager) {
                return $urlManager->routePostRest($name, $params, $query, $protocol);
            }
        );
    }
}
