<?php

use Spatie\TemporaryDirectory\TemporaryDirectory;
use Vagebond\Runtype\Runtype;

beforeEach(function () {
    $this->temporaryDirectory = (new TemporaryDirectory())->create();

    $this->config = getConfig()
        ->outputFile($this->temporaryDirectory->path('runtype.d.ts'));
});

it('works', function () {
    (new Runtype($this->config))->generate();

    expect($this->temporaryDirectory->path('runtype.d.ts'))->toBeFile();

    // TODO: Validate contents with snapshot.
});
