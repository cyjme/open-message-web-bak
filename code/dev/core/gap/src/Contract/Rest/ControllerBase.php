<?php
namespace Gap\Contract\Rest;

use Symfony\Component\HttpFoundation\JsonResponse;

abstract class ControllerBase
{
    use \Gap\Contract\Controller\ControllerTrait;

    protected function jsonResponse($data = null, int $status = 200, array $headers = array())
    {
        return new JsonResponse($data, $status, $headers);
    }
}
