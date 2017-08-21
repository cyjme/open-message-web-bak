<?php
namespace Gap\Open;

use Gap\App\Open\OpenApp;
use Gap\Routing\RouterManager;
use Gap\Open\Exception\OpenException;
use Gap\Open\HandleOpenException;
use Gap\Routing\RouteFilterManager;

class OpenHandler
{
    protected $app;
    protected $router;

    public function __construct(OpenApp $app)
    {
        $this->app = $app;
        $this->config = $app->getConfig();

        $routerManager = new RouterManager($this->app->getBaseDir(), 'http');

        if (!$router = $routerManager->getRouter()) {
            $router = $routerManager->buildRouter($this->config->get('router'));
        }
        if ($this->config->get('debug')) {
            $router = $routerManager->buildRouter($this->config->get('router'));
            $routerManager->compile();
        }

        $this->router = $router;
    }

    public function getRouter()
    {
        return $this->router;
    }

    public function handle(Request $request)
    {
        $route = $this->router->dispatch($request);

        try {
            $this->currentRoute = $route;
            obj(new RouteFilterManager())
                ->addFilters([
                    new \Gap\Open\RouteFilter\AccessTokenFilter()
                ])
                ->filter($this->app, $request, $route);
            $request->setRoute($route);
            return $this->callControllerAction($request);
        } catch (OpenException $e) {
            return obj(new HandleOpenException($this->app, $request))
                ->handle($e);
        }
    }

    protected function callControllerAction(Request $request)
    {
        $route = $request->getRoute();
        list($controllerClass, $fun) = explode('@', $route->getAction());

        if (!class_exists($controllerClass)) {
            throw new \Exception("class not found: $controllerClass");
        }

        $controller = new $controllerClass($this->app, $request);

        if (!method_exists($controller, $fun)) {
            throw new \Exception("method not found: $controllerClass::$fun");
        }

        if ($res = $controller->bootstrap()) {
            return $res;
        }

        return $controller->$fun();
    }
}
