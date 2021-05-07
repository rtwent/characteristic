<?php
declare(strict_types=1);

namespace App\EventSubscriber;


use App\dto\ErrorDto;
use App\Exceptions\RequestValidation;
use App\Exceptions\ValidationFail;
use App\Exceptions\ValueObjectConstraint;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Psr\Log\LoggerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ErrorSubscriber implements EventSubscriberInterface
{

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;
    private NormalizerInterface $normalizer;

    public function __construct(LoggerInterface $logger, NormalizerInterface $normalizer)
    {
        $this->logger = $logger;
        $this->normalizer = $normalizer;
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
        $throwable = $event->getThrowable();
        $statusCode = ($throwable->getCode() === 0) ? Response::HTTP_BAD_GATEWAY : $throwable->getCode();
        if ($statusCode > Response::HTTP_NOT_EXTENDED) {
            $statusCode = Response::HTTP_BAD_GATEWAY;
        }

        if ($throwable instanceof HttpException) {
            /** @var  HttpException $throwable */
            $statusCode = $throwable->getStatusCode();
        }
        if ($throwable instanceof ValueObjectConstraint || $throwable instanceof RequestValidation || $throwable instanceof ValidationFail) {
            $statusCode = Response::HTTP_BAD_REQUEST;
        }

        $errorDto = new ErrorDto(
            $throwable->getMessage(),
            $statusCode,
            $throwable->getTraceAsString()
        );

        $this->logger->error(\sprintf("%s %s", $throwable->getMessage(), $throwable->getTraceAsString()));

        $response = new JsonResponse($this->normalizer->normalize($errorDto));
        $response->setStatusCode($statusCode);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->send();
    }

}