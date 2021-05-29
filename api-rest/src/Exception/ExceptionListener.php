<?php

namespace App\Exception;

use App\Response\JsonMessage;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

/**
 * Class ExceptionListener.
 */
class ExceptionListener
{
    /**
     * @param ExceptionEvent $event
     */
    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        $message = $exception->getMessage();

        switch (true) {
            case $exception instanceof InvalidParameterException:
                $response = JsonMessage::response(
                    JsonResponse::HTTP_BAD_REQUEST,
                    ['message' => ('' !== $message) ? $message : 'Invalid parameters sent']
                );
                break;
            case $exception instanceof NotFoundException:
                $response = JsonMessage::response(
                    JsonResponse::HTTP_NOT_FOUND,
                    ['message' => ('' !== $message) ? $message : 'Resource does not exist']
                );
                break;
            case $exception instanceof AlreadyExistsException:
                $response = JsonMessage::response(
                    JsonResponse::HTTP_CONFLICT,
                    ['message' => ('' !== $message) ? $message : 'Resource already exist']
                );
                break;

            default:
                $response = JsonMessage::response(
                    JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
                    ['message' => ('' !== $message) ? $message : 'Unexpected error']
                );
        }

        $event->setResponse($response);
    }
}
