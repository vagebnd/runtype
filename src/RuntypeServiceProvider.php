<?php

namespace Vagebond\Runtype;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Vagebond\Runtype\Actions\ResolveRequest;
use Vagebond\Runtype\Commands\RuntypeCommand;
use Vagebond\Runtype\Contracts\ResolvesRequest;

class RuntypeServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('runtype')
            ->hasConfigFile()
            ->hasCommand(RuntypeCommand::class);
    }

    public function packageRegistered(): void
    {
        $this->app->bind(
            RuntypeConfig::class,
            fn () => RuntypeConfig::make()
                ->autoDiscoverPaths(config('runtype.auto_discover_paths'))
                ->processors(config('runtype.processors'))
                ->converters(config('runtype.converters'))
                ->modifiers(config('runtype.modifiers'))
                ->hooks(config('runtype.hooks'))
                ->outputFile(config('runtype.output_file'))
                ->typeReplacements(config('runtype.type_replacements'))
        );

        $this->app->bind(ResolvesRequest::class, ResolveRequest::class);
    }
}
