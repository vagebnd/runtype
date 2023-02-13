<?php

use Illuminate\Support\Collection;
use Vagebond\Runtype\Actions\ProcessEntities;
use Vagebond\Runtype\Tests\Fakes\Models\Category;
use Vagebond\Runtype\Tests\Fakes\Resources\ProductResource;
use Vagebond\Runtype\Tests\Fakes\Resources\ValueResource;
use Vagebond\Runtype\Tests\Fakes\Values\TestValue;

it('can process multiple entities', function () {
    $config = getConfig();

    $classes = [
        ProductResource::class,
        ValueResource::class,
        Category::class,
        TestValue::class,
    ];

    $processed = (new ProcessEntities($config))->handle($classes);

    expect($processed)->toBeInstanceOf(Collection::class);
    expect($processed->count())->toBe(4);
});

it('can process resources', function () {
    $config = getConfig();

    $classes = [
        ProductResource::class,
    ];

    $processed = (new ProcessEntities($config))->handle($classes);

    expect($processed->first())->toBeInstanceOf(ProductResource::class);
});

it('can process models', function () {
    $config = getConfig();

    $classes = [
        Category::class,
    ];

    $processed = (new ProcessEntities($config))->handle($classes);

    expect($processed->first())->toBeInstanceOf(Category::class);
});

it('defaults to a class reflection', function () {
    $config = getConfig();

    $classes = [
        TestValue::class,
    ];

    $processed = (new ProcessEntities($config))->handle($classes);

    expect($processed->first())->toBeInstanceOf(ReflectionClass::class);
});
