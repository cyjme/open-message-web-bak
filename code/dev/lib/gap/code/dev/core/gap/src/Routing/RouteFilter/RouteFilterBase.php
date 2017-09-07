<?php
namespace Gap\Routing\RouteFilter;

use Gap\App\App;
use Gap\Http\Request;
use Gap\Routing\Route;

class RouteFilterBase
{
    protected $app;
    protected $request;

    public function setApp(App $app)
    {
        $this->app = $app;
    }

    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    public function setRoute(Route $route)
    {
        $this->route = $route;
    }
}
