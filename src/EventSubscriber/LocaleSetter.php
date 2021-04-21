<?php


namespace App\EventSubscriber;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class LocaleSetter implements EventSubscriberInterface
{

    /**
     * @inheritDoc
     * setting up the priority (can be see by php bin/console debug:event kernel.request)
     * @see https://symfony.com/doc/current/translation/locale.html (registering locale)
     * @return array|string[]
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 12],
        ];
    }


    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();
        // $request->headers->all()
        // some logic to determine the $locale
        $request->setLocale('ru');
    }


}