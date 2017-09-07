<?php
namespace Gap\Util\Routing\Cmd;

use Gap\Routing\RouterManager;

class PrintRouteMapCmd extends CmdBase
{
    public function run()
    {
        $config = $this->app->getConfig();
        $routerManager = new RouterManager($config->get('baseDir'), 'console');
        $router = $routerManager->buildRouter($config->get('router'));

        print_r($router->getRouteMap());
    }
}
