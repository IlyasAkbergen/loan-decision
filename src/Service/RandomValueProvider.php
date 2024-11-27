<?php

declare(strict_types=1);

namespace App\Service;

use App\Domain\Service\RandomValueProviderInterface;
use Random\RandomException;

class RandomValueProvider implements RandomValueProviderInterface
{
    /**
     * @throws RandomException
     */
    public function getRandomBool(): bool
    {
        return random_int(0, 1) === 1;
    }
}
