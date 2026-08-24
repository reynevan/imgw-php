<?php

declare(strict_types=1);

namespace Reynevan\Imgw\Dto;

use DateTimeImmutable;
use Exception;

trait HasDateField
{
    private function parseDate(?string $date): ?DateTimeImmutable
    {
        if ($date === null) {
            return null;
        }

        try {
            return new DateTimeImmutable($date);
        } catch (Exception $e) {
            return null;
        }
    }
}
