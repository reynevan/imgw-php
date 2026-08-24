<?php

declare(strict_types=1);

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Reynevan\Imgw\Dto\MeteoWarning;
use Reynevan\Imgw\Http\HttpClientInterface;
use Reynevan\Imgw\Service\WarningsMeteo;

class WarningsMeteoTest extends TestCase
{
    public function testWarningsMeteo(): void
    {
        $fixture = file_get_contents(__DIR__ . '/../Fixtures/warningsmeteo_response.json') ?: throw new \RuntimeException('Unable to read fixture file.');

        $warningsData = json_decode($fixture, true);

        $httpClient = $this->createMock(HttpClientInterface::class);
        $httpClient->expects($this->once())
            ->method('request')
            ->with('GET', $this->stringContains('/warningsmeteo'))
            ->willReturn($warningsData);

        $warningsMeteo = new WarningsMeteo($httpClient);
        $warnings = $warningsMeteo->getWarnings();
        $warning = $warnings[0];

        $this->assertCount(1, $warnings);
        $this->assertInstanceOf(MeteoWarning::class, $warning);
        $this->assertSame('Sk20260824094735175', $warning->getId());
        $this->assertSame('Gęsta mgła', $warning->getEvent());
        $this->assertSame(1, $warning->getLevel());
        $this->assertSame(80, $warning->getProbability());
        $this->assertSame('2026-08-24 11:47:00', $warning->getPublishedAt()->format('Y-m-d H:i:s'));
        $this->assertSame('2026-08-24 23:00:00', $warning->getValidFrom()->format('Y-m-d H:i:s'));
        $this->assertSame('2026-08-25 08:00:00', $warning->getValidTo()->format('Y-m-d H:i:s'));
        $this->assertSame('Centralne Biuro Prognoz Meteorologicznych w Warszawie', $warning->getOffice());
        $this->assertSame(
            'Prognozuje się gęste mgły, w zasięgu których widzialność może miejscami wynosić poniżej 200 m.',
            $warning->getDescription()
        );
        $this->assertSame('Brak.', $warning->getComment());
        $this->assertCount(62, $warning->getTerytCodes());
        $this->assertSame('1415', $warning->getTerytCodes()[0]);
    }
}
