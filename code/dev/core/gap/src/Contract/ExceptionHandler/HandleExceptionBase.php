<?php
namespace Gap\Contract\ExceptionHandler;

abstract class HandleExceptionBase extends \Gap\Contract\Ui\ControllerBase
{
    abstract public function handle(\RuntimeException $exception);
}
