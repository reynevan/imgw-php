<?php

declare(strict_types=1);

namespace Reynevan\Imgw\Service;

use ReflectionException;
use Reynevan\Imgw\Dto\WeatherStation;
use Reynevan\Imgw\Mapper\AttributeMapper;

class Synop extends AbstractApiService
{
    /**
     * @return WeatherStation[]
     * @throws ReflectionException
     */
    public function getWeatherStations(): array
    {
        $data = $this->get('synop');
        $mapper = new AttributeMapper();
        $stations = [];
        foreach ($data as $item) {
            $station = $mapper->map(WeatherStation::class, $item);
            $stations[] = $station;
        }
        return $stations;
    }

    /**
     * @throws ReflectionException
     */
    public function getWeatherStationById(int|string $id): WeatherStation
    {
        $data = $this->get('synop/id/' . $id);
        $mapper = new AttributeMapper();
        return $mapper->map(WeatherStation::class, $data);

    }

    /**
     * @throws ReflectionException
     */
    public function getWeatherStationByName(string $name): WeatherStation
    {
        $data = $this->get('synop/station/' . $name);
        $mapper = new AttributeMapper();
        return $mapper->map(WeatherStation::class, $data);

    }
}
