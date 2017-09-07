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

    protected function getOAuth2Server()
    {
        return $this->app->getOAuth2Server();
    }

    protected function getOAuth2Storage()
    {
        return $this->app->getOAuth2Storage();
    }
}
