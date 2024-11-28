<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\Command\CreateClientCommand;
use App\Dto\Command\UpdateClientCommand;
use App\Dto\Query\GetClientQuery;
use App\Handler\CreateClientHandler;
use App\Handler\GetClientHandler;
use App\Handler\UpdateClientHandler;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class ClientController extends AbstractController
{
    #[Route('/clients/create', name: 'client_create_form', methods: ['GET'])]
    public function create(): Response
    {
        return $this->render('client/form.html.twig', [
            'error' => null,
            'client' => null,
            'edit' => false,
        ]);
    }

    #[Route('/clients', name: 'client_store', methods: ['POST'])]
    public function store(
        #[MapRequestPayload] CreateClientCommand $clientCommand,
        CreateClientHandler $handler,
    ): Response {
        $response = $handler($clientCommand);

        if ($response->error !== null) {
            return $this->render('client/form.html.twig', [
                'error' => $response->error,
                'client' => $response->client,
                'edit' => false,
            ]);
        }

        return $this->render('client/show.html.twig', [
            'client' => $response->client,
            'error' => $response->error,
        ]);
    }

    #[Route('/clients/{id}', name: 'client_show', requirements: [ 'id' => '[0-9a-fA-F\-]{36}'], methods: [ 'GET'])]
    public function show(
        string $id,
        GetClientHandler $handler,
    ): Response {
        $response = $handler(new GetClientQuery(id: Uuid::fromString($id)));

        return $this->render('client/show.html.twig', [
            'client' => $response->client,
            'error' => null,
        ]);
    }

    #[Route('/clients/{id}/edit', name: 'client_edit', requirements: [ 'id' => '[0-9a-fA-F\-]{36}'], methods: [ 'GET'])]
    public function edit(
        string $id,
        GetClientHandler $handler,
    ): Response {
        $response = $handler(new GetClientQuery(id: Uuid::fromString($id)));

        return $this->render('client/form.html.twig', [
            'client' => $response->client,
            'error' => null,
            'edit' => true,
        ]);
    }

    #[Route('/clients/{id}', name: 'client_update', requirements: ['id' => '[0-9a-fA-F\-]{36}'], methods: ['PUT'])]
    public function update(
        string $id,
        #[MapRequestPayload] UpdateClientCommand $updateCommand,
        UpdateClientHandler $handler,
    ): Response {
        $response = $handler(id: Uuid::fromString($id), command: $updateCommand);

        if ($response->error !== null) {
            return $this->render('client/form.html.twig', [
                'error' => $response->error,
                'client' => $response->client,
                'edit' => true,
            ]);
        }

        return $this->render('client/show.html.twig', [
            'client' => $response->client,
            'error' => null,
        ]);
    }
}