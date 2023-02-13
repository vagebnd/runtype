<?php

use Vagebond\Runtype\Values\TypescriptProperty;

it('it can create a property', function () {
    $property = new TypescriptProperty('name', 'string');

    expect($property->getName())->toBe('name');
    expect($property->getType())->toBe('string');
});

it('can set a property to optional', function () {
    $property = new TypescriptProperty('name', 'string');

    expect($property->isOptional())->toBeFalse();

    $property->setOptional(true);

    expect($property->isOptional())->toBeTrue();
});
