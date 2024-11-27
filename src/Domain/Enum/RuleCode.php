<?php

declare(strict_types=1);

namespace App\Domain\Enum;

enum RuleCode: string
{
    case CREDIT_RATING = 'credit_rating';
    case INCOME = 'income';
    case AGE = 'age';
    case STATE_EXCLUSIVE = 'state_exclusive';
    case STATE_NY_RANDOM = 'state_ny_random';
    case STATE_CA_INTEREST_INCREASE = 'state_ca_interest_increase';
}
