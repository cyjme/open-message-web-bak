<?php
namespace Gap\Routing;

trait ListRouteTrait
{
    public function getAclRoutes()
    {
        $routes = [];

        foreach ($this->routeMap as $sons) {
            foreach ($sons as $grands) {
                foreach ($grands as $route) {
                    if ('acl' === $route->getAccess()) {
                        $routes[] = $route;
                    }
                }
            }
        }

        return $routes;
    }

    public function getUiRoutes()
    {
        return $this->getRoutesByMode('ui');
    }

    public function getRestRoutes()
    {
        return $this->getRoutesByMode('rest');
    }

    protected function getRoutesByMode($mode)
    {
        $routes = [];
        foreach ($this->routeMap as $name => $sons) {
            if ($grands = prop($sons, $mode)) {
                foreach ($grands as $route) {
                    $routes[$name] = $route;
                    /*
                    if ('rest' === $route->getMode()) {
                        $routes[$name] = $route;
                    }
                     */
                }
            }
        }

        return $routes;
    }
}
