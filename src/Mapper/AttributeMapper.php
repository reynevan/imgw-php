<?php

declare(strict_types=1);

namespace Reynevan\Imgw\Mapper;

use ReflectionClass;
use ReflectionException;
use ReflectionNamedType;
use ReflectionParameter;
use Reynevan\Imgw\Attribute\ApiField;

class AttributeMapper
{
    /**
     * @template T of object
     * @param class-string<T> $class
     * @param array<string, mixed> $data
     * @return T
     * @throws ReflectionException
     */
    public function map(string $class, array $data): object
    {
        $reflection = new ReflectionClass($class);

        $args = [];
        $parameters = $reflection->getConstructor()->getParameters();
        foreach ($parameters as $parameter) {
            $attributes = $parameter->getAttributes(ApiField::class);
            if (empty($attributes)) {
                continue;
            }

            $apiField = $attributes[0]->newInstance();
            $key = $apiField->name;

            if (!array_key_exists($key, $data)) {
                continue;
            }

            $args[$parameter->getName()] = $this->castValue($parameter, $data[$key]);
        }

        return $reflection->newInstance(...$args);

    }

    private function castValue(ReflectionParameter $property, mixed $value): mixed
    {
        if ($value === null) {
            return null;
        }

        $type = $property->getType();

        if (!$type instanceof ReflectionNamedType) {
            return $value;
        }

        return match ($type->getName()) {
            'int' => (int) $value,
            'float' => (float) $value,
            'string' => (string) $value,
            default => $value,
        };
    }
}
