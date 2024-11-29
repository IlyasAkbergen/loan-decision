<?php

declare(strict_types=1);

namespace App\Handler\Messenger;

use App\Domain\Event\LoanCreatedEvent;
use App\Domain\Repository\ClientRepositoryInterface;
use App\Domain\Service\Messaging\MessageSender;
use App\Domain\ValueObject\Message;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class LoanCreatedEventHandler
{
    public function __construct(
        private ClientRepositoryInterface $clientRepository,
        private MessageSender $messageSender,
    ) {
    }

    public function __invoke(LoanCreatedEvent $event): void
    {
        $client = $this->clientRepository->findById($event->clientId);
        $this->messageSender->send(
            $client,
            new Message(sprintf('Dear %s, Loan with ID %s has been created', $client->fullName, $event->loanId)),
        );
    }
}
