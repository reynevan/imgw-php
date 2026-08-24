<?php

declare(strict_types=1);

namespace Reynevan\Imgw\Service;

use ReflectionException;
use Reynevan\Imgw\Dto\MeteoStation;
use Reynevan\Imgw\Mapper\AttributeMapper;

class Meteo extends AbstractApiService
{
    /**
     * @return MeteoStation[]
     * @throws ReflectionException
     */
    public function getMeteoStations(): array
    {
        $data = $this->get('meteo');
        $mapper = new AttributeMapper();
        $stations = [];
        foreach ($data as $item) {
            $station = $mapper->map(MeteoStation::class, $item);
            $stations[] = $station;
        }
        return $stations;
    }
}
