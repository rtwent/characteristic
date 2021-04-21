<?php
declare(strict_types=1);

namespace App\EventSubscriber;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Psr\Log\LoggerInterface;

class ErrorSubscriber implements EventSubscriberInterface
{

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @inheritDoc
     * @return array|string[]
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onException',
        ];
    }

    /**
     * Global exception handler
     * @param ExceptionEvent $event
     * @return void
     */
    public function onException(ExceptionEvent $event)
    {
        $statusCode = ($event->getThrowable()->getCode() === 0) ? Response::HTTP_BAD_GATEWAY : $event->getThrowable()->getCode();
        if ($statusCode > Response::HTTP_NOT_EXTENDED) {
            $statusCode = Response::HTTP_BAD_GATEWAY;
        }

        $error = [
            'success' => false,
            'error' => $event->getThrowable()->getMessage(),
            'code' => $statusCode,
            'trace' => explode("\n", $event->getThrowable()->getTraceAsString())
        ];

        $this->logger->error(\sprintf("%s %s", $event->getThrowable()->getMessage(), $event->getThrowable()->getTraceAsString()));

        $response = new JsonResponse($error);
        $response->setStatusCode($statusCode);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->send();
    }

}