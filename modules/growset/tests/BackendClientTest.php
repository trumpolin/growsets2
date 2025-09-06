<?php

use Growset\Service\BackendClient;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class BackendClientTest extends TestCase
{
    private function createBackendWithMock(MockHandler $mock): BackendClient
    {
        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack, 'base_uri' => 'http://example.com']);
        $backend = new BackendClient('http://example.com', 'token', 2);

        $ref = new \ReflectionProperty(BackendClient::class, 'client');
        $ref->setAccessible(true);
        $ref->setValue($backend, $client);

        return $backend;
    }

    public function testRetriesAndSucceeds()
    {
        $mock = new MockHandler([
            new RequestException('Error', new Request('GET', '/products')),
            new Response(200, [], json_encode(['data' => 'ok'])),
        ]);

        $backend = $this->createBackendWithMock($mock);

        $result = $backend->getProducts(1, 1);

        $this->assertSame(['data' => 'ok'], $result);
    }

    public function testThrowsAfterMaxRetries()
    {
        $mock = new MockHandler([
            new RequestException('Error', new Request('GET', '/filters')),
            new RequestException('Error', new Request('GET', '/filters')),
            new RequestException('Error', new Request('GET', '/filters')),
        ]);

        $backend = $this->createBackendWithMock($mock);

        $this->expectException(RequestException::class);

        $backend->getFilters(1, 1);
    }
}

