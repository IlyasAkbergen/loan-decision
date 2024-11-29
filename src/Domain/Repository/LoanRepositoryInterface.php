<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Loan;

interface LoanRepositoryInterface
{
    public function save(Loan $loan): Loan;
}
