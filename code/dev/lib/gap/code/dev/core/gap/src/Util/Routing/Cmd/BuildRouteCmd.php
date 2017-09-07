<?php
namespace Gap\Util\Routing\Cmd;

use Gap\Routing\RouterManager;

class BuildRouteCmd extends CmdBase
{
    public function run()
    {
        $config = $this->app->getConfig();
        $routerManager = new RouterManager($config->get('baseDir'), 'console');
        $router = $routerManager->buildRouter($config->get('router'));
        //var_dump($router->getRestRoutes());

        $baseDir = $config->get('baseDir');
        $this->writeJsRouter(
            $baseDir . '/dev/front/js/setting/router/rest.local.js',
            $router->getRestRoutes()
        );
    }

    protected function writeJsRouter($path, $data)
    {
        $this->makePathDir($path);

        file_put_contents($path, implode([
            'let route = ',
            json_encode($data),
            '; ',
            'export {route};'
        ]));
        $this->echoGreen("Wrote js config to $path");
    }

    protected function makePathDir($path)
    {
        $dir = pathinfo($path, PATHINFO_DIRNAME);
        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }
    }

    protected function echoGreen($msg)
    {
        $green = "\033[0;32m";
        $noColor = "\033[0m";
        echo $green . $msg . $noColor . "\n";
    }
}
