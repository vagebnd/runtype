<?php

namespace Vagebond\Runtype\Values;

use DateTimeInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

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

    private static function determineType(mixed $value)
    {
        return match (true) {
            is_string($value) => 'string',
            is_bool($value) => 'boolean',
            is_int($value) => 'number',
            is_float($value) => 'number',
            is_array($value) => self::processArray($value),
            $value instanceof DateTimeInterface => 'string',
            $value instanceof ResourceCollection => TypescriptType::determineName($value->collects).'[]',
            $value instanceof JsonResource => TypescriptType::determineName(get_class($value)),
            is_object($value) => self::processArray((array) $value),
            default => 'any',
        };
    }

    private static function processArray(array $value)
    {
        if (Arr::isAssoc($value)) {
            $result = collect($value)
                ->mapWithKeys(fn ($value, $key) => [$key => self::determineType($value)])
                ->toJson();

            return Str::replace('"', '', $result);
        }

        $types = collect($value)->map(fn ($value) => self::determineType($value))->unique();

        return $types->join('|').'[]';
    }
}
