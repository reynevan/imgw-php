# imgw-php

[![PHP Version](https://img.shields.io/badge/php-%3E%3D8.1-8892BF?logo=php&logoColor=white)](composer.json)
[![Tests](https://img.shields.io/badge/tests-passing-brightgreen?logo=phpunit&logoColor=white)](tests)
[![Coverage](https://img.shields.io/badge/coverage-100%25-brightgreen?logo=codecov&logoColor=white)](phpunit.xml)
[![PSR-18](https://img.shields.io/badge/http--client-PSR--18-blue)](https://www.php-fig.org/psr/psr-18/)

A lightweight, fully typed PHP client for the public IMGW API ([danepubliczne.imgw.pl](https://danepubliczne.imgw.pl)) - synoptic and hydrological station data plus meteorological and hydrological warnings, mapped directly onto DTO objects.

## Features

- Synoptic (`synop`) and meteorological (`meteo`) station data
- Hydrological station data (`hydro`)
- Hydrological (`warningshydro`) and meteorological (`warningsmeteo`) warnings
- API responses mapped onto strongly typed DTOs via PHP attributes (`#[ApiField]`)
- Decoupled from any specific HTTP client thanks to PSR-18 (`php-http/discovery` auto-detects an available client)
- 100% test coverage

## Requirements

- PHP >= 8.1
- A PSR-18 (`psr/http-client-implementation`) and PSR-17 (`psr/http-factory-implementation`) implementation, e.g. `guzzlehttp/guzzle` + `guzzlehttp/psr7` or `symfony/http-client` + `nyholm/psr7`

## Installation

```bash
composer require reynevan/imgw-php
```

If your project doesn't have a PSR-18 client yet, install one, e.g. Guzzle:

```bash
composer require guzzlehttp/guzzle guzzlehttp/psr7
```

## Quick start

```php
use Reynevan\Imgw\ImgwClient;

$client = new ImgwClient();

foreach ($client->synop()->getWeatherStations() as $station) {
    printf(
        "%s: %.1f°C\n",
        $station->getName(),
        $station->getTemperature()
    );
}
```

### Synoptic data (`Synop`)

```php
$synop = $client->synop();

$stations = $synop->getWeatherStations();          // WeatherStation[]
$station  = $synop->getWeatherStationById(12500);   // WeatherStation
$station  = $synop->getWeatherStationByName('Warszawa'); // WeatherStation
```

### Hydrological data (`Hydro`)

```php
foreach ($client->hydro()->getHydroStations() as $station) {
    printf(
        "%s (%s): water level %s cm\n",
        $station->getName(),
        $station->getRiver(),
        $station->getWaterLevel()
    );
}
```

### Meteorological data (`Meteo`)

```php
foreach ($client->meteo()->getMeteoStations() as $station) {
    printf(
        "%s: %.1f°C\n",
        $station->getName(),
        $station->getAirTemperature()
    );
}
```

### Hydrological warnings (`WarningsHydro`)

```php
foreach ($client->warningshydro()->getWarnings() as $warning) {
    printf(
        "[%s] %s (level %d), valid from %s to %s\n",
        $warning->getOffice(),
        $warning->getEvent(),
        $warning->getLevel(),
        $warning->getValidFrom()?->format('Y-m-d H:i'),
        $warning->getValidTo()?->format('Y-m-d H:i')
    );
}
```

### Meteorological warnings (`WarningsMeteo`)

```php
foreach ($client->warningsmeteo()->getWarnings() as $warning) {
    printf(
        "[%s] %s (level %d)\n",
        $warning->getOffice(),
        $warning->getEvent(),
        $warning->getLevel()
    );
}
```

## Custom HTTP client

`ImgwClient` optionally accepts a custom `HttpClientInterface` implementation - useful for plugging in a PSR-18 client with custom configuration (timeouts, headers, middleware) or for testing.

```php
use Reynevan\Imgw\Http\HttpClientInterface;
use Reynevan\Imgw\Http\PsrHttpClientAdapter;
use Reynevan\Imgw\ImgwClient;

$httpClient = new PsrHttpClientAdapter($myPsr18Client, $myPsr17RequestFactory);
$client = new ImgwClient($httpClient);
```

## Error handling

Connection errors and API responses with a status >= 400 are thrown as `Reynevan\Imgw\Exceptions\ImgwApiException`.

```php
use Reynevan\Imgw\Exceptions\ImgwApiException;

try {
    $station = $client->synop()->getWeatherStationById(999999);
} catch (ImgwApiException $e) {
    // e.g. the station doesn't exist or the API is unavailable
}
```

## Testing

```bash
composer test              # run the unit tests
composer test-coverage     # console coverage report
composer test-coverage-html # HTML coverage report in build/coverage
composer phpstan           # static analysis
```

## License

MIT