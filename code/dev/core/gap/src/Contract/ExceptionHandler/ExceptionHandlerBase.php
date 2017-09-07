<?php
namespace Gap\Contract\ExceptionHandler;

abstract class ExceptionHandlerBase extends \Gap\Contract\Ui\ControllerBase
{
    abstract public function handle(\RuntimeException $exception);
}
