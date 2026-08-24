<?php

declare(strict_types=1);

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Reynevan\Imgw\Dto\HydroArea;
use Reynevan\Imgw\Dto\HydroWarning;
use Reynevan\Imgw\Http\HttpClientInterface;
use Reynevan\Imgw\Service\WarningsHydro;

class WarningsHydroTest extends TestCase
{
    public function testWarningHydro(): void
    {
        $fixture = file_get_contents(__DIR__ . '/../Fixtures/warningshydro_response.json') ?: throw new \RuntimeException('Unable to read fixture file.');

        $stationsData = json_decode($fixture, true);

        $httpClient = $this->createMock(HttpClientInterface::class);
        $httpClient->expects($this->once())
            ->method('request')
            ->with('GET', $this->stringContains('/warningshydro'))
            ->willReturn($stationsData);

        $hydro = new WarningsHydro($httpClient);
        $warnings = $hydro->getWarnings();
        $warning = $warnings[0];

        $this->assertCount(100, $warnings);
        $this->assertInstanceOf(HydroWarning::class, $warning);
        $this->assertSame(31, $warning->getNumber());
        $this->assertSame(-1, $warning->getLevel());
        $this->assertSame(90, $warning->getProbability());
        $this->assertSame('2026-05-17 08:45:07', $warning->getPublishedAt()->format('Y-m-d H:i:s'));
        $this->assertSame('2026-05-17 08:45:56', $warning->getValidFrom()->format('Y-m-d H:i:s'));
        $this->assertSame('9999-12-31 23:59:59', $warning->getValidTo()->format('Y-m-d H:i:s'));
        $this->assertSame(
            'Biuro Prognoz Hydrologicznych we Wrocławiu, Wydział Prognoz i Opracowań Hydrologicznych w Poznaniu',
            $warning->getOffice()
        );
        $this->assertSame('Susza hydrologiczna', $warning->getEvent());
        $this->assertSame(
            'W związku z występującymi niskimi przepływami wody, w kolejnych dniach w zlewni Kanału Mosińskiego i spodziewane jest dalsze utrzymywanie się przepływów wody poniżej SNQ.',
            $warning->getDescription()
        );
        $this->assertSame(
            'Ostrzeżenie wydawane jest w sytuacji, gdy aktualne lub prognozowane wartości przepływu na stacjach wodowskazowych uznanych za reprezentatywne układają się poniżej SNQ przez minimum 10 dni w obrębie jednego obszaru hydrologicznego (który obejmuje grupę zlewni monitorowanych przez PSHM).',
            $warning->getComment()
        );

        $areas = $warning->getAreas();
        $this->assertCount(1, $areas);

        $area = $areas[0];
        $this->assertInstanceOf(HydroArea::class, $area);
        $this->assertSame('wielkopolskie', $area->getProvince());
        $this->assertSame('wielkopolskie, Kanał Mosiński, susza hydrologiczna', $area->getDescription());
        $this->assertSame(['Z_P_WP_1856'], $area->getCatchmentCodes());
    }
}
