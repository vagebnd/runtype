<?php

use Vagebond\Runtype\Actions\ResolveMixinFromClass;
use Vagebond\Runtype\Exceptions\UnresolvableResourceException;
use Vagebond\Runtype\Tests\Actions\Stubs\AliasedModelResource;
use Vagebond\Runtype\Tests\Actions\Stubs\MissingMixinResource;
use Vagebond\Runtype\Tests\Actions\Stubs\MissingModelResource;
use Vagebond\Runtype\Tests\Fakes\Resources\ProductResource;

it('can extract a model from a mixin docblock', function () {
    $modelClass = (new ResolveMixinFromClass)->handle(ProductResource::class);

    expect($modelClass)->toBeString();
    expect(class_exists($modelClass))->toBeTrue();
});

it('can extract a model from an alias', function () {
    $modelClass = (new ResolveMixinFromClass)->handle(AliasedModelResource::class);

    expect($modelClass)->toBeString();
    expect(class_exists($modelClass))->toBeTrue();
});

it('fails when a model is missing a mixin docblock', function () {
    (new ResolveMixinFromClass)->handle(MissingMixinResource::class);
})->throws(UnresolvableResourceException::class, 'No @mixin found for resource');

it('fails when the resolved class does not exist', function () {
    (new ResolveMixinFromClass)->handle(MissingModelResource::class);
})->throws(UnresolvableResourceException::class, 'Class Vagebond\Runtype\Tests\Actions\Stubs\MissingModelResource does not exist');
