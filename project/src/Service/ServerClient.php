<?php

namespace App\Service;

use Exception;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ServerClient
{
    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client, string $host, string $apiKey, string $apiValue)
    {
        $this->client = $client->withOptions([
            'base_uri' => "http://$host",
            'headers' => [
                'Content-Type' => 'application/json',
                $apiKey => $apiValue,
            ],
        ]);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws Exception
     */
    public function createUser(string $name, string $email): string
    {
        $data = json_encode([
            'name' => $name,
            'email' => $email,
        ]);

        $response = $this->client->request(
            'POST',
            '/api/v1/users',
            [
                'body' => $data
            ],
        );

        if (201 !== $response->getStatusCode()) {
           throw new Exception($response->getContent());
        }

        return $response->getContent();
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws Exception
     */
    public function getUsers(): string
    {
        $response = $this->client->request(
            'GET',
            '/api/v1/users',
        );

        if (200 !== $response->getStatusCode()) {
            throw new Exception($response->getContent());
        }

        return $response->getContent();
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws Exception
     */
    public function updateUser(int $userId, ?string $name, ?string $email): string
    {
        $data = json_encode([
            'name' => $name,
            'email' => $email,
        ]);

        $response = $this->client->request(
            'PUT',
            "/api/v1/users/$userId",
            [
                'body' => $data
            ],
        );

        if (200 !== $response->getStatusCode()) {
            throw new Exception($response->getContent());
        }

        return $response->getContent();
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws Exception
     */
    public function deleteUser(int $userId): string
    {
        $response = $this->client->request(
            'DELETE',
            "/api/v1/users/$userId",
        );

        if (200 !== $response->getStatusCode()) {
            throw new Exception($response->getContent());
        }

        return $response->getContent();
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws Exception
     */
    public function createGroup(string $name): string
    {
        $data = json_encode([
            'name' => $name,
        ]);

        $response = $this->client->request(
            'POST',
            '/api/v1/groups',
            [
                'body' => $data
            ],
        );

        if (201 !== $response->getStatusCode()) {
            throw new Exception($response->getContent());
        }

        return $response->getContent();
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws Exception
     */
    public function getGroups(): string
    {
        $response = $this->client->request(
            'GET',
            '/api/v1/groups',
        );

        if (200 !== $response->getStatusCode()) {
            throw new Exception($response->getContent());
        }

        return $response->getContent();
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws Exception
     */
    public function updateGroup(int $groupId, string $name): string
    {
        $data = json_encode([
            'name' => $name,
        ]);

        $response = $this->client->request(
            'PUT',
            "/api/v1/groups/$groupId",
            [
                'body' => $data
            ],
        );

        if (200 !== $response->getStatusCode()) {
            throw new Exception($response->getContent());
        }

        return $response->getContent();
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws Exception
     */
    public function deleteGroup(int $groupId): string
    {
        $response = $this->client->request(
            'DELETE',
            "/api/v1/groups/$groupId",
        );

        if (200 !== $response->getStatusCode()) {
            throw new Exception($response->getContent());
        }

        return $response->getContent();
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws Exception
     */
    public function getReport(): string
    {
        $response = $this->client->request(
            'GET',
            '/api/v1/reports',
        );

        if (200 !== $response->getStatusCode()) {
            throw new Exception($response->getContent());
        }

        return $response->getContent();
    }
}
