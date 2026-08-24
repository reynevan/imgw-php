<?php

declare(strict_types=1);

namespace Reynevan\Imgw\Dto;

use DateTimeImmutable;
use Reynevan\Imgw\Attribute\ApiField;

class MeteoWarning
{
    use HasDateField;

    /**
     * @param string[] $terytCodes
     */
    public function __construct(
        #[ApiField('id')]
        protected ?string $id,
        #[ApiField('nazwa_zdarzenia')]
        protected ?string $event,
        #[ApiField('stopien')]
        protected ?int $level,
        #[ApiField('prawdopodobienstwo')]
        protected ?int $probability,
        #[ApiField('opublikowano')]
        protected ?string $publishedAt,
        #[ApiField('obowiazuje_od')]
        protected ?string $validFrom,
        #[ApiField('obowiazuje_do')]
        protected ?string $validTo,
        #[ApiField('biuro')]
        protected ?string $office,
        #[ApiField('tresc')]
        protected ?string $description,
        #[ApiField('komentarz')]
        protected ?string $comment,
        #[ApiField('teryt')]
        protected array $terytCodes,
    ) {
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getEvent(): ?string
    {
        return $this->event;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    /**
     * @return string[]
     */
    public function getTerytCodes(): array
    {
        return $this->terytCodes;
    }
}
