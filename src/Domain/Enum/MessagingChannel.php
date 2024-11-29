<?php

declare(strict_types=1);

namespace App\Domain\Enum;

enum MessagingChannel: string
{
    case EMAIL = 'email';
    case SMS = 'sms';
}
