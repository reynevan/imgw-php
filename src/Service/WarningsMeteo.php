<?php

declare(strict_types=1);

namespace Reynevan\Imgw\Service;

use ReflectionException;
use Reynevan\Imgw\Dto\MeteoWarning;
use Reynevan\Imgw\Mapper\AttributeMapper;

class WarningsMeteo extends AbstractApiService
{
    /**
     * @return MeteoWarning[]
     * @throws ReflectionException
     */
    public function getWarnings(): array
    {
        $data = $this->get('warningsmeteo');
        $mapper = new AttributeMapper();
        $warnings = [];
        foreach ($data as $item) {
            $warning = $mapper->map(MeteoWarning::class, $item);
            $warnings[] = $warning;
        }
        return $warnings;
    }
}
