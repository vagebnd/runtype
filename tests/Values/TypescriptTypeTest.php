<?php

namespace Vagebond\Runtype\Tests\Values;

use Vagebond\Runtype\Tests\Fakes\Resources\ProductResource;
use Vagebond\Runtype\Values\TypescriptProperty;
use Vagebond\Runtype\Values\TypescriptType;

it('can create a type from a resource class', function () {
    $type = new TypescriptType(ProductResource::class);

    expect($type->getName())->toBe('ProductResourceType');
});

it('can add a property to a type', function () {
    $type = new TypescriptType(ProductResource::class);

    $type->addProperty(new TypescriptProperty(
        name: 'name',
        type: 'string',
    ));

    expect($type->listProperties())->toHaveCount(1);
});

it('can merge a type', function () {
    $type = new TypescriptType('SomeType');

    $type->addProperties([
        new TypescriptProperty(
            name: 'name',
            type: 'string',
        ),
        new TypescriptProperty(
            name: 'age',
            type: 'number',
        ),
    ]);

    $mergeType = new TypescriptType('SomeType');

    $mergeType->addProperties([
        new TypescriptProperty(
            name: 'name',
            type: 'string',
        ),
        new TypescriptProperty(
            name: 'address',
            type: 'string',
        ),
    ]);

    $type = $type->merge($mergeType, $type->listProperties());

    expect($type->listProperties()->firstWhere(fn ($property) => $property->getName() === 'address?'))->not->toBeNull();
    expect($type->listProperties()->firstWhere(fn ($property) => $property->getName() === 'address?')->isOptional())->toBeTrue();
    expect($type->listProperties()->firstWhere(fn ($property) => $property->getName() === 'age')->isOptional())->toBeFalse();
    expect($type->listProperties()->firstWhere(fn ($property) => $property->getName() === 'name')->isOptional())->toBeFalse();
});
