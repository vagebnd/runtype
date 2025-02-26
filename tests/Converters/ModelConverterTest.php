<?php

use Vagebond\Runtype\Converters\ModelConverter;
use Vagebond\Runtype\Processors\ModelProcessor;
use Vagebond\Runtype\Tests\Fakes\Models\Product;
use Vagebond\Runtype\Values\TypescriptType;

it('can convert models', function () {
    $instance = (new ModelProcessor)->process(Product::class);
    $processed = (new ModelConverter(getConfig()))->convert($instance);

    expect($processed)->toBeInstanceOf(TypescriptType::class);
    expect($processed->getName())->toBe('ProductType');
    expect($processed->listProperties())->toHaveCount(7);
});
