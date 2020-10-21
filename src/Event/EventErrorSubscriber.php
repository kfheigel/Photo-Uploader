<?php

namespace App\Event;

use Psr\Log\LoggerInterface;
use App\Event\LoginErrorEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class EventErrorSubscriber implements EventSubscriberInterface 
{
    private $logger;
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
    public static function getSubscribedEvents()
    {
        return [
            LoginErrorEvent::NAME => 'onLoginError'
        ];
    }

    public function onLoginError(LoginErrorEvent $event)
    {
        $this->logger->info('Podano błędne dane dla użytkownika '. $event->getUser()->getUserName());
    }
}
