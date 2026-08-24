<?php

declare(strict_types=1);

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Reynevan\Imgw\Dto\WeatherStation;
use Reynevan\Imgw\Http\HttpClientInterface;
use Reynevan\Imgw\Service\Synop;

class SynopTest extends TestCase
{
    public function testGetAllData(): void
    {
        $fixture = file_get_contents(__DIR__ . '/../Fixtures/synop_response.json') ?: throw new \RuntimeException('Unable to read fixture file.');
        $stationsData = json_decode($fixture, true);

        $httpClient = $this->createMock(HttpClientInterface::class);
        $httpClient->expects($this->once())
            ->method('request')
            ->with('GET', $this->stringContains('/synop'))
            ->willReturn($stationsData);

        $synop = new Synop($httpClient);
        $stations = $synop->getWeatherStations();
        $station = $stations[0];

        $this->assertCount(62, $stations);
        $this->assertInstanceOf(WeatherStation::class, $station);
        $this->assertSame('12295', $station->getStationId());
        $this->assertSame('Białystok', $station->getName());
        $this->assertSame(18.3, $station->getTemperature());
        $this->assertSame(3, $station->getWindSpeed());
        $this->assertSame(240, $station->getWindDirection());
        $this->assertSame(61.5, $station->getHumidity());
        $this->assertSame(0.0, $station->getTotalPrecipitation());
        $this->assertSame(1018.9, $station->getPressure());
        $this->assertSame('2026-08-24', $station->getMeasurementDate());
        $this->assertSame(11, $station->getMeasurementTime());
        $this->assertSame('2026-08-24 11:00:00', $station->getMeasuredAt()->format('Y-m-d H:i:s'));
    }

    public function testGetStationByName(): void
    {
        $fixture = file_get_contents(__DIR__ . '/../Fixtures/synop_response.json') ?: throw new \RuntimeException('Unable to read fixture file.');
        $stations = json_decode($fixture, true);

        $stationData = current(array_filter(
            $stations,
            fn (array $station) => $station['stacja'] === 'Jelenia Góra'
        ));

        $httpClient = $this->createMock(HttpClientInterface::class);
        $httpClient->expects($this->once())
            ->method('request')
            ->with('GET', $this->stringContains('synop/station/jeleniagora'))
            ->willReturn($stationData);

        $synop = new Synop($httpClient);
        $station = $synop->getWeatherStationByName('jeleniagora');

        $this->assertInstanceOf(WeatherStation::class, $station);
        $this->assertSame('12500', $station->getStationId());
        $this->assertSame('Jelenia Góra', $station->getName());
        $this->assertSame(18.2, $station->getTemperature());
        $this->assertSame(3, $station->getWindSpeed());
        $this->assertSame(310, $station->getWindDirection());
        $this->assertSame(53.3, $station->getHumidity());
        $this->assertSame(0.0, $station->getTotalPrecipitation());
        $this->assertSame(1022.6, $station->getPressure());
    }

    public function testGetStationById(): void
    {
        $fixture = file_get_contents(__DIR__ . '/../Fixtures/synop_response.json') ?: throw new \RuntimeException('Unable to read fixture file.');
        $stations = json_decode($fixture, true);

        $stationData = current(array_filter(
            $stations,
            fn (array $station) => $station['id_stacji'] === '12566'
        ));

        $httpClient = $this->createMock(HttpClientInterface::class);
        $httpClient->expects($this->once())
            ->method('request')
            ->with('GET', $this->stringContains('synop/id/12566'))
            ->willReturn($stationData);

        $synop = new Synop($httpClient);
        $station = $synop->getWeatherStationById(12566);

        $this->assertInstanceOf(WeatherStation::class, $station);
        $this->assertSame('12566', $station->getStationId());
        $this->assertSame('Kraków', $station->getName());
        $this->assertSame(21.2, $station->getTemperature());
        $this->assertSame(5, $station->getWindSpeed());
        $this->assertSame(240, $station->getWindDirection());
        $this->assertSame(40.3, $station->getHumidity());
        $this->assertSame(0.0, $station->getTotalPrecipitation());
        $this->assertSame(1021.4, $station->getPressure());
    }
}
