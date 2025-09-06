<?php

namespace Growset\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Growset\Growset;
use Configuration;

class BackendClient
{
    private Client $client;
    private string $token;
    private int $retries;

    public function __construct(?string $baseUri = null, ?string $token = null, int $retries = 3)
    {
        $baseUri = $baseUri ?: (string) (Configuration::get(Growset::CONFIG_BACKEND_URL) ?: getenv('GROWSET_BACKEND_URL'));
        $this->token = $token ?: (string) (Configuration::get(Growset::CONFIG_TOKEN) ?: getenv('GROWSET_BACKEND_TOKEN'));
        $this->client = new Client([
            'base_uri' => $baseUri,
            'timeout' => 5,
            'connect_timeout' => 5,
        ]);
        $this->retries = $retries;
    }

    public function getProducts(int $page, int $limit): array
    {
        $response = $this->request('GET', '/products', ['query' => ['page' => $page, 'limit' => $limit]]);
        return json_decode((string) $response->getBody(), true) ?: [];
    }

    public function getFilters(int $page, int $limit): array
    {
        $response = $this->request('GET', '/filters', ['query' => ['page' => $page, 'limit' => $limit]]);
        return json_decode((string) $response->getBody(), true) ?: [];
    }

    private function request(string $method, string $uri, array $options)
    {
        $options['headers']['Authorization'] = 'Bearer ' . $this->token;
        $attempts = 0;
        $delay = 1;

        while (true) {
            try {
                return $this->client->request($method, $uri, $options);
            } catch (RequestException $e) {
                $attempts++;
                if ($attempts > $this->retries) {
                    throw $e;
                }
                sleep($delay);
                $delay *= 2;
            }
        }
    }
}

