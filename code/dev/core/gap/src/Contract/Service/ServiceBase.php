<?php
namespace Gap\Contract\Service;

use Gap\App\App;

abstract class ServiceBase
{
    protected $app;

    public function __construct(App $app)
    {
        $this->app = $app;
    }

    protected function getConfig()
    {
        return $this->app->getConfig();
    }

    protected function getDmg()
    {
        return $this->app->getDmg();
    }
}
