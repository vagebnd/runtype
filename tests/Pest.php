<?php

use Vagebond\Runtype\RuntypeConfig;
use Vagebond\Runtype\Tests\Fakes\Models\Category;
use Vagebond\Runtype\Tests\Fakes\Resources\CategoryResource;
use Vagebond\Runtype\Tests\Fakes\Resources\FeatureResource;
use Vagebond\Runtype\Tests\Fakes\Resources\ProductResource;
use Vagebond\Runtype\Tests\TestCase;
use Vagebond\Runtype\Values\TypescriptProperty;
use Vagebond\Runtype\Values\TypescriptType;

uses(TestCase::class)->in(__DIR__);

function getConfig()
{
    return RuntypeConfig::make()
        ->autoDiscoverPaths(config('runtype.auto_discover_paths'))
        ->processors(config('runtype.processors'))
        ->converters(config('runtype.converters'))
        ->modifiers(config('runtype.modifiers'))
        ->outputFile(config('runtype.output_file'))
        ->typeReplacements(config('runtype.type_replacements'));
}

function createDummyTypescriptType()
{
    $type = new TypescriptType(ProductResource::class);

    $type->addProperty(TypescriptProperty::fromValue('id', 0));
    $type->addProperty(TypescriptProperty::fromValue('name', 'string'));
    $type->addProperty(TypescriptProperty::fromValue('price', 1.1));
    $type->addProperty(TypescriptProperty::fromValue('created_at', now()));
    $type->addProperty(TypescriptProperty::fromValue('category', new CategoryResource(new Category())));
    $type->addProperty(TypescriptProperty::fromValue('features', FeatureResource::collection([])));

    return $type;
}
