<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Event\LogoutEvent;#
use Symfony\Component\Security\Core\Security;

class LogoutEventSubscriber implements EventSubscriberInterface
{
    // private UrlGeneratorInterface $urlGenerator;
    // private FlashBagInterface $flashBag;

    public function __construct(private Security $security, private UrlGeneratorInterface $urlGenerator)
    {
        // $this->flashBag = $flashBag;
        // $this->urlGenerator = $urlGenerator;
    }
    
    public function onLogoutEvent(LogoutEvent $event): void
    {
        $event->getRequest()->getSession()->getFlashBag()->add(
            'success',
            'Bye bye ' . $this->security->getUser()->getFullName() . '. Come again when you want.'
        ); //$event->getToken()->getUser()->getFullName() . '. Come again when you want.'
        

        // $this->flashBag->add(
        //     'success',
        //     'Bye ' . $security->getUser()->getFullName() . '. Come when you want.'
        // );

        $event->setResponse(new RedirectResponse($this->urlGenerator->generate('app_home')));
    }

    public static function getSubscribedEvents(): array
    {
        return [
            LogoutEvent::class => 'onLogoutEvent',
        ];
    }
}
