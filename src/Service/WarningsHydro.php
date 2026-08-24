<?php

declare(strict_types=1);

namespace Reynevan\Imgw\Service;

use ReflectionException;
use Reynevan\Imgw\Dto\HydroWarning;
use Reynevan\Imgw\Mapper\AttributeMapper;

class WarningsHydro extends AbstractApiService
{
    /**
     * @return HydroWarning[]
     * @throws ReflectionException
     */
    public function getWarnings(): array
    {
        $data = $this->get('warningshydro');
        $mapper = new AttributeMapper();
        $warnings = [];
        foreach ($data as $item) {
            $warning = $mapper->map(HydroWarning::class, $item);
            $warnings[] = $warning;
        }
        return $warnings;
    }
}
