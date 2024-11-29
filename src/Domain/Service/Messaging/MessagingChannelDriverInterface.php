<?php

declare(strict_types=1);

namespace App\Domain\Service\Messaging;

use App\Domain\Entity\Client;
use App\Domain\ValueObject\Message;

interface MessagingChannelDriverInterface
{
    public function send(Client $client, Message $message): void;
}
