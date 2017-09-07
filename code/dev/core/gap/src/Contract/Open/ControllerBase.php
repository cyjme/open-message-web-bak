<?php
namespace Gap\Contract\Open;

use Symfony\Component\HttpFoundation\JsonResponse;

abstract class ControllerBase
{
    use \Gap\Contract\Controller\ControllerTrait;

    protected function jsonResponse($data = null, int $status = 200, array $headers = array())
    {
        return new JsonResponse($data, $status, $headers);
    }

    protected function getRouter()
    {
        return $this->app->getRouter();
    }

    protected function getOpenServer()
    {
        return $this->app->getOpenServer();
    }

    protected function getOpenStorage()
    {
        return $this->app->getOpenStorage();
    }
}
