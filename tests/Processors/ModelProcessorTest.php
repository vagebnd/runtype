<?php

use Illuminate\Support\Collection;
use Vagebond\Runtype\Processors\ModelProcessor;
use Vagebond\Runtype\Tests\Fakes\Models\Category;
use Vagebond\Runtype\Tests\Fakes\Models\Feature;
use Vagebond\Runtype\Tests\Fakes\Models\Product;

beforeEach(function () {
    $this->model = (new ModelProcessor)->process(Product::class);
});

it('can process a model', function () {
    expect($this->model)->toBeInstanceOf(Product::class);
});

it('can handle relations that return a model', function () {
    expect($this->model->category)->toBeInstanceOf(Category::class);
});

it('can handle relations that return a collection', function () {
    expect($this->model->features)->toBeInstanceOf(Collection::class);
});

it('can handle computed attributes', function () {
    expect((new ModelProcessor)->process(Feature::class)->computedAttribute)->toBe('computed');
});
