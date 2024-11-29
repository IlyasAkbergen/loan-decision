<?php

declare(strict_types=1);

namespace App\Domain\Service\Messaging;

use App\Domain\Entity\Client;
use App\Domain\ValueObject\Message;

class MessageSender
{
    public function __construct(
        private MessagingChannelDriverResolver $messagingChannelDriverResolver,
    )
    {
    }

    public function send(Client $client, Message $message): void
    {
        $messagingChannelDriver = $this->messagingChannelDriverResolver->resolve($client);
        $messagingChannelDriver->send($client, $message);
    }
}
