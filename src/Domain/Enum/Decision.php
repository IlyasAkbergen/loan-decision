<?php

declare(strict_types=1);

namespace App\Domain\Enum;

enum Decision: string
{
    case APPROVED = 'approved';
    case APPROVED_WITH_CHANGES = 'approved_with_changes';
    case DENIED = 'denied';
}
