<?php

declare(strict_types=1);

namespace App\Domain\Service\Messaging;

use App\Domain\Entity\Client;
use App\Domain\ValueObject\Message;

class EmailMessagingChannelDriver implements MessagingChannelDriverInterface
{
    public function send(Client $client, Message $message): void
    {
        echo sprintf('Message sent by Email driver to %s: %s', $client->email, $message);
        echo "\n";
    }
}
