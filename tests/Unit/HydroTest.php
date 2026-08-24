<?php

declare(strict_types=1);

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Reynevan\Imgw\Dto\HydroStation;
use Reynevan\Imgw\Http\HttpClientInterface;
use Reynevan\Imgw\Service\Hydro;

class HydroTest extends TestCase
{
    public function testHydro(): void
    {
        $fixture = file_get_contents(__DIR__ . '/../Fixtures/hydro_response.json') ?: throw new \RuntimeException('Unable to read fixture file.');

        $stationsData = json_decode($fixture, true);

        $httpClient = $this->createMock(HttpClientInterface::class);
        $httpClient->expects($this->once())
            ->method('request')
            ->with('GET', $this->stringContains('/hydro'))
            ->willReturn($stationsData);

        $hydro = new Hydro($httpClient);
        $stations = $hydro->getHydroStations();
        $station = $stations[0];

        $this->assertCount(913, $stations);
        $this->assertInstanceOf(HydroStation::class, $station);
        $this->assertSame('151140030', $station->getStationId());
        $this->assertSame('Przewoźniki', $station->getName());
        $this->assertSame('Skroda', $station->getRiver());
        $this->assertSame('lubuskie', $station->getProvince());
        $this->assertSame(14.8217, $station->getLongitude());
        $this->assertSame(51.5253, $station->getLatitude());
        $this->assertSame(1957, $station->getStationFoundedYear());
        $this->assertSame(114.049, $station->getGaugeZeroOrdinate());
        $this->assertSame(4.22, $station->getRiverKilometer());
        $this->assertSame(340, $station->getAlarmLevel());
        $this->assertSame(300, $station->getWarningLevel());
        $this->assertSame(224, $station->getWaterLevel());
        $this->assertSame('2026-08-24 12:20:00', $station->getWaterLevelMeasuredAt()->format('Y-m-d H:i:s'));
        $this->assertNull($station->getWaterTemperature());
        $this->assertNull($station->getWaterTemperatureMeasuredAt());
        $this->assertSame(0.11, $station->getFlow());
        $this->assertSame('2026-02-18 09:50:00', $station->getFlowMeasuredAt()->format('Y-m-d H:i:s'));
        $this->assertSame(0, $station->getIcePhenomenon());
        $this->assertSame('2026-02-26 11:20:00', $station->getIcePhenomenonMeasuredAt()->format('Y-m-d H:i:s'));
        $this->assertSame(0, $station->getVegetationPhenomenon());
        $this->assertSame('2026-07-29 10:40:00', $station->getVegetationPhenomenonMeasuredAt()->format('Y-m-d H:i:s'));
    }
}
