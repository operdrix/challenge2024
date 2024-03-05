<?php

namespace App\EventListener;

use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\Event\FailedMessageEvent;
use Symfony\Component\Mailer\Event\SentMessageEvent;

class MailerListener implements EventSubscriberInterface
{
    public function __construct(
        private LoggerInterface $logger
    ) {
    }
    public static function getSubscribedEvents(): array
    {
        return [
            SentMessageEvent::class => 'onMessageSent',
            FailedMessageEvent::class => 'onFailedMessage'
        ];
    }

    public function onMessageSent(SentMessageEvent $event): void
    {
        $this->logger->info('Message sent at ' . (new \DateTime())->format('d/m/Y h:i:s'));
    }

    public function onFailedMessage(FailedMessageEvent $event): void
    {
        $this->logger->error('Failed while attempting to send an email at ' . (new \DateTime())->format('d/m/Y h:i:s'));
        $this->logger->error('Error: ' . $event->getError());
    }
}
