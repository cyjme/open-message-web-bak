<?php
namespace Gap\Third\Swoole\Worker;

use Gap\Contract\Worker\WorkerBase;

class AdminWorker extends WorkerBase
{
    public function reload()
    {
        $this->app->reload();
    }

    /*
    protected function getTaskServer()
    {
        return \Tec\Swoole\Task\Server::app();
    }
     */
}
