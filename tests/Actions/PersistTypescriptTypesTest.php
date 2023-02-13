<?php

use Spatie\TemporaryDirectory\TemporaryDirectory;
use Vagebond\Runtype\Actions\PersistTypescriptTypes;

beforeEach(function () {
    $this->temporaryDirectory = (new TemporaryDirectory())->create();
    $this->action = new PersistTypescriptTypes(
        getConfig()
            ->outputFile($this->temporaryDirectory->path('runtype.d.ts'))
    );

    $this->types = collect([createDummyTypescriptType()]);
});

it('will persist the typescript types', function () {
    ($this->action->handle($this->types));

    expect($this->temporaryDirectory->path('runtype.d.ts'))->toBeFile();

    // Assert it matches snapshot
    $this->temporaryDirectory->delete();
});
