<?php
namespace Gap\Routing;

trait AddRouteTrait
{
    public function addRoute($opts)
    {
        $opts['site'] = $this->site;
        $opts['app'] = $this->app;
        $opts['access'] = $this->access;

        $route = new Route($opts);

        $routeCollector = $this->getRouteCollector($route->getSite());
        $routeCollector->addRoute($route);

        $name = $route->getName();
        $mode = $route->getMode();
        $httpMethod = $route->getMethod();

        if (isset($this->routeMap[$name][$mode][$httpMethod])) {
            throw new \Exception("route $name - $mode - $httpMethod already exists");
        }

        $this->routeMap[$name][$mode][$httpMethod] = $route;
    }

    public function get($pattern, $name, $action)
    {
        $this->addRoute([
            'method' => 'GET',
            'pattern' => $pattern,
            'name' => $name,
            'action' => $action
        ]);
        return $this;
    }

    public function post($pattern, $name, $action)
    {
        $this->addRoute([
            'method' => 'POST',
            'pattern' => $pattern,
            'name' => $name,
            'action' => $action
        ]);
        return $this;
    }

    public function getRest($pattern, $name, $action)
    {
        $this->addRoute([
            'method' => 'GET',
            'pattern' => $pattern,
            'mode' => 'rest',
            'name' => $name,
            'action' => $action
        ]);
        return $this;
    }

    public function postRest($pattern, $name, $action)
    {
        $this->addRoute([
            'method' => 'POST',
            'pattern' => $pattern,
            'mode' => 'rest',
            'name' => $name,
            'action' => $action
        ]);
        return $this;
    }

    public function getOpen($pattern, $name, $action)
    {
        $this->addRoute([
            'method' => 'GET',
            'pattern' => $pattern,
            'mode' => 'open',
            'name' => $name,
            'action' => $action
        ]);
        return $this;
    }

    public function postOpen($pattern, $name, $action)
    {
        $this->addRoute([
            'method' => 'POST',
            'pattern' => $pattern,
            'mode' => 'open',
            'name' => $name,
            'action' => $action
        ]);
        return $this;
    }
}
