<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller;

use App\Domain\Enum\MessagingChannel;
use App\Handler\CreateClientHandler;
use App\Handler\GetClientHandler;
use App\Handler\GetClientsHandler;
use App\Handler\UpdateClientHandler;
use App\Infrastructure\Http\Dto\Command\CreateClientCommand;
use App\Infrastructure\Http\Dto\Command\UpdateClientCommand;
use App\Infrastructure\Http\Dto\Query\GetClientQuery;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class ClientController extends AbstractController
{
    #[Route('/clients', name: 'client_index', methods: ['GET'])]
    public function index(
        GetClientsHandler $handler,
    ): Response {
        $response = $handler();

        return $this->render('client/index.html.twig', [
            'clients' => $response->clients,
        ]);
    }

    #[Route('/clients/create', name: 'client_create_form', methods: ['GET'])]
    public function create(): Response
    {
        return $this->render('client/form.html.twig', [
            'error' => null,
            'client' => null,
            'edit' => false,
            'messagingChannels' => MessagingChannel::cases(),
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
                'messagingChannels' => MessagingChannel::cases(),
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
            'messagingChannels' => MessagingChannel::cases(),
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
                'messagingChannels' => MessagingChannel::cases(),
            ]);
        }

        return $this->render('client/show.html.twig', [
            'client' => $response->client,
            'error' => null,
        ]);
    }
}
