<?php

use Vagebond\Runtype\Actions\TranspileToTypescript;
use Vagebond\Runtype\Tests\Fakes\Models\Category;
use Vagebond\Runtype\Tests\Fakes\Resources\CategoryResource;
use Vagebond\Runtype\Tests\Fakes\Resources\FeatureResource;
use Vagebond\Runtype\Tests\Fakes\Resources\ProductResource;
use Vagebond\Runtype\Values\TypescriptProperty;
use Vagebond\Runtype\Values\TypescriptType;

it('can transpile to typescript', function () {
    $type = new TypescriptType(ProductResource::class);

    $type->addProperty(TypescriptProperty::fromValue('id', 0));
    $type->addProperty(TypescriptProperty::fromValue('name', 'string'));
    $type->addProperty(TypescriptProperty::fromValue('price', 1.1));
    $type->addProperty(TypescriptProperty::fromValue('created_at', now()));
    $type->addProperty(TypescriptProperty::fromValue('category', new CategoryResource(new Category())));
    $type->addProperty(TypescriptProperty::fromValue('features', FeatureResource::collection([])));

    $generated = (new TranspileToTypescript())->handle(collect([$type]));
    $lines = explode(PHP_EOL, $generated);

    expect($lines)->toContain('export type ProductResourceType = {');
    expect($lines)->toContain('}');

    $type->listProperties()->each(function (TypescriptProperty $property) use ($lines) {
        expect($lines)->toContain("{$property->getName()}:{$property->getType()}");
    });
});

it('can handle types with no properties', function () {
    $type = new TypescriptType(ProductResource::class);

    $generated = (new TranspileToTypescript())->handle(collect([$type]));
    $lines = explode(PHP_EOL, $generated);

    expect($lines)->toContain('export type ProductResourceType = any');
});
