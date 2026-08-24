<?php

declare(strict_types=1);

namespace Reynevan\Imgw;

use Reynevan\Imgw\Http\HttpClientInterface;
use Reynevan\Imgw\Http\PsrHttpClientAdapter;
use Reynevan\Imgw\Service\Hydro;
use Reynevan\Imgw\Service\Meteo;
use Reynevan\Imgw\Service\Synop;
use Reynevan\Imgw\Service\WarningsHydro;
use Reynevan\Imgw\Service\WarningsMeteo;

class ImgwClient
{
    public function __construct(
        private ?HttpClientInterface $httpClient = null,
    ) {
        $this->httpClient = $httpClient ?? new PsrHttpClientAdapter();
    }

    public function synop(): Synop
    {
        return new Synop($this->httpClient);
    }

    public function hydro(): Hydro
    {
        return new Hydro($this->httpClient);
    }

    public function meteo(): Meteo
    {
        return new Meteo($this->httpClient);
    }

    public function warningshydro(): WarningsHydro
    {
        return new WarningsHydro($this->httpClient);
    }

    public function warningsmeteo(): WarningsMeteo
    {
        return new WarningsMeteo($this->httpClient);
    }
}
