<?php

declare(strict_types=1);

namespace Reynevan\Imgw\Dto;

use DateTimeImmutable;
use Reynevan\Imgw\Attribute\ApiField;

class MeteoStation
{
    use HasDateField;

    public function __construct(
        #[ApiField('kod_stacji')]
        protected ?string $stationId,
        #[ApiField('nazwa_stacji')]
        protected ?string $name,
        #[ApiField('lon')]
        protected ?float $longitude,
        #[ApiField('lat')]
        protected ?float $latitude,
        #[ApiField('rok_zalozenia_stacji')]
        protected ?int $stationFoundedYear,
        #[ApiField('wysokosc_npm')]
        protected ?float $altitude,
        #[ApiField('temperatura_gruntu')]
        protected ?float $groundTemperature,
        #[ApiField('temperatura_gruntu_data')]
        protected ?string $groundTemperatureMeasuredAt,
        #[ApiField('temperatura_powietrza')]
        protected ?float $airTemperature,
        #[ApiField('temperatura_powietrza_data')]
        protected ?string $airTemperatureMeasuredAt,
        #[ApiField('wiatr_kierunek')]
        protected ?int $windDirection,
        #[ApiField('wiatr_kierunek_data')]
        protected ?string $windDirectionMeasuredAt,
        #[ApiField('wiatr_srednia_predkosc')]
        protected ?float $windAverageSpeed,
        #[ApiField('wiatr_srednia_predkosc_data')]
        protected ?string $windAverageSpeedMeasuredAt,
        #[ApiField('wiatr_predkosc_maksymalna')]
        protected ?float $windMaxSpeed,
        #[ApiField('wiatr_predkosc_maksymalna_data')]
        protected ?string $windMaxSpeedMeasuredAt,
        #[ApiField('wilgotnosc_wzgledna')]
        protected ?float $humidity,
        #[ApiField('wilgotnosc_wzgledna_data')]
        protected ?string $humidityMeasuredAt,
        #[ApiField('wiatr_poryw_10min')]
        protected ?float $windGust10Min,
        #[ApiField('wiatr_poryw_10min_data')]
        protected ?string $windGust10MinMeasuredAt,
        #[ApiField('opad_10min')]
        protected ?float $precipitation10Min,
        #[ApiField('opad_10min_data')]
        protected ?string $precipitation10MinMeasuredAt,
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

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function getStationFoundedYear(): ?int
    {
        return $this->stationFoundedYear;
    }

    public function getAltitude(): ?float
    {
        return $this->altitude;
    }

    public function getGroundTemperature(): ?float
    {
        return $this->groundTemperature;
    }

    public function getGroundTemperatureMeasuredAt(): ?DateTimeImmutable
    {
        return $this->parseDate($this->groundTemperatureMeasuredAt);
    }

    public function getAirTemperature(): ?float
    {
        return $this->airTemperature;
    }

    public function getAirTemperatureMeasuredAt(): ?DateTimeImmutable
    {
        return $this->parseDate($this->airTemperatureMeasuredAt);
    }

    public function getWindDirection(): ?int
    {
        return $this->windDirection;
    }

    public function getWindDirectionMeasuredAt(): ?DateTimeImmutable
    {
        return $this->parseDate($this->windDirectionMeasuredAt);
    }

    public function getWindAverageSpeed(): ?float
    {
        return $this->windAverageSpeed;
    }

    public function getWindAverageSpeedMeasuredAt(): ?DateTimeImmutable
    {
        return $this->parseDate($this->windAverageSpeedMeasuredAt);
    }

    public function getWindMaxSpeed(): ?float
    {
        return $this->windMaxSpeed;
    }

    public function getWindMaxSpeedMeasuredAt(): ?DateTimeImmutable
    {
        return $this->parseDate($this->windMaxSpeedMeasuredAt);
    }

    public function getHumidity(): ?float
    {
        return $this->humidity;
    }

    public function getHumidityMeasuredAt(): ?DateTimeImmutable
    {
        return $this->parseDate($this->humidityMeasuredAt);
    }

    public function getWindGust10Min(): ?float
    {
        return $this->windGust10Min;
    }

    public function getWindGust10MinMeasuredAt(): ?DateTimeImmutable
    {
        return $this->parseDate($this->windGust10MinMeasuredAt);
    }

    public function getPrecipitation10Min(): ?float
    {
        return $this->precipitation10Min;
    }

    public function getPrecipitation10MinMeasuredAt(): ?DateTimeImmutable
    {
        return $this->parseDate($this->precipitation10MinMeasuredAt);
    }

}
