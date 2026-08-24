<?php

declare(strict_types=1);

namespace Reynevan\Imgw\Dto;

use DateTimeImmutable;
use Reynevan\Imgw\Attribute\ApiField;

class WeatherStation
{
    use HasDateField;

    public function __construct(
        #[ApiField('id_stacji')]
        protected ?string $stationId,
        #[ApiField('stacja')]
        protected ?string $name,
        #[ApiField('data_pomiaru')]
        protected ?string $measurementDate,
        #[ApiField('godzina_pomiaru')]
        protected ?int $measurementTime,
        #[ApiField('temperatura')]
        protected ?float $temperature,
        #[ApiField('predkosc_wiatru')]
        protected ?int $windSpeed,
        #[ApiField('kierunek_wiatru')]
        protected ?int $windDirection,
        #[ApiField('wilgotnosc_wzgledna')]
        protected ?float $humidity,
        #[ApiField('suma_opadu')]
        protected ?float $totalPrecipitation,
        #[ApiField('cisnienie')]
        protected ?float $pressure,
    ) {
    }

    public function getStationId(): string
    {
        return $this->stationId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getMeasuredAt(): ?DateTimeImmutable
    {
        return $this->parseDate($this->measurementDate . ' ' . str_pad((string) $this->measurementTime, 2, '0', STR_PAD_LEFT) . ':00:00');
    }

    public function getMeasurementDate(): string
    {
        return $this->measurementDate;
    }

    public function getMeasurementTime(): int
    {
        return $this->measurementTime;
    }

    public function getTemperature(): float
    {
        return $this->temperature;
    }

    public function getWindSpeed(): int
    {
        return $this->windSpeed;
    }

    public function getWindDirection(): int
    {
        return $this->windDirection;
    }

    public function getHumidity(): float
    {
        return $this->humidity;
    }

    public function getTotalPrecipitation(): float
    {
        return $this->totalPrecipitation;
    }

    public function getPressure(): float
    {
        return $this->pressure;
    }
}
