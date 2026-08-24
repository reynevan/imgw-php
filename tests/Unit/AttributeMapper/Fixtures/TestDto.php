<?php

declare(strict_types=1);

namespace Tests\Unit\AttributeMapper\Fixtures;

use Reynevan\Imgw\Attribute\ApiField;

class TestDto
{
    public function __construct(
        #[ApiField('nazwa')]
        public string $name,
        #[ApiField('temperatura')]
        public float $temperature,
        #[ApiField('predkosc_wiatru')]
        public int $windSpeed,
        public string $notMapped = '',
        #[ApiField('bez_typu')]
        public int|float|string|null $noType = null
    ) {
    }
}
