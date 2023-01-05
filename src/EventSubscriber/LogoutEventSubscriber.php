<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Event\LogoutEvent;

class LogoutEventSubscriber implements EventSubscriberInterface
{
    // private UrlGeneratorInterface $urlGenerator;
    // private FlashBagInterface $flashBag;

    public function __construct(private FlashBagInterface $flashBag, private UrlGeneratorInterface $urlGenerator)
    {
        // $this->flashBag = $flashBag;
        // $this->urlGenerator = $urlGenerator;
    }
    
    public function onLogoutEvent(LogoutEvent $event): void
    {
        // $event->getRequest()->getSession()->getFlashBag()->add(
        //     'success',
        //     'Logged out successfully'
        // );

        $this->flashBag->add(
            'success',
            'Logged out successfully'
        );

        $event->setResponse(new RedirectResponse($this->urlGenerator->generate('app_home')));
    }

    public static function getSubscribedEvents(): array
    {
        return [
            LogoutEvent::class => 'onLogoutEvent',
        ];
    }
}
