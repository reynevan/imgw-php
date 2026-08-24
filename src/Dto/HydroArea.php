<?php

declare(strict_types=1);

namespace Reynevan\Imgw\Dto;

use Reynevan\Imgw\Attribute\ApiField;

class HydroArea
{
    /**
     * @param string[] $catchmentCodes
     */
    public function __construct(
        #[ApiField('wojewodztwo')]
        protected ?string $province,
        #[ApiField('opis')]
        protected ?string $description,
        #[ApiField('kod_zlewni')]
        protected array $catchmentCodes,
    ) {
    }

    public function getProvince(): ?string
    {
        return $this->province;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return string[]
     */
    public function getCatchmentCodes(): array
    {
        return $this->catchmentCodes;
    }
}
