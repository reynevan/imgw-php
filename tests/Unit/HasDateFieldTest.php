<?php

declare(strict_types=1);

namespace Tests\Unit;

use DateTimeImmutable;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Reynevan\Imgw\Dto\HasDateField;

class HasDateFieldTest extends TestCase
{
    #[DataProvider('validDateProvider')]
    public function testParseDateWithCorrectDate(string $input, string $expected, string $format): void
    {
        $object = $this->createInstanceWithTrait();

        $result = $object->parseDateWrapper($input);
        $this->assertSame($expected, $result->format($format));
    }
    #[DataProvider('invalidDateProvider')]
    public function testParseDateWithIncorrectDate(string $input): void
    {
        $object = $this->createInstanceWithTrait();

        $result = $object->parseDateWrapper($input);
        $this->assertNull($result);
    }

    private function createInstanceWithTrait(): HasDateFieldTestSubject
    {
        return new HasDateFieldTestSubject();
    }

    /**
     * @return array<string, array{0: string, 1: string, 2: string}>
     */
    public static function validDateProvider(): array
    {
        return [
            'standard ISO date' => ['2010-01-01', '2010-01-01', 'Y-m-d'],
            'Y-m-d H:i:s' => ['2010-01-01 01:02:03', '2010-01-01 01:02:03', 'Y-m-d H:i:s'],
        ];
    }

    /**
     * @return array<int, array{0: string}>
     */
    public static function invalidDateProvider(): array
    {
        return [
            ['01-01'],
            ['10'],
            ['invalid date'],
        ];
    }
}

class HasDateFieldTestSubject
{
    use HasDateField;

    public function parseDateWrapper(?string $date): ?DateTimeImmutable
    {
        return $this->parseDate($date);
    }
}
