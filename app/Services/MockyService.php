<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class MockyService
{
    public function __construct(
        private Client $client
    ) {
        $this->client = new Client([
            'base_uri' => 'https://run.mocky.io',
        ]);
    }

    public function authorizeTransaction()
    {
        $uri = '/v3/5794d450-d2e2-4412-8131-73d0293ac1cc';
        try {
            $response = $this->client->request('GET', $uri);
            return json_decode($response->getBody(), true);
        } catch (GuzzleException $exception) {
            return ['Bad things are happened'];
        }
    }

    public function notifyUser(string $fakeUserId): array
    {
        $uri = '/v3/54dc2cf1-3add-45b5-b5a9-6bf7e7f1f4a6';
        try {
            $response = $this->client->request('GET', $uri);
            return json_decode($response->getBody(), true);
        } catch (GuzzleException $exception) {
            return ['message' => 'Não autorizado'];
        }
    }
}
