<?php

use Illuminate\Http\Resources\Json\JsonResource;
use Vagebond\Runtype\Exceptions\UnresolvableResourceException;
use Vagebond\Runtype\Processors\ResourceProcessor;
use Vagebond\Runtype\Tests\Actions\Stubs\MissingMixinResource;
use Vagebond\Runtype\Tests\Actions\Stubs\MissingModelResource;
use Vagebond\Runtype\Tests\Fakes\Resources\FeatureResource;
use Vagebond\Runtype\Tests\Fakes\Resources\ValueResource;

it('can process resources', function ($class) {
    $processed = (new ResourceProcessor(getConfig()))->process($class);

    expect($processed)->toBeInstanceOf(JsonResource::class);
})->with(function () {
    yield FeatureResource::class;
    yield ValueResource::class;
});

it('throws an error when a resource does not have a mixin', function () {
    (new ResourceProcessor(getConfig()))->process(MissingMixinResource::class);
})->throws(UnresolvableResourceException::class);

it('throws an error when a resource has an unresolvable mixin', function () {
    (new ResourceProcessor(getConfig()))->process(MissingModelResource::class);
})->throws(UnresolvableResourceException::class);
