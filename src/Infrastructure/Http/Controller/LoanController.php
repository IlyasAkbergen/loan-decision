<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller;

use App\Domain\Repository\ClientRepositoryInterface;
use App\Domain\Repository\ProductRepositoryInterface;
use App\Handler\CheckEligibilityHandler;
use App\Handler\CreateLoanHandler;
use App\Infrastructure\Http\Dto\Command\CreateLoanCommand;
use App\Infrastructure\Http\Dto\Query\CheckEligibilityQuery;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LoanController extends AbstractController
{
    #[Route('/loan/check-eligibility', name: 'loan_check_eligibility_form', methods: ['GET'])]
    public function checkEligibilityForm(
        ProductRepositoryInterface $productRepository,
        ClientRepositoryInterface $clientRepository,
    ): Response {
        return $this->render('loan/check_eligibility.html.twig', [
            'products' => $productRepository->getAll(),
            'clients' => $clientRepository->getAll(),
        ]);
    }

    #[Route('/loan/check-eligibility', name: 'loan_check_eligibility', methods: ['POST'])]
    public function checkEligibility(
        Request $request,
        CheckEligibilityHandler $handler,
    ): Response {
        $response = $handler(new CheckEligibilityQuery(
            clientId: Uuid::fromString($request->request->get('client_id')),
            productId: Uuid::fromString($request->request->get('product_id')),
        ));

        return $this->render('loan/show_eligibility.html.twig', [
            'loanDecision' => $response->loanDecision,
            'error' => $response->error,
        ]);
    }

    #[Route('/loans', name: 'loan_create', methods: ['POST'])]
    public function store(
        Request $request,
        CreateLoanHandler $handler,
    ): Response {
        $response = $handler(new CreateLoanCommand(
            clientId: Uuid::fromString($request->request->get('client_id')),
            productId: Uuid::fromString($request->request->get('product_id')),
        ));

        if ($response->error !== null) {
            return $this->render('loan/error.html.twig', [
                'error' => $response->error,
            ]);
        }

        return $this->render('loan/success.html.twig', [
            'error' => $response->error,
            'loan' => $response->loan,
        ]);
    }
}
