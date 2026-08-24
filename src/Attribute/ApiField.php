<?php

declare(strict_types=1);

namespace Reynevan\Imgw\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_PARAMETER)]
final class ApiField
{
    public function __construct(
        public readonly string $name,
        public readonly ?string $type = null
    ) {
    }
}
