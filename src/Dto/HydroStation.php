<?php

declare(strict_types=1);

namespace Reynevan\Imgw\Dto;

use DateTimeImmutable;
use Reynevan\Imgw\Attribute\ApiField;

class HydroStation
{
    use HasDateField;

    public function __construct(
        #[ApiField('id_stacji')]
        protected ?string $stationId,
        #[ApiField('stacja')]
        protected ?string $name,
        #[ApiField('rzeka')]
        protected ?string $river,
        #[ApiField('wojewodztwo')]
        protected ?string $province,
        #[ApiField('lon')]
        protected ?float $longitude,
        #[ApiField('lat')]
        protected ?float $latitude,
        #[ApiField('rok_zalozenia_stacji')]
        protected ?int $stationFoundedYear,
        #[ApiField('rzedna_zerawodowskazu')]
        protected ?float $gaugeZeroOrdinate,
        #[ApiField('kilometr_biegu_rzeki')]
        protected ?float $riverKilometer,
        #[ApiField('stan_alarmowy')]
        protected ?int $alarmLevel,
        #[ApiField('stan_ostrzegawczy')]
        protected ?int $warningLevel,
        #[ApiField('stan_wody')]
        protected ?int $waterLevel,
        #[ApiField('stan_wody_data_pomiaru')]
        protected ?string $waterLevelMeasuredAt,
        #[ApiField('temperatura_wody')]
        protected ?float $waterTemperature,
        #[ApiField('temperatura_wody_data_pomiaru')]
        protected ?string $waterTemperatureMeasuredAt,
        #[ApiField('przeplyw')]
        protected ?float $flow,
        #[ApiField('przeplyw_data')]
        protected ?string $flowMeasuredAt,
        #[ApiField('zjawisko_lodowe')]
        protected ?int $icePhenomenon,
        #[ApiField('zjawisko_lodowe_data_pomiaru')]
        protected ?string $icePhenomenonMeasuredAt,
        #[ApiField('zjawisko_zarastania')]
        protected ?int $vegetationPhenomenon,
        #[ApiField('zjawisko_zarastania_data_pomiaru')]
        protected ?string $vegetationPhenomenonMeasuredAt,
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

    public function getRiver(): ?string
    {
        return $this->river;
    }

    public function getProvince(): ?string
    {
        return $this->province;
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

    public function getGaugeZeroOrdinate(): ?float
    {
        return $this->gaugeZeroOrdinate;
    }

    public function getRiverKilometer(): ?float
    {
        return $this->riverKilometer;
    }

    public function getAlarmLevel(): ?int
    {
        return $this->alarmLevel;
    }

    public function getWarningLevel(): ?int
    {
        return $this->warningLevel;
    }

    public function getWaterLevel(): ?int
    {
        return $this->waterLevel;
    }

    public function getWaterLevelMeasuredAt(): ?DateTimeImmutable
    {
        return $this->parseDate($this->waterLevelMeasuredAt);
    }

    public function getWaterTemperature(): ?float
    {
        return $this->waterTemperature;
    }

    public function getWaterTemperatureMeasuredAt(): ?DateTimeImmutable
    {
        return $this->parseDate($this->waterTemperatureMeasuredAt);
    }

    public function getFlow(): ?float
    {
        return $this->flow;
    }

    public function getFlowMeasuredAt(): ?DateTimeImmutable
    {
        return $this->parseDate($this->flowMeasuredAt);
    }

    public function getIcePhenomenon(): ?int
    {
        return $this->icePhenomenon;
    }

    public function getIcePhenomenonMeasuredAt(): ?DateTimeImmutable
    {
        return $this->parseDate($this->icePhenomenonMeasuredAt);
    }

    public function getVegetationPhenomenon(): ?int
    {
        return $this->vegetationPhenomenon;
    }

    public function getVegetationPhenomenonMeasuredAt(): ?DateTimeImmutable
    {
        return $this->parseDate($this->vegetationPhenomenonMeasuredAt);
    }

}
