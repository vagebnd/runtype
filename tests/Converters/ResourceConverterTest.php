<?php

use Vagebond\Runtype\Converters\ResourceConverter;
use Vagebond\Runtype\Processors\ResourceProcessor;
use Vagebond\Runtype\Tests\Fakes\Resources\ProductResource;
use Vagebond\Runtype\Tests\Fakes\Resources\ValueResource;
use Vagebond\Runtype\Values\TypescriptType;

it('can convert resources with models', function () {
    $instance = (new ResourceProcessor(getConfig()))->process(ProductResource::class);
    $processed = (new ResourceConverter(getConfig()))->convert($instance);

    expect($processed)->toBeInstanceOf(TypescriptType::class);
    expect($processed->getName())->toBe('ProductResourceType');
    expect($processed->listProperties())->toHaveCount(5);
});

it('can convert resources with value objects', function () {
    $instance = (new ResourceProcessor(getConfig()))->process(ValueResource::class);
    $processed = (new ResourceConverter(getConfig()))->convert($instance);

    expect($processed)->toBeInstanceOf(TypescriptType::class);
});

// TODO: Add tests for modifiers.
