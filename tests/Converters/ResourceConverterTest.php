<?php

use Vagebond\Runtype\Converters\ResourceConverter;
use Vagebond\Runtype\Processors\ResourceProcessor;
use Vagebond\Runtype\Tests\Fakes\Models\User;
use Vagebond\Runtype\Tests\Fakes\Modifiers\FeatureModifier;
use Vagebond\Runtype\Tests\Fakes\Resources\FeatureResource;
use Vagebond\Runtype\Tests\Fakes\Resources\ProductResource;
use Vagebond\Runtype\Tests\Fakes\Resources\ProductResourceCollection;
use Vagebond\Runtype\Tests\Fakes\Resources\UserResource;
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

it('can convert resource collections', function () {
    $instance = (new ResourceProcessor(getConfig()))->process(ProductResourceCollection::class);
    $processed = (new ResourceConverter(getConfig()))->convert($instance);

    expect($processed)->toBeInstanceOf(TypescriptType::class);
    expect($processed->getName())->toBe('ProductResourceCollectionType');
    expect($processed->listProperties())->toHaveCount(1);

    $property = $processed->listProperties()->first();

    expect($property->getName())->toBe('data');
    expect($property->getType())->toBe('ProductResourceType[]');
});

it('can convert resources that use the user bound to the request', function () {
    Auth::login(User::firstOrFail());

    $instance = (new ResourceProcessor(getConfig()))->process(UserResource::class);
    $processed = (new ResourceConverter(getConfig()))->convert($instance);

    expect($processed)->toBeInstanceOf(TypescriptType::class);
    expect($processed->getName())->toBe('UserResourceType');
    expect($processed->listProperties())->toHaveCount(3);

    $userBoundProperty = $processed->listProperties()->last();

    expect($userBoundProperty->getName())->toBe('can');
    expect($userBoundProperty->getType())->toBe('{edit:boolean}');
});

it('can detect optional properties', function () {
    $config = getConfig();
    $config->modifiers([
        FeatureResource::class => FeatureModifier::class,
    ]);

    $instance = (new ResourceProcessor($config))->process(FeatureResource::class);
    $processed = (new ResourceConverter($config))->convert($instance);

    expect($processed->getName())->toBe('FeatureResourceType');

    $modifiedProperty = $processed->listProperties()->last();

    expect($modifiedProperty->getName())->toBe('hidden?');
    expect($modifiedProperty->getType())->toBe('boolean');
});
