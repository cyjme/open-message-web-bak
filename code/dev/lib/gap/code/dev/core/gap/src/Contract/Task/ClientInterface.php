<?php
namespace Gap\Contract\Task;

interface ClientInterface
{
    public function sendTask($workerClass, $taskName, $taskAttrs = []);
}
