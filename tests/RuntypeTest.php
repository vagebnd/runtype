<?php

use Spatie\TemporaryDirectory\TemporaryDirectory;
use Vagebond\Runtype\Runtype;
use Vagebond\Runtype\Tests\Fakes\Hooks\SetupEnvironment;

use function Pest\Laravel\artisan;

beforeEach(function () {
    $this->temporaryDirectory = (new TemporaryDirectory)->create();

    $this->config = getConfig()
        ->outputFile($this->temporaryDirectory->path('runtype.d.ts'));
});

it('works', function () {
    (new Runtype($this->config->hooks([SetupEnvironment::class])))->generate();

    expect($this->temporaryDirectory->path('runtype.d.ts'))->toBeFile();
    // TODO: Validate contents with snapshot.
});

it('can call the command', function () {
    (new Runtype($this->config->hooks([SetupEnvironment::class])))->generate();

    artisan('runtype:generate')->assertExitCode(0);

    expect($this->temporaryDirectory->path('runtype.d.ts'))->toBeFile();
});

it('can hook into the process', function () {
    $this->mock(Setup::class, function ($mock) {
        $mock->shouldReceive('before')->once();
        $mock->shouldReceive('after')->once();
    });

    $this->config->hooks([
        SetupEnvironment::class,
        Setup::class,
    ]);

    (new Runtype($this->config))->generate();
});
