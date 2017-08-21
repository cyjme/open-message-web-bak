<?php
namespace Gap\Third\Swoole\Message;

use Gap\Third\Swoole\App\MsgApp;
use Gap\Contract\Task\Task;

abstract class MessageBase
{
    protected $app;

    public function __construct(MsgApp $app)
    {
        $this->app = $app;
    }
}
