<?php
namespace Gap\Contract\Controller;

use Gap\App\App;
use Gap\Config\Config;
use Gap\Http\Request;
use Gap\Exception\NotLoginException;
use Gap\Exception\NoPermissionException;
use Symfony\Component\HttpFoundation\Response;

trait ControllerTrait
{
    protected $app;
    protected $config;

    protected $translator;
    protected $request;
    protected $params = [];

    protected $urlManager;

    public function __construct(App $app, Request $request)
    {
        $this->app = $app;
        $this->config = $app->getConfig();
        $this->request = $request;

        if ($route = $request->getRoute()) {
            $this->params = $route->getParams();
        }
    }

    public function bootstrap()
    {
    }

    public function getUrlManager()
    {
        if ($this->urlManager) {
            return $this->urlManager;
        }

        $this->urlManager = $this->app->getUrlManager($this->request);
        return $this->urlManager;
    }

    protected function routeGet($name, $params = [], $query = [], $protocol = '')
    {
        return $this->getUrlManager()->routeGet($name, $params, $query, $protocol);
    }

    public function getTranslator()
    {
        return $this->app->getTranslator();
    }

    protected function getRequest()
    {
        return $this->request;
    }

    protected function getConfig()
    {
        return $this->config;
    }

    protected function getRouter()
    {
        return $this->app->getRouter();
    }

    protected function getApp()
    {
        return $this->app;
    }

    protected function getParam($key, $default = null)
    {
        return prop($this->params, $key, $default);
    }

    protected function response($content)
    {
        return new Response($content);
    }

    protected function throwNotLogin($msg = '')
    {
        throw new NotLoginException($msg);
    }

    protected function throwNoPermission($msg = '')
    {
        throw new NoPermissionException($msg);
    }
}
