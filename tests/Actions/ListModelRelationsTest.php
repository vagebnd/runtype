<?php

use Vagebond\Runtype\Actions\ListModelRelations;
use Vagebond\Runtype\Tests\Fakes\Models\Product;

it('can list a models relations', function () {
    $relations = app(ListModelRelations::class)->handle(new Product);

    expect($relations)->toBeArray();
    expect(count($relations))->toBe(2);
    expect($relations)->toMatchArray([
        'category',
        'features',
    ]);
});
