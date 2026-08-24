<?php

declare(strict_types=1);

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Reynevan\Imgw\Dto\MeteoStation;
use Reynevan\Imgw\Http\HttpClientInterface;
use Reynevan\Imgw\Service\Meteo;

class MeteoTest extends TestCase
{
    public function testMeteo(): void
    {
        $fixture = file_get_contents(__DIR__ . '/../Fixtures/meteo_response.json') ?: throw new \RuntimeException('Unable to read fixture file.');

        $stationsData = json_decode($fixture, true);

        $httpClient = $this->createMock(HttpClientInterface::class);
        $httpClient->expects($this->once())
            ->method('request')
            ->with('GET', $this->stringContains('/meteo'))
            ->willReturn($stationsData);

        $meteo = new Meteo($httpClient);
        $stations = $meteo->getMeteoStations();
        $station = $stations[0];

        $this->assertCount(3, $stations);
        $this->assertInstanceOf(MeteoStation::class, $station);
        $this->assertSame('12295', $station->getStationId());
        $this->assertSame('Białystok', $station->getName());
        $this->assertSame(23.1688, $station->getLongitude());
        $this->assertSame(53.1021, $station->getLatitude());
        $this->assertSame(1971, $station->getStationFoundedYear());
        $this->assertSame(148.0, $station->getAltitude());
        $this->assertSame(22.4, $station->getGroundTemperature());
        $this->assertSame('2026-08-24 12:00:00', $station->getGroundTemperatureMeasuredAt()->format('Y-m-d H:i:s'));
        $this->assertSame(18.3, $station->getAirTemperature());
        $this->assertSame('2026-08-24 12:00:00', $station->getAirTemperatureMeasuredAt()->format('Y-m-d H:i:s'));
        $this->assertSame(240, $station->getWindDirection());
        $this->assertSame('2026-08-24 12:00:00', $station->getWindDirectionMeasuredAt()->format('Y-m-d H:i:s'));
        $this->assertSame(3.0, $station->getWindAverageSpeed());
        $this->assertSame('2026-08-24 12:00:00', $station->getWindAverageSpeedMeasuredAt()->format('Y-m-d H:i:s'));
        $this->assertSame(6.0, $station->getWindMaxSpeed());
        $this->assertSame('2026-08-24 12:00:00', $station->getWindMaxSpeedMeasuredAt()->format('Y-m-d H:i:s'));
        $this->assertSame(61.5, $station->getHumidity());
        $this->assertSame('2026-08-24 12:00:00', $station->getHumidityMeasuredAt()->format('Y-m-d H:i:s'));
        $this->assertSame(4.5, $station->getWindGust10Min());
        $this->assertSame('2026-08-24 12:00:00', $station->getWindGust10MinMeasuredAt()->format('Y-m-d H:i:s'));
        $this->assertSame(0.0, $station->getPrecipitation10Min());
        $this->assertSame('2026-08-24 12:00:00', $station->getPrecipitation10MinMeasuredAt()->format('Y-m-d H:i:s'));
    }

    public function testMeteoWithMissingValues(): void
    {
        $fixture = file_get_contents(__DIR__ . '/../Fixtures/meteo_response.json') ?: throw new \RuntimeException('Unable to read fixture file.');

        $stationsData = json_decode($fixture, true);

        $httpClient = $this->createMock(HttpClientInterface::class);
        $httpClient->expects($this->once())
            ->method('request')
            ->with('GET', $this->stringContains('/meteo'))
            ->willReturn($stationsData);

        $meteo = new Meteo($httpClient);
        $stations = $meteo->getMeteoStations();
        $station = $stations[1];

        $this->assertSame('12500', $station->getStationId());
        $this->assertSame('Jelenia Góra', $station->getName());
        $this->assertNull($station->getGroundTemperature());
        $this->assertNull($station->getGroundTemperatureMeasuredAt());
    }
}
