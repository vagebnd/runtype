<?php

use Symfony\Component\Finder\SplFileInfo;
use Vagebond\Runtype\Actions\ResolveClassesInPhpFile;

beforeEach(function () {
    $this->action = new ResolveClassesInPhpFile;
});

it('can find classes', function () {
    $result = $this->action->handle(new SplFileInfo(__DIR__.'/../Fakes/Resources/CategoryResource.php', '', ''));
    expect($result)->toContain('Vagebond\Runtype\Tests\Fakes\Resources\CategoryResource');
});
