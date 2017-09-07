<?php
namespace Gap\Http;

use Gap\App\Http\HttpApp;
use Gap\Routing\RouterListener;
use Gap\Routing\RouterManager;
use Gap\Routing\RouteFilterManager;
use Gap\Exception\NotLoginException;
use Gap\Exception\NoPermissionException;
use Gap\Routing\Route;

class HttpHandler
{
    protected $app;
    protected $router;

    public function __construct(HttpApp $app)
    {
        $this->app = $app;

        $routerManager = new RouterManager($this->app->getBaseDir(), 'http');
        $this->config = $this->app->getConfig();

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
                    new \Gap\Routing\RouteFilter\LoginFilter(),
                    new \Gap\Routing\RouteFilter\PrivilegeFilter(),
                    new \Gap\Routing\RouteFilter\AclFilter()
                ])
                ->filter($this->app, $request, $route);
            $request->setRoute($route);
            return $this->callControllerAction($request);
        } catch (NotLoginException $e) {
            return $this->handleException(
                $request,
                $this->config->get('exception.handler.notLogin'),
                $e
            );
        } catch (NoPermissionException $e) {
            return $this->handleException(
                $request,
                $this->config->get('exception.handler.noPermission'),
                $e
            );
        }
    }

    protected function callControllerAction(Request $request)
    {
        //$handler = $route['handler'];
        //$params = $route['params'];

        $route = $request->getRoute();
        list($controllerClass, $fun) = explode('@', $route->getAction());

        if (!class_exists($controllerClass)) {
            throw new \Exception("class not found: $controllerClass");
        }

        //$request->attributes->set('site', $handler['site']);
        //$request->attributes->set('app', $handler['app']);
        //$request->attributes->set('mode', $handler['mode']);

        $controller = new $controllerClass($this->app, $request);

        if (!method_exists($controller, $fun)) {
            throw new \Exception("method not found: $controllerClass::$fun");
        }

        if ($res = $controller->bootstrap()) {
            return $res;
        }

        return $controller->$fun();
    }

    protected function handleException(Request $request, $handlerClass, $exception)
    {
        $handler = new $handlerClass($this->app, $request);
        return $handler->handle($exception);
    }
}
