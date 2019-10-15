<?php

namespace App\ApiListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionListener
{
    function __invoke(ExceptionEvent $event)
    {
        $exception = $event->getException();
        $statusCode = Response::HTTP_BAD_REQUEST;
        if ($exception instanceof HttpExceptionInterface) {
            $statusCode = $exception->getStatusCode();
        }
        $event->setResponse(new JsonResponse(
            ['message' => $exception->getMessage()],
            $statusCode
        ));
    }
}