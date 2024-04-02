<?php

use Vagebond\Runtype\Actions\ConvertEntities;
use Vagebond\Runtype\Actions\ProcessEntities;
use Vagebond\Runtype\Tests\Fakes\Models\Category;
use Vagebond\Runtype\Tests\Fakes\Modifiers\FeatureModifier;
use Vagebond\Runtype\Tests\Fakes\Resources\FeatureResource;
use Vagebond\Runtype\Tests\Fakes\Resources\ProductResource;
use Vagebond\Runtype\Tests\Fakes\Resources\ValueResource;
use Vagebond\Runtype\Tests\Fakes\Values\TestValue;
use Vagebond\Runtype\Values\TypescriptType;

beforeEach(function () {
    $this->config = getConfig();
});

it('can process entities', function (string $class) {
    $processed = (new ProcessEntities($this->config))->handle([$class]);
    $converted = (new ConvertEntities($this->config))->handle($processed);

    expect($converted->count())->toBe(1);
    $type = $converted->first();

    expect($type)->toBeInstanceOf(TypescriptType::class);
})
    ->with(function () {
        yield Category::class;
        yield ProductResource::class;
        yield TestValue::class;
        yield ValueResource::class;
    });

it('can use custom modifiers', function () {
    $processed = (new ProcessEntities($this->config))->handle([FeatureResource::class]);
    $config = $this->config
        ->modifiers([
            FeatureResource::class => FeatureModifier::class,
        ]);

    $converted = (new ConvertEntities($config))->handle($processed);
    $type = $converted->first();

    expect($converted->count())->toBe(1);
    expect($type->listProperties())->toHaveCount(4);

    $hiddenProperty = $type->listProperties()->last();

    expect($hiddenProperty->getName())->toBe('hidden');
});
