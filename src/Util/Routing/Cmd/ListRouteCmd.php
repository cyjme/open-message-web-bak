<?php
namespace Gap\Util\Routing\Cmd;

use Gap\Routing\RouterManager;

class ListRouteCmd extends CmdBase
{
    public function run()
    {
        $config = $this->app->getConfig();
        $routerManager = new RouterManager($config->get('baseDir'), 'console');
        $router = $routerManager->buildRouter($config->get('router'));

        $routes = [];
        $errors = [];

        foreach ($router->getRouteMap() as $routeName => $set) {
            foreach ($set as $mode => $sons) {
                foreach ($sons as $method => $route) {
                    $action = $route->getAction();
                    $appName = $route->getApp();

                    if (0 !== strpos($action, $appName)) {
                        $errors[] = "$appName - $routeName - $action";
                        continue;
                    }

                    $appLen = strlen($appName);

                    $tplAction = substr($action, $appLen);
                    $moduleName = strstr($tplAction, "\\", true);

                    //echo "$appName - $moduleName - $action - $tplAction \n";
                    //continue;

                    $routes[$appName][$moduleName][$routeName]["$mode$method"] = 1;
                }
            }
        }

        ksort($routes);
        foreach ($routes as $appName => $modules) {
            ksort($modules);
            echo "$appName\n";

            foreach ($modules as $moduleName => $routes) {
                ksort($routes);
                echo " - $moduleName\n";

                foreach ($routes as $routeName => $ways) {
                    echo "  - $routeName ";
                    echo "[" . implode(',', array_keys($ways)) . "]";
                    echo "\n";
                }
                echo "\n";
            }
            echo "\n\n";
        }

        echo "\nerror\n";
        echo " - the action of route does not match with appName: \n";

        foreach ($errors as $error) {
            echo "  - $error\n";
        }

        //print_r($routes);
        //print_r($errors);
    }
}
