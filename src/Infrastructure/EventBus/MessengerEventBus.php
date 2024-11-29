<?php

declare(strict_types=1);

namespace App\Infrastructure\EventBus;

use App\Domain\Event\DomainEvent;
use App\Domain\Event\EventBusInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\DispatchAfterCurrentBusStamp;

readonly class MessengerEventBus implements EventBusInterface
{
    public function __construct(private MessageBusInterface $messageBus)
    {
    }

    /**
     * @throws ExceptionInterface
     */
    public function dispatch(DomainEvent ...$domainEvents): void
    {
        foreach ($domainEvents as $currentEvent) {
            $this->messageBus->dispatch(
                (new Envelope($currentEvent))->with(new DispatchAfterCurrentBusStamp()),
            );
        }
    }
}
