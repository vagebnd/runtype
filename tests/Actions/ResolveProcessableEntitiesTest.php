<?php

use Symfony\Component\Finder\Finder;
use Vagebond\Runtype\Actions\ResolveProcessableEntities;
use Vagebond\Runtype\Tests\Fakes\Models\Category;
use Vagebond\Runtype\Tests\Fakes\Resources\ProductResource;

it('can resolve processable entities based on the config', function () {
    $config = getConfig()
        ->autoDiscoverPaths([
            __DIR__.'/../Fakes/Resources',
            __DIR__.'/../Fakes/Models',
        ]);

    $entities = (new ResolveProcessableEntities(new Finder, $config))->handle();

    expect($entities)->toBeArray();
    expect($entities)->toContain(ProductResource::class);
    expect($entities)->toContain(Category::class);
});
