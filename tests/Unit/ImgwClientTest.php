<?php

declare(strict_types=1);

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Reynevan\Imgw\Http\HttpClientInterface;
use Reynevan\Imgw\ImgwClient;
use Reynevan\Imgw\Service\Hydro;
use Reynevan\Imgw\Service\Meteo;
use Reynevan\Imgw\Service\Synop;
use Reynevan\Imgw\Service\WarningsHydro;
use Reynevan\Imgw\Service\WarningsMeteo;

final class ImgwClientTest extends TestCase
{
    private HttpClientInterface $httpClient;
    private ImgwClient $client;

    protected function setUp(): void
    {
        $this->httpClient = $this->createMock(HttpClientInterface::class);
        $this->client = new ImgwClient($this->httpClient);
    }

    public function testSynopReturnsSynopService(): void
    {
        $synop = $this->client->synop();

        self::assertInstanceOf(Synop::class, $synop);
    }

    public function testMeteoReturnsMeteoService(): void
    {
        $synop = $this->client->meteo();

        self::assertInstanceOf(Meteo::class, $synop);
    }

    public function testHydroReturnsHydroService(): void
    {
        $hydro = $this->client->hydro();

        self::assertInstanceOf(Hydro::class, $hydro);
    }

    public function testWarningsHydroReturnsWarningsHydroService(): void
    {
        $warningsHydro = $this->client->warningshydro();

        self::assertInstanceOf(WarningsHydro::class, $warningsHydro);
    }

    public function testWarningsMeteoReturnsWarningsMeteoService(): void
    {
        $warningsMeteo = $this->client->warningsmeteo();

        self::assertInstanceOf(WarningsMeteo::class, $warningsMeteo);
    }
}
