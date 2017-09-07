<?php
namespace Gap\Open;

use Gap\Contract\ExceptionHandler\HandleExceptionBase;
use Symfony\Component\HttpFoundation\JsonResponse;

class HandleOpenException extends HandleExceptionBase
{
    public function handle(\RuntimeException $exception)
    {
        $response = new JsonResponse([
            'error' => $exception->getMessage()
        ]);

        $response->setStatusCode(400);
        return $response;
    }
}
