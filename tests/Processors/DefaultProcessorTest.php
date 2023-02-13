<?php

use Vagebond\Runtype\Processors\DefaultProcessor;
use Vagebond\Runtype\Tests\Fakes\Values\TestValue;

it('returns a class reflection', function () {
    $processed = (new DefaultProcessor(getConfig()))->process(TestValue::class);

    expect($processed)->toBeInstanceOf(ReflectionClass::class);
});
