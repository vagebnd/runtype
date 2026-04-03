<?php

use Vagebond\Runtype\Actions\TranspileToTypescript;
use Vagebond\Runtype\Tests\Fakes\Models\Category;
use Vagebond\Runtype\Tests\Fakes\Models\Product;
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
    $type->addProperty(TypescriptProperty::fromValue('category', new CategoryResource(new Category)));
    $type->addProperty(TypescriptProperty::fromValue('features', FeatureResource::collection([])));

    $generated = (new TranspileToTypescript)->handle(collect([$type]));
    $lines = explode(PHP_EOL, $generated);

    expect($lines)->toContain('declare namespace Vagebond.Runtype.Tests.Fakes.Resources {');
    expect($lines)->toContain("\t// Vagebond\\Runtype\\Tests\\Fakes\\Resources\\ProductResource");
    expect($lines)->toContain("\texport type ProductResourceType = {");
    expect($lines)->toContain("\t}");

    $type->listProperties()->each(function (TypescriptProperty $property) use ($lines) {
        expect($lines)->toContain("\t\t{$property->getName()}: {$property->getType()};");
    });
});

it('can handle types with no properties', function () {
    $type = new TypescriptType(ProductResource::class);

    $generated = (new TranspileToTypescript)->handle(collect([$type]));
    $lines = explode(PHP_EOL, $generated);

    expect($lines)->toContain('declare namespace Vagebond.Runtype.Tests.Fakes.Resources {');
    expect($lines)->toContain("\texport type ProductResourceType = any");
});

it('groups types by namespace', function () {
    $resourceType = new TypescriptType(ProductResource::class);
    $resourceType->addProperty(TypescriptProperty::fromValue('id', 0));

    $modelType = new TypescriptType(Product::class);
    $modelType->addProperty(TypescriptProperty::fromValue('name', 'string'));

    $generated = (new TranspileToTypescript)->handle(collect([$resourceType, $modelType]));

    expect($generated)->toContain('declare namespace Vagebond.Runtype.Tests.Fakes.Resources {');
    expect($generated)->toContain('declare namespace Vagebond.Runtype.Tests.Fakes.Models {');
});
