<?php

use Vagebond\Runtype\Tests\Fakes\Models\Product;
use Vagebond\Runtype\Tests\Fakes\Resources\ProductResource;
use Vagebond\Runtype\Types\Types;

it('can determine a type from a value', function ($value, $expected) {
    expect((new Types(getConfig()))->determineType($value))->toBe($expected);
})->with([
    ['string', 'string'],
    [true, 'boolean'],
    [1, 'number'],
    [-1, 'number'],
    [1.1, 'number'],
    [now(), 'string'],
    [new ProductResource(new Product), 'ProductResourceType'],
    [[1, 2, 3], 'number[]'],
    [['name' => 'name', 'value' => 1], '{name:string,value:number}'],
    [['name' => 'name', 'values' => ['name' => 'value']], '{name:string,values:{name:string}}'],
    [(object) ['name' => 'name', 'value' => 1], '{name:string,value:number}'],
]);
