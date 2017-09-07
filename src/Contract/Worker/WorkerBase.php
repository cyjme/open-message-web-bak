<?php
namespace Gap\Contract\Worker;

use Tec\Swoole\App\ServerApp;
use Gap\Contract\Task\Task;

abstract class WorkerBase
{
    protected $task;
    protected $app;

    public function __construct(ServerApp $app)
    {
        $this->app = $app;
    }

    public function setTask(Task $task)
    {
        $this->task = $task;
    }

    public function work()
    {
        $name = $this->task->getName();
        if (!method_exists($this, $name)) {
            // todo
            throw new \Exception(__class__ . " cannot work task $name");
        }
        $this->$name();
    }
}
