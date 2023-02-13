<?php

use Vagebond\Runtype\Converters\DefaultConverter;
use Vagebond\Runtype\Processors\DefaultProcessor;
use Vagebond\Runtype\Tests\Fakes\Values\TestValue;
use Vagebond\Runtype\Values\TypescriptType;

it('can convert value objects', function () {
    $instance = (new DefaultProcessor())->process(TestValue::class);
    $processed = (new DefaultConverter(getConfig()))->convert($instance);

    expect($processed)->toBeInstanceOf(TypescriptType::class);
    expect($processed->getName())->toBe('TestValueType');
});
