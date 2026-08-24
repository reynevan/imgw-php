<?php

declare(strict_types=1);

namespace Reynevan\Imgw\Service;

use Reynevan\Imgw\Http\HttpClientInterface;

abstract class AbstractApiService
{
    protected const BASE_URL = 'https://danepubliczne.imgw.pl/api/data';

    public function __construct(protected HttpClientInterface $httpClient)
    {
    }

    protected function buildUrl(string $endpoint): string
    {
        return self::BASE_URL . '/' . ltrim($endpoint, '/');
    }

    /**
     * @return array<string, mixed>
     */
    protected function get(string $endpoint): array
    {
        return $this->httpClient->request('GET', $this->buildUrl($endpoint));
    }
}
