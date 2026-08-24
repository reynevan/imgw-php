<?php

declare(strict_types=1);

namespace Reynevan\Imgw\Service;

use ReflectionException;
use Reynevan\Imgw\Dto\HydroStation;
use Reynevan\Imgw\Mapper\AttributeMapper;

class Hydro extends AbstractApiService
{
    /**
     * @return HydroStation[]
     * @throws ReflectionException
     */
    public function getHydroStations(): array
    {
        $data = $this->get('hydro');
        $mapper = new AttributeMapper();
        $stations = [];
        foreach ($data as $item) {
            $station = $mapper->map(HydroStation::class, $item);
            $stations[] = $station;
        }
        return $stations;
    }
}
