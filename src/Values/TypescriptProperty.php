<?php

namespace Vagebond\Runtype\Values;

use BackedEnum;
use DateTimeInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Arr;

class TypescriptProperty
{
    public function __construct(
        private string $name,
        private string $type,
        private bool $optional = false,
    ) {}

    public static function fromValue(string $key, mixed $value): self
    {
        return new self($key, self::determineType($value));
    }

    public function getName(): string
    {
        return $this->isOptional() ? $this->name.'?' : $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function isOptional(): bool
    {
        return $this->optional;
    }

    public function setOptional(bool $optional)
    {
        $this->optional = $optional;
    }

    private static function determineType(mixed $value): string
    {
        return match (true) {
            is_string($value) => 'string',
            is_bool($value) => 'boolean',
            is_int($value) => 'number',
            is_float($value) => 'number',
            is_array($value) => self::processArray($value),
            $value instanceof DateTimeInterface => 'string',
            $value instanceof BackedEnum => self::processEnum($value),
            $value instanceof ResourceCollection => self::qualifiedTypeName($value->collects).'[]',
            $value instanceof JsonResource => self::qualifiedTypeName(get_class($value)),
            is_object($value) => self::processArray((array) $value),
            default => 'any',
        };
    }

    private static function processArray(array $value): string
    {
        if (Arr::isAssoc($value)) {
            $result = collect($value)
                ->map(fn ($v, $key) => "{$key}: ".self::determineType($v))
                ->implode(', ');

            return "{ {$result} }";
        }

        $types = collect($value)->map(fn ($value) => self::determineType($value))->unique();

        return $types->join(' | ').'[]';
    }

    private static function processEnum(BackedEnum $value): string
    {
        return implode(' | ', Arr::map(array_column($value::cases(), 'value'), fn ($val) => is_string($val) ? "'$val'" : $val));
    }

    private static function qualifiedTypeName(string $class): string
    {
        $namespace = TypescriptType::determineNamespace($class);
        $name = TypescriptType::determineName($class);

        return $namespace !== '' ? "{$namespace}.{$name}" : $name;
    }
}
