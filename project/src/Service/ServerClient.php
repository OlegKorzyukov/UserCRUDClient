<?php

namespace App\Service;

use HttpRequestException;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Component\HttpClient\HttpClient;

class ServerClient
{
    private HttpClient $client;

    public function __construct()
    {
        $this->client = (new HttpClient());
    }

    public function createUser(string $name, string $email): bool
    {
        $uri = '/api/v1/users';
        try {
            $response = $this->client->request(
                'GET',
                'https://api.github.com/repos/symfony/symfony-docs'
            );

            if (201 === $response->getStatusCode()) {
                return true;
            } else {
                throw new HttpRequestException();
            }
        } catch (ClientExceptionInterface | TransportExceptionInterface | HttpRequestException $e) {
            return false;
        }
    }
}
