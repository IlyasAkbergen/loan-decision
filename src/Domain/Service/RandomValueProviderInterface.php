<?php

declare(strict_types=1);

namespace App\Domain\Service;

interface RandomValueProviderInterface
{
    public function getRandomBool(): bool;
}
