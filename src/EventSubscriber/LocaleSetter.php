<?php


namespace App\EventSubscriber;


use App\Enum\LangsEnum;
use App\Exceptions\InvalidArgument;
use App\Services\Locale\CurrentLanguage;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
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
        $lang = $request->query->get('lang', $_ENV['DEFAULT_LANG'] ?? '');
        if (empty($lang)) {
            throw new InvalidArgument("Application language can not be empty. Set env file with param DEFAULT_LANG", Response::HTTP_BAD_REQUEST);
        }

        if (!LangsEnum::accepts($lang)) {
            throw new InvalidArgument(sprintf("Language %s is not supported", $lang));
        }

        $request->setLocale($lang);
        CurrentLanguage::getInstance()->setLang($lang);
    }


}