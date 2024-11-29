<?php

declare(strict_types=1);

namespace App\Infrastructure\DB\Factory;

use App\Domain\Entity\Loan as DomainLoan;
use App\Domain\Exception\DomainException;
use App\Domain\Exception\InvalidEmailException;
use App\Domain\ValueObject\InterestRate;
use App\Domain\ValueObject\LoanConditions;
use App\Domain\ValueObject\Term;
use App\Entity\Loan as DoctrineLoan;

readonly class LoanFactory
{
    public function __construct(
        private ClientFactory $clientFactory,
        private ProductFactory $productFactory,
    ) {
    }

    /**
     * @throws DomainException
     * @throws InvalidEmailException
     */
    public function createFromDoctrineEntity(DoctrineLoan $loan): DomainLoan
    {
        return new DomainLoan(
            id: $loan->getId(),
            client: $this->clientFactory->createFromDoctrineEntity($loan->getClient()),
            product: $this->productFactory->createFromDoctrineEntity($loan->getProduct()),
            conditions: new LoanConditions(
                sum: $loan->getSum(),
                term: Term::fromMonths($loan->getTermMonths()),
                interestRate: new InterestRate($loan->getInterestRate()),
            ),
            createdAt: $loan->getCreatedAt(),
        );
    }

    public function createDoctrineEntity(DomainLoan $loan): DoctrineLoan
    {
        return new DoctrineLoan(
            id: $loan->id,
            client: $this->clientFactory->createDoctrineEntity($loan->client),
            product: $this->productFactory->createDoctrineEntity($loan->product),
            termMonths: $loan->conditions->term->months,
            interestRate: $loan->conditions->interestRate->value,
            sum: $loan->conditions->sum,
        );
    }
}
