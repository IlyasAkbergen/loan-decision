<?php

declare(strict_types=1);

namespace App\Domain\Service\Messaging;

use App\Domain\Entity\Client;
use App\Domain\ValueObject\Message;

class SmsMessagingChannelDriver implements MessagingChannelDriverInterface
{
    public function send(Client $client, Message $message): void
    {
        echo sprintf('Message sent by Sms driver to %s: %s', $client->phoneNumber->value, $message);
        echo "\n";
    }
}
