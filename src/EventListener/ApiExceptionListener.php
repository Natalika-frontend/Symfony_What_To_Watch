<?php

namespace App\EventListener;

use App\Exceptions\EntityNotFoundException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

final class ApiExceptionListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $statusCode = 500;

        if ($exception instanceof EntityNotFoundException) {
            $statusCode = 404;
        } elseif ($exception instanceof HttpExceptionInterface) {
            $statusCode = $exception->getStatusCode();
        }

        $response = new JsonResponse([
            'message' => $exception->getMessage()
        ], $statusCode);

        $event->setResponse($response);
    }
}
