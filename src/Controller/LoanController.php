<?php

declare(strict_types=1);

namespace App\Controller;

use App\Domain\Repository\ClientRepositoryInterface;
use App\Domain\Repository\ProductRepositoryInterface;
use App\Dto\Query\CheckEligibilityQuery;
use App\Handler\CheckEligibilityHandler;
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
}
