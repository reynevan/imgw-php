<?php

declare(strict_types=1);

namespace Reynevan\Imgw\Http;

interface HttpClientInterface
{
    /**
     * @return array<string, mixed>
     */
    public function request(string $method, string $uri): array;
}
