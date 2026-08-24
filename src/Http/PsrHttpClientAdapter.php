<?php

declare(strict_types=1);

namespace Reynevan\Imgw\Http;

use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Reynevan\Imgw\Exceptions\ImgwApiException;
use Throwable;

final class PsrHttpClientAdapter implements HttpClientInterface
{
    public function __construct(
        private ?ClientInterface $client = null,
        private ?RequestFactoryInterface $requestFactory = null
    ) {
        $this->client = $client ?? Psr18ClientDiscovery::find();
        $this->requestFactory = $requestFactory ?? Psr17FactoryDiscovery::findRequestFactory();
    }

    /**
     * @return array<string, mixed>
     * @throws ImgwApiException
     */
    public function request(string $method, string $uri): array
    {
        $request = $this->requestFactory->createRequest($method, $uri);

        try {
            $response = $this->client->sendRequest($request);
        } catch (Throwable $e) {
            throw new ImgwApiException('HTTP request failed: ' . $e->getMessage(), 0, $e);
        }

        return $this->handleResponse($response);
    }

    /**
     * @return array<string, mixed>
     * @throws ImgwApiException
     */
    private function handleResponse(ResponseInterface $response): array
    {
        $body = (string) $response->getBody();
        $data = json_decode($body, true) ?? [];

        if ($response->getStatusCode() === 404) {
            return [];
        }

        if ($response->getStatusCode() >= 400) {
            throw new ImgwApiException($data['message'] ?? 'API error', $response->getStatusCode());
        }

        return $data;
    }
}
