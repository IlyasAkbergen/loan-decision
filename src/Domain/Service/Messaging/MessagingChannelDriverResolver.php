<?php

declare(strict_types=1);

namespace App\Domain\Service\Messaging;

use App\Domain\Entity\Client;
use App\Domain\Enum\MessagingChannel;

class MessagingChannelDriverResolver
{
    public function resolve(Client $client): MessagingChannelDriverInterface
    {
        return match ($client->preferences->messagingChannel) {
            MessagingChannel::EMAIL => new EmailMessagingChannelDriver(),
            MessagingChannel::SMS => new SmsMessagingChannelDriver(),
        };
    }
}
