<?php

declare(strict_types=1);

namespace Tests\Unit\AttributeMapper;

use PHPUnit\Framework\TestCase;
use Reynevan\Imgw\Mapper\AttributeMapper;
use Tests\Unit\AttributeMapper\Fixtures\TestDto;

class AttributeMapperTest extends TestCase
{
    public function testMapReturnsInstanceOfGivenClass(): void
    {
        $mapper = new AttributeMapper();
        $result = $mapper->map(TestDto::class, $this->validApiData());

        $this->assertInstanceOf(TestDto::class, $result);

    }
    public function testMapMapsApiFieldsToDtoProperties(): void
    {
        $mapper = new AttributeMapper();
        $result = $mapper->map(TestDto::class, $this->validApiData());

        $this->assertSame('Test name', $result->name);
        $this->assertSame(21.36, $result->temperature);
        $this->assertSame(5, $result->windSpeed);
    }

    public function testMapDoesntMapFieldsWithoutAttribute(): void
    {
        $mapper = new AttributeMapper();
        $result = $mapper->map(TestDto::class, $this->validApiData());

        $this->assertEmpty($result->notMapped);
    }

    public function testMapMapsFieldsToCorrectType(): void
    {
        $mapper = new AttributeMapper();
        $data = [
            'nazwa' => 123,
            'temperatura' => '21.36',
            'predkosc_wiatru' => 4.99,
        ];
        $result = $mapper->map(TestDto::class, $data);

        $this->assertSame('123', $result->name);
        $this->assertSame(21.36, $result->temperature);
        $this->assertSame(4, $result->windSpeed);
    }

    public function testMapMapsFieldsWithoutType(): void
    {
        $mapper = new AttributeMapper();
        $data = $this->validApiData();
        $data['bez_typu'] = 123.456;
        $result = $mapper->map(TestDto::class, $data);

        $this->assertSame(123.456, $result->noType);
    }

    /**
     * @return array<string, string|int|float>
     */
    private function validApiData(): array
    {
        return [
            'nazwa' => 'Test name',
            'temperatura' => 21.36,
            'predkosc_wiatru' => 5,
        ];
    }
}
