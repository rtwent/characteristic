<?php


namespace App\EventSubscriber;


use App\Exceptions\WrongRequest;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


/**
 * Class JsonRequestTransformer
 *
 * Transform requests sending via content-type=application/json into request object for getting it as $request->request->all()
 * @package App\EventSubscriber
 */
class JsonRequestTransformer implements EventSubscriberInterface
{
    /**
     * @inheritDoc
     * @return array|string[]
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => 'onStartRequest',
        ];
    }

    /**
     * @param RequestEvent $event
     */
    public function onStartRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        $content = $request->getContent();
        if (empty($content)) {
            return;
        }

        if ($request->getContentType() !== 'json') {
            return;
        }

        if (!$this->transformJsonBody($request)) {
            throw new WrongRequest(sprintf("Can not parse json from request. Error in parameter: %s", $request->getContent()), null, [], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @param Request $request
     * @return bool
     */
    private function transformJsonBody(Request $request): bool
    {
        $data = json_decode($request->getContent(), true);
        if (json_last_error() !== \JSON_ERROR_NONE) {
            return false;
        }
        if ($data === null) {
            return true;
        }
        $request->request->replace($data);
        return true;
    }

}