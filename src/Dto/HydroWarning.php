<?php

declare(strict_types=1);

namespace Reynevan\Imgw\Dto;

use DateTimeImmutable;
use ReflectionException;
use Reynevan\Imgw\Attribute\ApiField;
use Reynevan\Imgw\Mapper\AttributeMapper;

class HydroWarning
{
    use HasDateField;

    /**
     * @param array<int, array<string, mixed>> $areas
     */
    public function __construct(
        #[ApiField('numer')]
        protected int $number,
        #[ApiField('stopień')]
        protected ?int $level,
        #[ApiField('prawdopodobienstwo')]
        protected ?int $probability,
        #[ApiField('opublikowano')]
        protected ?string $publishedAt,
        #[ApiField('data_od')]
        protected ?string $validFrom,
        #[ApiField('data_do')]
        protected ?string $validTo,
        #[ApiField('biuro')]
        protected ?string $office,
        #[ApiField('zdarzenie')]
        protected ?string $event,
        #[ApiField('przebieg')]
        protected ?string $description,
        #[ApiField('komentarz')]
        protected ?string $comment,
        #[ApiField('obszary')]
        protected array $areas
    ) {

    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function getProbability(): ?int
    {
        return $this->probability;
    }

    public function getPublishedAt(): ?DateTimeImmutable
    {
        return $this->parseDate($this->publishedAt);
    }

    public function getValidFrom(): ?DateTimeImmutable
    {
        return $this->parseDate($this->validFrom);
    }

    public function getValidTo(): ?DateTimeImmutable
    {
        return $this->parseDate($this->validTo);
    }

    public function getOffice(): ?string
    {
        return $this->office;
    }

    public function getEvent(): ?string
    {
        return $this->event;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    /**
     * @return HydroArea[]
     * @throws ReflectionException
     */
    public function getAreas(): array
    {
        $areas = [];
        $mapper = new AttributeMapper();
        foreach ($this->areas as $area) {
            $areas[] = $mapper->map(HydroArea::class, $area);
        }
        return $areas;
    }
}
