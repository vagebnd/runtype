<?php

namespace Vagebond\Runtype\Types;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Vagebond\Runtype\RuntypeConfig;
use Vagebond\Runtype\Values\TypescriptType;

final class Types
{
    public function __construct(
        private RuntypeConfig $config
    ) {}

    public const ANY = 'any';

    public const BOOLEAN = 'boolean';

    public const NUMBER = 'number';

    public const STRING = 'string';

    public const UNKNOWN = 'unknown';

    public function determineType(mixed $value)
    {
        foreach ($this->config->getTypeReplacements() as $class => $replacement) {
            if ($value instanceof $class) {
                return $replacement;
            }
        }

        return match (true) {
            is_string($value) => self::STRING,
            is_bool($value) => self::BOOLEAN,
            is_int($value) => self::NUMBER,
            is_float($value) => self::NUMBER,
            is_array($value) => $this->processArray($value),
            $value instanceof \BackedEnum => $this->processEnum($value),
            $value instanceof ResourceCollection => TypescriptType::determineName($value->collects).'[]',
            $value instanceof JsonResource => TypescriptType::determineName(get_class($value)),
            $value instanceof Arrayable => $this->processArray($value->toArray()), // TODO: Test for this
            is_object($value) => $this->processArray((array) $value),
            default => self::UNKNOWN,
        };
    }

    private function processArray(array $value)
    {
        if (Arr::isAssoc($value)) {
            $result = collect($value)
                ->mapWithKeys(fn ($value, $key) => [$key => $this->determineType($value)])
                ->toJson();

            return Str::replace('"', '', $result);
        }

        $types = collect($value)->map(fn ($value) => $this->determineType($value))->unique();

        return $types->join('|').'[]';
    }

    private function processEnum(\BackedEnum $value)
    {
        return implode(' | ', Arr::map(array_column($value::cases(), 'value'), fn ($val) => is_string($val) ? "'$val'" : $val));
    }
}
