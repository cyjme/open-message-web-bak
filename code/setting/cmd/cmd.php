<?php
return [
    //
    // system cmd
    //
    'test' => 'Gap\Util\Test\Cmd\TestCmd',
    'buildConfig' => 'Gap\Util\Config\Cmd\BuildConfigCmd',

    'buildRoute' => 'Gap\Util\Routing\Cmd\BuildRouteCmd',
    'printRouteMap' => 'Gap\Util\Routing\Cmd\PrintRouteMapCmd',
    'listRoute' => 'Gap\Util\Routing\Cmd\ListRouteCmd',

    'buildApp' => 'Gap\Util\Coder\Cmd\BuildAppCmd',
    'removeApp' => 'Gap\Util\Coder\Cmd\RemoveAppCmd',
    'listApp' => 'Gap\Util\Coder\Cmd\ListAppCmd',
    'buildModule' => 'Gap\Util\Coder\Cmd\BuildModuleCmd',
    'listModule' => 'Gap\Util\Coder\Cmd\ListModuleCmd',
    'buildEntity' => 'Gap\Util\Coder\Cmd\BuildEntityCmd',

    // customer cmd
];
