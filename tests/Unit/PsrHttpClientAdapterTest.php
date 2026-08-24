<?php

declare(strict_types=1);

namespace Tests\Unit;

use Exception;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Reynevan\Imgw\Exceptions\ImgwApiException;
use Reynevan\Imgw\Http\PsrHttpClientAdapter;

class PsrHttpClientAdapterTest extends TestCase
{
    public function testThrowsImgwApiExceptionOnErrorStatus(): void
    {
        $stream = $this->createMock(StreamInterface::class);
        $stream->method('__toString')->willReturn(json_encode(['message' => 'Unauthorized']));

        $response = $this->createMock(ResponseInterface::class);
        $response->method('getStatusCode')->willReturn(401);
        $response->method('getBody')->willReturn($stream);

        $request = $this->createMock(RequestInterface::class);

        $requestFactory = $this->createMock(RequestFactoryInterface::class);
        $requestFactory->method('createRequest')->willReturn($request);

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willReturn($response);

        $adapter = new PsrHttpClientAdapter($client, $requestFactory);

        $this->expectException(ImgwApiException::class);
        $this->expectExceptionMessage('Unauthorized');
        $this->expectExceptionCode(401);

        $adapter->request('GET', 'https://example.com');
    }

    public function testThrowsImgwApiExceptionOnRequestError(): void
    {
        $stream = $this->createMock(StreamInterface::class);

        $response = $this->createMock(ResponseInterface::class);
        $response->method('getStatusCode')->willReturn(401);
        $response->method('getBody')->willReturn($stream);

        $request = $this->createMock(RequestInterface::class);

        $requestFactory = $this->createMock(RequestFactoryInterface::class);
        $requestFactory->method('createRequest')->willReturn($request);

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willThrowException(new Exception());

        $adapter = new PsrHttpClientAdapter($client, $requestFactory);

        $this->expectException(ImgwApiException::class);

        $adapter->request('GET', 'https://example.com');
    }

    public function testCreatesRequestWithCorrectMethodAndUri(): void
    {
        $stream = $this->createMock(StreamInterface::class);
        $stream->method('__toString')->willReturn('test message');

        $response = $this->createMock(ResponseInterface::class);
        $response->method('getStatusCode')->willReturn(200);
        $response->method('getBody')->willReturn($stream);

        $request = $this->createMock(RequestInterface::class);

        $requestFactory = $this->createMock(RequestFactoryInterface::class);
        $requestFactory->expects($this->once())
            ->method('createRequest')
            ->with('GET', 'https://example.com')
            ->willReturn($request);

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willReturn($response);

        $adapter = new PsrHttpClientAdapter($client, $requestFactory);

        $adapter->request('GET', 'https://example.com');
    }

    public function testReturnsDecodedJsonArrayOnSuccess(): void
    {
        $data = ['key1' => 'value1', 'key2' => 'value2'];
        $stream = $this->createMock(StreamInterface::class);
        $stream->method('__toString')->willReturn(json_encode($data));

        $response = $this->createMock(ResponseInterface::class);
        $response->method('getStatusCode')->willReturn(200);
        $response->method('getBody')->willReturn($stream);

        $request = $this->createMock(RequestInterface::class);

        $requestFactory = $this->createMock(RequestFactoryInterface::class);
        $requestFactory->method('createRequest')->willReturn($request);

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willReturn($response);

        $adapter = new PsrHttpClientAdapter($client, $requestFactory);

        $response = $adapter->request('GET', 'https://example.com');
        $this->assertSame($data, $response);
    }
}
