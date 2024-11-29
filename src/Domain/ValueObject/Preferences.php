<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use App\Domain\Enum\MessagingChannel;

readonly class Preferences
{
    public function __construct(
        public MessagingChannel $messagingChannel,
    ) {
    }
}
