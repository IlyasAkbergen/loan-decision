<?php

declare(strict_types=1);

namespace App\Handler;

use App\Domain\Entity\Loan;
use App\Domain\Enum\Decision;
use App\Domain\Event\EventBusInterface;
use App\Domain\Event\LoanCreatedEvent;
use App\Domain\Repository\ClientRepositoryInterface;
use App\Domain\Repository\LoanRepositoryInterface;
use App\Domain\Repository\ProductRepositoryInterface;
use App\Domain\Service\DecisionMaker\DecisionMaker;
use App\Infrastructure\Http\Dto\Command\CreateLoanCommand;
use App\Infrastructure\Http\Dto\Response\CreateLoanResponse;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;

readonly class CreateLoanHandler
{
    public function __construct(
        private DecisionMaker $decisionMaker,
        private ClientRepositoryInterface $clientRepository,
        private ProductRepositoryInterface $productRepository,
        private LoanRepositoryInterface $loanRepository,
        private EventBusInterface $eventBus,
    ) {
    }

    public function __invoke(CreateLoanCommand $command): CreateLoanResponse
    {
        $client = $this->clientRepository->findById($command->clientId);
        if ($client === null) {
            return new CreateLoanResponse(
                loan: null,
                error: 'Client not found',
            );
        }

        $product = $this->productRepository->findById($command->productId);
        if ($product === null) {
            return new CreateLoanResponse(
                loan: null,
                error: 'Product not found',
            );
        }

        $loanDecision = $this->decisionMaker->decide(
            client: $client,
            product: $product,
        );

        if ($loanDecision->getDecision() === Decision::DENIED) {
            return new CreateLoanResponse(
                loan: null,
                error: 'Loan denied',
            );
        }

        $loan = new Loan(
            id: Uuid::uuid4(),
            client: $client,
            product: $product,
            conditions: $loanDecision->conditions,
            createdAt: new DateTimeImmutable(),
        );

        $loan = $this->loanRepository->save($loan);
        $this->eventBus->dispatch(new LoanCreatedEvent(
            loanId: $loan->id,
            clientId: $client->id,
            createdAt: $loan->createdAt,
        ));

        return new CreateLoanResponse(
            loan: $loan,
            error: null,
        );
    }
}
