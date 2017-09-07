<?php
namespace Gap\Contract\Cmd;

use Gap\App\Console\ConsoleApp;

abstract class CmdBase
{
    protected $app;
    protected $argv;

    public function __construct(ConsoleApp $app, array $argv = [])
    {
        $this->app = $app;
        $this->argv = $argv;
    }
}
